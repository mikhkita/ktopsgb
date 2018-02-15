<?php

/**
 * This is the model class for table "correspondent".
 *
 * The followings are the available columns in table "correspondent":
 * @property string $id
 * @property string $name
 * @property string $inn
 * @property integer $is_provider
 */
class Correspondent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "correspondent";
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
			array("provider_id", "numerical", "integerOnly" => true),
			array("name", "length", "max" => 256),
			array("inn", "length", "max" => 12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, name, inn, provider_id", "safe", "on" => "search"),
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
			"provider" =>  array(self::BELONGS_TO, "WoodProvider", "provider_id"),
			"orders" => array(self::HAS_MANY, "Order", "correspondent_id"),
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
			"inn" => "ИНН",
			"provider_id" => "Поставщик",
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
		$criteria->order = "name ASC";

		$criteria->compare("id", $this->id, true);
		$criteria->addSearchCondition("name", $this->name);
		$criteria->addSearchCondition("inn", $this->inn);

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
