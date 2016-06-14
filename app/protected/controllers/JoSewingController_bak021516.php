<?php

class JoSewingController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
//public $layout='//layouts/column2';

public $int_fields = array('jo_id','priority','quantity','line','output','balance','sort_order');

/**
* @return array action filters
*/
public function filters()
{
return array(
'accessControl', // perform access control for CRUD operations
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

array('allow', // allow authenticated user to perform 'create' and 'update' actions
'actions'=>array('addNew','create','update','index','edit'),
'users'=>array('admin','@'),
),
array('allow',  // allow all users to perform 'index' and 'view' actions
'actions'=>array('view','sortable'),
'users'=>array('*'),
),
array('deny',  // deny all users
'users'=>array('*'),
),

array('allow', // allow admin user to perform 'admin' and 'delete' actions
'actions'=>array('addNew','admin','delete','create','update','edit'),
'users'=>array('admin'),
),


);
}
/*
public function actions() {
    return array(
        'sortable' => array(
        'class' => 'booster.actions.TbSortableAction',
        'modelName' => 'JoSewing'
    ));
}
*/
public function actionSortable(){

	print_r($_POST);
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
$model=new JoSewing;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['JoSewing']))
{
$model->attributes=$_POST['JoSewing'];
if($model->save())
$this->redirect(array('view','id'=>$model->jo_id));
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

if(isset($_POST['JoSewing']))
{
$model->attributes=$_POST['JoSewing'];
if($model->save())
$this->redirect(array('view','id'=>$model->jo_id));
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
if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset($_GET['ajax']))
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
}
else
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}


/**
* Manages all models.
*/
public function actionAdmin()
{
$model=new JoSewing('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['JoSewing']))
$model->attributes=$_GET['JoSewing'];


$dataProvider=new CActiveDataProvider('JoSewing');

$this->render('admin',array(
'model'=>$model,
'dataProvider'=>$dataProvider,
));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=JoSewing::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='jo-sewing-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}

public function behaviors() {
    return array(
        'exportableGrid' => array(
            'class' => 'application.components.ExportableGridBehavior',
            'filename' => 'jo_list.csv',
            'csvDelimiter' => ',', //i.e. Excel friendly csv delimiter
            ));
}


public function loadTempSewingModel($jo_id,$admin_id,$session_id)
{
$model=TempSewing::model()->findByAttributes(array('jo_id'=>$jo_id,'admin_id'=>$admin_id,'session_id'=>$session_id));
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

public function actionEdit()
{

    $r = Yii::app()->getRequest();
    
	
    	$model=$this->loadModel($_POST['pk']);
	// Uncomment the following line if AJAX validation is needed
	$this->performAjaxValidation($model);
	$msg	=	'default';
	$field_value	=	null;
	$data_params	=	array();

	//print_r($_POST);
	if(isset($_POST['name']))
	{
		if($_POST['name']== 'delivery_date' || $_POST['name']== 'date_received'){
			$date=date_create($_POST['value']);
			$_POST['value'] = date_format($date,"Y-m-d");
		}
		
		 $_attr['JoSewing'][$_POST['name']]=$_POST['value'];
         $model->attributes=$_attr['JoSewing'];
         //$model->jo=$_POST['value'];
         $valid=$model->validate();            
         if($valid){
			$field_value=$_POST['value'];
			try{
			$temp=new TempSewing;
			$temp->attributes=$_attr['JoSewing'];
			
			$temp->jo_id=$_POST['pk'];
			$temp->admin_id=Yii::app()->user->id;
			$temp->session_id=Yii::app()->getSession()->getSessionId();
			$temp->date_updated=new CDbExpression ('NOW()');
			//print_r($temp->validate());
			
			$new_record = false;
			
			try{
				$temp->datetime_created=new CDbExpression ('NOW()');
            	if($temp->save()){
                	$msg='saved';
                	$new_record = true;
                	if($_POST['name']=='priority'){
                		$temp = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id); 
                		$new_target_end_date = $model->getNewTargetEndDate($temp->jo_id, $_POST['value'], $temp->line, $temp->days_allotted, $temp->admin_id, $temp->session_id);
                	
                		$data_params = array('new_target_end_date' => $new_target_end_date);
                	}elseif($_POST['name']=='days_allotted'){
                		$temp = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id); 
                		$new_target_end_date = $model->getNewTargetEndDate($temp->jo_id, $temp->priority, $temp->line, $_POST['value'], $temp->admin_id, $temp->session_id);
                	
                		$data_params = array('new_target_end_date' => $new_target_end_date);
                	}
                }
			}
			catch(CDbException $e){

				$temp = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id); 
				//print_r($temp);
				$temp->isNewRecord = false;
					$temp->attributes=$_attr['JoSewing'];
					$temp->jo_id=$_POST['pk'];
					$temp->admin_id=Yii::app()->user->id;
					$temp->session_id=Yii::app()->getSession()->getSessionId();
					$temp->date_updated=new CDbExpression ('NOW()');
            	if($temp->save()){
            		$msg='updated';
            		if($_POST['name']=='priority'){
                		$new_target_end_date = $model->getNewTargetEndDate($temp->jo_id, $_POST['value'], $temp->line, $temp->days_allotted, $temp->admin_id, $temp->session_id);
                	
                		$data_params = array('new_target_end_date' => $new_target_end_date);
                	}elseif($_POST['name']=='days_allotted'){
                		$new_target_end_date = $model->getNewTargetEndDate($temp->jo_id, $temp->priority, $temp->line, $_POST['value'], $temp->admin_id, $temp->session_id);
                	
                		$data_params = array('new_target_end_date' => $new_target_end_date);
                	}
            	}
        	}
        	
        	}catch(CDbException $e){
        	
        		$error =$e;
        		
        		$_error=$error;
                header('Content-type: application/json');
				$this->layout=false;
                echo json_encode(array('success'=>false,'msg' => $_error));
                                    
				foreach (Yii::app()->log->routes as $route) {
        			if($route instanceof CWebLogRoute) {
            			$route->enabled = false; // disable any weblogroutes
        			}
    			}//END of foreach log routes
                                
                Yii::app()->end();
        	}

		
			
		}else{ //START of else for model valid
			
			//$error = CActiveForm::validate($model);
            //if($error!='[]'){
                ///echo json_encode($error);
                //print_r($model->getErrors());
                $error=$model->getErrors();
                if(isset($error[$_POST['name']][0]))
                	$_error=$error[$_POST['name']][0];
                else
                	$_error=$error;
                header('Content-type: application/json');
				$this->layout=false;
                echo json_encode(array('success'=>false,'msg' => $_error));
                                    
				foreach (Yii::app()->log->routes as $route) {
        			if($route instanceof CWebLogRoute) {
            			$route->enabled = false; // disable any weblogroutes
        			}
    			}//END of foreach log routes
                                
                Yii::app()->end();
                
            //}//END of if $error
            
			//return json_encode($model->getErrors());
			
		}//END of else if model valid 		
		
	}//END of isset
    
    
			/*echo CJSON::encode(array(
                        'status'=>'success'
                ));
                Yii::app()->end();
                */
	echo json_encode(array('msg'=>$msg,'success' => true,'field_value'=>$field_value,'data_params'=>$data_params));
    Yii::app()->end();
}


