<?php

class AdminController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all Production Head to all actions
				'expression'=>'$user->isProductionHead',
			),
			array('allow',  // allow all Production Head to all actions
				'expression'=>'$user->isSuperAdmin',
			),
			array('allow',  // allow to all users
				'actions'=>array('login','logout'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Admin;
		$model->setScenario('create');
		$single_div_display = "display:none;";
		$div_display = "display:none;";
		$line_list_data = JoLine::model()->LineList("admin");
		
		
		$selected_line_data = array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Admin']))
		{
			
			$model->attributes=$_POST['Admin'];
			if($model->user_role == "Sewing Output & Status Controller" || $model->user_role == "Finishing Output & Status Controller"){
				$div_display = "display:block;";
				$single_div_display = "display:none;";
				
				
				if(!empty($model->selected_line)){
					foreach($model->selected_line as $sl){
						$v = $line_list_data[$sl];
						unset($line_list_data[$sl]);
						$selected_line_data[$sl]  = $v;
					}
				}
			
			}else if($model->user_role == Admin::LEVEL_LINE_HEAD){
				$div_display = "display:none;";
				$single_div_display = "display:block;";
			}	
			$model->validate();
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}
		
		$this->render('create',array(
			'model'=>$model,
			'single_div_display' => $single_div_display,
			'div_display' => $div_display,
			'line_list_data' => $line_list_data,
			'selected_line_data'=>$selected_line_data
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		/*$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Admin']))
		{
			$model->attributes=$_POST['Admin'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));*/
		$model=$this->loadModel($id);
		$model->setScenario('update');
		$single_div_display = "display:none;";
		$div_display = "display:none;";
		$line_list_data = JoLine::model()->LineList("admin");
		$selected_line_data = array();
		$style='display:none; border-top: solid 1px #ccc; padding: 10px 0 0 0; margin: 10px 0 0 0;';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Admin']))
		{
			$model->attributes=$_POST['Admin'];
			if($model->user_role == "Sewing Output & Status Controller" || $model->user_role == "Finishing Output & Status Controller"){
				$div_display = "display:block;";
				$single_div_display = "display:none;";
				
				
				if(!empty($model->selected_line)){
					foreach($model->selected_line as $sl){
						$v = $line_list_data[$sl];
						unset($line_list_data[$sl]);
						$selected_line_data[$sl]  = $v;
					}
				}
			
			}else if($model->user_role == Admin::LEVEL_LINE_HEAD){
				$div_display = "display:none;";
				$single_div_display = "display:block;";
			}	
			
			if($model->validate()){
				if($model->save())
					$this->redirect(array('view','id'=>$model->user_id));
			}else{
				if(!empty($model->new_password) || !empty($model->confirm_new_password) || !empty($model->old_password))
				$style='display:block; border-top: solid 1px #ccc; padding: 10px 0 0 0; margin: 10px 0 0 0;';
			}
		}else{
			if($model->user_role == "Sewing Output & Status Controller" || $model->user_role == "Finishing Output & Status Controller"){
				$div_display = "display:block;";
				//select from admin line
				$result = $model->getselectedLine($model->user_id);
				$selected_line_data = $result["selected_line"];
				$line_list_data = $result["list_data"];
			
			}else if($model->user_role == Admin::LEVEL_LINE_HEAD){
				$single_div_display = "display:block;";
				
				$single_result_id = $model->getSelectedSingleLine($model->user_id);
				$model->single_line = $single_result_id;
			}	
			$style='display:none; border-top: solid 1px #ccc; padding: 10px 0 0 0; margin: 10px 0 0 0;';
			$model->selected_line = $model->getselectedLineIDS($model->user_id);
		}
		
		$this->render('update',array(
			'model'=>$model,
			'style' => $style,
			'single_div_display' => $single_div_display,
			'div_display' => $div_display,
			'line_list_data' => $line_list_data,
			'selected_line_data'=>$selected_line_data
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		Admin::model()->changeStatus($id);
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Admin');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Admin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Admin']))
			$model->attributes=$_GET['Admin'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Admin the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Admin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Admin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Displays the login page
	 */

	public function actionLogin()
	{
		$model=new LoginForm;
			
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$result = '';
			//$today = shell_exec('date +%Y-%m-%d ');
			$today = date('Y-m-d');
			// validate user input and redirect to the previous page if valid

			if($model->validate() && $model->login()){
				//$this->redirect(Yii::app()->user->returnUrl);
				if(Yii::app()->user->isGlobalViewer){
					$this->redirect(Yii::app()->createUrl('/jo/edit'));
				}else{
					$this->redirect(Yii::app()->createUrl('/jo'));
				}	
			}
				
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		unset(Yii::app()->session['access_role']);
		$this->redirect(Yii::app()->createUrl('/admin/login'));
	}
}
