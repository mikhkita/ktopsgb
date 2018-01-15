<?php

class IncomingController extends Controller
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
				"roles" => array("readIncoming"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateIncoming"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

        $filter = new Incoming('filter');

		if (isset($_GET['Incoming'])){
            $filter->attributes = $_GET['Incoming'];
        }

        $dataProvider = $filter->search(50);
		$incomingCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"incomingCount" => $incomingCount,
				"labels" => Incoming::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"incomingCount" => $incomingCount,
				"labels" => Incoming::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Incoming;

		if(isset($_POST["Incoming"])) {
			if( $model->updateObj($_POST["Incoming"]) ){
				$this->actionAdminIndex(true);
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

		if(isset($_POST["Incoming"])) {
			if( $model->updateObj($_POST["Incoming"]) ){
				$this->actionAdminIndex(true);
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
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true);
	}

	public function loadModel($id)
	{
		$model = Incoming::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
