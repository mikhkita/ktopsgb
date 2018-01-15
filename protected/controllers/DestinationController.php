<?php

class DestinationController extends Controller
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
				"roles" => array("readContainer"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateContainer"),
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

        $filter = new Destination('filter');

		if (isset($_GET['Destination'])){
            $filter->attributes = $_GET['Destination'];
        }

        $dataProvider = $filter->search(50);
		$destinationCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex", array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"destinationCount" => $destinationCount,
				"labels" => Destination::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex", array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"destinationCount" => $destinationCount,
				"labels" => Destination::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Destination;

		if(isset($_POST["Destination"])) {
			if( $model->updateObj($_POST["Destination"]) ){
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

		if(isset($_POST["Destination"])) {
			if( $model->updateObj($_POST["Destination"]) ){
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
		$model = Destination::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
