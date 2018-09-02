<?php

/**
 * This is the model class for table "exporter_group".
 *
 * The followings are the available columns in table "exporter_group":
 * @property integer $id
 * @property string $name
 */
class ExporterGroup extends CActiveRecord
{
	public $branch_id = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "exporter_group";
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
			array("name", "length", "max" => 64),
			array("sort", "numerical", "integerOnly" => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, name, sort, branch_id", "safe", "on" => "search"),
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
			"containers" => array(self::HAS_MANY, "Container", "exporter_group_id"),
			"exporters" => array(self::HAS_MANY, "Exporter", "group_id"),
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
			"sort" => "Сортировка",
			"branches" => "Филиалы",
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

		$criteria = new CDbCriteria;
		$criteria->order = "t.sort ASC";
		$criteria->with = "branches";
		$criteria->together = true;

		$criteria->compare("branches.branch_id", $this->branch_id);
		$criteria->compare("t.id", $this->id);
		$criteria->addSearchCondition("t.name", $this->name);

		if( $count ){
			return ExporterGroup::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "exporterGroup/adminindex")
			));
		}
	}

	public function updateObj($attributes, $branches = NULL){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$this->attributes = $attributes;

		if($this->save()){
			ExporterGroupBranch::model()->deleteAll("exporter_group_id=".$this->id);

			if( is_array($branches) && count($branches) ){
				foreach ($branches as $key => $branchId) {
					$branch = new ExporterGroupBranch();
					$branch->exporter_group_id = $this->id;
					$branch->branch_id = $branchId;
					$branch->save();
				}
			}

			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function getBranchNames(){
		$out = array();

		foreach ($this->branches as $i => $branch) {
			$out[$branch->branch->id] = $branch->branch->name;
		}

		return $out;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExporterGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
