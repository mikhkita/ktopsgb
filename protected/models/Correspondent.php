<?php

/**
 * This is the model class for table "wood_provider".
 *
 * The followings are the available columns in table "wood_provider":
 * @property string $id
 * @property string $name
 */
class Correspondent extends CActiveRecord
{
	public $sumWoods = 0;
	public $sumOrders = 0;
	public $sumTotal = 0;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "correspondent";
	}

	public function scopes()
    {
        return array(
            "providers" => array(
                "order" => "t.name ASC",
                "condition" => "is_provider = '1' AND active = '1'"
            ),
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("name", "required"),
			array("is_provider, active", "numerical", "integerOnly"=>true),
			array("name", "length", "max"=>256),
			array("inn", "length", "max"=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, inn, name, is_provider, active", "safe", "on"=>"search"),
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
			"woods" => array(self::HAS_MANY, "Wood", "provider_id"),
			"orders" => array(self::HAS_MANY, "Order", "correspondent_id", "on" => "is_new = 0"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"name" => "Наименование",
			"active" => "Активно",
			"inn" => "ИНН",
			"is_provider" => "Поставщик",
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
	public function search($pages, $count = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = "is_provider DESC, name ASC";

		$criteria->compare("id", $this->id);
		$criteria->compare("active", 1);
		$criteria->compare("is_provider", $this->is_provider);
		$criteria->addSearchCondition("name", $this->name);

		if( $count ){
			return Correspondent::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "correspondent/adminindex")
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

	public function addNew($corrArr){
		$innArr = Correspondent::findAllByInn( Controller::getIds($corrArr, "inn") );

		$existInnArr = Controller::getIds($innArr, "inn");

		$diffInnArr = Controller::removeKeys($corrArr, $existInnArr);
		Controller::insertValues(Correspondent::tableName(), array_values($diffInnArr));
	}

	public function findAllByInn($innArr){
		$tmpArr = [];
		foreach ($innArr as $corr) {
			$tmpArr[] = "'".$corr."'";
		}

		$model = Correspondent::model()->findAll("inn IN (".implode(",", $tmpArr).")");

		return Controller::getAssoc( $model, "inn" );
	}

	public function sumTotal(){
		$this->sumTotal = (-1)*($this->sumWoods() - $this->sumOrders());
		return $this->sumTotal;
	}

	public function sumWoods(){
		$sum = 0;
		foreach ($this->woods as $key => $wood) {
			$sum += $wood->sum;
		}
		$this->sumWoods = $sum;
		return $sum;
	}

	public function sumOrders(){
		$sum = 0;
		foreach ($this->orders as $key => $order) {
			if( $order->negative ){
				$sum += $order->sum;
			}else{
				$sum -= $order->sum;
			}
		}
		$this->sumOrders = $sum;
		return $sum;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Correspondent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
