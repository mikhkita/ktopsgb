<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table "user":
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $email
 */
class User extends CActiveRecord
{
	const ROLE_USER = "user";
	const ROLE_ADMIN = "admin";
	const ROLE_ROOT = "root";

	const STATE_ACTIVE = 1;
	const STATE_DISABLED = 0;

	public $prevPass = null;
	public $fio = "";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return "user";
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("login, password, name, email", "required"),
			array("active", "numerical", "integerOnly"=>true),
			array("login, password, email", "length", "max"=>128),
			array("name", "length", "max"=>255),
			array("surname, token", "length", "max"=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array("id, login, password, name, email, surname, active, token", "safe", "on"=>"search"),
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
			"roles" => array(self::HAS_MANY, "UserRole", "user_id"),
			"widgets" => array(self::HAS_MANY, "UserWidget", "user_id"),
			"branches" => array(self::HAS_MANY, "UserBranch", "user_id"),
			"settings" => array(self::HAS_MANY, "UserSettings", "user_id"),
			"locations" => array(self::HAS_MANY, "Location", "user_id"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			"id" => "ID",
			"login" => "Логин",
			"password" => "Пароль",
			"name" => "Имя",
			"surname" => "Фамилия",
			"email" => "E-mail",
			"roles" => "Роли",
			"widgets" => "Виджеты",
			"branches" => "Доступ к филиалам",
			"active" => "Активность",
			"token" => "Токен",
		);
	}

	public function beforeSave() {
		parent::beforeSave();
		$this->password = ( $this->prevPass == $this->password ) ? $this->password : md5($this->password."eduplan");

		if( !$this->login || !$this->email || !$this->password ){
	        return false;
		}

		if( !Yii::app()->user->checkAccess("updateUser") )
			throw new CHttpException(403,"Доступ запрещен");

		return true;
	}

	public function afterSave() {
		parent::afterSave();

		//связываем нового пользователя с ролями
		$auth = Yii::app()->authManager;

		//предварительно удаляем старые связи
		$auth->revoke("readAnyBranches", $this->id);
		$auth->revoke("updateAnyBranches", $this->id);
		foreach ($this->roles as $key => $role) {
			$auth->revoke($role->role->code, $this->id);	
		}
		foreach ($this->widgets as $key => $widget) {
			$auth->revoke($widget->widget->code, $this->id);	
		}

		UserRole::model()->deleteAll("user_id=".$this->id);

		if( isset($_POST["Roles"]) ){
			foreach ($_POST["Roles"] as $key => $roleId) {
				$role = new UserRole();
				$role->user_id = $this->id;
				$role->role_id = $roleId;
				$role->save();
			}
		}

		UserWidget::model()->deleteAll("user_id=".$this->id);

		if( isset($_POST["Widgets"]) ){
			foreach ($_POST["Widgets"] as $key => $widgetId) {
				$widget = new UserWidget();
				$widget->user_id = $this->id;
				$widget->widget_id = $widgetId;
				$widget->save();
			}
		}

		UserBranch::model()->deleteAll("user_id=".$this->id);

		if( isset($_POST["Branches"]) ){
			foreach ($_POST["Branches"] as $branch_id => $type) {
				if( $type == "" ) continue;
				
				$branch = new UserBranch();
				$branch->user_id = $this->id;
				$branch->branch_id = $branch_id;
				if( intval($type) == 2 ){
					$branch->w = 1;
				}
				$branch->save();
			}
		}

		$auth->assign("readAnyBranches", $this->id);
        $auth->assign("updateAnyBranches", $this->id);

		$model = UserRole::model()->with("role")->findAll("user_id=".$this->id);
		foreach ($model as $key => $role) {
			$auth->assign($role->role->code, $this->id);	
		}

		$model = UserWidget::model()->with("widget")->findAll("user_id=".$this->id);
		foreach ($model as $key => $widget) {
			$auth->assign($widget->widget->code, $this->id);	
		}
		$auth->save();
		return true;
	}

	public function afterFind()
	{
		parent::afterFind();

		$this->fio = $this->surname." ".$this->name;
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

		$criteria->compare("id", $this->id);
		$criteria->compare("login", $this->login, true);
		$criteria->compare("password", $this->password, true);
		$criteria->compare("name", $this->name, true);
		$criteria->compare("email", $this->email, true);
		$criteria->compare("surname", $this->surname, true);
		$criteria->compare("active", $this->active);

		return new CActiveDataProvider($this, array(
			"criteria"=>$criteria,
		));
	}

	public function getRoleNames(){
		$out = array();

		foreach ($this->roles as $i => $role) {
			$out[$role->role->id] = $role->role->name;
		}

		return $out;
	}

	public function getBranches(){
		$out = array();

		foreach ($this->branches as $i => $branch) {
			$out[$branch->branch->id] = $branch->branch->name.(($branch->w)?" (w)":" (r)");
		}

		return $out;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
