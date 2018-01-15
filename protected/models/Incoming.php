<?php

/**
 * This is the model class for table "incoming".
 *
 * The followings are the available columns in table "incoming":
 * @property string $id
 * @property string $date
 * @property string $car
 * @property integer $cargo
 */
class Incoming extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "incoming";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date, car, cargo", "required"),
			array("car", "length", "max" => 16),
			array("cargo", "length", "max" => 64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date, car, cargo", "safe", "on" => "search"),
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
			"car" => "Номер авто",
			"cargo" => "Груз",
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
		$criteria->order = "date DESC";

		$criteria->compare("id", $this->id, true);
		$criteria->compare("date", $this->date, true);
		$criteria->addSearchCondition("car", $this->car);
		$criteria->addSearchCondition("cargo", $this->cargo);

		if( $count ){
			return Incoming::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "incoming/adminindex")
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

	public function afterFind(){
		parent::afterFind();

		$this->date = date("d.m.Y", strtotime($this->date));
	}

	public function getDistinct($field){
		$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->select = $field;

		$model = Incoming::model()->findAll($criteria);

        $arr = array();
        foreach ($model as $i => $item) 
            $arr[] = $item->{$field};

        return json_encode($arr);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Incoming the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
