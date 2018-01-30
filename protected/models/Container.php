<?php

/**
 * This is the model class for table "container".
 *
 * The followings are the available columns in table "container":
 * @property string $id
 * @property integer $exporter_group_id
 * @property integer $exporter_id
 * @property integer $station_id
 * @property integer $way_id
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
			array("exporter_group_id, station_id, way_id, destination_id, number", "required"),
			array("exporter_group_id, exporter_id, station_id, way_id, destination_id, owner_id, stamp_type_id, loading_place_id, carrier_id, weight, consignee_id", "numerical", "integerOnly" => true),
			array("number, stamp_num, shipment_num, railway_num", "length", "max" => 15),
			array("dt, kc, st, dhl_st, dhl_fit", "length", "max" => 30),
			array("container_place", "length", "max" => 5000),
			array("loading_date, issue_date, border_date, arrival_date, container_date", "safe"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, exporter_group_id, exporter_id, station_id, way_id, destination_id, number, owner_id, stamp_type_id, stamp_num, loading_date, loading_place_id, carrier_id, weight, dt, shipment_num, railway_num, issue_date, consignee_id, border_date, arrival_date, container_date, container_place, kc, st, dhl_st, dhl_fit", "safe", "on" => "search"),
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
			"exporterGroup" => array(self::BELONGS_TO, "ExporterGroup", "exporter_group_id"),
			"exporter" => array(self::BELONGS_TO, "Exporter", "exporter_id"),
			"station" => array(self::BELONGS_TO, "Station", "station_id"),
			"way" => array(self::BELONGS_TO, "Way", "way_id"),
			"destination" => array(self::BELONGS_TO, "Destination", "destination_id"),
			"owner" => array(self::BELONGS_TO, "Owner", "owner_id"),
			"stampType" => array(self::BELONGS_TO, "StampType", "stamp_type_id"),
			"loadingPlace" => array(self::BELONGS_TO, "LoadingPlace", "loading_place_id"),
			"carrier" => array(self::BELONGS_TO, "Carrier", "carrier_id"),
			"consignee" => array(self::BELONGS_TO, "Consignee", "consignee_id"),
			"locations" => array(self::HAS_MANY, "Location", "container_id", "order" => "date DESC"),
			"cargo" => array(self::HAS_MANY, "Cargo", "container_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID", // 1
			"exporter_group_id" => "Группа экспортеров", // 1
			"exporter_id" => "Экспортер", // 1
			"station_id" => "Станция отправления", // 1
			"way_id" => "Маршрут", // 1
			"destination_id" => "Пункт назначения", // 1
			"number" => "Номер контейнера", // 1
			"owner_id" => "Собственник", // 1
			"stamp_type_id" => "Тип пломбы", // 1
			"stamp_num" => "Номер пломбы", // 1
			"loading_date" => "Дата погрузки", // 1
			"loading_place_id" => "Место погрузки", // 1
			"carrier_id" => "Перевозчик", // 1
			"weight" => "Вес груза", // 1
			"dt" => "Д/Т", // 1
			"shipment_num" => "Номер отправки", // 1
			"railway_num" => "Номер вагона", // 1
			"issue_date" => "Дата оформления", // 1
			"consignee_id" => "Грузополучатель", // 1
			"border_date" => "Дата пересечения границы", // 1
			"arrival_date" => "Дата прибытия в пункт назначения", 
			"container_date" => "Дата сдачи порожнего контейнера", 
			"container_place" => "Пункт возврата порожнего контейнера", 
			"kc" => "К/С", 
			"st" => "СТ", 
			"dhl_st" => "DHL на СТ", 
			"dhl_fit" => "DHL на фит", 
			"location" => "Дислокация", 
		);
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
		$criteria->with = array("locations" => array("limit" => 1, "order" => "date DESC"));

		if( $branch_id !== NULL ){
			$exGroups = Yii::app()->db->createCommand()
	            ->select('g.exporter_group_id')
	            ->from(ExporterGroupBranch::tableName().' g')
	            ->where("g.branch_id=".$branch_id)
	            ->queryAll();

	        $exGroups = Controller::getIds($exGroups, "exporter_group_id");

	        if( count($exGroups) ){
	        	$criteria->addCondition("t.exporter_group_id IN (".implode(", ", $exGroups).")", "AND");
	        }else{
	        	$criteria->addCondition("t.id=0", "AND");
	        }
		}

		$criteria->compare("id", $this->id, true);
		$criteria->compare("exporter_group_id", $this->exporter_group_id);
		$criteria->compare("exporter_id", $this->exporter_id);
		$criteria->compare("station_id", $this->station_id);
		$criteria->compare("way_id", $this->way_id);
		$criteria->compare("destination_id", $this->destination_id);
		$criteria->addSearchCondition("number", $this->number);
		$criteria->compare("owner_id", $this->owner_id);
		$criteria->compare("stamp_type_id", $this->stamp_type_id);
		$criteria->compare("stamp_num", $this->stamp_num, true);
		$criteria->compare("loading_date", $this->loading_date, true);
		$criteria->compare("loading_place_id", $this->loading_place_id);
		$criteria->compare("carrier_id", $this->carrier_id);
		$criteria->compare("weight", $this->weight);
		$criteria->compare("dt", $this->dt, true);
		$criteria->compare("shipment_num", $this->shipment_num, true);
		$criteria->compare("railway_num", $this->railway_num, true);
		$criteria->compare("issue_date", $this->issue_date, true);
		$criteria->compare("consignee_id", $this->consignee_id);
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
			
		$dates = array(
			"loading_date",
			"issue_date",
			"border_date",
			"arrival_date",
			"container_date",
		);

		foreach ($dates as $i => $date) {
			if( isset($attributes[$date]) && $attributes[$date] != "" ){
				$attributes[$date] = date("Y-m-d H:i:s", strtotime($attributes[$date]));
			}else{
				$attributes[$date] = NULL;
			}
		}

		$this->attributes = $attributes;

		if($this->save()){
			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function afterFind(){
		parent::afterFind();

		$dates = array(
			"loading_date",
			"issue_date",
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
