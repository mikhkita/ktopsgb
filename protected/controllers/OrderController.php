<?php

class OrderController extends Controller
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
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
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

        $this->readDates($filter);

        $filter->is_new = 0;
        $filter->company_id = $company_id;

		if (isset($_GET['Order'])){
            $filter->attributes = $_GET['Order'];
        }

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);
		$total = $filter->getTotal( $filter->search(50, false, "Order", true) );

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Order::attributeLabels(),
			"is_new" => $is_new,
			"companies" => $companies,
			"total" => $total,
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($company_id)
	{
		$model = new Order;

		if(isset($_POST["Order"])) {
			if( $model->updateObj($_POST["Order"]) ){
				$this->actionAdminIndex(true, $company_id);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model
			));
		}
	}

	public function actionAdminUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["Order"])) {
			if( $model->updateObj($_POST["Order"]) ){
				$this->actionAdminIndex(true, $model->company_id);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminDelete($id)
	{
		$model = $this->loadModel($id);
		$company_id = $model->company_id;
		$model->delete();

		$this->actionAdminindex(true, $model->company_id);
	}

	public function loadModel($id)
	{
		$model = Order::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
