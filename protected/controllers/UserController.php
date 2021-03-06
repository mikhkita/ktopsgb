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
		}else{
			$branches = array();
			foreach (Branch::model()->findAll() as $key => $branch) {
				$branches[$branch->id] = (object) array(
					"name" => $branch->name,
					"value" => NULL
				);
			}
		}

		$this->renderPartial("adminCreate",array(
			"model" => $model,
			"branches" => $branches,
		));

	}

	public function actionAdminUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST["User"]))
		{
			$model->prevPass = $model->password;
			$model->attributes = $_POST["User"];

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
			foreach (Branch::model()->findAll() as $key => $branch) {
				$branches[$branch->id] = (object) array(
					"name" => $branch->name,
					"value" => NULL
				);
			}
			foreach ($model->branches as $key => $branch) {
				if( isset($branches[$branch->branch_id]) ){
					$branches[$branch->branch_id]->value = ($branch->w)?2:1;
				}
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
