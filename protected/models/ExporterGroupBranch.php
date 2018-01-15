<?php

/**
 * This is the model class for table "branch_exporter_group".
 *
 * The followings are the available columns in table "branch_exporter_group":
 * @property integer $branch_id
 * @property integer $exporter_group_id
 */
class ExporterGroupBranch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "exporter_group_branch";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("branch_id, exporter_group_id", "required"),
			array("branch_id, exporter_group_id", "numerical", "integerOnly" => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("branch_id, exporter_group_id", "safe", "on" => "search"),
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
			"branch" => array(self::BELONGS_TO, "Branch", "branch_id"),
			"exporterGroup" => array(self::BELONGS_TO, "ExporterGroup", "exporter_group_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"branch_id" => "Филиал",
			"exporter_group_id" => "Группа экспортеров",
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

		$criteria->compare("branch_id", $this->branch_id);
		$criteria->compare("exporter_group_id", $this->exporter_group_id);

		return new CActiveDataProvider($this, array(
			"criteria"=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BranchExporterGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
