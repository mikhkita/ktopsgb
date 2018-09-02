<?php

/**
 * This is the model class for table "note".
 *
 * The followings are the available columns in table "note":
 * @property string $id
 * @property string $container_id
 * @property string $date
 * @property string $text
 */
class Note extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "note";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("container_id, user_id, date", "required"),
			array("container_id", "length", "max" => 10),
			array("text", "length", "max" => 4096),
			array("user_id", "length", "max" => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, container_id, date, text, user_id", "safe", "on" => "search"),
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
			"container" => array(self::BELONGS_TO, "Container", "container_id"),
			"files" => array(self::HAS_MANY, "File", "note_id"),
			"user" => array(self::BELONGS_TO, "User", "user_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"container_id" => "ID элемента",
			"date" => "Дата",
			"text" => "Текст примечания",
			"user_id" => "Пользователь"
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
		$criteria->order = "date DESC";

		$criteria->compare("id", $this->id);
		$criteria->compare("container_id", $this->container_id);
		$criteria->addSearchCondition("date", $this->date);
		$criteria->addSearchCondition("text", $this->text);
		$criteria->compare("user_id", $this->user_id);

		if( $count ){
			return Note::model()->count($criteria);
		}else{
			return new CActiveDataProvider($this, array(
				"criteria" => $criteria,
				"pagination" => array("pageSize" => $pages, "route" => "note/adminindex")
			));
		}
	}

	public function updateObj($attributes){
		foreach ($attributes as &$value) {
	    	$value = trim($value);
		}

		$isNewRecord = $this->isNewRecord;
		$prev = clone $this;

		if( !$this->date ){
			$attributes["date"] = date("Y-m-d H:i:s", time());
		}else{
			$attributes["date"] = date("Y-m-d H:i:s", strtotime($this->date));
		}

		$this->attributes = $attributes;

		if($this->save()){
			return true;
		}else{
			print_r($this->getErrors());
			return false;
		}
	}

	public function afterFind(){
		parent::afterFind();

		$this->date = date("d.m.Y H:i:s", strtotime($this->date));
	}

	public function afterSave(){
		parent::afterSave();

		$this->date = date("d.m.Y H:i:s", strtotime($this->date));
	}

	protected function beforeDelete()
	{
		if(parent::beforeDelete() === false) {
			return false;
		}

		$ids = Controller::getIds($this->files);
		if( $ids ){
			Controller::removeFiles( $ids );
		}

		return true;
	}

	public function getFilesString(){
		$out = array();
		foreach ($this->files as $key => $file){
			array_push($out, "<a href=\"http://".$_SERVER["HTTP_HOST"]."/".Yii::app()->params['docsFolder']."/".$file->id."/".$file->original."\" class=\"b-doc\" target=\"_blank\">".$file->original."</a>");
		}
		if( count($out) ){
			return implode(", ", $out);
		}else{
			return false;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Note the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
