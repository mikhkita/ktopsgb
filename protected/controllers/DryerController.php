<?php

class DryerController extends Controller
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
				"actions" => array("adminIndex", "adminDetail"),
				"roles" => array("readDryer"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateDryer"),
			),
			array("allow",
				"actions" => array("adminQueueUpdate", "adminQueueDelete", "adminQueueCreate", "adminQueueComplete", "adminOn", "adminOff"),
				"roles" => array("updateDryerQueue"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex($partial = false){
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

        $model = Dryer::model()->with("queue:last:incomplete")->findAll(array("order" => "t.id ASC"));

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $model,
				"labels" => Dryer::attributeLabels(),
				"queueLabels" => DryerQueue::attributeLabels(),
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $model,
				"labels" => Dryer::attributeLabels(),
				"queueLabels" => DryerQueue::attributeLabels(),
			));
		}
	}

	public function actionAdminCreate()
	{
		$model = new Dryer;

		if(isset($_POST["Dryer"])) {
			if( $model->updateObj($_POST["Dryer"]) ){
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

		if(isset($_POST["Dryer"])) {
			if( $model->updateObj($_POST["Dryer"]) ){
				$this->actionAdminIndex(true);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminOn($id)
	{
		$model = $this->loadModel($id);

		$model->switch = 1;
		if( $model->save() ){
			echo "Работает";
		}else{
			echo "0";
		}
	}

	public function actionAdminOff($id)
	{
		$model = $this->loadModel($id);

		$model->switch = 0;
		if( $model->save() ){
			echo "Выключена";
		}else{
			echo "0";
		}
	}

	public function actionAdminDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true);
	}

	public function actionAdminDetail($dryerID, $partial = false)
	{
		$dryer = Dryer::model()->findByPk($dryerID);
		$model = DryerQueue::model()->findAll(array("condition" => "dryer_id='$dryerID'", "order" => "start_date DESC, id DESC"));

		if( !$partial ){
			$this->layout = "admin";
		}

		if( !$partial ){
			$this->render("adminDetail",array(
				"dryer" => $dryer,
				"data" => $model,
				"labels" => DryerQueue::attributeLabels()
			));
		}else{
			$this->renderPartial("adminDetail",array(
				"dryer" => $dryer,
				"data" => $model,
				"labels" => DryerQueue::attributeLabels()
			));
		}
	}

	public function actionAdminQueueCreate($dryer_id = NULL, $dryers = false)
	{
		$model = new DryerQueue;

		if(isset($_POST["DryerQueue"])) {
			if( $model->updateObj($_POST["DryerQueue"], $dryer_id) ){
				if( $dryers ){
					$this->actionAdminIndex(true);
				}else{
					$this->actionAdminDetail($model->dryer_id, true);
				}
				return true;
			}
		} else {
			$this->renderPartial("adminQueueCreate",array(
				"model" => $model
			));
		}
	}

	public function actionAdminQueueUpdate($id, $dryers = false)
	{
		$model = $this->loadQueueModel($id);

		if(isset($_POST["DryerQueue"])) {
			if( $model->updateObj($_POST["DryerQueue"]) ){
				if( $dryers ){
					$this->actionAdminIndex(true);
				}else{
					$this->actionAdminDetail($model->dryer_id, true);
				}
				return true;
			}
		}else{
			$this->renderPartial("adminQueueUpdate",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminQueueComplete($id)
	{
		$model = $this->loadQueueModel($id);

		if(isset($_POST["DryerQueue"])) {
			if( $model->updateObj($_POST["DryerQueue"]) ){
				$this->actionAdminIndex(true);
				return true;
			}
		}else{
			$this->renderPartial("adminQueueComplete",array(
				"model" => $model,
			));
		}
	}

	public function actionAdminQueueDelete($id)
	{
		$model = $this->loadQueueModel($id);
		$dryerID = $model->dryer_id;
		$model->delete();

		$this->actionAdminDetail($model->dryer_id, true);
	}

	public function loadModel($id)
	{
		$model = Dryer::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}

	public function loadQueueModel($id)
	{
		$model = DryerQueue::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
