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
        $this->user = User::model()->with("roles.role", "branches")->findByPk(Yii::app()->user->id);

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
        $from = NULL;
        $to = NULL;

        if( isset($_GET["current_month"]) ){
            $from = $this->getCurrentMonthFrom();
        }else if( isset($_GET["previous"]) ){
            $previousMonth = $this->getPreviousMonth();

            $from = $previousMonth->from;
            $to = $previousMonth->to;
        }else if( isset($_GET["current_year"]) ){
            $from = $this->getCurrentYearFrom();
        }else{
            $from = (isset($_GET[$modelName]["date_from"]))?$_GET[$modelName]["date_from"]:NULL;
            $to = (isset($_GET[$modelName]["date_to"]))?$_GET[$modelName]["date_to"]:NULL;
        }

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
        }else{
            $_SESSION[$modelName]["date"]["from"] = $from;
            $_SESSION[$modelName]["date"]["to"] = $to;
        }

        $model->date_from = $from;
        $model->date_to = $to;
    }

    public function setSessionFilter($filter, $modelName, $fields, $type = ""){
        if ( isset($_GET["set_filter"]) && $_GET["set_filter"] == "true" ){
            if(isset($_GET[$modelName]) ){
                // foreach ($_GET[$modelName] as $key => $value) {
                //     if( !isset($fields[$key][$value]) ){
                //         unset($_GET[$modelName][$key]);
                //     }
                // }
                // print_r($_GET[$modelName]);

                $filter->attributes = $_GET[$modelName];
                $this->setUserParam($modelName.$type."_filter", $_GET[$modelName]);
            }else{
                $this->setUserParam($modelName.$type."_filter", NULL);
            }
        }else{
            if( $params = $this->getUserParam($modelName.$type."_filter") ){
                $filter->attributes = (array) $params;
            }
        }

        return $filter;
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

        Controller::checkCheckboxes($key);

        return ((count($_SESSION[$key]))?(Controller::pluralForm(count($_SESSION[$key]), array("Выделен", "Выделено", "Выделено"))." ".count($_SESSION[$key])." ".Controller::pluralForm(count($_SESSION[$key]), array("контейнер", "контейнера", "контейнеров")).": ".implode(", ", $_SESSION[$key])):"");
    }

    public function checkCheckboxes($key){
        if( is_array($_SESSION[$key]) && count($_SESSION[$key]) ){
            $container_ids = Controller::getAssoc(Container::model()->findAll("id IN (".implode(", ", array_keys($_SESSION[$key])).")"));

            $_SESSION[$key] = array_intersect_key($_SESSION[$key], $container_ids);
        }
    }

    public function getCheckboxes($key){
        if(!isset($_SESSION)) session_start();

        Controller::checkCheckboxes($key);

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

    public function getSortedAttributes($attributes){
        $order = $this->getUserParam("container_view");
        $outArr = array();
        if( is_array($order) && count($order) ){
            foreach ($order as $key => $value) {
                if( isset($attributes[ $value ]) ){
                    $outArr[ $value ] = $attributes[ $value ];
                    unset($attributes[ $value ]);
                }
            }
        }
        return array_merge($outArr, $attributes);
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

    public function isCurrentYear($model){
        echo $this->getCurrentYearFrom();
        return $model->date_from == $this->getCurrentYearFrom() && $model->date_to == NULL;
    }

    public function isPreviousMonth($model){
        $previousMonth = $this->getPreviousMonth();
        return $model->date_from == $previousMonth->from && $model->date_to == $previousMonth->to;
    }

    public function getCurrentMonthFrom(){
        return date("d.m.Y", strtotime("first day of this month"));
    }

    public function getCurrentYearFrom(){
        return "01.01.".date("Y");
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

    public function checkSubAccess($menuItem){
        if( !count($menuItem->submenu) ) return true;

        foreach ($menuItem->submenu as $key => $item) {
            if( $item->rule == NULL || Yii::app()->user->checkAccess($item->rule) ){
                return true;
            }
        }
        // 
        return false;
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

    public function removeFiles($ids = array()){
        if( !count($ids) ) return false;

        $files = File::model()->findAll("id IN (".implode(", ", $ids).")");

        if( count($files) ){
            $out = array();
            foreach ($files as $key => $file) {
                array_push($out, $file->original);
            }

            $note = Note::model()->findByPk($files[0]->note_id);

            // Log::add("1".$note->type_id, $note->item_id, $note->getItemName()." (".$note->item_id.")", 6, "Примечание от ".$note->date."<br>".implode("<br>", $out));
        }

        File::model()->updateAll(array("note_id" => 0), "id IN (".implode(", ", $ids).")");
    }

    public function addFiles($noteId){
        $count = $_POST["uploaderPj_count"];
        $out = array();

        for( $i = 0; $i < $count; $i++ ){
            $name = $_POST["uploaderPj_".$i."_tmpname"];
            $original = $_POST["uploaderPj_".$i."_name"];
            $status = $_POST["uploaderPj_".$i."_status"];

            if( $status == "done" ){
                if( $this->saveFile($name) ){
                    $file = new File();
                    $file->original = $original;
                    $file->name = $name;
                    $file->note_id = $noteId;
                    if( !$file->save() ){
                        print_r($file->getErrors());
                    }else{
                        array_push($out, $file->original);
                    }
                }
            }
        }

        if( count($out) ){
            $note = Note::model()->findByPk($noteId);

            // Log::add("1".$note->type_id, $note->item_id, $note->getItemName()." (".$note->item_id.")", 5, "Примечание от ".$note->date."<br>".implode("<br>", $out));
        }
    }

    public function saveFile($name){
        $arr = explode("/", $name);
        $name = array_pop($arr);

        $tmpFileName = Yii::app()->params['tempFolder']."/".$name;
        $fileName = Yii::app()->params['saveFolder']."/".$name;

        return rename($tmpFileName, $fileName);
    }   

    public function DownloadFile($source, $filename) {
        if (file_exists($source)) {
        
            if (ob_get_level()) {
              ob_end_clean();
            }

            $arr = explode(".", $source);
            $tmp = explode(".", $filename);

            if( count($tmp) > 1 ){
                $filename = $tmp[0];
            }
            
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

    public function checkAccessByBranchID($rule, $branch_id){
        if( !$this->checkAccess($rule, $branch_id) ){
            throw new CHttpException(403, "You are not authorized to perform this action.");
        }
    }

    public function checkAccessByContainer($rule, $container){
        if( !isset($container->id) ){
            $container = Container::model()->with("station")->findByPk($container);
        }
        if( !$container ){
            throw new CHttpException(403, "Access error: container does not exist.");
        }
        if( !$this->checkAccess($rule, $container->station->branch_id) ){
            throw new CHttpException(403, "You are not authorized to perform this action.");
        }
    }

    public function checkAccess($rule, $branch_id = NULL){
        switch ($rule) {
            case "readBranch":
                return $this->accessBranch($branch_id);
                break;
            case "updateBranch":
                return $this->accessBranch($branch_id, true);
                break;
            
            default:
                return Yii::app()->user->checkAccess($rule);
                break;
        }
        // checkAccess
    }

    public function accessBranch($branch_id = NULL, $update = false){
        $branch_id = (isset($_GET["branch_id"]) && $branch_id === NULL)?$_GET["branch_id"]:$branch_id;

        foreach ($this->user->branches as $key => $branch) {
            if( $branch->branch_id == $branch_id ){
                if( $update && !$branch->w ){
                    return false;
                }
                return true;
            }
        }

        return false;
    }

    public function accessAnyBranches($update = false){
        $user_id = Yii::app()->user->id;

        return ( UserBranch::model()->count("user_id = '$user_id'".(($update)?" AND w='1'":"")) != 0 );
    }

    public function getBackLink($name, $default, $partial = false){
        if( $partial ){
            return ( isset($_SESSION[$name]) )?$_SESSION[$name]:$default;
        }else{
            if( isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] ){
                $_SESSION[$name] = $_SERVER["HTTP_REFERER"];
                return $_SERVER["HTTP_REFERER"];
            }else{
                return $default;   
            }
        }
    }
}