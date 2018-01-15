<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to 'column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='admin';
    public $scripts = array();
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $interpreters = array();

    public $user;

    public $texts = NULL;

    public $start;
    public $render;
    public $debugText = "";

    public $adminMenu = array();
    public $settings = NULL;

    public function init() {
        parent::init();
        date_default_timezone_set("Asia/Krasnoyarsk");
        $this->user = User::model()->with("roles.role")->findByPk(Yii::app()->user->id);

        $this->adminMenu["items"] = ModelNames::model()->with("submenu")->findAll(array("order" => "t.sort ASC", "condition" => "t.parent=0"));

        foreach ($this->adminMenu["items"] as $key => $value) {
            $this->adminMenu["items"][$key] = $this->toLowerCaseModelNames($value);
        }

        $this->adminMenu["cur"] = $this->toLowerCaseModelNames(ModelNames::model()->find(array("condition" => "code = '".Yii::app()->controller->id."'")));
        
        $this->start = microtime(true);
    }

    public function beforeRender($view){
        parent::beforeRender($view);

        $this->render = microtime(true);

        $this->debugText = "Controller ".round(microtime(true) - $this->start,4);
        
        return true;
    }
    
    public function afterRenderPartial(){
        parent::afterRenderPartial();

        $this->debugText = ($this->debugText."<br>View ".round(microtime(true) - $this->render,4));
    }

    public function getParam($code, $force = false){
        if( $force ) $this->settings = NULL;

        if( $this->settings == NULL ) $this->getSettings();

        return $this->settings[mb_strtoupper($code,"UTF-8")];
    }

    public function setParam($code,$value){
        $model = Settings::model()->find("code='".$code."'");
        $model->value = $value;
        if( is_array($this->settings) )
            $this->settings[$code] = $value;
        return $model->save();
    }

    public function getSettings(){
        $model = Settings::model()->findAll();

        $this->settings = array();

        foreach ($model as $param) {
            $this->settings[$param->code] = $param->value;
        }
    }

    public function toLowerCaseModelNames($el){
        if( !$el ) return false;
        $el->vin_name = mb_strtolower($el->vin_name, "UTF-8");
        $el->rod_name = mb_strtolower($el->rod_name, "UTF-8");

        return $el;
    }

    public function getRusMonth($num){
        $rus = array(
            "января",
            "февраля",
            "марта",
            "апреля",
            "мая",
            "июня",
            "июля",
            "августа",
            "сентября",
            "октября",
            "ноября",
            "декабря",
        );

        return $rus[$num-1];
    }

    public function getRusDate($time){
        $date = explode(".", date("j.n.Y", strtotime($time)));
        return $date[0]." ".$this->getRusMonth($date[1])." ".$date[2];
    }

    public function getTime($time){
        return date("G:i", strtotime($time));
    }

    public function getIds($model, $field = NULL){
        $ids = array();
        foreach ($model as $key => $value)
            array_push($ids, (($field !== NULL)?$value[$field]:$value->id) );
        return $ids;
    }

    public function readDates(&$model){
        $modelName = get_class($model);

        if( isset($_GET["previous"]) ){
            $previousMonth = $this->getPreviousMonth();

            $model->date_from = $previousMonth->from;
            $model->date_to = $previousMonth->to;

            return true;
        }

        $from = (isset($_GET[$modelName]["date_from"]))?$_GET[$modelName]["date_from"]:NULL;
        $to = (isset($_GET[$modelName]["date_to"]))?$_GET[$modelName]["date_to"]:NULL;
        if( $from === NULL && $to === NULL ){

            // Проверка на наличие дат в сессии (пока не заносим туда)
            // #TODO# сделать запоминание дат
            if( isset($_SESSION[$modelName]) && isset($_SESSION[$modelName]["date"]) ){
                $from = $_SESSION[$modelName]["date"]["from"];
                $to = $_SESSION[$modelName]["date"]["to"];
            }else{
                // Дефолтные значения
                $from = $this->getCurrentMonthFrom();
            }
        }

        $model->date_from = $from;
        $model->date_to = $to;
    }

    public function isCurrentMonth($model){
        return $model->date_from == $this->getCurrentMonthFrom() && $model->date_to == NULL;
    }

    public function isPreviousMonth($model){
        $previousMonth = $this->getPreviousMonth();
        return $model->date_from == $previousMonth->from && $model->date_to == $previousMonth->to;
    }

    public function getCurrentMonthFrom(){
        return date("d.m.Y", strtotime("first day of this month"));
    }

    public function getPreviousMonth(){
        return (object) array( 
            "from" => date("d.m.Y", strtotime("first day of previous month")),
            "to" => date("d.m.Y", strtotime("last day of previous month")),
        );
    }

    public function replaceToBr($str){
        return str_replace("\n", "<br>", $str);
    }

    public function replaceToSpan($str){
        return "<span>".str_replace("<br>", "</span><span>", $str)."</span>";
    }
}