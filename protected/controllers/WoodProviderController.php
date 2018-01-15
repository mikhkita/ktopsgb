<?php

class WoodProviderController extends Controller
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

	public function actionAdminIndex($partial = false){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

        $filter = new WoodProvider('filter');

		if (isset($_GET['WoodProvider'])){
            $filter->attributes = $_GET['WoodProvider'];
        }

        $dataProvider = $filter->search(50);
		$woodProviderCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"woodProviderCount" => $woodProviderCount,
				"labels" => WoodProvider::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"woodProviderCount" => $woodProviderCount,
				"labels" => WoodProvider::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new WoodProvider;

		if(isset($_POST["WoodProvider"])) {
			if( $model->updateObj($_POST["WoodProvider"]) ){
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

		if(isset($_POST["WoodProvider"])) {
			if( $model->updateObj($_POST["WoodProvider"]) ){
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
		$model = WoodProvider::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
