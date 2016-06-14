<?php

class CalendarController extends Controller
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
			/*array('allow',  // deny all users
				'users'=>array('*'),
			),*/
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
		$model=new Calendar;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Calendar']))
		{
			$model->attributes=$_POST['Calendar'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->calendar_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Calendar']))
		{
			$model->attributes=$_POST['Calendar'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->calendar_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Calendar');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		$month = date("n");
		$year = date("Y");
		$calendar = Calendar::model()->drawCalendar($month,$year);
		$this->render('index',array(
			'calendar'=>$calendar,
			'month'=>$month,
			'year'=>$year
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Calendar('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Calendar']))
			$model->attributes=$_GET['Calendar'];

		$this->render('admin',array(
			'model'=>$model,
			
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Calendar the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Calendar::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Calendar $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='calendar-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAlterCalendar()
	{
		Yii::app()->clientscript->scriptMap['jquery.js'] = true;
		
		$month = $_GET['month'];
		$year =  $_GET['year'];
		$line =  $_GET['line'];
		$calendar = Calendar::model()->drawCalendar($month,$year,$line);
		//echo $calendar;
		$this->renderPartial('_calendar', array('calendar'=>$calendar),false,true);
	}
	
	public function actionUpdateStatus(){
		$line_status =  $_POST['line_status'];
		$month = $_POST['month'];
		$year =  $_POST['year'];
		$line =  $_POST['line'];
		$date =  $_POST['date'];
		
		if($line == "all"){
			Calendar::model()->updateAllLine($line,$line_status,$month,$date,$year);
		}else{
			Calendar::model()->updateStatus($line,$line_status,$month,$date,$year);
		}
		
	}
}
