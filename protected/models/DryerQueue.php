<?php

/**
 * This is the model class for table "dryer_queue".
 *
 * The followings are the available columns in table 'dryer_queue':
 * @property string $id
 * @property string $dryer_id
 * @property string $start_date
 * @property string $size
 * @property string $cubage
 * @property string $packs
 * @property string $rows
 * @property string $comment
 * @property string $complete_date
 */
class DryerQueue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dryer_queue';
	}

	public function scopes()
    {
        return array(
            'incomplete' => array(
                'condition' => 'complete_date IS NULL',
            ),
            'last' => array(
                'order' => 'queue.id DESC',
                'limit' => 1,
            ),
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dryer_id, start_date, size, cubage, packs, rows', 'required'),
			array('dryer_id', 'length', 'max'=>10),
			array('size', 'length', 'max'=>256),
			array('cubage', 'length', 'max'=>512),
			array('packs, rows', 'length', 'max'=>128),
			array('comment', 'length', 'max'=>1024),
			array('complete_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dryer_id, start_date, size, cubage, packs, rows, comment, complete_date', 'safe', 'on'=>'search'),
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
			'dryer' => array(self::BELONGS_TO, 'Dryer', 'dryer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dryer_id' => 'Сушилка',
			'start_date' => 'Дата загрузки',
			'size' => 'Размеры',
			'cubage' => 'Кубатура',
			'packs' => 'Количество пачек',
			'rows' => 'Ряды',
			'comment' => 'Комментарий',
			'complete_date' => 'Дата выгрузки',
		);
	}

	public function updateObj($attributes, $dryer_id = NULL){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		if( !isset($attributes["start_date"]) || $attributes["start_date"] == "" ){
			$attributes["start_date"] = $this->start_date;
		}
			
		$attributes["start_date"] = date("Y-m-d H:i:s", strtotime($attributes["start_date"]));

		if( isset($attributes["complete_date"]) && $attributes["complete_date"] != "" ){
			$attributes["complete_date"] = date("Y-m-d H:i:s", strtotime($attributes["complete_date"]));
		}else{
			$attributes["complete_date"] = NULL;
		}

		if( $dryer_id !== NULL ){
			$attributes["dryer_id"] = $dryer_id;
		}

		$this->attributes = $attributes;

		if($this->save()){
			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function afterFind()
	{
		parent::afterFind();

		$this->start_date = date("d.m.Y", strtotime($this->start_date));
		if( $this->complete_date )
			$this->complete_date = date("d.m.Y", strtotime($this->complete_date));
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('dryer_id',$this->dryer_id,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('cubage',$this->cubage,true);
		$criteria->compare('packs',$this->packs,true);
		$criteria->compare('rows',$this->rows,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('complete_date',$this->complete_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DryerQueue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
