<?php

class WorkController extends Controller
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
				"roles" => array("readWorker"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateWorker"),
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

        $filter = new Day('filter');

		if (isset($_GET['Day'])){
            $filter->attributes = $_GET['Day'];
        }

        $this->readDates($filter);

        $dataProvider = $filter->searchPost(50);
		$count = $filter->searchPost(50, true);

		$total = Salary::getTotal($filter);

		$params = array(
			"data" => $dataProvider->getData(),
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Day::attributeLabels(),
			"total" => $total,
		);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate()
	{
		$model = new Day;

		if(isset($_POST["Day"])) {
			$model->updateWork(false, $_POST["Day"]["date"], $_POST["Worker"]);
			
			$this->actionAdminIndex(true);
		} else {
			$workers = Worker::model()->findAll("post_id != 1");
			$salary = array();

			$workerLabels = Worker::attributeLabels();
			$salaryLabels = Salary::attributeLabels();
			$labels = array(
				"name" => $workerLabels["name"],
				"k" => $salaryLabels["k"],
				"day_pay" => $salaryLabels["day_pay"]
			);
			
			$this->renderPartial("adminCreate",array(
				"model" => $model,
				"workers" => $workers,
				"salary" => $salary,
				"labels" => $labels
			));
		}
	}

	public function actionAdminUpdate($id)
	{
		$model = Day::model()->findByPk($id);

		if(isset($_POST["Day"])) {
			$model->updateWork($id, $_POST["Day"]["date"], $_POST["Worker"]);
			
			$this->actionAdminIndex(true);
		}else{
			$workers = Worker::model()->findAll("post_id != 1");
			$salary = $this->getAssoc(Salary::model()->findAll("day_id = '".$id."'"), "worker_id");

			$workerLabels = Worker::attributeLabels();
			$salaryLabels = Salary::attributeLabels();
			$labels = array(
				"name" => $workerLabels["name"],
				"k" => $salaryLabels["k"],
				"day_pay" => $salaryLabels["day_pay"]
			);

			$this->renderPartial("adminUpdate",array(
				"model" => $model,
				"workers" => $workers,
				"salary" => $salary,
				"labels" => $labels
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
		$model = Work::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
