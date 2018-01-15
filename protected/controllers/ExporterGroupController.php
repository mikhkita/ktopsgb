<?php

class ExporterGroupController extends Controller
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

        $filter = new ExporterGroup('filter');

		if (isset($_GET['ExporterGroup'])){
            $filter->attributes = $_GET['ExporterGroup'];

            if( isset($_GET['ExporterGroup']["branch_id"]) ){
            	$filter->branch_id = $_GET['ExporterGroup']["branch_id"];
            }
        }

        $dataProvider = $filter->search(50);
		$exporterGroupCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"exporterGroupCount" => $exporterGroupCount,
				"labels" => ExporterGroup::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"exporterGroupCount" => $exporterGroupCount,
				"labels" => ExporterGroup::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new ExporterGroup;

		if(isset($_POST["ExporterGroup"])) {
			if( $model->updateObj($_POST["ExporterGroup"], $_POST["Branches"]) ){
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

		if(isset($_POST["ExporterGroup"])) {
			if( $model->updateObj($_POST["ExporterGroup"], $_POST["Branches"]) ){
				$this->actionAdminIndex(true);
				return true;
			}
		}else{
			$branches = array();
			foreach ($model->branches as $key => $branch) {
				array_push($branches, $branch->branch_id);
			}

			$this->renderPartial("adminUpdate",array(
				"model" => $model,
				"branches" => $branches,
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
		$model = ExporterGroup::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
