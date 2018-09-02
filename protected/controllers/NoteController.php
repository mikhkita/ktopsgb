<?php

class NoteController extends Controller
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
				"actions" => array("adminIndex", "adminView", "adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("readContainer"),
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

        $filter = new Note('filter');

		if (isset($_GET['Note'])){
            $filter->attributes = $_GET['Note'];
        }

        $dataProvider = $filter->search(50);
		$count = $filter->search(50, true);

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Note::attributeLabels(),
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminView($container_id)
	{
		$filter = new Note('filter');

		$filter->container_id = $container_id;

        $dataProvider = $filter->search(256);

		$params = array(
			"data" => $dataProvider->getData(),
			"labels" => Note::attributeLabels(),
		);

		$this->renderPartial("adminView", $params);
	}

	public function actionAdminCreate($container_id, $index = false, $state_id = NULL, $archive = 0)
	{
		$this->checkAccessByContainer("updateBranch", $container_id);

		$model = new Note;
		$model->container_id = $container_id;
		$model->user_id = $this->user->id;

		if(isset($_POST["Note"])) {
			if( (isset($_POST["Note"]["text"]) && $_POST["Note"]["text"] != "") || isset($_POST["uploaderPj_count"]) && intval($_POST["uploaderPj_count"]) > 0 ){
				if( $model->updateObj($_POST["Note"]) ){
					if(isset($_POST["Remove"]) && count($_POST["Remove"]) > 0){
						$this->removeFiles($_POST["Remove"]);
					}

					if(isset($_POST["uploaderPj_count"]) && intval($_POST["uploaderPj_count"]) > 0){
						$this->addFiles($model->id);
					}

					// $this->sendNoteMail( $this->loadModel($model->id) );
				}
			}
			$this->redirect($model->container_id, $index, ( ($state_id !== NULL)?array("state_id" => $state_id, "archive" => $archive):array("archive" => $archive) ) );
			return true;
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminUpdate($id, $index = false, $state_id = NULL, $archive = 0)
	{
		$model = $this->loadModel($id);

		$this->checkAccessByContainer("updateBranch", $model->container_id);

		if(isset($_POST["Note"])) {
			if( $model->updateObj($_POST["Note"]) ){

				if(isset($_POST["Remove"]) && count($_POST["Remove"]) > 0){
					$this->removeFiles($_POST["Remove"]);
				}

				if(isset($_POST["uploaderPj_count"]) && intval($_POST["uploaderPj_count"]) > 0){
					$this->addFiles($model->id);
				}

				$this->redirect($model->container_id, $index, ( ($state_id !== NULL)?array("state_id" => $state_id, "archive" => $archive):array("archive" => $archive) ) );
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminDelete($id, $index = false, $state_id = NULL, $archive = 0)
	{
		$model = $this->loadModel($id);
		$this->checkAccessByContainer("updateBranch", $model->container_id);

		$container_id = $model->container_id;
		$model->delete();

		$this->redirect($container_id, $index, ( ($state_id !== NULL)?array("state_id" => $state_id, "archive" => $archive):array("archive" => $archive) ) );
	}

	public function redirect($id = NULL, $index = false, $params = array()){
		if( $index ){
			header("Location: ".Yii::app()->createUrl('/container/adminindex',array("partial" => true) + $params));
		}else{
			header("Location: ".Yii::app()->createUrl('/container/adminview',array("partial" => true, "id" => $id) + $params));
		}
	}

	public function loadModel($id)
	{
		$model = Note::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
