<?php

class ChinaController extends Controller
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
				"roles" => array("readChina"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateChina"),
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

        $filter = new China('filter');

		if (isset($_GET['China'])){
            $filter->attributes = $_GET['China'];
        }

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);
		$total = $filter->getAllMoney($filter->search(50, false, true));

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => China::attributeLabels(),
			"plankGroups" => PlankGroup::model()->findAll(),
			"total" => $total
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate()
	{
		$model = new China;

		if(isset($_POST["China"])) {
			if( $model->updateObj($_POST["China"]) ){
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

		if(isset($_POST["China"])) {
			if( $model->updateObj($_POST["China"]) ){
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
		$model = China::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
