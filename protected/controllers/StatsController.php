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
				"actions" => array("adminTotal", "adminIndex", "adminCheck", "adminOrder", "adminBoard"),
				"roles" => array("readWood"),
			),
			array("allow",
				"actions" => array("adminUpdate", "adminDelete", "adminCreate"),
				"roles" => array("updateWood"),
			),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminIndex(){
		header("Location: ".$this->createUrl('/stats-total/adminindex'));
	}

	public function actionAdminTotal(){
		$this->layout = "admin";
		$this->pageTitle = $this->adminMenu["cur"]->name;

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

		$params = array(
			"data" => $months,
			"total" => $total,
		);

		$this->render("adminTotal", $params);
	}

	public function actionAdminCheck(){
		$this->layout = "admin";
		$this->pageTitle = $this->adminMenu["cur"]->name;

		$providers = Correspondent::model()->providers()->with("orders", "woods")->findAll();

		$total = (object)array(
			"woods" => 0,
			"orders" => 0,
			"total" => 0
		);

		foreach ($providers as $key => $provider) {
			$total->total += $provider->sumTotal();
			$total->woods += $provider->sumWoods;
			$total->orders += $provider->sumOrders;
		}

		$params = array(
			"data" => $providers,
			"total" => $total,
		);

		$this->render("adminCheck", $params);
	}

	public function actionAdminOrder(){
		$this->layout = "admin";
		$this->pageTitle = $this->adminMenu["cur"]->name;

		$startDate = "01.01.".date("Y", time());
		$months = array(
			1 => array(
				"name" => "Январь",
				"order" => array(),
			),
			2 => array(
				"name" => "Февраль",
				"order" => array(),
			),
			3 => array(
				"name" => "Март",
				"order" => array(),
			),
			4 => array(
				"name" => "Апрель",
				"order" => array(),
			),
			5 => array(
				"name" => "Май",
				"order" => array(),
			),
			6 => array(
				"name" => "Июнь",
				"order" => array(),
			),
			7 => array(
				"name" => "Июль",
				"order" => array(),
			),
			8 => array(
				"name" => "Август",
				"order" => array(),
			),
			9 => array(
				"name" => "Сентябрь",
				"order" => array(),
			),
			10 => array(
				"name" => "Октярь",
				"order" => array(),
			),
			11 => array(
				"name" => "Ноябрь",
				"order" => array(),
			),
			12 => array(
				"name" => "Декабрь",
				"order" => array(),
			),
		);

		// Получаем все поручения за год
		$orderFilter = new Order('filter');
		$orderFilter->date_from = $startDate;
		$orderFilter->is_new = 0;
		$order = $orderFilter->search(99999999)->getData();

		// Получаем все категории
		$categories = Category::model()->findAll();

		// Заносим названия столбцов платежных поручений и обнуляем сумму
		foreach ($months as $i => $month) {
			foreach ($categories as $j => $category) {
				$months[$i]["order"]["c".$category->id] = array(
					"name" => $category->name,
					"sum" => 0,
					"negative" => false
				);
			}
		}

		// Суммируем поручения по месяцам
		foreach ($order as $key => $item) {
			$monthId = intval(date("n", strtotime($item->date)));

			if( $item->negative ){
				$months[$monthId]["order"]["c".$item->category_id]["sum"] -= $item->sum;
			}else{
				$months[$monthId]["order"]["c".$item->category_id]["sum"] += $item->sum;
			}	
		}

		// Создаем массив сумм для столбцов и обнуляем его
		$total = $months[1]["order"];
		foreach ($total as $key => $value) {
			$total[$key] = 0;
		}
		$total["order"] = 0;

		// Получаем суммы по столбцам
		foreach ($months as $i => $month) {
			foreach ($month["order"] as $j => $col) {
				$total[$j] += $col["sum"];

				if( $col["negative"] ){
					$total["order"] -= $col["sum"];
				}else{
					$total["order"] += $col["sum"];
				}
			}
		}

		$params = array(
			"data" => $months,
			"total" => $total,
		);

		$this->render("adminOrder", $params);
	}

	public function actionAdminBoard(){
		$this->layout = "admin";
		$this->pageTitle = $this->adminMenu["cur"]->name;

		$startDate = "01.01.".date("Y", time());
		$months = array(
			1 => array(
				"name" => "Январь",
				"sum" => 0,
				"cubage" => 0,
			),
			2 => array(
				"name" => "Февраль",
				"sum" => 0,
				"cubage" => 0,
			),
			3 => array(
				"name" => "Март",
				"sum" => 0,
				"cubage" => 0,
			),
			4 => array(
				"name" => "Апрель",
				"sum" => 0,
				"cubage" => 0,
			),
			5 => array(
				"name" => "Май",
				"sum" => 0,
				"cubage" => 0,
			),
			6 => array(
				"name" => "Июнь",
				"sum" => 0,
				"cubage" => 0,
			),
			7 => array(
				"name" => "Июль",
				"sum" => 0,
				"cubage" => 0,
			),
			8 => array(
				"name" => "Август",
				"sum" => 0,
				"cubage" => 0,
			),
			9 => array(
				"name" => "Сентябрь",
				"sum" => 0,
				"cubage" => 0,
			),
			10 => array(
				"name" => "Октярь",
				"sum" => 0,
				"cubage" => 0,
			),
			11 => array(
				"name" => "Ноябрь",
				"sum" => 0,
				"cubage" => 0,
			),
			12 => array(
				"name" => "Декабрь",
				"sum" => 0,
				"cubage" => 0,
			),
		);

		// Получаем все поручения за год
		$boardFilter = new Board('filter');
		$boardFilter->date_from = $startDate;
		$board = $boardFilter->search(99999999)->getData();

		// Суммируем поручения по месяцам
		foreach ($board as $key => $item) {
			$monthId = intval(date("n", strtotime($item->date)));

			$months[$monthId]["sum"] += $item->getSum();
			$months[$monthId]["cubage"] += $item->getCubageSum();
		}

		// Создаем массив сумм для столбцов и обнуляем его
		$total = array(
			"sum" => 0,
			"cubage" => 0,
		);

		// Получаем суммы по столбцам
		foreach ($months as $i => $month) {
			$total["sum"] += $month["sum"];
			$total["cubage"] += $month["cubage"];
		}

		$params = array(
			"data" => $months,
			"total" => $total,
		);

		$this->render("adminBoard", $params);
	}
}
