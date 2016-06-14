<?php

class FormDropdownController extends Controller
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
			/*array('allow',  // allow to all users
				'actions'=>array('view','index','admin'),
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
		$model=new FormDropdown;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FormDropdown']))
		{
			$model->attributes=$_POST['FormDropdown'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->dropdown_id));
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

		if(isset($_POST['FormDropdown']))
		{
			$model->attributes=$_POST['FormDropdown'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->dropdown_id));
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
		$dataProvider=new CActiveDataProvider('FormDropdown');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FormDropdown('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FormDropdown']))
			$model->attributes=$_GET['FormDropdown'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FormDropdown the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FormDropdown::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FormDropdown $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='form-dropdown-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAdd($id)
	{
		$model = $this->loadModel($id);
		$arr_value = array();
		$error = "";
		if(isset($_POST['FormDropdown']))
		{
			$model->attributes=$_POST['FormDropdown'];
			if(isset($_POST['FormDropdown']['value'])){
				$arr_value = json_encode($_POST['FormDropdown']['value']);
				$model->values = $arr_value;
				if($model->save())
					$this->redirect(array('index'));
					echo "reditrecr";
			}else{
				$model->values = $arr_value;
			}
			
		}
		
		$this->render('add',array(
			'model'=>$model,
			'error'=>$error
		));
	}
	
	public function actionCheckValue(){
		$value = $_POST['value'];
		$name = $_POST['name'];
		switch($name){
			case "Category":
				$name_val = "category";
			break;
			case "Status":
				$name_val = "status";
			break;
			case "Washing Info":
				$name_val = "washing_info";
			break;
			case "Brand":
				$name_val = "brand";
			break;
			case "Delivery Receipt":
				$name_val = "delivery_receipt";
			break;
			case "Closed":
				$name_val = "closed";
			break;
		}
		//check if value exist
		try{
			$record=JoSewing::model()->find(array(
      			'select'=>'*',
      			'condition'=> $name_val.'=:value',
      			'params'=>array(':value'=>$value))
    		);
    		echo count($record);
		}catch(Exception $e){
			echo 2;
		}
		
    	
	}
}
