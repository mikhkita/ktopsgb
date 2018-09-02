<?php

class ExporterController extends Controller
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

        $filter = new Exporter('filter');

		if (isset($_GET['Exporter'])){
            $filter->attributes = $_GET['Exporter'];
        }

        $dataProvider = $filter->search(50);
		$exporterCount = $filter->search(50, true);

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"exporterCount" => $exporterCount,
				"labels" => Exporter::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $dataProvider->getData(),
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"exporterCount" => $exporterCount,
				"labels" => Exporter::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Exporter;

		if(isset($_POST["Exporter"])) {
			if( $model->updateObj($_POST["Exporter"], $_POST["Branches"]) ){
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

		if(isset($_POST["Exporter"])) {
			if( $model->updateObj($_POST["Exporter"], $_POST["Branches"]) ){
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
				"branches" => $branches
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
		$model = Exporter::model()->with("branches")->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
