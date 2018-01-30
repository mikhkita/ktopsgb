<?php

/**
 * This is the model class for table "day".
 *
 * The followings are the available columns in table "day":
 * @property integer $id
 * @property string $date
 */
class Day extends CActiveRecord
{
	public $date_from = NULL;
	public $date_to = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "day";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date", "required"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date", "safe", "on" => "search"),
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
			"relocs" => array(self::HAS_MANY, "Reloc", "day_id"),
			"salary" => array(self::HAS_MANY, "Salary", "day_id"),
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
			"sum" => "Зарплата за день",
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
	public function search($pages, $count = false, $with = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if( $with ){
			$criteria->with = $with;
		}

		$criteria->compare("id", $this->id);
		$criteria->addSearchCondition("date", $this->date);

		if( $count ){
			return Day::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "day/adminindex")
			));
		}
	}

	public function searchPost($pages, $count = false, $other = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = "date DESC";

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			$criteria->addCondition("date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

		$criteria->with = "salary.worker";
		$criteria->together = true;
		if( $other ){
			$criteria->addCondition("worker.post_id = 1");
		}else{
			$criteria->addCondition("worker.post_id != 1");
		}

		if( $count ){
			return Day::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "day/adminindex")
			));
		}
	}

	public function getSumSalary(){
		$sum = 0;

		foreach ($this->salary as $i => $salary) {
			$sum += ($salary->calc_pay + $salary->day_pay);
		}

		return $sum;
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

	public function updateWork($prevDayId = false, $date, $workersPost){

		// Получаем ID для или создаем его и получаем ID
		$dayId = Day::addDay($date);

		// Получаем рабочих и массив с их айдишниками для удаления
		$workers = Worker::model()->findAll("post_id != 1");
		$workerIds = Controller::getIds($workers);
		$workers = Controller::getAssoc($workers, "id");

		if( !$prevDayId ){
			if( Salary::model()->count("day_id = '".$dayId."' AND worker_id IN (".implode(",", $workerIds).")") ){
				return true;
			}
			$prevDayId = $dayId;
		}

		// Удаляем предыдущие записи
		Salary::model()->deleteAll("day_id = '".$prevDayId."' AND worker_id IN (".implode(",", $workerIds).")");

		foreach ($workersPost as $workerId => $worker) {
			if( floatval($worker["k"]) == 0 && floatval($worker["day_pay"]) == 0 ) continue;

	    	$salary = new Salary();
	    	$salary->day_id = $dayId;
	    	$salary->worker_id = $workerId;
	    	$salary->day_pay = $worker["day_pay"];
	    	if( isset($workers[$workerId]) ){
	    		$salary->calc_pay = round(floatval($worker["k"])*$workers[$workerId]->salary);
	    	}
	    	$salary->k = $worker["k"];
	    	$salary->save();
		}
	}

	public function updateReloc($prevDayId = false, $date, $reloc){

		// Получаем ID для или создаем его и получаем ID
		$dayId = Day::addDay($date);

		// Получаем рабочих и массив с их айдишниками для удаления
		$workers = Worker::model()->findAll("post_id = 1");
		$workerIds = Controller::getIds($workers);
		$workers = Controller::getAssoc($workers, "id");

		$planks = Controller::getAssoc( RelocPlank::model()->findAll(), "id" );

		if( !$prevDayId ){
			if( Salary::model()->count("day_id = '".$dayId."' AND worker_id IN (".implode(",", $workerIds).")") ){
				return true;
			}
			$prevDayId = $dayId;
		}

		// Удаляем предыдущие записи
		Reloc::model()->deleteAll("day_id = '".$prevDayId."'");
		Salary::model()->deleteAll("day_id = '".$prevDayId."' AND worker_id IN (".implode(",", $workerIds).")");

		foreach ($reloc as $workerId => $worker) {
			$sum = 0;
			foreach ($worker["planks"] as $plankId => $count){
				if( floatval($count) == 0 || !isset($planks[$plankId]) ) continue;

				$sum += ($count*$planks[$plankId]->price);

				$model = new Reloc();
		    	$model->day_id = $dayId;
		    	$model->worker_id = $workerId;
		    	$model->plank_id = $plankId;
		    	$model->count = $count;
		    	$model->save();
			}

			if( $sum == 0 && intval($worker["day_pay"]) == 0 ) continue;

			$salary = new Salary();
	    	$salary->day_id = $dayId;
	    	$salary->worker_id = $workerId;
	    	$salary->day_pay = $worker["day_pay"];
	    	$salary->calc_pay = round($sum);
	    	$salary->save();
		}
	}

	public function addDay($date){
		$date = date("Y-m-d H:i:s", strtotime($date));

		if( $day = Day::model()->find("date = '".$date."'") ){
			return $day->id;
		}else{
			$model = new Day();
			$model->date = $date;
			$model->save();

			return $model->id;
		}
	}

	public function afterFind()
	{
		parent::afterFind();

		$this->date = date("d.m.Y", strtotime($this->date));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Day the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
