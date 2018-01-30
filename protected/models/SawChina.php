<?php

/**
 * This is the model class for table "saw_china".
 *
 * The followings are the available columns in table "saw_china":
 * @property integer $china_id
 * @property string $saw_id
 */
class SawChina extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "saw_china";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("china_id, saw_id", "required"),
			array("china_id", "numerical", "integerOnly" => true),
			array("saw_id", "length", "max" => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("china_id, saw_id", "safe", "on" => "search"),
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
			"saw" => array(self::BELONGS_TO, "Saw", "saw_id"),
			"china" => array(self::BELONGS_TO, "China", "china_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"china_id" => "Рабочий",
			"saw_id" => "Рабочий день",
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

		$criteria->compare("china_id", $this->china_id);
		$criteria->addSearchCondition("saw_id", $this->saw_id);

		if( $count ){
			return SawChina::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "sawChina/adminindex")
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SawChina the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
