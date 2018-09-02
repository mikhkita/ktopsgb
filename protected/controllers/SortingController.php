<?php

class SortingController extends Controller
{
	public function filters()
	{
		return array(
			"accessControl"
		);
	}

	public function accessRules()
	{
		return array(
			array("allow",
				"actions" => array("adminIndex"),
				"roles" => array("readOrder"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate", "adminImport", "adminSubmit"),
				"roles" => array("updateOrder"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $company_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указана компания, то редиректить на первую
		$companies = Company::model()->findAll(array("order" => "id ASC"));
		if( $company_id === NULL ){
			header("Location: ".$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex', array("company_id" => $companies[0]->id)));
			die();
		}

        $filter = new Order('filter');

        $filter->is_new = 1;
        $filter->company_id = $company_id;

		if (isset($_GET['Order'])){
            $filter->attributes = $_GET['Order'];
        }

        $dataProvider = $filter->search(10000, false, "sorting");
		$count = $filter->search(10000, true);

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Order::attributeLabels(),
			"is_new" => $is_new,
			"companies" => $companies,
			"options" => array(0 => "Не задано") + CHtml::listData(Category::model()->findAll(), 'id', 'name'),
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminImport($company_id)
	{
		if( isset($_POST["file"]) ){
			$company = Company::model()->findByPk($company_id);
			$filename = Yii::app()->params['tempFolder']."/".$_POST["file"];

			$client = new BankClient($company->inn);

			$params = array(
				"error" => NULL,
				"company_id" => $company_id
			);

			if( $orders = $client->readOrders($filename) ){
				$countOrders = count($orders);
				$countWarnings = count($client->warnings);
				$percent = $countWarnings/$countOrders*100;

				if( $countWarnings ){
					if( $percent > 80 ){
						$params["error"] = "Загружен неверный файл (возможно неверная компания)";
					}else{
						$params["error"] = implode("<br>", $client->warnings);
					}
				}else{// Если нет ошибок, то добавляем платежные поручения

					$corrArr = $client->getCorrArr();

					// Добавляем новых корреспондентов, если есть такие
					Correspondent::addNew($client->getCorrArr());

					// Получаем всех корреспондентов
					$corrs = Correspondent::findAllByInn( $this->getIds($corrArr, "inn") );

					// Добавляем новые поручения, если такие есть
					Order::addNew($company_id, $orders, $corrs);

					header("Location: ".$this->createUrl("/".$this->adminMenu["cur"]->code."/adminIndex", array("company_id" => $company_id)));
				}
			}else{
				echo $client->error;
				$params["error"] = "Не удалось получить платежные поручения из файла";
			}

			$this->render("adminImport", $params);
		}else{
			$this->renderPartial("adminImportForm",array(
				// "model" => $model,
			));
		}

		// $data = array();
		// foreach ($variable as $key => $value) {
		// 	# code...
		// }

		// foreach ($orders as $key => $order) {
		// 	$newOrder = new Order();
		// 	$newOrder
		// }


		// print_r($orders);
		// print_r($client->warnings);
		// echo $client->error;
	}

	public function actionAdminUpdate($id)
	{
		$model = $this->loadModel($id);
		$json = array(
			"result" => "error",
			"error" => "Отсутствуют данные",
		);
		if(isset($_POST["Order"]) && isset($_POST["Order"]["category_id"])) {
			$model->category_id = $_POST["Order"]["category_id"];
			$model->date = $model->original_date;

			if( $model->save() ){
				$json = array(
					"result" => "success",
				);
			}
		}
		$json["category_id"] = $model->category_id;

		echo json_encode($json);
	}

	public function actionAdminSubmit($company_id){
		Order::model()->updateAll(array("is_new" => 0), "company_id=$company_id AND category_id != 0");

		$this->actionAdminIndex(false, $company_id);		 
		// header("Location: ".$this->createUrl("/".$this->adminMenu["cur"]->code."/adminIndex", array("company_id" => $company_id)));
	}

	public function loadModel($id)
	{
		$model = Order::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
