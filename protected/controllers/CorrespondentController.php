<?php

class CorrespondentController extends Controller
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
				"roles" => array("readCorr"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateCorr"),
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

        $filter = new Correspondent('filter');

        $filter->is_provider = NULL;

		if (isset($_GET['Correspondent'])){
            $filter->attributes = $_GET['Correspondent'];
        }

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"count" => $count,
				"labels" => Correspondent::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"count" => $count,
				"labels" => Correspondent::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Correspondent;

		if(isset($_POST["Correspondent"])) {
			if( $model->updateObj($_POST["Correspondent"]) ){
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

		if(isset($_POST["Correspondent"])) {
			if( $model->updateObj($_POST["Correspondent"]) ){
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
		$model = $this->loadModel($id);
		$model->active = 0;
		$model->save();

		$this->actionAdminindex(true);
	}

	public function loadModel($id)
	{
		$model = Correspondent::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
