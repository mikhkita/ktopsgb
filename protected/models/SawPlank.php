<?php

/**
 * This is the model class for table "saw_plank".
 *
 * The followings are the available columns in table "saw_plank":
 * @property string $saw_id
 * @property integer $plank_id
 * @property double $cubage
 */
class SawPlank extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "saw_plank";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("saw_id, plank_id, cubage", "required"),
			array("plank_id", "numerical", "integerOnly" => true),
			array("cubage", "numerical"),
			array("saw_id", "length", "max" => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("saw_id, plank_id, cubage", "safe", "on" => "search"),
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
			"plank" => array(self::BELONGS_TO, "Plank", "plank_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"saw_id" => "Saw",
			"plank_id" => "Plank",
			"cubage" => "Cubage",
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

		$criteria->addSearchCondition("saw_id", $this->saw_id);
		$criteria->compare("plank_id", $this->plank_id);
		$criteria->compare("cubage", $this->cubage);

		if( $count ){
			return SawPlank::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "sawPlank/adminindex")
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
	 * @return SawPlank the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
