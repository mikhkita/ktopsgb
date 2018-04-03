<?php

/**
 * This is the model class for table "salary".
 *
 * The followings are the available columns in table "salary":
 * @property integer $day_id
 * @property integer $worker_id
 * @property integer $calc_pay
 * @property integer $day_pay
 * @property double $k
 */
class Salary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "salary";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("day_id, worker_id", "required"),
			array("day_id, worker_id, calc_pay, day_pay", "numerical", "integerOnly" => true),
			array("k", "numerical"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("day_id, worker_id, calc_pay, day_pay, k", "safe", "on" => "search"),
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
			"day" => array(self::BELONGS_TO, "Day", "day_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"day_id" => "День",
			"worker_id" => "Рабочий",
			"calc_pay" => "Рассчитанная зарплата",
			"day_pay" => "Доп. зарплата",
			"k" => "Коэффициент",
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

		$criteria->compare("day_id", $this->day_id);
		$criteria->compare("worker_id", $this->worker_id);
		$criteria->compare("calc_pay", $this->calc_pay);
		$criteria->compare("day_pay", $this->day_pay);
		$criteria->compare("k", $this->k);

		if( $count ){
			return Salary::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "salary/adminindex")
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

	public function getTotal($filter, $other = false){
		$workerIds = Controller::getIds(Worker::model()->findAll( (( $other )?"post_id = 1":"post_id != 1") ));

		$criteria=new CDbCriteria;

		if( $filter->date_from != NULL && $filter->date_from != "__.__.____" ){
			$criteria->addCondition("day.date >= '".date("Y-m-d H:i:s", strtotime($filter->date_from))."'");
		}
		if( $filter->date_to != NULL && $filter->date_to != "__.__.____" ){
			$criteria->addCondition("day.date <= '".date("Y-m-d H:i:s", strtotime($filter->date_to))."'");
		}

		$criteria->with = "day";
		$criteria->addCondition("worker_id IN (".implode(",", $workerIds).")");
		$criteria->together = true;

		$salary = Salary::model()->findAll($criteria);

		$sum = 0;
		foreach ($salary as $key => $item) {
			$sum += ($item->calc_pay + $item->day_pay);
		}

		return $sum;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Salary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
