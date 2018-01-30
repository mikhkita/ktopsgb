<?php

class ContainerController extends Controller
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
				"actions" => array("adminUpdate", "adminDelete", "adminCreate", "adminCargoIndex", "adminCargoCreate", "adminCargoUpdate", "adminCargoDelete", "adminLocationHistory"),
				"roles" => array("updateContainer"),
			),
			array("allow",
				"actions" => array("adminLocation"),
				"roles" => array("updateLocation"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $branch_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указан тип, то редиректить на первый
		$branches = Branch::model()->findAll();
		
		if( $branch_id === NULL ){
			header("Location: ".$this->createUrl("/".$this->adminMenu["cur"]->code."/adminindex", array("branch_id" => $branches[0]->id)));
			die();
		}

        $filter = new Container("filter");

		if (isset($_GET["Container"])){
            $filter->attributes = $_GET["Container"];
        }

        $dataProvider = $filter->search(50, $branch_id);

		$data = $dataProvider->getData();

		$count = Container::model()->count($criteria);

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Container::attributeLabels(),
			"branches" => $branches,
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($branch_id)
	{
		$model = new Container;

		if(isset($_POST["Container"])) {
			if( $model->updateObj($_POST["Container"]) ){
				$this->actionAdminIndex(true, $branch_id);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model
			));
		}
	}

	public function actionAdminUpdate($id, $branch_id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["Container"])) {
			if( $model->updateObj($_POST["Container"]) ){
				$this->actionAdminIndex(true, $branch_id);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminDelete($id, $branch_id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true, $branch_id);
	}

	public function actionAdminLocation($id, $branch_id)
	{
		$container = $this->loadModel($id);
		$model = new Location;

		if(isset($_POST["Location"])) {
			if( $model->updateObj($_POST["Location"]) ){
				$this->actionAdminIndex(true, $branch_id);
				return true;
			}
		}else{
			$model->container_id = $id;

			$this->renderPartial("adminLocation",array(
				"model" => $model,
				"container" => $container
			));
		}
	}

	public function actionAdminLocationHistory($id, $partial = false)
	{
		$container = $this->loadModel($id);

		$filter = new Location("filter");

		$filter->container_id = $id;

        $dataProvider = $filter->search(500);

		$data = $dataProvider->getData();

		$params = array(
			"data" => $dataProvider->getData(),
			"container" => $container,
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"labels" => Location::attributeLabels(),
		);

		if( !$partial ){
			$this->render("adminLocationHistory", $params);
		}else{
			$this->renderPartial("adminLocationHistory", $params);
		}
	}

	public function actionAdminCargoIndex($partial = false, $container_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		$container = $this->loadModel($container_id);
		$model = Cargo::model()->findAll("container_id='$container_id'");

		$params = array(
			"data" => $model,
			"labels" => Cargo::attributeLabels(),
			"container" => $container,
			"total" => Cargo::getTotal($model)
		);

		if( !$partial ){
			$this->render("cargo/adminIndex", $params);
		}else{
			$this->renderPartial("cargo/adminIndex", $params);
		}
	}

	public function actionAdminCargoCreate($container_id)
	{
		$model = new Cargo;

		if(isset($_POST["Cargo"])) {
			if( $model->updateObj($_POST["Cargo"]) ){
				$this->actionAdminCargoIndex(true, $container_id);
				return true;
			}
		} else {
			$this->renderPartial("cargo/adminCreate",array(
				"model" => $model
			));
		}
	}

	public function actionAdminCargoUpdate($id, $container_id)
	{
		$model = Cargo::model()->findByPk($id);

		if(isset($_POST["Cargo"])) {
			if( $model->updateObj($_POST["Cargo"]) ){
				$this->actionAdminCargoIndex(true, $container_id);
				return true;
			}
		}else{
			$this->renderPartial("cargo/adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminCargoDelete($id, $container_id)
	{
		Cargo::model()->findByPk($id)->delete();

		$this->actionAdminCargoIndex(true, $container_id);
	}

	public function loadModel($id)
	{
		$model = Container::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
