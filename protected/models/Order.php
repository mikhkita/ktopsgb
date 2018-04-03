<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table "order":
 * @property string $id
 * @property string $number
 * @property string $date
 * @property integer $correspondent_id
 * @property integer $negative
 * @property integer $category_id
 * @property string $purpose
 * @property integer $is_new
 */
class Order extends CActiveRecord
{
	public $date_from = NULL;
	public $date_to = NULL;
	public $original_date = NULL;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "order";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("company_id, number, date, correspondent_id, category_id", "required"),
			array("company_id, correspondent_id, negative, category_id, is_new", "numerical", "integerOnly" => true),
			array("sum", "numerical"),
			array("number", "length", "max" => 10),
			array("purpose", "length", "max" => 256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, company_id, number, date, correspondent_id, sum, negative, category_id, purpose, is_new", "safe", "on" => "search"),
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
			"correspondent" => array(self::BELONGS_TO, "Correspondent", "correspondent_id"),
			"category" => array(self::BELONGS_TO, "Category", "category_id"),
			"company" => array(self::BELONGS_TO, "Company", "company_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"company_id" => "Компания",
			"number" => "Номер",
			"date" => "Дата",
			"correspondent_id" => "Корреспондент",
			"sum" => "Сумма",
			"negative" => "Тип платежа",
			"category_id" => "Категория",
			"purpose" => "Назначение",
			"is_new" => "Новый",
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
	public function search($pages, $count = false, $model = "Order", $returnCriteria = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		if( $model == "Order" ){
			$criteria->order = "date DESC";
		}else{
			$criteria->order = "id ASC";
		}

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			$criteria->addCondition("date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

		$criteria->addSearchCondition("id", $this->id);
		$criteria->compare("company_id", $this->company_id);
		$criteria->addSearchCondition("number", $this->number);
		$criteria->addSearchCondition("date", $this->date);
		$criteria->compare("correspondent_id", $this->correspondent_id);
		// $criteria->compare("negative", $this->negative);
		$criteria->compare("category_id", $this->category_id);
		$criteria->addSearchCondition("purpose", $this->purpose);
		$criteria->compare("is_new", $this->is_new);

		if( $returnCriteria ){
			return $criteria;
		}else if( $count ){
			return Order::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => strtolower($model)."/adminindex")
			));
		}
	}

	public function updateObj($attributes){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$attributes["date"] = date("Y-m-d H:i:s", strtotime($attributes["date"]));

		$this->attributes = $attributes;

		if($this->save()){
			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function afterFind()
	{
		parent::afterFind();

		$this->original_date = $this->date;
		$this->date = date("d.m.Y", strtotime($this->date));
	}

	public function addNew($company_id, $orders, $corrs){
		$data = array();
		foreach ($orders as $key => $order) {
			$data[] = "('".$order->number."','".date("Y-m-d H:i:s", strtotime($order->date))."')";
		}

		$model = Order::model()->findAll("(number,date) IN (".implode(",", $data).")");

		$exist = array();
		foreach ($model as $key => $order) {
			$exist[$order->number."-".$order->date] = true;
		}

		$data = array();
		foreach ($orders as $key => $order) {
			if( !isset($exist[ $order->number."-".date("d.m.Y", strtotime($order->date)) ]) ){
				$data[] = array(
					"company_id" => $company_id,
					"number" => $order->number,
					"date" => date("Y-m-d H:i:s", strtotime($order->date)),
					"correspondent_id" => $corrs[$order->corrInn]->id,
					"negative" => (!$order->income)?1:0,
					"category_id" => 0,
					"sum" => $order->sum,
					"purpose" => $order->purpose,
					"is_new" => 1,
				);
			}
		}
		if( count($data) ){
			Controller::insertValues(Order::tableName(), $data);
		}
	}

	public function getTotal($criteria){
		$arCash = Order::model()->findAll($criteria);

		$sum = 0;
		foreach ($arCash as $i => $cash) {
			$sum += (($cash->negative)?($cash->sum*(-1)):$cash->sum);
		}

		return $sum;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
