<?php

/**
 * This is the model class for table "cargo".
 *
 * The followings are the available columns in table "cargo":
 * @property integer $id
 * @property integer $type_id
 * @property double $length
 * @property double $thickness
 * @property double $cubage
 * @property integer $count
 * @property double $price
 * @property string $container_id
 */
class Cargo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "cargo";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("type_id, length, thickness, cubage, count, price, container_id", "required"),
			array("type_id, count", "numerical", "integerOnly" => true),
			array("length, thickness, cubage, price", "numerical"),
			array("container_id", "length", "max" => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, type_id, length, thickness, cubage, count, price, container_id", "safe", "on" => "search"),
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
			"container" => array(self::BELONGS_TO, "Container", "container_id"),
			"type" => array(self::BELONGS_TO, "CargoType", "type_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"type_id" => "Тип груза",
			"length" => "Длина",
			"thickness" => "Толщина",
			"cubage" => "Кубатура",
			"count" => "Количество пачек",
			"price" => "Цена за куб",
			"sum" => "Сумма",
			"container_id" => "Контейнер",
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

		$criteria->compare("id", $this->id);
		$criteria->compare("type_id", $this->type_id);
		$criteria->compare("length", $this->length);
		$criteria->compare("thickness", $this->thickness);
		$criteria->compare("cubage", $this->cubage);
		$criteria->compare("count", $this->count);
		$criteria->compare("price", $this->price);
		$criteria->addSearchCondition("container_id", $this->container_id);

		if( $count ){
			return Cargo::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "cargo/adminindex")
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

	public function getTotal($model){
		$out = (object) array(
			"sum" => 0,
			"cubage" => 0
		);
		foreach ($model as $key => $cargo) {
			$out->sum += ($cargo->cubage*$cargo->price);
			$out->cubage += $cargo->cubage;
		}
		return $out;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cargo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
