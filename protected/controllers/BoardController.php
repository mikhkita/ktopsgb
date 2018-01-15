<?php

class BoardController extends Controller
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
				"roles" => array("readBoard"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateBoard"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false, $plant_id = NULL){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		// Если не указан тип, то редиректить на первый
		$plants = Plant::model()->findAll();
		if( $plant_id === NULL ){
			header("Location: ".$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex', array("plant_id" => $plants[0]->id)));
			die();
		}

        $filter = new Board('filter');

		if (isset($_GET['Board'])){
            $filter->attributes = $_GET['Board'];
        }

        $this->readDates($filter);

        $filter->plant_id = $plant_id;

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);
		$total = $filter->getTotal($filter->search(999999, false, true));

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"total" => $total,
			"labels" => Board::attributeLabels(),
			"itemLabels" => BoardItem::attributeLabels(),
			"plants" => $plants,
			"curPlant" => Plant::model()->findByPk($plant_id),
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($plant_id)
	{
		$model = new Board;
		$model->plant_id = $plant_id;
		$plant = Plant::model()->findByPk($plant_id);

		if(isset($_POST["Board"])) {
			if( $model->updateObj($_POST["Board"], $_POST["Items"]) ){
				$this->actionAdminIndex(true, $plant_id);
				return true;
			}
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model,
				"plant" => $plant
			));
		}
	}

	public function actionAdminUpdate($id, $plant_id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["Board"])) {
			if( $model->updateObj($_POST["Board"], $_POST["Items"]) ){
				$this->actionAdminIndex(true, $plant_id);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
				"plant" => $model->plant
			));
		}
	}

	public function actionAdminDelete($id, $plant_id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true, $plant_id);
	}

	public function loadModel($id)
	{
		$model = Board::model()->with("plant")->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
