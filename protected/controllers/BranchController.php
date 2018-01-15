<?php

class BranchController extends Controller
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

        $filter = new Branch('filter');

		if (isset($_GET['Branch'])){
            $filter->attributes = $_GET['Branch'];
        }

        $dataProvider = $filter->search(50);
		$branchCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"branchCount" => $branchCount,
				"labels" => Branch::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"branchCount" => $branchCount,
				"labels" => Branch::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Branch;

		if(isset($_POST["Branch"])) {
			if( $model->updateObj($_POST["Branch"]) ){
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

		if(isset($_POST["Branch"])) {
			if( $model->updateObj($_POST["Branch"]) ){
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
		$model = Branch::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
