<?php

class CashController extends Controller
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
				"roles" => array("readCash"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateCash"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $type_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указан тип, то редиректить на первый
		$types = CashType::model()->findAll();
		if( $type_id === NULL ){
			header("Location: ".$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex', array("type_id" => $types[0]->id)));
			die();
		}

        $filter = new Cash('filter');

		if (isset($_GET["Cash"])){
            $filter->attributes = $_GET["Cash"];
        }

        $this->readDates($filter);

        $filter->type_id = $type_id;

        $dataProvider = $filter->search(50);
        $cashCount = $filter->search(50, true);
        $total = $filter->getTotal( $filter->search(50, false, true) );

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"cashCount" => $cashCount,
			"labels" => Cash::attributeLabels(),
			"types" => $types,
			"total" => $total,
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($type_id)
	{
		$model = new Cash;

		if(isset($_POST["Cash"])) {
			if( $model->updateObj($_POST["Cash"]) ){
				$this->actionAdminIndex(true, $type_id);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model
			));
		}
	}

	public function actionAdminUpdate($id, $type_id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["Cash"])) {
			if( $model->updateObj($_POST["Cash"]) ){
				$this->actionAdminIndex(true, $type_id);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminDelete($id, $type_id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true, $type_id);
	}

	public function loadModel($id)
	{
		$model = Cash::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
