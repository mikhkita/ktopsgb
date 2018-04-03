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
    public $user_settings = NULL;
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

    public function getAssoc($model, $field = NULL){
        $out = array();
        foreach ($model as $key => $value){
            $out[(($field !== NULL)?$value[$field]:$value->id)] = $value;
        }
        return $out;
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

    public function insertValues($tableName, $values){
        if( !count($values) ) return true;

        $values = array_values($values);
        $structure = array();
        foreach ($values[0] as $key => $value) {
            $structure[] = "`".$key."`";
        }

        $structure = "(".implode(",", $structure).")";

        $sql = "INSERT INTO `$tableName` ".$structure." VALUES ";

        $vals = array();
        foreach ($values as $value) {
            $item = array();
            foreach ($value as $el) {
                if( $el === NULL ){
                    $item[] = "NULL";
                }else{
                    $item[] = "'".addslashes($el)."'";
                }
            }
            $vals[] = "(".implode(",", $item).")";
        }

        $sql .= implode(",", $vals);

        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function updateRows($table_name, $values = array(), $update){
        $result = true;

        if( count($values) ){
            $query = Yii::app()->db->createCommand("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE `table_name` = '".$table_name."' AND `table_schema` = '".Yii::app()->params["dbname"]."'")->query();

            $structure = array();
            $primary_keys = array();
            $columns = array();
            $vals = array();
            while($next = $query->read()){
                if( !in_array("`".$next["COLUMN_NAME"]."`", $columns) ){
                    array_push($columns, "`".$next["COLUMN_NAME"]."`");
                    if( $next["COLUMN_KEY"] == "PRI" ) 
                            array_push($primary_keys, "`".$next["COLUMN_NAME"]."`");
                    $structure[$next["COLUMN_NAME"]] = $next["COLUMN_TYPE"]." ".(($next["IS_NULLABLE"] == "NO" && $next["EXTRA"] != "auto_increment")?"NOT ":"")."NULL";
                }
            }

            $structure[0] = "PRIMARY KEY (".implode(",", $primary_keys).")";

            $tmpName = "tmp_".md5(rand().time());

            Yii::app()->db->createCommand()->createTable($tmpName, $structure, 'ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci');

            $sql = "INSERT INTO `$tmpName` (".implode(",", $columns).") VALUES ";

            foreach ($values as $arr) {
                $strArr = array();
                foreach ($arr as $item) {
                    array_push($strArr, ( $item === NULL )?"NULL":( ($item == "LAST_INSERT_ID()")?$item:("'".$item."'")));
                }
                array_push($vals, "(".implode(",", $strArr).")");
            }

            $sql .= implode(",", $vals);

            foreach ($update as &$item) {
                $item = " ".$table_name.".".$item." = ".$tmpName.".".$item;
            }

            if( Yii::app()->db->createCommand($sql)->execute() ){
                $sql = "INSERT INTO `$table_name` SELECT * FROM `$tmpName` ON DUPLICATE KEY UPDATE".implode(",", $update);
                $result = Yii::app()->db->createCommand($sql)->execute();
                
                Yii::app()->db->createCommand()->dropTable($tmpName);
            }else $result = false;
        }

        return $result;
    }

    public function addCheckbox($key, $id, $name = NULL){
        if(!isset($_SESSION)) session_start();

        if( $id ){
            if( !is_array($_SESSION[$key]) ){
                $_SESSION[$key] = array();
            }

            if( !isset($_SESSION[$key][$id]) ){
                $_SESSION[$key][$id] = ($name !== NULL)?$name:$id;
            }

            return true;
        }else{
            return false;
        }
    }

    public function removeCheckbox($key, $id = NULL){
        if(!isset($_SESSION)) session_start();

        if( $id ){
            if( is_array($_SESSION[$key]) && isset($_SESSION[$key][$id]) ){
                unset($_SESSION[$key][$id]);
            }

            return true;
        }else{
            return false;
        }
    }

    public function removeAllCheckboxes($key){
        if(!isset($_SESSION)) session_start();

        if( isset($_SESSION[$key]) ){
            unset($_SESSION[$key]);
        }

        return true;
    }

    public function displayCodes($success, $key) {
        if(!isset($_SESSION)) session_start();
        
        $result = array();
        $result["result"] = "error";
        if( !isset($_SESSION[$key]) || !is_array($_SESSION[$key]) ) $_SESSION[$key] = array();
        if($success) {
            $result["result"] = "success";
            $result["codes"] = Controller::getTextCheckboxes($key);           
        }
        echo json_encode($result);
        die();
    }

    public function getTextCheckboxes($key){
        if(!isset($_SESSION)) session_start();

        return ((count($_SESSION[$key]))?(Controller::pluralForm(count($_SESSION[$key]), array("Выделен", "Выделено", "Выделено"))." ".count($_SESSION[$key])." ".Controller::pluralForm(count($_SESSION[$key]), array("контейнер", "контейнера", "контейнеров")).": ".implode(", ", $_SESSION[$key])):"");
    }

    public function getCheckboxes($key){
        if(!isset($_SESSION)) session_start();

        return (isset($_SESSION[$key]))?array_keys($_SESSION[$key]):array();
    }

    public function getUserParam($code, $reload = false, $int_assoc = false){
        if( $this->user_settings == NULL || $reload ) $this->getUserSettings();

        $param_code = mb_strtoupper($code,"UTF-8");

        if( isset($this->user_settings[$param_code]) ){
            if( $int_assoc ){
                $out = array();
                foreach ($this->user_settings[$param_code] as $key => $value)
                    $out[intval($key)] = $value;
            }else{
                $out = $this->user_settings[$param_code];
            }

            return $out;
        }else{
            return NULL;
        }
    }

    public function getUserSettings(){
        $out = array();
        if( $this->user->settings )
            foreach ($this->user->settings as $i => $param)
                $out[$param->code] = json_decode($param->value);

        $this->user_settings = $out;
    }

    public function setUserParam($code, $value){
        $param_code = mb_strtoupper($code,"UTF-8");

        if( UserSettings::model()->count("user_id=".$this->user->id." AND code='".$param_code."'") ){
            $model = UserSettings::model()->find(array("limit"=>1,"condition"=>"user_id=".$this->user->id." AND code='".$param_code."'"));
            $model->value = json_encode($value);
            $model->save();
        }else{
            $this->insertValues(UserSettings::tableName(),array(array("user_id"=>$this->user->id,"code"=>$param_code,"value"=>json_encode($value))));
        }

        if( is_array($this->user_settings) )
            $this->user_settings[$param_code] = $value;
    }

    public function splitByRows($row_count, $items){
        $out = array();
        $i = 0;
        $j = 0;
        foreach ($items as $key => $item) {
            if( $i!=0 && $i%$row_count == 0 ){
                $j++;
                $out[$j] = array();
            }
            $out[$j][$key] = $item;
            $i++;
        }
        return $out;
    }

    public function splitByCols($col_count, $items){
        return $this->splitByRows(ceil(count($items)/$col_count),$items);
    }

    public function removeKeys($arr, $keys){
        foreach ($keys as $i => $key) {
            if( isset($arr[$key]) )
                unset($arr[$key]);
        }
        return $arr;
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

    public function pluralForm($number, $after) {
       $cases = array (2, 0, 1, 1, 1, 2);
       return $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
    }

    public function replaceToBr($str){
        return str_replace("\n", "<br>", $str);
    }

    public function replaceToSpan($str){
        return "<span>".str_replace("<br>", "</span><span>", $str)."</span>";
    }

    public function writeExcel($data, $title = "Новый экспорт"){
        include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel.php';
        // include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel/IOFactory.php';

        $excelDir = Yii::app()->params['excelDir'];

        $phpexcel = new PHPExcel(); // Создаём объект PHPExcel
        $filename = "example.xlsx";

        /* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
        $page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её
        foreach($data as $i => $ar){ // читаем массив
            foreach($ar as $j => $val){
                $page->setCellValueByColumnAndRow($j,$i+1,$val); // записываем данные массива в ячейку
                $page->getStyleByColumnAndRow($j,$i+1)->getAlignment()->setWrapText(true);
            }
        }
        $page->setTitle($title); // Заголовок делаем "Example"
        
        for($col = 'A'; $col !== 'Z'; $col++) {
            $page->getColumnDimension($col)->setAutoSize(true);
        }

        /* Начинаем готовиться к записи информации в xlsx-файл */
        $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
        /* Записываем в файл */
        $objWriter->save($excelDir."/".$filename);

        return $excelDir."/".$filename;
    }

    public function DownloadFile($source, $filename) {
        if (file_exists($source)) {
        
            if (ob_get_level()) {
              ob_end_clean();
            }

            $arr = explode(".", $source);
            
            header("HTTP/1.0 200 OK");
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$filename.".".array_pop($arr) );
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($source));
            
            readfile($source);
            exit;
        }
    }
}