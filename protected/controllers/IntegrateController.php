<?php

class IntegrateController extends Controller
{
    private $params = array();

    public function filters()
    {
        return array(
                'accessControl'
            );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
            ),
        );
    }

// Парсинг -------------------------------------------------------------- Парсинг
    public function actionQueueNext($debug = false){
        if( (!$this->checkQueueAccess() && !$debug) ) return true;

        while( $this->allowed() || $debug ){
            $this->writeTime();
            if( !$this->getNext() ){
                // $this->clearTime();
                // return true;
                if( !$debug ) sleep(10);
            }else{
                // if( !$debug ) sleep(rand(5,10));
            }
              
            if( $debug ){
                $this->clearTime();
                return true;
            }
        }
    }

    public function writeTime(){
        $this->setParam( "TIME", time() );
    }

    public function clearTime(){
        $this->setParam( "TIME", "0" );
    }

    public function checkQueueAccess(){
        return ( time() - intval( $this->getParam( "TIME", true ) ) > 100 );
    }

    public function allowed(){
        return ( trim( $this->getParam( "TOGGLE", true ) ) == "on" );
    }

    public function getNext(){
        $requests = Request::model()->with("word","city","positions.domain")->forced()->findAll();
        if( !$requests )
            $requests = Request::model()->with("word","city","positions.domain")->next()->findAll();

        if( $requests ){
            foreach ($requests as $i => $request) {
                $ids = Controller::getIds($request->positions, "domain_id");
                $domains = Domain::model()->findAll("id IN (".implode(",", $ids).")");
                $domain_names = Controller::getIds($domains, "value");
                $yandex = new Yandex($domain_names);

                $result = $yandex->parse($request->word->value, $request->city->yandex, 100);
                foreach ($request->positions as $j => $position) {
                    $position->number = $result[$position->domain->value]["number"];
                    $position->title = $result[$position->domain->value]["title"];
                    $position->link = $result[$position->domain->value]["link"];
                    $position->description = $result[$position->domain->value]["description"];
                    $position->save();
                }
                $request->last_update = date("Y-m-d H:i:s", time());
                $request->forced = 0;
                $request->save();
                var_dump($result);
                var_dump($yandex->debug);
            }
            return true;
        }else return false;
    }
    
// Парсинг -------------------------------------------------------------- Парсинг

}