/**
* Lists all models.
*/
public function actionIndex()
{
//$cs = Yii::app()->clientScript;
//$cs->scriptMap['jquery.js'] = false;
//$cs->scriptMap['jquery.min.js'] = false;
/*$dataProvider=new CActiveDataProvider('JoSewing');
$this->render('index',array(
'dataProvider'=>$dataProvider,
));
*/
$model=new JoSewing('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['JoSewing']))
$model->attributes=$_GET['JoSewing'];
if ($this->isExportRequest()) {
	$this->exportCSV($model->search(), array('jo_id', 'brand', 'quantity', 'color'));
}

$stat="Done";
$criteria=new CDbCriteria(array(                    
                                'order'=>'line, priority',
                                //'with'   => array('userToProject'=>array('alias'=>'user')),
                                'condition'=>'status!='.$stat.' AND priority >0',

                        ));
$dataProvider=new CActiveDataProvider('JoSewing', array(
            'criteria'=>$criteria,
    ));


$startDate='Dec/12/2015';
$avgOutput='1000';


$this->render('index',array(
'model'=>$model,
'dataProvider'=>$dataProvider,
'startDate'=>$startDate,
'avgOutput'=>$avgOutput,
));
}
/*
$post=new Post;
$post->title='sample post';
$post->content='content for the sample post';
$post->create_time=time();
$post->save();*/
public function actionGetWashingInfo()
{
    $model = new JoSewing();
    $data = $model->getBrands();
    echo json_encode($data);
}


public function actionUpdateBox($id)
{

	
    $r = Yii::app()->getRequest();
    
	
    	$model=$this->loadModel($_POST['pk']);
	// Uncomment the following line if AJAX validation is needed
	$this->performAjaxValidation($model);
	$msg='default';

	//print_r($_POST);
	if(isset($_POST['delivery_date']))
	{

		 $_attr['JoSewing']['delivery_date']=$_POST['delivery_date'];
         $model->attributes=$_attr['JoSewing'];
         //$model->jo=$_POST['value'];
         $valid=$model->validate();            
         if($valid){
			
			try{
			$temp=new TempSewing;
			$temp->attributes=$_attr['JoSewing'];
			
			$temp->jo_id=$_POST['pk'];
			$temp->admin_id=Yii::app()->user->id;
			$temp->session_id=Yii::app()->getSession()->getSessionId();
			$temp->date_updated=new CDbExpression ('NOW()');
			//print_r($temp->validate());
			
			try{
				$temp->datetime_created=new CDbExpression ('NOW()');
            	if($temp->save())
                	$msg='saved';
			}
			catch(CDbException $e){

				$temp = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id); 
				//print_r($temp);
				$temp->isNewRecord = false;
					$temp->attributes=$_attr['JoSewing'];
					$temp->jo_id=$_POST['pk'];
					$temp->admin_id=Yii::app()->user->id;
					$temp->session_id=Yii::app()->getSession()->getSessionId();
					$temp->date_updated=new CDbExpression ('NOW()');
            	if($temp->save())
            	$msg='updated';
        	}
        	
        	}catch(CDbException $e){
        	
        		$error =$e;
        		
        		$_error=$error;
                header('Content-type: application/json');
				$this->layout=false;
                echo json_encode(array('success'=>false,'msg' => $_error));
                                    
				foreach (Yii::app()->log->routes as $route) {
        			if($route instanceof CWebLogRoute) {
            			$route->enabled = false; // disable any weblogroutes
        			}
    			}//END of foreach log routes
                                
                Yii::app()->end();
        	}

		
			
		}else{ //START of else for model valid
			
			//$error = CActiveForm::validate($model);
            //if($error!='[]'){
                ///echo json_encode($error);
                //print_r($model->getErrors());
                $error=$model->getErrors();
                if(isset($error[$_POST['name']][0]))
                	$_error=$error[$_POST['name']][0];
                else
                	$_error=$error;
                header('Content-type: application/json');
				$this->layout=false;
                echo json_encode(array('success'=>false,'msg' => $_error));
                                    
				foreach (Yii::app()->log->routes as $route) {
        			if($route instanceof CWebLogRoute) {
            			$route->enabled = false; // disable any weblogroutes
        			}
    			}//END of foreach log routes
                                
                Yii::app()->end();
                
            //}//END of if $error
            
			//return json_encode($model->getErrors());
			
		}//END of else if model valid 		
		
	}//END of isset
    
    
			/*echo CJSON::encode(array(
                        'status'=>'success'
                ));
                Yii::app()->end();
                */
	echo json_encode(array('msg'=>$msg,'success' => true));
    Yii::app()->end();

}

	public function actionAddNew(){


		$model=new JoSewing('addNew');
		$data="200 OK";
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['JoSewing']))
		{
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			//echo $date->format('Y-m-d H:i:s');
			
			$model->datetime_created=	$date->format('Y-m-d H:i:s');
			$model->date_added	=	$date->format('Y-m-d');
			$model->jo_updated	=	$date->format('Y-m-d H:i:s');
			
			/*Assign custom attribute to ORIGNAL attribute
				-- Custom attribute to handle DatePicker conflict
					when 2 datepickers with the same attributes
					are initialized
			*/
			if(isset($_POST['JoSewing']['delivery_date_modal'])){
				$model->delivery_date = $_POST['JoSewing']['delivery_date_modal'];
			}
			
			
			/*Assign custom attribute to ORIGNAL attribute
				-- Custom attribute to handle DatePicker conflict
					when 2 datepickers with the same attributes
					are initialized
			*/
			if(isset($_POST['JoSewing']['date_received_modal'])){
				$model->date_received = $_POST['JoSewing']['date_received_modal'];
			}
			
			$model->attributes=$_POST['JoSewing'];
			
			
			
			if($model->save()){
				$data="200 OK - Saved";
				//$this->redirect(array('view','id'=>$model->jo_id));
			}
			else{

                header('Content-type: application/json');
				$this->layout=false;
                
                $error = CActiveForm::validate($model);
                if($error!='[]')
                    echo json_encode( $error );
                    
                    foreach (Yii::app()->log->routes as $route) {
        				if($route instanceof CWebLogRoute) {
            				$route->enabled = false; // disable any weblogroutes
        				}
    				}//END of foreach log routes
                                
                Yii::app()->end();


			}
		}
		// Validate ok! Saving your data from form okay!
		// Send a response back!
		header('Content-type: application/json');
		$this->layout=false;
		echo json_encode(array('result'=>true, 'data'=>$data)); // Use CJSON::encode() instead of json_encode() if you are encoding a Yii model
		
		foreach (Yii::app()->log->routes as $route) {
        	if($route instanceof CWebLogRoute) {
            	$route->enabled = false; // disable any weblogroutes
        	}
    	}//END of foreach log routes
		Yii::app()->end(); // Properly end the app
	}

}
