<?php

class WoodController extends Controller
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
				"roles" => array("readWood"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateWood"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $payment_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указан тип, то редиректить на первый
		$payments = Payment::model()->findAll(array("order" => "id DESC"));
		if( $payment_id === NULL ){
			header("Location: ".$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex', array("payment_id" => $payments[0]->id)));
			die();
		}

        $filter = new Wood('filter');

		if (isset($_GET['Wood'])){
            $filter->attributes = $_GET['Wood'];
        }

        $this->readDates($filter);

		$filter->payment_id = $payment_id;

        $dataProvider = $filter->search(50);
		$woodCount = $filter->search(50, true);
		$totals = $filter->getTotals( $filter->search(999999, false, true) );

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"woodCount" => $woodCount,
			"labels" => Wood::attributeLabels(),
			"payments" => $payments,
			"totals" => $totals,
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($payment_id)
	{
		$model = new Wood;

		if(isset($_POST["Wood"])) {
			if( $model->updateObj($_POST["Wood"]) ){
				$this->actionAdminIndex(true, $payment_id);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model
			));
		}
	}

	public function actionAdminUpdate($id, $payment_id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["Wood"])) {
			if( $model->updateObj($_POST["Wood"]) ){
				$this->actionAdminIndex(true, $payment_id);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminDelete($id, $payment_id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true, $payment_id);
	}

	public function loadModel($id)
	{
		$model = Wood::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
