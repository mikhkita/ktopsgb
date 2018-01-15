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
		if( !Yii::app()->user->isGuest ) $this->redirect($this->createUrl(Yii::app()->params["defaultAdminRedirect"]));

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
				$this->redirect($this->createUrl(Yii::app()->params["defaultAdminRedirect"]));
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

        if ( Yii::app()->user->id != 1 ) {
            throw new CHttpException(403, "Forbidden");
        }

        $auth=Yii::app()->authManager;
        
        //сбрасываем все существующие правила
        $auth->clearAll();
        
        //Операции управления пользователями.
        // $bizRule="return Yii::app()->user->id == $params["id"];";

        // Пользователи
        $auth->createOperation("readUser", "Просмотр пользователей");
        $auth->createOperation("updateUser", "Создание/изменение/удаление пользователей");

        // Контейнеры
        $auth->createOperation("readContainer", "Просмотр контейнеров");
        $auth->createOperation("updateContainer", "Создание/изменение/удаление контейнеров");
        $auth->createOperation("updateLocation", "Создание/изменение/удаление локации");

        // Сушилки
        $auth->createOperation("readDryer", "Просмотр раздела сушилок");
        $auth->createOperation("updateDryer", "Создание/изменение/удаление сушилок");
        $auth->createOperation("updateDryerQueue", "Создание/изменение загрузок в сушилки");

        // Платежи
        $auth->createOperation("readCash", "Просмотр раздела платежей");
        $auth->createOperation("updateCash", "Создание/изменение/удаление платежей");
        $auth->createOperation("widgetCash", "Виджет");

        // Пилорамы
        $auth->createOperation("readSaw", "Просмотр раздела пилорам");
        $auth->createOperation("updateSaw", "Создание/изменение/удаление пилорам");

        // $bizRule = 'return $params["type_id"] == 2;';
        // $task = $auth->createTask("updateFinCash", "Создание/изменение/удаление платежей в разделе финансов", $bizRule);
        // $task->addChild("updateCash");

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

    // Роли --------------------------------------------------- Роли

        // Администратор пользователей (полный доступ к пользователям)
        $role = $auth->createRole("userAdmin");
        $role->addChild("readUser");
        $role->addChild("updateUser");   

        // Управляющий контейнерами
        $role = $auth->createRole("containerManager");
        $role->addChild("readContainer");
        $role->addChild("updateContainer");
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

        // Управляющий отгрузками
        $role = $auth->createRole("woodManager");
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

        // Директор
        $role = $auth->createRole("director");
        $role->addChild("containerManager");
        $role->addChild("readDryer"); // Может только просматривать сушилки
        $role->addChild("cashManager");
        $role->addChild("readWood");
        $role->addChild("readBoard");
        $role->addChild("readIncoming");
        $role->addChild("readParabel");
        $role->addChild("readSaw");

        $role = $auth->createRole("root");
        $role->addChild("userAdmin"); // Администрирование пользователей
        $role->addChild("dryerAdmin"); // Администрирование сушилок
        $role->addChild("woodManager");
        $role->addChild("parabelManager");
        $role->addChild("incomingManager");
        $role->addChild("boardManager");
        $role->addChild("sawManager");
        $role->addChild("director");

    // Роли --------------------------------------------------- Роли
        
        // Связываем пользователей с ролями
        $users = User::model()->with("roles.role")->findAll();
        foreach ($users as $i => $user) {
            foreach ($user->roles as $j => $role) {
                $auth->assign($role->role->code, $user->id);
            }
        }

        // Сохраняем роли и операции
        $auth->save();
        
        $this->render("install");
    }
}
