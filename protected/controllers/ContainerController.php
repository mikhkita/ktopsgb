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
				"actions" => array("adminIndex", "adminExport", "adminViewSettings", "adminLocationHistory", "adminAddCheckbox","adminRemoveCheckbox","adminAddManyCheckboxes","adminRemoveManyCheckboxes", "adminRemoveAllCheckboxes", "adminView", "adminUpdate", "adminUpdateAll", "adminDelete", "adminCreate", "adminCargoIndex", "adminCargoCreate", "adminCargoUpdate", "adminCargoDelete"),
				"roles" => array("readContainer"),
			),
			array("allow",
				"actions" => array("adminLocation", "adminLocationDelete","adminLocationAll"),
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

		$branch_ids = $this->getIds($this->user->branches, "branch_id");

		// Если в пользовательских параметрах нет ID филиала, то редиректить на первый
		$branches = Branch::model()->findAll("id IN (".implode(",", $branch_ids).")");
		if( $branch_id === NULL ){
			if( !($branch_id = $this->getUserParam("Container_branch_id")) ){
				$branch_id = $branches[0]->id;
			}
		}
		// Костыль.
		$_GET["branch_id"] = $branch_id;

		if(!$this->checkAccess("readBranch")){
			// Если нет доступа к филиалу, то редиректить на первый
			$branch_id = $branches[0]->id;
		}
		// Сохраняем ID филиала в пользовательских параметрах
		$this->setUserParam("Container_branch_id", $branch_id);

		$fields = array(
			"exporters" => CHtml::listData(Exporter::model()->with("branches")->findAll("branches.branch_id=".$_GET["branch_id"]), "id", "name"),
			"shippers" => CHtml::listData(Shipper::model()->findAll(), "id", "name"),
			"stations" => CHtml::listData(Station::model()->findAll("branch_id=".$_GET["branch_id"]), "id", "name"),
			"carriers" => CHtml::listData(Carrier::model()->findAll("branch_id=".$_GET["branch_id"]), "id", "name"),
			"ways" => CHtml::listData(Way::model()->findAll(), "id", "name"),
			"stationDests" => CHtml::listData(StationDest::model()->findAll(), "id", "name"),
			"destinations" => CHtml::listData(Destination::model()->findAll(), "id", "name"),
			"owners" => CHtml::listData(Owner::model()->findAll(), "id", "name"),
			"stampTypes" => CHtml::listData(StampType::model()->findAll(), "id", "name"),
			"loadingPlaces" => CHtml::listData(LoadingPlace::model()->findAll(), "id", "name"),
			"consignees" => CHtml::listData(Consignee::model()->findAll(), "id", "name"),
			"deliveryConditions" => CHtml::listData(DeliveryCondition::model()->findAll(), "id", "name"),
		);

        $filter = $this->setSessionFilter( new Container("filter"), "Container", $fields, $branch_id);

        $this->readDates($filter);

        $dataProvider = $filter->search(50, $branch_id);
		$data = $dataProvider->getData();
		$count = $filter->search(50, $branch_id, true);

		$params = array(
			"data" => $data,
			"pages" => $dataProvider->getPagination(),
			"filter" => $filter,
			"count" => $count,
			"labels" => Container::attributeLabels(),
			"branches" => $branches,
			"edit" => false,
			"fields" => $this->getSortedAttributes( Container::attributesFiltered( $this->getUserParam("container_view") ) )
		);
		$params = array_merge($params, $fields);

		if( !$partial ){
			$this->render("adminIndex", $params);
		}else{
			$this->renderPartial("adminIndex", $params);
		}
	}

	public function actionAdminCreate($branch_id, $many = false)
	{
		$this->checkAccessByBranchID("updateBranch", $branch_id);

		$model = new Container;

		if(isset($_POST["Container"])) {
			if( isset($_POST["count"]) ){
				for ($i=0; $i < intval($_POST["count"]); $i++) { 
					$model = new Container;
					$model->updateObj($_POST["Container"]);
				}
			}else{
				$model->updateObj($_POST["Container"]);
			}
			$this->actionAdminIndex(true, $branch_id);
			return true;
		} else {
			$this->renderPartial("adminCreate",array(
				"model" => $model,
				"many" => $many
			));
		}
	}

	public function actionAdminUpdate($id, $branch_id)
	{
		$model = $this->loadModel($id);
		$this->checkAccessByContainer("updateBranch", $model);

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
		$model = $this->loadModel($id);
		$this->checkAccessByContainer("updateBranch", $model);

		$model->delete();

		$this->actionAdminindex(true, $branch_id);
	}

	public function actionAdminView($id, $partial = false)
	{
		$model = Container::model()->with(array("notes"))->findByPk($id);

		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = "Примечания контейнера №".$model->number;
		}

		$backLink = $this->getBackLink("containerView", Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex'), $partial);

		$params = array(
			"model" => $model,
			"labels" => Container::attributeLabels(),
			"noteLabels" => Note::attributeLabels(),
			"backLink" => $backLink
		);

		if( $partial ){
			$this->renderPartial("adminView", $params);
		}else{
			$this->render("adminView", $params);
		}
	}

	public function actionAdminUpdateAll($partial = false, $branch_id)
	{
		unset($_GET["partial"]);
		if( !$partial ){
			$this->layout = "admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

		if( isset($_POST["Container"]) ){
			foreach ($_POST["Container"] as $key => $container) {
				$model = Container::model()->findByPk($key);
				$this->checkAccessByContainer("updateBranch", $model);

				foreach ($container as $i => $value) {
					$model[$i] = $value;
				}
				$model->save();
			}

			$this->actionAdminIndex(true, $branch_id);
			return true;
		}else{
	        $filter = new Container("filter");

	        $filter->id = $this->getCheckboxes("container".$branch_id);

	        $dataProvider = $filter->search(1000, $branch_id);

			$data = $dataProvider->getData();

			$count = Container::model()->count($criteria);

			$params = array(
				"data" => $data,
				"pages" => $dataProvider->getPagination(),
				"filter" => $filter,
				"count" => $count,
				"labels" => Container::attributeLabels(),
				"branches" => Branch::model()->findAll(),
				"edit" => false,
				"fields" => Container::attributesFiltered( $this->getUserParam("container_view") )
			);

			$params["exporters"] = CHtml::listData(Exporter::model()->with("branches")->findAll("branches.branch_id=".$_GET["branch_id"]), "id", "name");
			$params["shippers"] = CHtml::listData(Shipper::model()->findAll(), "id", "name");
			$params["stations"] = CHtml::listData(Station::model()->findAll("branch_id=".$_GET["branch_id"]), "id", "name");
			$params["carriers"] = CHtml::listData(Carrier::model()->findAll("branch_id=".$_GET["branch_id"]), "id", "name");
			$params["ways"] = CHtml::listData(Way::model()->findAll(), "id", "name");
			$params["stationDests"] = CHtml::listData(StationDest::model()->findAll(), "id", "name");
			$params["destinations"] = CHtml::listData(Destination::model()->findAll(), "id", "name");
			$params["owners"] = CHtml::listData(Owner::model()->findAll(), "id", "name");
			$params["stampTypes"] = CHtml::listData(StampType::model()->findAll(), "id", "name");
			$params["loadingPlaces"] = CHtml::listData(LoadingPlace::model()->findAll(), "id", "name");
			$params["consignees"] = CHtml::listData(Consignee::model()->findAll(), "id", "name");
			$params["deliveryConditions"] = CHtml::listData(DeliveryCondition::model()->findAll(), "id", "name");

			$params["edit"] = true;

			if( !$partial ){
				$this->render("adminIndex", $params);
			}else{
				$this->renderPartial("adminIndex", $params);
			}
		}
	}

	public function actionAdminExport($branch_id)
	{
		$checkboxes = $this->getCheckboxes("container".$branch_id);
		if( !$checkboxes || !count($checkboxes) ) return false;

		$filter = new Container("filter");
        $filter->id = $this->getCheckboxes("container".$branch_id);
        $dataProvider = $filter->search(100000, $branch_id);

		$data = $dataProvider->getData();

		$params = array(
			"data" => $data,
			"fields" => Container::attributesFiltered( $this->getUserParam("container_view") )
		);

		$this->exportExcel($params);
	}

	public function actionAdminLocation($id, $branch_id = NULL)
	{
		$container = $this->loadModel($id);
		$model = new Location;
		$this->checkAccessByContainer("readBranch", $container);

		if(isset($_POST["Location"])) {
			if( $model->updateObj($_POST["Location"]) ){
				if( $branch_id == NULL ){
					$this->actionAdminLocationHistory($id, true);
				}else{
					$this->actionAdminIndex(true, $branch_id);
				}
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

	public function actionAdminLocationAll($branch_id)
	{
		$filter = new Container("filter");
        $filter->id = $this->getCheckboxes("container".$branch_id);
        $containers = $filter->search(1000, $branch_id)->getData();

		if(isset($_POST["Location"])) {
			foreach ($containers as $key => $container) {
				$this->checkAccessByContainer("readBranch", $container);

				$model = new Location;

				$model->updateObj(array(
					"container_id" => $container->id,
					"name" => $_POST["Location"]["name"],
				));
			}
			$this->actionAdminIndex(true, $branch_id);
			return true;
		}else{
			$model = new Location;

			$this->renderPartial("adminLocationAll",array(
				"model" => $model,
				"container" => $container,
				"containersText" => implode(", ", $this->getIds($containers, "number"))
			));
		}
	}

	public function actionAdminLocationDelete($id, $branch_id)
	{
		$location = Location::model()->findByPk($id);
		$container_id = $location->container_id;
		if($location===null)
			throw new CHttpException(404, "The requested page does not exist.");

		$this->checkAccessByContainer("readBranch", $container_id);

		$location->delete();

		$_GET["branch_id"] = $branch_id;
		$this->actionAdminLocationHistory($container_id, true);
		return true;
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
		$this->checkAccessByContainer("readBranch", $container);

		$model = Cargo::model()->findAll("container_id='$container_id'");

		$backLink = $this->getBackLink("cargo", Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex'), $partial);

		$params = array(
			"data" => $model,
			"labels" => Cargo::attributeLabels(),
			"container" => $container,
			"total" => Cargo::getTotal($model),
			"backLink" => $backLink
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
		$this->checkAccessByContainer("readBranch", $container_id);

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
		$this->checkAccessByContainer("readBranch", $model->container_id);

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
		$model = Cargo::model()->findByPk($id);
		$this->checkAccessByContainer("readBranch", $model->container_id);
		$model->delete();

		$this->actionAdminCargoIndex(true, $container_id);
	}

	public function actionAdminAddCheckbox($branch_id, $container_id = NULL){
		$model = Container::model()->findByPk($container_id);
		$this->displayCodes($this->addCheckbox("container".$branch_id, $model->id, $model->number), "container".$branch_id);
	}

	public function actionAdminRemoveCheckbox($branch_id, $container_id = NULL){
		$model = Container::model()->findByPk($container_id);
		$this->displayCodes($this->removeCheckbox("container".$branch_id, $model->id, $model->number), "container".$branch_id);
	}

	public function actionAdminAddManyCheckboxes($branch_id, $ids = NULL){
		$arrIds = explode(",", $ids);
		$model = Container::model()->findAll("id IN (".$ids.")");
		$result = true;
		foreach ($model as $key => $item) {
			if( !$this->addCheckbox("container".$branch_id, $item->id, $item->number) ){
				$result = false;
			}
		}
		$this->displayCodes($result, "container".$branch_id);
	}

	public function actionAdminRemoveManyCheckboxes($branch_id, $ids = NULL){
		$arrIds = explode(",", $ids);
		$model = Container::model()->findAll("id IN (".$ids.")");
		$result = true;
		foreach ($model as $key => $item) {
			if( !$this->removeCheckbox("container".$branch_id, $item->id) ){
				$result = false;
			}
		}
		$this->displayCodes($result, "container".$branch_id);
	}

	public function actionAdminRemoveAllCheckboxes($branch_id){
		$this->displayCodes($this->removeAllCheckboxes("container".$branch_id), "container".$branch_id);
	}

	public function actionAdminViewSettings($branch_id){
		if( isset($_POST["submit"]) ){
			$fields = (isset($_POST["view_fields"])) ? $_POST["view_fields"] : array();

			$this->setUserParam("container_view", $fields);

			$this->redirect( Yii::app()->createUrl("container/adminindex", array("branch_id" => $branch_id, "partial" => true)) );
		}else{
			$labels = Container::model()->find()->attributes();

			$attributes = array();
			foreach ($labels as $code => $label) {
				if( isset($label["IS_HIDDEN"]) && $label["IS_HIDDEN"] ) continue;

				$attributes[$code] = $label["NAME"];
			}

			$this->renderPartial("_viewSettings", array(
				"attributes" => $this->getSortedAttributes($attributes),
				"selected" => $this->getUserParam("container_view")
			));
		}
	}

	public function exportExcel($params){
		$data = array();

		$header = array();
		foreach ($params["fields"] as $i => $field){
			array_push($header, $field["NAME"]);
		}
		array_push($data, $header);

		foreach ($params["data"] as $i => $item){
			$array = array();
			foreach ($params["fields"] as $i => $field){
				$value = ""; 
				eval($field["VALUE"]);
				array_push($array, strip_tags($value));
			}
			array_push($data, $array);
		}

		$file = $this->writeExcel($data, "Новый документ");

		$this->DownloadFile($file, "Контейнеры ".date("d-m-Y").".xlsx");
	}

	public function loadModel($id)
	{
		$model = Container::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}
}
