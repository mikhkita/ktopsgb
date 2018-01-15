<?php

/**
 * This is the model class for table "cash".
 *
 * The followings are the available columns in table "cash":
 * @property string $id
 * @property string $date
 * @property integer $type_id
 * @property string $reason
 * @property integer $sum
 * @property string $comment
 * @property integer $cheque
 */
class Cash extends CActiveRecord
{
	public $date_from = NULL;
	public $date_to = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "cash";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date, type_id, sum, negative", "required"),
			array("type_id, sum, cheque, negative", "numerical", "integerOnly" => true),
			array("reason, comment", "length", "max" => 512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date, type_id, reason, sum, comment, cheque, negative", "safe", "on" => "search"),
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
			"type" => array(self::BELONGS_TO, "CashType", "type_id"),
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
			"type_id" => "Группа",
			"reason" => "Пояснение",
			"sum" => "Сумма",
			"comment" => "Комментарий",
			"cheque" => "Чек",
			"negative" => "Тип платежа",
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
		$criteria->order = "date DESC";

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			$criteria->addCondition("date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

        $criteria->compare("type_id", $this->type_id);
		$criteria->addSearchCondition('reason', $this->reason);
		$criteria->addSearchCondition('comment', $this->comment);

		if( $returnCriteria ){
			return $criteria;
		}else if( $count ){
			return Cash::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				"pagination" => array('pageSize' => $pages, 'route' => 'cash/adminindex')
			));
		}
	}

	public function updateObj($attributes){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		if( !isset($attributes["date"]) || $attributes["date"] == "" ){
			$attributes["date"] = $this->date;
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

	public function getReasons($type_id = NULL){
		$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->select = "reason";
		if( $type_id !== NULL ){
			$criteria->condition = "type_id='".$type_id."'";
		}

		$model = Cash::model()->findAll($criteria);

        $arr = array();

        foreach ($model as $i => $item) 
            $arr[] = $item->reason;

        return json_encode($arr);
    }

	public function afterFind()
	{
		parent::afterFind();

		$this->date = date("d.m.Y", strtotime($this->date));
	}

	public function getTotal($criteria){
		$arCash = Cash::model()->findAll($criteria);

		$sum = 0;
		foreach ($arCash as $i => $cash) {
			$sum += (($cash->negative)?($cash->sum*(-1)):$cash->sum);
		}

		return $sum;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cash the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
