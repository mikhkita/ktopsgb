<?php

class ParabelController extends Controller
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
				"roles" => array("readParabel"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateParabel"),
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

        $filter = new Parabel('filter');

		if (isset($_GET['Parabel'])){
            $filter->attributes = $_GET['Parabel'];
        }

        $this->readDates($filter);

        $dataProvider = $filter->search(50);
		$parabelCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"parabelCount" => $parabelCount,
				"labels" => Parabel::attributeLabels(),
				"providers" => ParabelProvider::model()->sorted()->findAll(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"parabelCount" => $parabelCount,
				"labels" => Parabel::attributeLabels(),
				"providers" => ParabelProvider::model()->sorted()->findAll(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Parabel;

		if(isset($_POST["Parabel"])) {
			if( $model->updateObj($_POST["Parabel"], $_POST["Provider"]) ){
				$this->actionAdminIndex(true);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model,
				"providers" => ParabelProvider::model()->sorted()->findAll(),
			));
		}
	}

	public function actionAdminUpdate($id)
	{
		$model = $this->loadModel($id);
		$model->getCubages();

		if(isset($_POST["Parabel"])) {
			if( $model->updateObj($_POST["Parabel"], $_POST["Provider"]) ){
				$this->actionAdminIndex(true);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
				"providers" => ParabelProvider::model()->sorted()->findAll(),
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
		$model = Parabel::model()->with("cargo.provider")->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
