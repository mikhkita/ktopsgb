<?php

class IntegrateTemplateController extends Controller
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
                return true;
            }else{
                if( !$debug ) sleep(rand(5,10));
            }
              
            if( $debug ) return true;
        }
    }

    public function writeTime(){
        $this->setParam( "TIME", time() );
    }

    public function checkQueueAccess(){
        return ( time() - intval( $this->getParam( "TIME", true ) ) > 180 );
    }

    public function allowed(){
        return ( trim( $this->getParam( "TOGGLE", true ) ) == "on" );
    }

    public function getNext(){
        

        return false;
    }
    
// Парсинг -------------------------------------------------------------- Парсинг

}
