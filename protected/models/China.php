<?php

/**
 * This is the model class for table "China".
 *
 * The followings are the available columns in table "China":
 * @property integer $id
 * @property string $name
 */
class China extends CActiveRecord
{
	public $cubages = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "china";
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
			array("name", "length", "max" => 64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, name", "safe", "on" => "search"),
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
			"saws" => array(self::HAS_MANY, "SawChina", "china_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"name" => "Имя",
			"salary" => "Зарплата",
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
		$criteria->with = "saws.saw.planks";

		$criteria->compare("id", $this->id);
		$criteria->addSearchCondition("name", $this->name);

		if( $returnCriteria ){
			return $criteria;
		}else if( $count ){
			return China::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "China/adminindex")
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

	public function getMoney(){
		$out = 0;

		foreach ($this->saws as $i => $saw) {
			$out += ($saw->saw->getMoney()/count($saw->saw->chinese));
		}

		return $out;
	}

	public function getAllMoney($criteria){
		$model = China::model()->findAll();

		$out = 0;
		foreach ($model as $key => $item) {
			$out += $item->getMoney();
		}
		return $out;
	}

	public function getCubages(){
		$this->cubages = array();

		foreach ($this->saws as $i => $saw) {
			foreach ($saw->saw->planks as $j => $plank) {
				$group_id = $plank->plank->group_id;	
				if( !isset($this->cubages[$group_id]) ){
					$this->cubages[$group_id] = 0;
				}
				
				$this->cubages[$group_id] = $this->cubages[$group_id] + ($plank->cubage/count($saw->saw->chinese));
			}
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return China the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
