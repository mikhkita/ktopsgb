<?php

class SiteController extends Controller
{
	public $layout="column1";

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			"captcha" => array(
				"class" => "CCaptchaAction",
				"backColor" => 0xFFFFFF,
			),
			// page action renders "static" pages stored under "protected/views/site/pages"
			// They can be accessed via: index.php?r=site/page&view=FileName
			"page" => array(
				"class" => "CViewAction",
			),
		);
	}

    public function accessRules()
    {
        return array(
            array("allow",
                "actions" => array("notifications"),
                "users" => array("*"),
            ),
            array("allow",
                "actions" => array("download", "viewFile"),
                "roles" => array("readContainer"),
            ),
            array("allow",
                "actions" => array("upload", "install"),
                "roles" => array("updateContainer"),
            ),
            array("allow",
                "actions" => array("error", "index", "login", "logout"),
                "users" => array("*"),
            ),
            array("deny",
                "users" => array("*"),
            ),
        );
    }

    public function actionDownload($file_id){
        $file = File::model()->findByPk($file_id);
        if($file===null)
            throw new CHttpException(404, "The requested page does not exist.");

        $this->downloadFile(Yii::app()->params['saveFolder']."/".$file->name, $file->original);
    }

    public function actionViewFile($file_id){
        $file = File::model()->findByPk($file_id);
        if($file===null)
            throw new CHttpException(404, "The requested page does not exist.");

        $filename = Yii::app()->params['saveFolder']."/".$file->name;
        if (file_exists($filename)) {
            $ext = array_pop(explode(".", $filename));
            // header('Content-Description: File Transfer');
            switch (strtolower($ext)) {
                case "pdf":
                    header('Content-Type: application/pdf');
                    break;
                case "jpg":
                case "jpeg":
                case "png":
                case "gif":
                case "gif":
                    header('Content-Type: image/'.$ext);
                    break;
                
                default:
                    header('Content-Type: application/octet-stream');
                    break;
            }
            // header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            // header('Expires: 0');
            // header('Cache-Control: must-revalidate');
            // header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        }

        // readfile(Yii::app()->params['saveFolder']."/".$file->name);
        // $this->downloadFile(, $file->original);
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->layout="service";
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error["message"];
	    	else
	        	$this->render("error", $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST["ContactForm"]))
		{
			$model->attributes=$_POST["ContactForm"];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params["adminEmail"], $model->subject, $model->body, $headers);
				Yii::app()->user->setFlash("contact", "Thank you for contacting us. We will respond to you as soon as possible.");
				$this->refresh();
			}
		}
		$this->render("contact",array("model" => $model));
	}

	/**
	 * Displays the login page
	 */
	public function actionIndex(){
		$this->redirect(array("login"));
	}

	public function actionLogin()
	{
        $this->layout="service";
		if( !Yii::app()->user->isGuest ){
            foreach ($this->adminMenu["items"]as $key => $modelName) {
                if( $modelName->rule !== NULL && Yii::app()->user->checkAccess($modelName->rule) ){
                    $this->redirect($this->createUrl("admin/".$modelName->code));
                }
            }
        }

		// $this->layout="admin";
		if (!defined("CRYPT_BLOWFISH")||!CRYPT_BLOWFISH)
			throw new CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST["ajax"]) && $_POST["ajax"]==="login-form")
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST["LoginForm"]))
		{
			$model->attributes=$_POST["LoginForm"];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
                foreach ($this->adminMenu["items"]as $key => $modelName) {
                    if( $modelName->rule !== NULL && Yii::app()->user->checkAccess($modelName->rule) ){
                        $this->redirect($this->createUrl("admin/".$modelName->code));
                    }
                }
		}
		// display the login form
		$this->render("login",array("model" => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionUpload(){
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        /* 
        // Support CORS
        header("Access-Control-Allow-Origin: *");
        // other CORS headers if any...
        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            exit; // finish preflight CORS requests here
        }
        */

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
        // usleep(5000);

        // Settings
        $targetDir = "upload/images";
        //$targetDir = "uploads";
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 60 * 3600; // Temp file age in seconds


        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        echo $filePath;

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


        // Remove old temp files    
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match("/\.part$/", $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }   


        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {    
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $filePath);
        }

        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

	/*! Сброс всех правил. */
    public function actionInstall() {
        $this->layout="service";

        if ( Yii::app()->user->id != 1 ) {
            throw new CHttpException(403, "Forbidden");
        }

        $auth=Yii::app()->authManager;
        
        //сбрасываем все существующие правила
        $auth->clearAll();
        
        //Операции управления пользователями.
        // $bizRule="return Yii::app()->user->id == $params["id"];";

        // Просмотр статистики
        $auth->createOperation("readStats", "Просмотр статистики");

        $auth->createOperation("adminAction", "Действия администратора");

        // Пользователи
        $auth->createOperation("readUser", "Просмотр пользователей");
        $auth->createOperation("updateUser", "Создание/изменение/удаление пользователей");

        // Контейнеры
        $auth->createOperation("readContainer", "Просмотр контейнеров");
        $auth->createOperation("updateContainer", "Создание/изменение/удаление контейнеров");
        $auth->createOperation("updateLocation", "Создание/изменение/удаление локации");
        // $auth->createOperation("readBranch", "Просмотр контейнеров в филиале");
        // $auth->createOperation("readAnyBranches", "Просмотр хотя бы одного филиала");

        // $task = $auth->createTask("readBranch", "Просмотр контейнеров в филиале", 'return Controller::accessBranch($params["branch_id"]);');
        // $task->addChild("readContainer");

        $task = $auth->createTask("readAnyBranches", "Просмотр хотя бы одного филиала", 'return Controller::accessAnyBranches();');
        $task->addChild("readContainer");

        $task = $auth->createTask("updateAnyBranches", "Создание/изменение/удаление хотя бы одного филиала", 'return Controller::accessAnyBranches(true);');
        $task->addChild("updateContainer");

        // Сушилки
        $auth->createOperation("readDryer", "Просмотр раздела сушилок");
        $auth->createOperation("updateDryer", "Создание/изменение/удаление сушилок");
        $auth->createOperation("updateDryerQueue", "Создание/изменение загрузок в сушилки");

        // Платежи
        $auth->createOperation("readCash", "Просмотр раздела платежей");
        $auth->createOperation("updateCash", "Создание/изменение/удаление платежей");

        // Пилорамы
        $auth->createOperation("readSaw", "Просмотр раздела пилорам");
        $auth->createOperation("updateSaw", "Создание/изменение/удаление пилорам");

        // Китайцы
        $auth->createOperation("readChina", "Просмотр раздела рабочих китайцев");
        $auth->createOperation("updateChina", "Создание/изменение/удаление рабочих китайцев");

        // Рабочие
        $auth->createOperation("readWorker", "Просмотр раздела рабочих");
        $auth->createOperation("updateWorker", "Создание/изменение/удаление рабочих");

        // Перекладка
        $auth->createOperation("readReloc", "Просмотр раздела перекладок");
        $auth->createOperation("updateReloc", "Создание/изменение/удаление перекладок");

        // Корреспонденты
        $auth->createOperation("readCorr", "Просмотр корреспондентов");
        $auth->createOperation("updateCorr", "Создание/изменение/удаление корреспондентов");

        // Отгрузки
        $auth->createOperation("readWood", "Просмотр раздела отгрузок");
        $auth->createOperation("updateWood", "Создание/изменение/удаление отгрузок");

        // Машины из парабели
        $auth->createOperation("readParabel", "Просмотр раздела машины из Парабели");
        $auth->createOperation("updateParabel", "Создание/изменение/удаление отгрузок");

        // Входящий транспорт
        $auth->createOperation("readIncoming", "Просмотр раздела входящий транспорт");
        $auth->createOperation("updateIncoming", "Создание/изменение/удаление транспорта");

        // Доски Чин
        $auth->createOperation("readBoard", "Просмотр раздела доски Чин");
        $auth->createOperation("updateBoard", "Создание/изменение/удаление раздела доски Чин");

        // Платежные поручения
        $auth->createOperation("readOrder", "Просмотр платежных поручений");
        $auth->createOperation("updateOrder", "Создание/изменение/удаление платежных поручений");

    // Виджеты ------------------------------------------------ Виджеты
        // Статистика
        $role = $auth->createRole("widgetStats");
        $role->addChild("readStats");
    // Виджеты ------------------------------------------------ Виджеты

    // Роли --------------------------------------------------- Роли

        // Администратор пользователей (полный доступ к пользователям)
        $role = $auth->createRole("userAdmin");
        $role->addChild("readUser");
        $role->addChild("updateUser");   

        // Управляющий контейнерами
        $role = $auth->createRole("containerManager");
        $role->addChild("readContainer");
        $role->addChild("updateContainer");

        // Управление дислокацией
        $role = $auth->createRole("locationManager");
        $role->addChild("updateLocation");

        // Управляющий сушилками
        $role = $auth->createRole("dryerManager");
        $role->addChild("readDryer");
        $role->addChild("updateDryerQueue");

        // Администратор сушилок (полный доступ к сушилкам)
        $role = $auth->createRole("dryerAdmin");
        $role->addChild("dryerManager");
        $role->addChild("updateDryer");

        // Управляющий финансами
        $role = $auth->createRole("cashManager");
        $role->addChild("readCash");
        $role->addChild("updateCash");

        // Управляющий корреспондентами
        $role = $auth->createRole("corrManager");
        $role->addChild("readCorr");
        $role->addChild("updateCorr");

        // Управляющий отгрузками
        $role = $auth->createRole("woodManager");
        $role->addChild("corrManager");
        $role->addChild("readWood");
        $role->addChild("updateWood");

        // Управляющий машинами из Парабели
        $role = $auth->createRole("parabelManager");
        $role->addChild("readParabel");
        $role->addChild("updateParabel");

        // Управляющий входящим транспортом
        $role = $auth->createRole("incomingManager");
        $role->addChild("readIncoming");
        $role->addChild("updateIncoming");

        // Управляющий досками Чин
        $role = $auth->createRole("boardManager");
        $role->addChild("readBoard");
        $role->addChild("updateBoard");

        // Управляющий пилорамами
        $role = $auth->createRole("sawManager");
        $role->addChild("readSaw");
        $role->addChild("updateSaw");

        // Управляющий китайцами
        $role = $auth->createRole("chinaManager");
        $role->addChild("readChina");
        $role->addChild("updateChina");

        // Управляющий рабочими
        $role = $auth->createRole("workerManager");
        $role->addChild("readWorker");
        $role->addChild("updateWorker");

        // Управляющий перекладкой
        $role = $auth->createRole("relocManager");
        $role->addChild("readReloc");
        $role->addChild("updateReloc");

        // Управляющий платежными поручениями
        $role = $auth->createRole("orderManager");
        $role->addChild("corrManager");
        $role->addChild("readOrder");
        $role->addChild("updateOrder");

        // Директор
        $role = $auth->createRole("director");
        $role->addChild("containerManager");
        $role->addChild("dryerManager"); // Может только просматривать сушилки
        $role->addChild("cashManager");
        $role->addChild("woodManager");
        $role->addChild("boardManager");
        $role->addChild("incomingManager");
        $role->addChild("parabelManager");
        $role->addChild("chinaManager");
        $role->addChild("sawManager");
        $role->addChild("workerManager");
        $role->addChild("relocManager");
        $role->addChild("orderManager");
        $role->addChild("widgetStats");

        $role = $auth->createRole("root");
        $role->addChild("adminAction");
        $role->addChild("userAdmin"); // Администрирование пользователей
        $role->addChild("director");

    // Роли --------------------------------------------------- Роли
        
        // Связываем пользователей с ролями
        $users = User::model()->with("roles.role")->findAll();
        foreach ($users as $i => $user) {
            // $auth->assign("readBranch", $user->id);
            $auth->assign("readAnyBranches", $user->id);
            $auth->assign("updateAnyBranches", $user->id);

            foreach ($user->roles as $j => $role) {
                $auth->assign($role->role->code, $user->id);
            }
        }

        // Сохраняем роли и операции
        $auth->save();
        
        $this->render("install");
    }
}
