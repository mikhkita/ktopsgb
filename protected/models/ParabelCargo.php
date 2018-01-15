<?php

/**
 * This is the model class for table "parabel_cargo".
 *
 * The followings are the available columns in table "parabel_cargo":
 * @property string $parabel_id
 * @property string $provider_id
 * @property double $cubage
 */
class ParabelCargo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "parabel_cargo";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("parabel_id, provider_id, cubage", "required"),
			array("cubage", "numerical"),
			array("parabel_id, provider_id", "length", "max" => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("parabel_id, provider_id, cubage", "safe", "on" => "search"),
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
			"parabel" => array(self::BELONGS_TO, "Parabel", "parabel_id"),
			"provider" => array(self::BELONGS_TO, "ParabelProvider", "provider_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"parabel_id" => "Машина из парабели",
			"provider_id" => "Поставщик",
			"cubage" => "Кубатура",
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare("parabel_id", $this->parabel_id, true);
		$criteria->compare("provider_id", $this->provider_id, true);
		$criteria->compare("cubage", $this->cubage);

		return new CActiveDataProvider($this, array(
			"criteria" => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ParabelCargo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
