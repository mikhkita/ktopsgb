<?php

/**
 * This is the model class for table "wood".
 *
 * The followings are the available columns in table "wood":
 * @property string $id
 * @property string $date
 * @property integer $payment_id
 * @property string $provider_id
 * @property integer $cubage
 * @property integer $price
 * @property string $car
 * @property string $who
 * @property integer $paid
 */
class Wood extends CActiveRecord
{
	public $date_from = NULL;
	public $date_to = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "wood";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date, payment_id, cubage, price, car", "required"),
			array("payment_id, paid", "numerical", "integerOnly" => true),
			array("provider_id, car", "length", "max" => 10),
			array("cubage, price", "numerical"),
			array("who", "length", "max" => 128),
			array("comment", "length", "max" => 256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date, payment_id, provider_id, cubage, price, car, who, paid", "safe", "on" => "search"),
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
			"payment" => array(self::BELONGS_TO, "Payment", "payment_id"),
			"provider" => array(self::BELONGS_TO, "WoodProvider", "provider_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"date" => "Дата",
			"payment_id" => "Тип",
			"provider_id" => "Поставщик",
			"cubage" => "Кубатура",
			"price" => "Цена",
			"sum" => "Сумма",
			"car" => "Номер авто",
			"who" => "Кто принял",
			"paid" => "Оплачено",
			"comment" => "Комментарий",
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
	public function search($pages, $count = false, $returnCriteria = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = "date DESC";

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			$criteria->addCondition("date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

		$criteria->compare("provider_id", $this->provider_id, true);
		$criteria->compare("payment_id", $this->payment_id, true);

		// $criteria->compare("date",$this->date,true);
		$criteria->addSearchCondition("car", $this->car);
		$criteria->addSearchCondition("who", $this->who);
		$criteria->compare("paid",$this->paid);

		if( $returnCriteria ){
			return $criteria;
		}else if( $count ){
			return Wood::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "wood/adminindex")
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

	public function getTotals($criteria){
		$arWood = Wood::model()->findAll($criteria);

		$cubage = 0;
		$sum = 0;
		foreach ($arWood as $i => $wood) {
			$cubage += $wood->cubage;
			$sum += ($wood->cubage*$wood->price);
		}

		return (object) array(
			"cubage" => $cubage,
			"sum" => $sum,
		);
	}

	public function afterFind(){
		parent::afterFind();

		$this->date = date("d.m.Y", strtotime($this->date));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Wood the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
