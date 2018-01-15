<?php

/**
 * This is the model class for table "board_item".
 *
 * The followings are the available columns in table "board_item":
 * @property string $id
 * @property string $board_id
 * @property integer $thickness
 * @property integer $width
 * @property integer $length
 * @property integer $count
 */
class BoardItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "board_item";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("board_id, thickness, width, length, count", "required"),
			array("thickness, width, length, count, price", "numerical"),
			array("board_id", "length", "max" => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, board_id, thickness, width, length, count, price", "safe", "on" => "search"),
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
			"board" => array(self::BELONGS_TO, "Board", "board_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"board_id" => "Отгрузка",
			"thickness" => "Толщина, м.",
			"width" => "Ширина, м.",
			"length" => "Длина, м.",
			"count" => "Количество, шт.",
			"cubage" => "Кубатура, куб.м.",
			"price" => "Цена, руб.",
			"sum" => "Стоимость, руб.",
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

		$criteria->addSearchCondition("id", $this->id);
		$criteria->addSearchCondition("board_id", $this->board_id);
		$criteria->compare("thickness", $this->thickness);
		$criteria->compare("width", $this->width);
		$criteria->compare("length", $this->length);
		$criteria->compare("count", $this->count);
		$criteria->compare("price", $this->price);

		if( $count ){
			return BoardItem::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "boardItem/adminindex")
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
	 * @return BoardItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
