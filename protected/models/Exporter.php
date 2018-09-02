<?php

/**
 * This is the model class for table "exporter".
 *
 * The followings are the available columns in table "exporter":
 * @property integer $id
 * @property string $name
 * @property string $email
 */
class Exporter extends CActiveRecord
{
	public $branch_id = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "exporter";
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
			array("sort", "numerical", "integerOnly" => true),
			array("name, email", "length", "max" => 64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, name, email, sort, branch_id", "safe", "on" => "search"),
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
			"containers" => array(self::HAS_MANY, "Container", "exporter_id"),
			"branches" => array(self::HAS_MANY, "ExporterBranch", "exporter_id"),
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
			"email" => "E-mail",
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

		$criteria=new CDbCriteria;
		$criteria->order = "t.name ASC";
		$criteria->with = "branches";
		$criteria->together = true;

		$criteria->compare("id", $this->id);
		$criteria->compare("branches.branch_id", $this->branch_id);
		$criteria->addSearchCondition("t.name", $this->name);
		$criteria->addSearchCondition("t.email", $this->email);

		if( $count ){
			return Exporter::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "exporter/adminindex")
			));
		}
	}

	public function updateObj($attributes, $branches = NULL){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$this->attributes = $attributes;

		if($this->save()){
			ExporterBranch::model()->deleteAll("exporter_id=".$this->id);

			if( is_array($branches) && count($branches) ){
				foreach ($branches as $key => $branchId) {
					$branch = new ExporterBranch();
					$branch->exporter_id = $this->id;
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
	 * @return Exporter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
