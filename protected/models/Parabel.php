<?php

/**
 * This is the model class for table "parabel".
 *
 * The followings are the available columns in table "parabel":
 * @property string $id
 * @property string $date
 * @property string $type_id
 */
class Parabel extends CActiveRecord
{
	public $date_from = NULL;
	public $date_to = NULL;
	public $cubages = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "parabel";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date, type_id", "required"),
			array("type_id", "numerical", "integerOnly" => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date, type_id", "safe", "on" => "search"),
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
			"cargo" => array(self::HAS_MANY, "ParabelCargo", "parabel_id", "order" => "provider.sort"),
			"type" => array(self::BELONGS_TO, "ParabelType", "type_id"),
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
			"type_id" => "Тип груза",
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

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			$criteria->addCondition("date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

		$criteria->with = array("cargo.provider", "type");
		$criteria->order = "date DESC";
		$criteria->compare("id", $this->id, true);
		$criteria->compare("date", $this->date, true);
		$criteria->compare("type_id", $this->type_id, true);

		if( $returnCriteria ){
			return $criteria;
		}else if( $count ){
			return Parabel::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				"pagination" => array('pageSize' => $pages, 'route' => 'parabel/adminindex')
			));
		}
	}

	public function getTotal($criteria){
		$parabel = Parabel::model()->findAll($criteria);

		$cubage = 0;
		foreach ($parabel as $i => $item) {
			foreach ($item->cargo as $j => $cargo) {
				$cubage += $cargo->cubage;
			}
		}

		return $cubage;
	}

	public function updateObj($attributes, $providers){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}
			
		$attributes["date"] = date("Y-m-d H:i:s", strtotime($attributes["date"]));

		$this->attributes = $attributes;

		if($this->save()){
			ParabelCargo::model()->deleteAll("parabel_id=".$this->id);

			foreach ($providers as $providerId => $cubage) {
		    	$cargo = new ParabelCargo();
				$cargo->parabel_id = $this->id;
				$cargo->provider_id = $providerId;
				$cargo->cubage = $cubage;
				$cargo->save();
			}

			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function afterFind(){
		parent::afterFind();

		$this->date = date("d.m.Y", strtotime($this->date));
	}

	public function getCubages(){
		$this->cubages = array();

		foreach ($this->cargo as $i => $cargo) {
			$this->cubages[$cargo->provider_id] = $cargo->cubage;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Parabel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
