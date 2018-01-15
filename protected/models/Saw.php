<?php

/**
 * This is the model class for table "saw".
 *
 * The followings are the available columns in table "saw":
 * @property string $id
 * @property string $date
 * @property integer $sawmill_id
 */
class Saw extends CActiveRecord
{
	public $cubages = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "saw";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date, sawmill_id", "required"),
			array("sawmill_id", "numerical", "integerOnly" => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date, sawmill_id", "safe", "on" => "search"),
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
			"planks" => array(self::HAS_MANY, "SawPlank", "saw_id"),
			"workers" => array(self::HAS_MANY, "SawWorker", "saw_id"),
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
			"sawmill_id" => "Пилорама",
			"workers" => "Рабочие",
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
	public function search($pages, $count = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = "date DESC";

		$criteria->addSearchCondition("id", $this->id);
		$criteria->addSearchCondition("date", $this->date);
		$criteria->compare("sawmill_id", $this->sawmill_id);

		if( $count ){
			return Saw::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "saw/adminindex")
			));
		}
	}

	public function updateObj($attributes, $planks = NULL, $workers = NULL){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$attributes["date"] = date("Y-m-d H:i:s", strtotime($attributes["date"]));

		$this->attributes = $attributes;

		if($this->save()){
			SawPlank::model()->deleteAll("saw_id=".$this->id);

			if( is_array($planks) && count($planks) ){
				foreach ($planks as $plankId => $cubage) {
			    	$cargo = new SawPlank();
					$cargo->saw_id = $this->id;
					$cargo->plank_id = $plankId;
					$cargo->cubage = $cubage;
					$cargo->save();
				}
			}

			SawWorker::model()->deleteAll("saw_id=".$this->id);

			if( is_array($workers) && count($workers) ){
				foreach ($workers as $key => $workerId) {
					$worker = new SawWorker();
					$worker->saw_id = $this->id;
					$worker->worker_id = $workerId;
					$worker->save();
				}
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

		foreach ($this->planks as $i => $plank) {
			$this->cubages[$plank->plank_id] = $plank->cubage;
		}
	}

	public function getMoney(){
		$out = 0;

		foreach ($this->planks as $i => $plank) {
			$out += ($plank->cubage*$plank->plank->group->price);
		}

		return $out;
	}

	public function getWorkerNames(){
		$out = array();

		foreach ($this->workers as $i => $worker) {
			$out[$worker->worker->id] = $worker->worker->name;
		}

		return $out;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Saw the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
