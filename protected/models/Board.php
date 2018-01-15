<?php

/**
 * This is the model class for table "board".
 *
 * The followings are the available columns in table "board":
 * @property string $id
 * @property string $date
 * @property integer $plant_id
 */
class Board extends CActiveRecord
{
	public $date_from = NULL;
	public $date_to = NULL;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "board";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("date, plant_id", "required"),
			array("plant_id", "numerical", "integerOnly" => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, date, plant_id", "safe", "on" => "search"),
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
			"items" => array(self::HAS_MANY, "BoardItem", "board_id"),
			"plant" => array(self::BELONGS_TO, "Plant", "plant_id"),
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
			"plant_id" => "Место",
			"cubageSum" => "Всего кубов, куб.м.",
			"sum" => "Итого, руб.",
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
		$criteria->with = "items";
		$criteria->order = "date DESC";

		if( $this->date_from != NULL && $this->date_from != "__.__.____" ){
			$criteria->addCondition("date >= '".date("Y-m-d H:i:s", strtotime($this->date_from))."'");
		}
		if( $this->date_to != NULL && $this->date_to != "__.__.____" ){
			$criteria->addCondition("date <= '".date("Y-m-d H:i:s", strtotime($this->date_to))."'");
		}

		$criteria->compare("t.id", $this->id);
		$criteria->addSearchCondition("date", $this->date);
		$criteria->compare("plant_id", $this->plant_id);

		if( $returnCriteria ){
			return $criteria;
		}else if( $count ){
			return Board::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "board/adminindex")
			));
		}
	}

	public function updateObj($attributes, $items = NULL){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$attributes["date"] = date("Y-m-d H:i:s", strtotime($attributes["date"]));

		$this->attributes = $attributes;

		if($this->save()){
			BoardItem::model()->deleteAll("board_id=".$this->id);

			if( is_array($items) && count($items) ){
				foreach ($items as $itemAttributes) {
					$item = new BoardItem();
					$item->attributes = $itemAttributes;
					$item->board_id = $this->id;
					if( !$item->save() ){
						print_r($item->getErrors());
						die();
					}
				}
			}

			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function getCubageSum(){
		$sum = 0;
		foreach ($this->items as $i => $item) {
			$sum += ($item->thickness*$item->width*$item->length*$item->count);
		}

		return $sum;
	}

	public function getSum(){
		$sum = 0;
		foreach ($this->items as $i => $item) {
			$sum += ($item->price*$item->count);
		}

		return $sum;
	}

	public function getTotal($criteria){
		$boards = Board::model()->findAll($criteria);

		$cubage = 0;
		$sum = 0;
		foreach ($boards as $i => $board) {
			$cubage += $board->getCubageSum();
			$sum += $board->getSum();
		}

		return (object) array(
			"cubage" => $cubage,
			"sum" => $sum,
		);
	}

	public function afterFind(){
		parent::afterFind();

		$this->date = date("d.m.Y", strtotime($this->date));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Board the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
