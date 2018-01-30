<?php

/**
 * This is the model class for table "worker".
 *
 * The followings are the available columns in table "worker":
 * @property integer $id
 * @property string $name
 * @property integer $post_id
 * @property integer $salary
 */
class Worker extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "worker";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("name, post_id, salary", "required"),
			array("post_id, salary", "numerical", "integerOnly" => true),
			array("name", "length", "max" => 80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, name, post_id, salary", "safe", "on" => "search"),
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
			"relocs" => array(self::HAS_MANY, "Reloc", "worker_id"),
			"salaries" => array(self::HAS_MANY, "Salary", "worker_id"),
			"post" => array(self::BELONGS_TO, "Post", "post_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"name" => "ФИО",
			"post_id" => "Должность",
			"salary" => "Оклад в день",
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
		$criteria->order = "name ASC";

		$criteria->compare("id", $this->id);
		$criteria->addSearchCondition("name", $this->name);
		$criteria->compare("post_id", $this->post_id);
		$criteria->compare("salary", $this->salary);

		if( $count ){
			return Worker::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "worker/adminindex")
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
	 * @return Worker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
