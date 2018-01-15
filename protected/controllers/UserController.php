<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to "//layouts/column2", meaning
	 * using two-column layout. See "protected/views/layouts/column2.php".
	 */

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			"accessControl", // perform access control for CRUD operations
			"postOnly + delete", // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the "accessControl" filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array("allow",
                "actions" => array("adminIndex"),
                "roles" => array("readUser"),
            ),
            array("allow",
                "actions" => array("adminCreate", "adminUpdate", "adminDelete"),
                "roles" => array("updateUser"),
            ),
			array("deny",
				"users" => array("*"),
			),
		);
	}

	public function actionAdminCreate()
	{
		$model=new User;

		if(isset($_POST["User"]))
		{
			$model->attributes=$_POST["User"];

			if($model->save()){
				$this->actionAdminindex(true);
				return true;
			}
		}

		$this->renderPartial("adminCreate",array(
			"model" => $model,
		));

	}

	public function actionAdminUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["User"]))
		{
			$model->prevPass = $model->password;
			$model->attributes = $_POST["User"];

			UserRole::model()->deleteAll("user_id=".$model->id);

			if( isset($_POST["Roles"]) ){
				foreach ($_POST["Roles"] as $key => $roleId) {
					$role = new UserRole();
					$role->user_id = $model->id;
					$role->role_id = $roleId;
					$role->save();
				}
			}

			UserWidget::model()->deleteAll("user_id=".$model->id);

			if( isset($_POST["Widgets"]) ){
				foreach ($_POST["Widgets"] as $key => $widgetId) {
					$widget = new UserWidget();
					$widget->user_id = $model->id;
					$widget->widget_id = $widgetId;
					$widget->save();
				}
			}

			UserBranch::model()->deleteAll("user_id=".$model->id);

			if( isset($_POST["Branches"]) ){
				foreach ($_POST["Branches"] as $key => $branchId) {
					$branch = new UserBranch();
					$branch->user_id = $model->id;
					$branch->branch_id = $branchId;
					$branch->save();
				}
			}

			if($model->save()){
				$this->actionAdminindex(true);
			}
				
		}else{
			$roles = array();
			foreach ($model->roles as $key => $role) {
				array_push($roles, $role->role_id);
			}

			$widgets = array();
			foreach ($model->widgets as $key => $widget) {
				array_push($widgets, $widget->widget_id);
			}

			$branches = array();
			foreach ($model->branches as $key => $branch) {
				array_push($branches, $branch->branch_id);
			}

			$this->renderPartial("adminUpdate",array(
				"model" => $model,
				"roles" => $roles,
				"widgets" => $widgets,
				"branches" => $branches,
			));
		}
	}

	public function actionAdminDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true);
	}

	public function actionAdminIndex($partial = false)
	{
		if( !$partial ){
			$this->layout="admin";
			$this->pageTitle = $this->adminMenu["cur"]->name;
		}

        $model = User::model()->findAll();

		if( !$partial ){
			$this->render("adminIndex",array(
				"data" => $model,
				"labels" => User::attributeLabels()
			));
		}else{
			$this->renderPartial("adminIndex",array(
				"data" => $model,
				"labels" => User::attributeLabels()
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->with("roles.role")->findByPk($id);
		if($model===null)
			throw new CHttpException(404, "The requested page does not exist.");
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST["ajax"]) && $_POST["ajax"] === "user-form")
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
