<?php

class IncomingController extends Controller
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
				"roles" => array("readIncoming"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateIncoming"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $place_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указан тип, то редиректить на первый
		$places = IncomingPlace::model()->findAll();
		if( $place_id === NULL ){
			header("Location: ".$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex', array("place_id" => $places[0]->id)));
			die();
		}

        $filter = new Incoming('filter');

		if (isset($_GET['Incoming'])){
            $filter->attributes = $_GET['Incoming'];
        }

        $this->readDates($filter);

        $filter->place_id = $place_id;

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Incoming::attributeLabels(),
			"places" => $places,
			"curPlace" => IncomingPlace::model()->findByPk($place_id),
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($place_id)
	{
		$model = new Incoming;
		$model->place_id = $place_id;

		if(isset($_POST["Incoming"])) {
			if( $model->updateObj($_POST["Incoming"]) ){
				$this->actionAdminIndex(true, $place_id);
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

		if(isset($_POST["Incoming"])) {
			if( $model->updateObj($_POST["Incoming"]) ){
				$this->actionAdminIndex(true, $model->place_id);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminDelete($id, $place_id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true, $place_id);
	}

	public function loadModel($id)
	{
		$model = Incoming::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
