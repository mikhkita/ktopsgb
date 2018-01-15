<?php

class SawController extends Controller
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
				"roles" => array("readSaw"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateSaw"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $sawmill_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указана пилорама, то редиректить на первую
		$sawmills = Sawmill::model()->findAll();
		if( $sawmill_id === NULL ){
			header("Location: ".$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex', array("sawmill_id" => $sawmills[0]->id)));
			die();
		}

        $filter = new Saw('filter');

		if (isset($_GET['Saw'])){
            $filter->attributes = $_GET['Saw'];
        }

        $filter->sawmill_id = $sawmill_id;

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Saw::attributeLabels(),
			"planks" => Plank::model()->with("group")->findAll(),
			"sawmills" => $sawmills,
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($sawmill_id)
	{
		$model = new Saw;
		$model->sawmill_id = $sawmill_id;

		if(isset($_POST["Saw"])) {
			if( $model->updateObj($_POST["Saw"], $_POST["Plank"], $_POST["Worker"]) ){
				$this->actionAdminIndex(true, $model->sawmill_id);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model,
				"planks" => Plank::model()->with("group")->findAll(),
			));
		}
	}

	public function actionAdminUpdate($id)
	{
		$model = $this->loadModel($id);
		$model->getCubages();

		if(isset($_POST["Saw"])) {
			if( $model->updateObj($_POST["Saw"], $_POST["Plank"], $_POST["Worker"]) ){
				$this->actionAdminIndex(true, $model->sawmill_id);
				return true;
			}
		}else{
			$workers = array();
			foreach ($model->workers as $key => $worker) {
				array_push($workers, $worker->worker_id);
			}

			$this->renderPartial("adminUpdate",array(
				"model" => $model,
				"planks" => Plank::model()->with("group")->findAll(),
				"workers" => $workers,
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
		$model = Saw::model()->with("planks", "workers")->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
