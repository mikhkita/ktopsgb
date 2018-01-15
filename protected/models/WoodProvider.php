<?php

/**
 * This is the model class for table "wood_provider".
 *
 * The followings are the available columns in table "wood_provider":
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property integer $sort
 */
class WoodProvider extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "wood_provider";
	}

	public function scopes()
    {
        return array(
            "sorted" => array(
                "order" => "t.sort ASC",
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
			array("name, sort", "required"),
			array("sort", "numerical", "integerOnly"=>true),
			array("name", "length", "max"=>256),
			array("phone", "length", "max"=>20),
			array("email", "length", "max"=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, name, phone, email, sort", "safe", "on"=>"search"),
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
			"woods" => array(self::HAS_MANY, "Wood", "provider_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"name" => "Наименование",
			"phone" => "Телефон",
			"email" => "E-mail",
			"sort" => "Сортировка",
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
		$criteria->order = "sort ASC";

		$criteria->compare("id", $this->id, true);
		$criteria->addSearchCondition("name", $this->name);
		$criteria->addSearchCondition("phone", $this->phone);
		$criteria->addSearchCondition("email", $this->email);

		if( $count ){
			return WoodProvider::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "woodProvider/adminindex")
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
	 * @return WoodProvider the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
