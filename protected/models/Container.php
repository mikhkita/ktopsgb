<?php

/**
 * This is the model class for table "container".
 *
 * The followings are the available columns in table "container":
 * @property string $id
 * @property integer $exporter_id
 * @property integer $shipper_id
 * @property integer $station_id
 * @property integer $way_id
 * @property integer $station_dest_id
 * @property integer $destination_id
 * @property string $number
 * @property integer $owner_id
 * @property integer $stamp_type_id
 * @property string $stamp_num
 * @property string $loading_date
 * @property integer $loading_place_id
 * @property integer $carrier_id
 * @property integer $weight
 * @property string $dt
 * @property string $shipment_num
 * @property string $railway_num
 * @property string $issue_date
 * @property integer $consignee_id
 * @property string $custom_date
 * @property string $border_date
 * @property string $arrival_date
 * @property string $container_date
 * @property string $container_place
 * @property string $kc
 * @property string $st
 * @property string $dhl_st
 * @property string $dhl_fit
 */
class Container extends CActiveRecord
{
	public $fields = NULL;
	public $date_from = NULL;
	public $date_to = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "container";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("station_id", "required"),
			array("exporter_id, shipper_id, station_id, way_id, station_dest_id, destination_id, owner_id, stamp_type_id, loading_place_id, weight, supernorm, consignee_id, delivery_condition_id", "numerical", "integerOnly" => true),
			array("number, stamp_num, shipment_num, railway_num", "length", "max" => 15),
			array("dt, kc, st, dhl_st, dhl_fit", "length", "max" => 30),
			array("carrier_id, contract_number", "length", "max" => 64),
			array("supernorm_price", "length", "max" => 128),
			array("container_place", "length", "max" => 5000),
			array("loading_date, issue_date, custom_date, border_date, arrival_date, container_date", "safe"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, exporter_id, shipper_id, station_id, way_id, station_dest_id, destination_id, number, owner_id, stamp_type_id, stamp_num, loading_date, loading_place_id, carrier_id, weight, supernorm, dt, shipment_num, supernorm_price, railway_num, issue_date, consignee_id, contract_number, delivery_condition_id, custom_date, border_date, arrival_date, container_date, container_place, kc, st, dhl_st, dhl_fit", "safe", "on" => "search"),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			"exporter" => array(self::BELONGS_TO, "Exporter", "exporter_id"),
			"shipper" => array(self::BELONGS_TO, "Shipper", "shipper_id"),
			"station" => array(self::BELONGS_TO, "Station", "station_id"),
			"carrier" => array(self::BELONGS_TO, "Carrier", "carrier_id"),
			"way" => array(self::BELONGS_TO, "Way", "way_id"),
			"stationDest" => array(self::BELONGS_TO, "StationDest", "station_dest_id"),
			"destination" => array(self::BELONGS_TO, "Destination", "destination_id"),
			"owner" => array(self::BELONGS_TO, "Owner", "owner_id"),
			"stampType" => array(self::BELONGS_TO, "StampType", "stamp_type_id"),
			"loadingPlace" => array(self::BELONGS_TO, "LoadingPlace", "loading_place_id"),
			"consignee" => array(self::BELONGS_TO, "Consignee", "consignee_id"),
			"deliveryCondition" => array(self::BELONGS_TO, "DeliveryCondition", "delivery_condition_id"),
			"locations" => array(self::HAS_MANY, "Location", "container_id", "order" => "date DESC"),
			"cargo" => array(self::HAS_MANY, "Cargo", "container_id"),
			"notes" => array(self::HAS_MANY, "Note", "container_id", "order" => "notes.date DESC"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID", // 1
			"location" => "Дислокация", 
			"cargo" => "Груз", 
			"exporter_id" => "Экспортер", // 1
			"shipper_id" => "Грузоотправитель", // 1
			"station_id" => "Станция отправления", // 1
			"way_id" => "Погранпереход", // 1
			"station_dest_id" => "Станция назначения", // 1
			"destination_id" => "Пункт назначения", // 1
			"number" => "Номер контейнера", // 1
			"owner_id" => "Собственник", // 1
			"stamp_type_id" => "Тип пломбы", // 1
			"stamp_num" => "Номер пломбы", // 1
			"loading_date" => "Дата погрузки", // 1
			"loading_place_id" => "Место погрузки", // 1
			"carrier_id" => "Автоперевозчик", // 1
			"weight" => "Вес груза", // 1
			"supernorm" => "Сверхнорма (дней)",
			"supernorm_price" => "Цена сверхнормы (руб/$)",
			"dt" => "Д/Т", // 1
			"shipment_num" => "Номер отправки", // 1
			"railway_num" => "Номер вагона", // 1
			"issue_date" => "Дата оформления", // 1
			"consignee_id" => "Грузополучатель", // 1
			"contract_number" => "Номер контракта", // 1
			"delivery_condition_id" => "Условие поставки", // 1
			"custom_date" => "Дата растаможки",
			"border_date" => "Дата пересечения границы", // 1
			"arrival_date" => "Дата прибытия в пункт назначения", 
			"container_date" => "Дата сдачи порожнего контейнера", 
			"container_place" => "Пункт возврата порожнего контейнера", 
			"kc" => "К/С", 
			"st" => "СТ", 
			"dhl_st" => "DHL на СТ", 
			"dhl_fit" => "DHL на фит", 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributes($template = "Container[#]")
	{
		return array(
			"number" => array(
				"NAME" => "Номер контейнера", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "number", $template), $item->number, array("data-id" => "number", "maxlength" => 15, "required" => true));',
				// "IS_HIDDEN" => true,
				"VALUE" => '$value = $item->number;'
			),
			"id" => array(
				"NAME" => "ID", // 1
				"IS_EDITABLE" => false,
				"FORM" => NULL,
				"IS_HIDDEN" => true,
			),
			"exporter_id" => array(
				"NAME" => "Экспортер", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList( str_replace("#", "exporter_id", $template), $item->exporter_id, $exporters, array("class" => "select2", "data-id" => "exporter_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->exporter->name;'
			),
			"shipper_id" => array(
				"NAME" => "Грузоотправитель", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList( str_replace("#", "shipper_id", $template), $item->shipper_id, $shippers, array("class" => "select2", "data-id" => "shipper_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->shipper->name;'
			),
			"station_id" => array(
				"NAME" => "Станция отправления", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "station_id", $template), $item->station_id, $stations, array("class" => "select2", "data-id" => "station_id", "empty" => "Не задано", "required" => true));',
				"VALUE" => '$value = $item->station->name;'
			),
			"way_id" => array(
				"NAME" => "Погранпереход", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "way_id", $template), $item->way_id, $ways, array("class" => "select2", "data-id" => "way_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->way->name;'
			),
			"station_dest_id" => array(
				"NAME" => "Станция назначения", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "station_dest_id", $template), $item->station_dest_id, $stationDests, array("class" => "select2", "data-id" => "station_dest_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->stationDest->name;'
			),
			"destination_id" => array(
				"NAME" => "Пункт назначения", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "destination_id", $template), $item->destination_id, $destinations, array("class" => "select2", "data-id" => "destination_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->destination->name;'
			),
			"cargo" => array(
				"NAME" => "Груз", 
				"IS_EDITABLE" => false,
				"FORM" => NULL,
				"VALUE" => '$value = $item->getCargoText();'
			),
			"owner_id" => array(
				"NAME" => "Собственник", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "owner_id", $template), $item->owner_id, $owners, array("class" => "select2", "data-id" => "owner_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->owner->name;'
			),
			"stamp_type_id" => array(
				"NAME" => "Тип пломбы", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "stamp_type_id", $template), $item->stamp_type_id, $stampTypes, array("class" => "select2", "data-id" => "stamp_type_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->stampType->name;'
			),
			"stamp_num" => array(
				"NAME" => "Номер пломбы", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "stamp_num", $template), $item->stamp_num, array("data-id" => "stamp_num", "maxlength" => 15));',
				"VALUE" => '$value = $item->stamp_num;'
			),
			"loading_date" => array(
				"NAME" => "Дата погрузки", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "loading_date", $template), $item->loading_date, array("data-id" => "loading_date", "maxlength" => 20, "class" => "date", "required" => true ));',
				"VALUE" => '$value = $item->loading_date;',
				"FILTER" => ''
			),
			"loading_place_id" => array(
				"NAME" => "Место погрузки", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "loading_place_id", $template), $item->loading_place_id, $loadingPlaces, array("class" => "select2", "data-id" => "loading_place_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->loadingPlace->name;'
			),
			"carrier_id" => array(
				"NAME" => "Автоперевозчик", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "carrier_id", $template), $item->carrier_id, $carriers, array("class" => "select2", "data-id" => "carrier_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->carrier->name;'
			),
			"weight" => array(
				"NAME" => "Вес груза", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "weight", $template), $item->weight, array("data-id" => "weight", "maxlength" => 11, "class" => "numeric"));',
				"VALUE" => '$value = $item->weight;',
				"FILTER" => ''
			),
			"dt" => array(
				"NAME" => "Д/Т", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "dt", $template), $item->dt, array("data-id" => "dt", "maxlength" => 30));',
				"VALUE" => '$value = $item->dt;'
			),
			"shipment_num" => array(
				"NAME" => "Номер отправки", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "shipment_num", $template), $item->shipment_num, array("data-id" => "shipment_num", "maxlength" => 15));',
				"VALUE" => '$value = $item->shipment_num;'
			),
			"railway_num" => array(
				"NAME" => "Номер вагона", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "railway_num", $template), $item->railway_num, array("data-id" => "railway_num", "maxlength" => 15));',
				"VALUE" => '$value = $item->railway_num;'
			),
			"issue_date" => array(
				"NAME" => "Дата оформления", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "issue_date", $template), $item->issue_date, array("data-id" => "issue_date", "maxlength" => 20, "class" => "date" ));',
				"VALUE" => '$value = $item->issue_date;',
				"FILTER" => '$value = CHtml::textField(str_replace("#", "date_from", $template), $item->date_from, array("tabindex" => 0, "placeholder" => "От", "class" => "date"))."<span class=\"filter-separator\">-</span>".CHtml::textField(str_replace("#", "date_to", $template), $item->date_to, array("tabindex" => 0, "placeholder" => "До", "class" => "date"));'
			),
			"consignee_id" => array(
				"NAME" => "Грузополучатель", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "consignee_id", $template), $item->consignee_id, $consignees, array("class" => "select2", "data-id" => "consignee_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->consignee->name;'
			),
			"contract_number" => array(
				"NAME" => "Номер контракта", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "contract_number", $template), $item->contract_number, array("data-id" => "contract_number", "maxlength" => 64));',
				"VALUE" => '$value = $item->contract_number;'
			),
			"delivery_condition_id" => array(
				"NAME" => "Условие поставки", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::dropDownList(str_replace("#", "delivery_condition_id", $template), $item->delivery_condition_id, $deliveryConditions, array("class" => "select2", "data-id" => "delivery_condition_id", "empty" => "Не задано"));',
				"VALUE" => '$value = $item->deliveryCondition->name;'
			),
			"custom_date" => array(
				"NAME" => "Дата растаможки", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "custom_date", $template), $item->custom_date, array("data-id" => "custom_date", "maxlength" => 20, "class" => "date" ));',
				"VALUE" => '$value = $item->custom_date;',
				"FILTER" => ''
			),
			"border_date" => array(
				"NAME" => "Дата пересечения границы", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "border_date", $template), $item->border_date, array("data-id" => "border_date", "maxlength" => 20, "class" => "date" ));',
				"VALUE" => '$value = $item->border_date;',
				"FILTER" => ''
			),
			"arrival_date" => array(
				"NAME" => "Дата прибытия в пункт назначения", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "arrival_date", $template), $item->arrival_date, array("data-id" => "arrival_date", "maxlength" => 20, "class" => "date" ));',
				"VALUE" => '$value = $item->arrival_date;',
				"FILTER" => ''
			),
			"container_date" => array(
				"NAME" => "Дата сдачи порожнего контейнера", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "container_date", $template), $item->container_date, array("data-id" => "container_date", "maxlength" => 20, "class" => "date" ));',
				"VALUE" => '$value = $item->container_date;',
				"FILTER" => ''
			),
			"container_place" => array(
				"NAME" => "Пункт возврата порожнего контейнера", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textArea(str_replace("#", "container_place", $template), $item->container_place, array("data-id" => "container_place", "maxlength" => 5000));',
				"VALUE" => '$value = $item->container_place;',
				"FILTER" => ''
			),
			"kc" => array(
				"NAME" => "К/С", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "kc", $template), $item->kc, array("data-id" => "kc", "maxlength" => 30));',
				"VALUE" => '$value = $item->kc;'
			),
			"st" => array(
				"NAME" => "СТ", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "st", $template), $item->st, array("data-id" => "st", "maxlength" => 30));',
				"VALUE" => '$value = $item->st;'
			),
			"dhl_st" => array(
				"NAME" => "DHL на СТ", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "dhl_st", $template), $item->dhl_st, array("data-id" => "dhl_st", "maxlength" => 30));',
				"VALUE" => '$value = $item->dhl_st;'
			),
			"dhl_fit" => array(
				"NAME" => "DHL на фит", 
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "dhl_fit", $template), $item->dhl_fit, array("data-id" => "dhl_fit", "maxlength" => 30));',
				"VALUE" => '$value = $item->dhl_fit;'
			),
			"supernorm" => array(
				"NAME" => "Сверхнорма (дней)", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "supernorm", $template), $item->supernorm, array("data-id" => "supernorm", "maxlength" => 11, "class" => "numeric"));',
				"VALUE" => '$value = $item->supernorm;',
				"FILTER" => ''
			),
			"supernorm_price" => array(
				"NAME" => "Цена сверхнормы", // 1
				"IS_EDITABLE" => true,
				"FORM" => '$value = CHtml::textField(str_replace("#", "supernorm_price", $template), $item->supernorm_price, array("data-id" => "supernorm_price", "maxlength" => 15));',
				"VALUE" => '$value = $item->supernorm_price;'
			),
			"location" => array(
				"NAME" => "Дислокация", 
				"IS_EDITABLE" => false,
				"FORM" => NULL,
				"VALUE" => '$value = "<a href=\"".Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminlocationhistory",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))."\" title=\"История изменений дислокации\" class=\"b-help\">".$item->locations[0]->name.( (count($item->locations))?(" (".$item->locations[0]->date.")"):"" )."</a>";'
			),
		);
	}

	public function attributesFiltered($filtered){
		$attributes = Container::attributes();
		if( !count($filtered) )
			$filtered = array();

		foreach ($attributes as $key => $value) {
			if( !in_array($key, $filtered) && !in_array($key, array("number", "issue_date")) ){
				unset($attributes[$key]);
			}
		}

		return $attributes;
	}

	public function getCargoText(){
		$array = array();

		foreach ($this->cargo as $key => $cargo) {
			array_push($array, $cargo->type->name.": ".$cargo->cubage." куб.");
		}

		return implode("; ", $array);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($pages, $branch_id = NULL, $count = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with = array("locations" => array("limit" => 1, "order" => "date DESC"), "exporter", "station");
		$criteria->order = "exporter.sort ASC, issue_date IS NULL DESC, t.id DESC";

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
				$criteria->addCondition("issue_date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
			}else{
				$criteria->addCondition("issue_date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."' OR issue_date IS NULL");
			}
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("issue_date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

		if( $branch_id !== NULL ){
			$criteria->addCondition("station.branch_id = '$branch_id'", "AND");
			// $criteria->compare("station.branch_id", $this->branch_id);
			// $exGroups = Yii::app()->db->createCommand()
			// 	->select("g.exporter_id")
	  //           ->from(ExporterBranch::tableName().' g')
	  //           ->where("g.branch_id=".$branch_id)
	  //           ->queryAll();

	  //       $exGroups = Controller::getIds($exGroups, "exporter_id");

	  //       if( count($exGroups) ){
	  //       	$criteria->addCondition("t.exporter_id IN (".implode(", ", $exGroups).")", "AND");
	  //       }else{
	  //       	$criteria->addCondition("t.id=0", "AND");
	  //       }
		}

		if( is_array($this->id) ){
			$criteria->addCondition("t.id IN (".implode(", ", $this->id).")", "AND");
		}else{
			$criteria->compare("t.id", $this->id, true);
		}

		$criteria->compare("exporter_id", $this->exporter_id);
		$criteria->compare("shipper_id", $this->shipper_id);
		$criteria->compare("station_id", $this->station_id);
		$criteria->compare("way_id", $this->way_id);
		$criteria->compare("station_dest_id", $this->station_dest_id);
		$criteria->compare("destination_id", $this->destination_id);
		$criteria->addSearchCondition("number", $this->number);
		$criteria->compare("owner_id", $this->owner_id);
		$criteria->compare("stamp_type_id", $this->stamp_type_id);
		$criteria->compare("stamp_num", $this->stamp_num, true);
		$criteria->compare("loading_date", $this->loading_date, true);
		$criteria->compare("loading_place_id", $this->loading_place_id);
		$criteria->compare("carrier_id", $this->carrier_id, true);
		$criteria->compare("weight", $this->weight);
		$criteria->compare("supernorm", $this->supernorm);
		$criteria->compare("supernorm_price", $this->supernorm_price, true);
		$criteria->compare("dt", $this->dt, true);
		$criteria->compare("shipment_num", $this->shipment_num, true);
		$criteria->compare("railway_num", $this->railway_num, true);
		$criteria->compare("issue_date", $this->issue_date, true);
		$criteria->compare("consignee_id", $this->consignee_id);
		$criteria->addSearchCondition("contract_number", $this->contract_number);
		$criteria->compare("delivery_condition_id", $this->delivery_condition_id);
		$criteria->compare("custom_date", $this->custom_date, true);
		$criteria->compare("border_date", $this->border_date, true);
		$criteria->compare("arrival_date", $this->arrival_date, true);
		$criteria->compare("container_date", $this->container_date, true);
		$criteria->compare("container_place", $this->container_place, true);
		$criteria->compare("kc", $this->kc, true);
		$criteria->compare("st", $this->st, true);
		$criteria->compare("dhl_st", $this->dhl_st, true);
		$criteria->compare("dhl_fit", $this->dhl_fit, true);

		if( $count ){
			return Container::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "container/adminindex")
			));
		}
	}

	public function updateObj($attributes){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$this->attributes = $attributes;

		if($this->save()){
			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function beforeSave() {
		parent::beforeSave();
		
		$dates = array(
			"loading_date",
			"issue_date",
			"custom_date",
			"border_date",
			"arrival_date",
			"container_date",
		);

		foreach ($dates as $i => $date) {
			if( isset($this->{$date}) && $this->{$date} != "" ){
				$this->{$date} = date("Y-m-d H:i:s", strtotime($this->{$date}));
			}else{
				$this->{$date} = NULL;
			}
		}

		return true;
	}

	public function afterFind(){
		parent::afterFind();

		$dates = array(
			"loading_date",
			"issue_date",
			"custom_date",
			"border_date",
			"arrival_date",
			"container_date",
		);

		foreach ($dates as $i => $date) {
			if( $this->{$date} ){
				$this->{$date} = date("d.m.Y", strtotime($this->{$date}));
			}
		}
	}

	public function isChecked($branch_id){
		if(!isset($_SESSION)) session_start();

		return ((isset($_SESSION[$this->tableName().$branch_id]) && isset($_SESSION[$this->tableName().$branch_id][$this->id]))?true:false);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Container the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
