<?php

class StatsController extends Controller
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

	public function actionAdminIndex($partial = false){
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		$startDate = "01.01.".date("Y", time());
		$months = array(
			1 => array(
				"name" => "Январь",
				"finance" => array(),
				"cubage" => array()
			),
			2 => array(
				"name" => "Февраль",
				"finance" => array(),
				"cubage" => array()
			),
			3 => array(
				"name" => "Март",
				"finance" => array(),
				"cubage" => array()
			),
			4 => array(
				"name" => "Апрель",
				"finance" => array(),
				"cubage" => array()
			),
			5 => array(
				"name" => "Май",
				"finance" => array(),
				"cubage" => array()
			),
			6 => array(
				"name" => "Июнь",
				"finance" => array(),
				"cubage" => array()
			),
			7 => array(
				"name" => "Июль",
				"finance" => array(),
				"cubage" => array()
			),
			8 => array(
				"name" => "Август",
				"finance" => array(),
				"cubage" => array()
			),
			9 => array(
				"name" => "Сентябрь",
				"finance" => array(),
				"cubage" => array()
			),
			10 => array(
				"name" => "Октярь",
				"finance" => array(),
				"cubage" => array()
			),
			11 => array(
				"name" => "Ноябрь",
				"finance" => array(),
				"cubage" => array()
			),
			12 => array(
				"name" => "Декабрь",
				"finance" => array(),
				"cubage" => array()
			),
		);

		// Получаем все платежи за год
		$cashFilter = new Cash('filter');
		$cashFilter->date_from = $startDate;
		$cash = $cashFilter->search(99999999)->getData();

		// Получаем используемые типы платежей
		$typesId = $this->getIds($cashFilter->search(99999999, false, false, "type_id" )->getData(), "type_id");
		$types = CashType::model()->findAll("id IN (".implode(",", $typesId).")");

		// Заносим названия столбцов платежей и обнуляем сумму
		foreach ($months as $i => $month) {
			foreach ($types as $j => $type) {
				$months[$i]["finance"]["c".$type->id] = array(
					"name" => $type->name,
					"sum" => 0,
					"negative" => false
				);
			}
		}

		// Суммируем платежи по месяцам
		foreach ($cash as $key => $item) {
			$monthId = intval(date("n", strtotime($item->date)));

			if( $item->negative ){
				$months[$monthId]["finance"]["c".$item->type_id]["sum"] -= $item->sum;
			}else{
				$months[$monthId]["finance"]["c".$item->type_id]["sum"] += $item->sum;
			}	
		}

		// Получаем все отгрузки за год
		$woodFilter = new Wood('filter');
		$woodFilter->date_from = $startDate;
		$woodFilter->payment_id = 1;
		$woodFilter->group_id = NULL;
		$wood = $woodFilter->search(99999999)->getData();

		// Получаем используемые группы отгрузок
		$groupId = $this->getIds($woodFilter->search(99999999, false, false, false, "group_id" )->getData(), "group_id");
		$groups = WoodGroup::model()->findAll("id IN (".implode(",", $groupId).")");

		// Получаем используемые породы
		$speciesId = $this->getIds($woodFilter->search(99999999, false, false, false, "species_id" )->getData(), "species_id");
		$species = Species::model()->findAll("id IN (".implode(",", $speciesId).")");

		// Заносим название столбца суммы отгрузок и обнуляем сумму
		foreach ($months as $i => $month) {
			$months[$i]["finance"]["ws"] = array(
				"name" => "Сумма отгрузок",
				"sum" => 0,
				"negative" => true
			);

			foreach ($groups as $j => $group) {
				$months[$i]["cubage"]["w".$group->id] = array(
					"name" => $group->name,
					"sum" => 0,
					"get" => false,
				);
			}

			foreach ($species as $j => $item) {
				$months[$i]["cubage"]["s".$item->id] = array(
					"name" => $item->name,
					"sum" => 0,
					"get" => false,
				);
			}

			$months[$i]["cubage"]["m"] = array(
				"name" => "Всего за месяц",
				"sum" => 0,
				"get" => true
			);
		}

		// Суммируем отгрузки по месяцам
		foreach ($wood as $key => $item) {
			$monthId = intval(date("n", strtotime($item->date)));

			$months[$monthId]["finance"]["ws"]["sum"] += $item->sum;
			$months[$monthId]["cubage"]["w".$item->group_id]["sum"] += $item->cubage;
			$months[$monthId]["cubage"]["s".$item->species_id]["sum"] += $item->cubage;
			$months[$monthId]["cubage"]["m"]["sum"] += $item->cubage;
		}

		// Создаем массив сумм для столбцов и обнуляем его
		$total = $months[1]["finance"];
		foreach ($total as $key => $value) {
			$total[$key] = 0;
		}
		$total["finance"] = 0;
		$total["cubage"] = 0;

		// Получаем суммы по столбцам
		foreach ($months as $i => $month) {
			foreach ($month["finance"] as $j => $col) {
				$total[$j] += $col["sum"];

				if( $col["negative"] ){
					$total["finance"] -= $col["sum"];
				}else{
					$total["finance"] += $col["sum"];
				}
			}

			foreach ($month["cubage"] as $j => $col) {
				$total[$j] += $col["sum"];

				if( $col["get"] ){
					$total["cubage"] += $col["sum"];
				}
			}
		}

		// var_dump($months);

  //       $filter = new Stats('filter');

		// if (isset($_GET['Stats'])){
  //           $filter->attributes = $_GET['Stats'];
  //       }

  //       $dataProvider = $filter->search(50);
		// $count = $filter->search(50, true);

		$params = array(
			"data" => $months,
			"total" => $total,
		);

		// if( !$partial ){
		$this->render("adminIndex", $params);
		// }else{
			// $this->renderPartial("adminIndex", $params);
		// }
	}

	public function actionAdminCreate()
	{
		$model = new Stats;

		if(isset($_POST["Stats"])) {
			if( $model->updateObj($_POST["Stats"]) ){
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

		if(isset($_POST["Stats"])) {
			if( $model->updateObj($_POST["Stats"]) ){
				$this->actionAdminIndex(true);
				return true;
			}
		}else{
			$this->renderPartial("adminUpdate",array(
				"model" => $model,
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
		$model = Stats::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
