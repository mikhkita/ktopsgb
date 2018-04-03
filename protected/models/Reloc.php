<?php

/**
 * This is the model class for table "reloc".
 *
 * The followings are the available columns in table "reloc":
 * @property integer $worker_id
 * @property integer $plank_id
 * @property integer $day_id
 * @property integer $count
 */
class Reloc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "reloc";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("worker_id, plank_id, day_id, count", "required"),
			array("worker_id, plank_id, day_id, count", "numerical", "integerOnly" => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("worker_id, plank_id, day_id, count", "safe", "on" => "search"),
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
			"worker" => array(self::BELONGS_TO, "Worker", "worker_id"),
			"plank" => array(self::BELONGS_TO, "RelocPlank", "plank_id"),
			"day" => array(self::BELONGS_TO, "Day", "day_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"worker_id" => "Рабочий",
			"plank_id" => "Тип доски",
			"day_id" => "День",
			"count" => "Количество пачек",
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

		$criteria->compare("worker_id", $this->worker_id);
		$criteria->compare("plank_id", $this->plank_id);
		$criteria->compare("day_id", $this->day_id);
		$criteria->compare("count", $this->count);

		if( $count ){
			return Reloc::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "reloc/adminindex")
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

	public function getAssoc($model){
		$out = array();
        foreach ($model as $key => $value){
            $out[$value["worker_id"]."-".$value["plank_id"]] = $value;
        }
        return $out;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reloc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
