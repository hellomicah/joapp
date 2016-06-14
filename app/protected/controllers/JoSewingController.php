<?php

class JoSewingController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';
    
    public $int_fields = array('jo_id', 'priority', 'quantity', 'line', 'output', 'balance', 'sort_order');
    
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl' // perform access control for CRUD operations
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
            
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'addNew',
                    'create',
                    'update',
                    'index',
                    'revert',
                    'updateJos',
                    'edit'
                ),
                'users' => array(
                    'admin',
                    '@'
                )
            ),
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'view',
                    'sortable'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            ),
            
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'addNew',
                    'admin',
                    'delete',
                    'create',
                    'update',
                    'revert',
                    'updateJos',
                    'edit'
                ),
                'users' => array(
                    'admin'
                )
            )
            
            
        );
    }
    
    
    
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = JoSewing::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jo-sewing-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function behaviors()
    {
        return array(
            'exportableGrid' => array(
                'class' => 'application.components.ExportableGridBehavior',
                'filename' => 'jo_list.csv',
                'csvDelimiter' => ',' //i.e. Excel friendly csv delimiter
            )
        );
    }
    
    
    public function loadTempSewingModel($jo_id, $admin_id, $session_id)
    {
        $model = TempSewing::model()->findByAttributes(array(
            'jo_id' => $jo_id,
            'admin_id' => $admin_id,
            'session_id' => $session_id
        ));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionEdit()
    {
        
        $r = Yii::app()->getRequest();
        
        
        $model = $this->loadModel($_POST['pk']);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $msg         = 'default';
        $field_value = null;
        $data_params = array();
        
        //print_r($_POST);
        if (isset($_POST['name'])) {
           
            
            if(isset($_POST['balance'])){
                $_attr['JoSewing']['balance']	=	 $_POST['balance'];
                if($_POST['balance']==0){
                	     $_attr['JoSewing']['status']	=	"Done";
                	     //EDIT HERE TO ADJUST the rest of the Jo rows PRIORITY number
                	     
                	     //**************************************
                }
            }    
            
            if(isset($_POST['allowance'])){
            	if($_POST['allowance'] >=0){
                	$_attr['JoSewing']['allowance']	=	 $_POST['allowance'];
                
					$data_params['allowance']	= $_POST['allowance'];
				}
            }
            
            if(isset($_POST['name'])=='quantity' && isset($_POST['line'])){ 
            	if($_POST['value'] >=0){
            		$quantity = $_POST['value'];
					$line = $_POST['line'];
					
					if($line > 0){
						$days_needed = Yii::app()->joModule->getDaysNeeded($quantity, $line);
						$days_allotted = Yii::app()->joModule->getDaysAllotted($days_needed);
						$allowance = Yii::app()->joModule->getAllowance($days_allotted, $days_needed);
					}else{
						$days_needed = 0;
						$days_allotted = 0;
						$allowance = 0;
					}
					
						$_attr['JoSewing']['days_needed']	= (float)($days_needed);
						$_attr['JoSewing']['days_allotted']	= (float)($days_allotted);
						$_attr['JoSewing']['allowance']	= (float)($allowance);
						
					$data_params['days_needed']	= (float)($days_needed);
					$data_params['days_allotted']	= (float)($days_allotted);
					$data_params['allowance']	= (float)($line);
					
            	}
            }  
            
            if(isset($_POST['line'])){
            
					$data_params['line']	= 	$_POST['line'];
            }
            
            $_attr['JoSewing'][$_POST['name']] = $_POST['value'];
            if(isset($_POST['name'])=='quantity'){ 
				$_attr['JoSewing']['quanity']	= $_POST['value'];
			}
            $model->attributes                 = $_attr['JoSewing'];
            //$model->jo=$_POST['value'];
            $valid                             = $model->validate();
            if ($valid) {
                $field_value = $_POST['value'];
              
                
                
                try {
                    $temp             = new TempSewing;
                    $temp->attributes = $_attr['JoSewing'];
                    $temp->$_POST['name']        = $_POST['value'];
                    
                    $temp->jo_id        = $_POST['pk'];
                    $temp->admin_id     = Yii::app()->user->id;
                    $temp->session_id   = Yii::app()->getSession()->getSessionId();
                    $temp->date_updated = new CDbExpression('NOW()');
                    //print_r($temp->validate());
                      
                      		 
                    $new_record = false;
                    
                    try {
                        $temp->datetime_created = new CDbExpression('NOW()');
                        if ($temp->save()) {
                            $msg        = 'saved';
                            $new_record = true;
                            if ($_POST['name'] == 'priority') {
                                $temp                = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id);
                                $new_target_end_date = Yii::app()->joModule->getNewTargetEndDate($temp->jo_id, $_POST['value'], $temp->line, $temp->days_allotted, $temp->admin_id, $temp->session_id,$temp, 'Sewing');
                                
                                $data_params['new_target_end_date']=$new_target_end_date;
                                
                                if(isset($new_target_end_date['line'])){
                                	$data_params['line']=$new_target_end_date['line'];
                                }
                                
                                if(!$new_target_end_date){
                                	$data_params['line']='0';
                                }
                            } elseif ($_POST['name'] == 'days_allotted') {
                                $temp                = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id);
                                $new_target_end_date = Yii::app()->joModule->getNewTargetEndDate($temp->jo_id, $temp->priority, $temp->line, $_POST['value'], $temp->admin_id, $temp->session_id,$temp, 'Sewing');
                                
                                $data_params['new_target_end_date']=$new_target_end_date;
                                
                                if(isset($new_target_end_date['line'])){
                                	$data_params['line']=$new_target_end_date['line'];
                                }
                                
                                if(!$new_target_end_date){
                                	$data_params['line']='0';
                                }
                            }
                            
                            if(strpos($_POST['name'], 'date') !== false)   {         
                    			$field_value = date ('M/d/y',  strtotime($_POST['value']));
                    		}
                        }
                    }
                    catch (CDbException $e) {
                        
                        $temp               = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id);
                        //print_r($temp);
                        $temp->isNewRecord  = false;
                        $temp->attributes   = $_attr['JoSewing'];
                        $temp->$_POST['name']        = $_POST['value'];
                        $temp->jo_id        = $_POST['pk'];
                        $temp->admin_id     = Yii::app()->user->id;
                        $temp->session_id   = Yii::app()->getSession()->getSessionId();
                        $temp->date_updated = new CDbExpression('NOW()');
                        
                        if ($temp->save()) {
                            $msg = 'updated';
                            if ($_POST['name'] == 'priority') {
                                $new_target_end_date = Yii::app()->joModule->getNewTargetEndDate($temp->jo_id, $_POST['value'], $temp->line, $temp->days_allotted, $temp->admin_id, $temp->session_id,$temp, 'Sewing');
                                
                                $data_params['new_target_end_date']=$new_target_end_date;
                                
                                if(isset($new_target_end_date['line'])){
                                	$data_params['line']=$new_target_end_date['line'];
                                }
                                
                                if(!$new_target_end_date){
                                	$data_params['line']='0';
                                }
                            } elseif ($_POST['name'] == 'days_allotted') {
                                $new_target_end_date = Yii::app()->joModule->getNewTargetEndDate($temp->jo_id, $temp->priority, $temp->line, $_POST['value'], $temp->admin_id, $temp->session_id,$temp, 'Sewing');
                                
                                $data_params['new_target_end_date']=$new_target_end_date;
                            
                            	if(isset($new_target_end_date['line'])){
                                	$data_params['line']=$new_target_end_date['line'];
                                }
                            
                                if(!$new_target_end_date){
                                	$data_params['line']='0';
                                }
                            }
                            
                            if(strpos($_POST['name'], 'date') !== false)   {         
                    			$field_value = date ('M/d/y', strtotime($_POST['value']));
                    		}
                        }
                    }
                    
                }
                catch (CDbException $e) {
                    
                    $error = $e;
                    
                    $_error = $error;
                    header('Content-type: application/json');
                    $this->layout = false;
                    echo json_encode(array(
                        'success' => false,
                        'msg' => $_error
                    ));
                    
                    foreach (Yii::app()->log->routes as $route) {
                        if ($route instanceof CWebLogRoute) {
                            $route->enabled = false; // disable any weblogroutes
                        }
                    } //END of foreach log routes
                    
                    Yii::app()->end();
                }
                
                
                
            } else { //START of else for model valid
                

                $error = $model->getErrors();
                if (isset($error[$_POST['name']][0]))
                    $_error = $error[$_POST['name']][0];
                else
                    $_error = $error;
                header('Content-type: application/json');
                $this->layout = false;
                echo json_encode(array(
                    'success' => false,
                    'msg' => $_error
                ));
                
                foreach (Yii::app()->log->routes as $route) {
                    if ($route instanceof CWebLogRoute) {
                        $route->enabled = false; // disable any weblogroutes
                    }
                } //END of foreach log routes
                
                Yii::app()->end();
                
                //}//END of if $error
         
                
            } //END of else if model valid 		
            
        } //END of isset
        
        
        echo json_encode(array(
            'msg' => $msg,
            'success' => true,
            'field_value' => $field_value,
            'data_params' => $data_params
        ));
        Yii::app()->end();
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {

        $model = new JoSewing('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['JoSewing']))
            $model->attributes = $_GET['JoSewing'];
        if ($this->isExportRequest()) {
            $this->exportCSV($model->search(), array(
                'jo_id',
                'brand',
                'quantity',
                'color'
            ));
        }
        
        $stat         = "Done";
        $criteria     = new CDbCriteria(array(
            'order' => 'line, priority',
            //'with'   => array('userToProject'=>array('alias'=>'user')),
            'condition' => 'status!=' . $stat . ' AND priority >0'
            
        ));
        $dataProvider = new CActiveDataProvider('JoSewing', array(
            'criteria' => $criteria
        ));
        
        
       
       	 
        
        $model2 = new JoFinishing('search');
        $model2->unsetAttributes(); // clear any default values
        if (isset($_GET['JoFinishing']))
            $model2->attributes = $_GET['JoFinishing'];
        if ($this->isExportRequest()) {
            $this->exportCSV($model2->search(), array(
                'jo_id',
                'brand',
                'quantity',
                'color'
            ));
        }
        
        
        $dataProvider2 = new CActiveDataProvider('JoFinishing', array(
            'criteria' => $criteria
        ));
        
        
        $startDate = '';
        $avgOutput = '';
        
        
		$options=Yii::app()->joModule->getOptions();
		$lines=Yii::app()->joModule->getLines();
        
        $this->render('../jo/index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'model2' => $model2,
            'dataProvider2' => $dataProvider2,
            'startDate' => $startDate,
            'avgOutput' => $avgOutput,
            'options' => $options,
            'lines' => $lines
        ));
        
        
    }
    
    
    
    /*
     * Updates JO data from modal
     */
    public function actionUpdateBox($id)
    {
        
        
        $r = Yii::app()->getRequest();
        
        
        $model = $this->loadModel($_POST['pk']);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $msg = 'default';
        
        //print_r($_POST);
        if (isset($_POST['delivery_date'])) {
            
            $_attr['JoSewing']['delivery_date'] = $_POST['delivery_date'];
            $model->attributes                  = $_attr['JoSewing'];
            //$model->jo=$_POST['value'];
            $valid                              = $model->validate();
            if ($valid) {
                
                try {
                    $temp             = new TempSewing;
                    $temp->attributes = $_attr['JoSewing'];
                    
                    $temp->jo_id        = $_POST['pk'];
                    $temp->admin_id     = Yii::app()->user->id;
                    $temp->session_id   = Yii::app()->getSession()->getSessionId();
                    $temp->date_updated = new CDbExpression('NOW()');
                    //print_r($temp->validate());
                    
                    try {
                        $temp->datetime_created = new CDbExpression('NOW()');
                        if ($temp->save())
                            $msg = 'saved';
                    }
                    catch (CDbException $e) {
                        
                        $temp               = $this->loadTempSewingModel($temp->jo_id, $temp->admin_id, $temp->session_id);
                        //print_r($temp);
                        $temp->isNewRecord  = false;
                        $temp->attributes   = $_attr['JoSewing'];
                        $temp->jo_id        = $_POST['pk'];
                        $temp->admin_id     = Yii::app()->user->id;
                        $temp->session_id   = Yii::app()->getSession()->getSessionId();
                        $temp->date_updated = new CDbExpression('NOW()');
                        if ($temp->save())
                            $msg = 'updated';
                    }
                    
                }
                catch (CDbException $e) {
                    
                    $error = $e;
                    
                    $_error = $error;
                    header('Content-type: application/json');
                    $this->layout = false;
                    echo json_encode(array(
                        'success' => false,
                        'msg' => $_error
                    ));
                    
                    foreach (Yii::app()->log->routes as $route) {
                        if ($route instanceof CWebLogRoute) {
                            $route->enabled = false; // disable any weblogroutes
                        }
                    } //END of foreach log routes
                    
                    Yii::app()->end();
                }
                
                
                
            } else { //START of else for model valid
                
                //$error = CActiveForm::validate($model);
                //if($error!='[]'){
                ///echo json_encode($error);
                //print_r($model->getErrors());
                $error = $model->getErrors();
                if (isset($error[$_POST['name']][0]))
                    $_error = $error[$_POST['name']][0];
                else
                    $_error = $error;
                header('Content-type: application/json');
                $this->layout = false;
                echo json_encode(array(
                    'success' => false,
                    'msg' => $_error
                ));
                
                foreach (Yii::app()->log->routes as $route) {
                    if ($route instanceof CWebLogRoute) {
                        $route->enabled = false; // disable any weblogroutes
                    }
                } //END of foreach log routes
                
                Yii::app()->end();
                
                //}//END of if $error
                
                
            } //END of else if model valid 		
            
        } //END of isset
        

        echo json_encode(array(
            'msg' => $msg,
            'success' => true
        ));
        Yii::app()->end();
        
    }
  
  
      /*
     * Updates JO data from modal
     */
    public function actionRevert()
    {
        
        
        $r = Yii::app()->getRequest();
        
        
        $model = $this->loadModel($_POST['jo_id']);
        $model->scenario = 'revert';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $msg = 'default';
        //echo $model->quantity;
        //print_r($_POST);
        if (isset($_POST['output'])) {
            
            $_attr['JoSewing']['output'] = $_POST['output'];
            $_attr['JoSewing']['quantity'] = $_POST['quantity'];
            $_attr['JoSewing']['jo_id'] = $_POST['jo_id'];
            $_attr['JoSewing']['status'] = "For Loading";
            $model->attributes                  = $_attr['JoSewing'];
            //$model->jo=$_POST['value'];
            
            
            $valid                              = $model->validate();
            if ($valid) {
                
                if($_POST['output']>=$_POST['quantity']){
                
                	
                	$_error = "Set Output value less than Quantity value (".$_POST['quantity'].") to continue";
                	
                	header('Content-type: application/json');
                	$this->layout = false;
                	echo json_encode(array(
                    	'success' => "false",
                	    'msg' => $_error
                	));
                
               		foreach (Yii::app()->log->routes as $route) {
                    	if ($route instanceof CWebLogRoute) {
                        	$route->enabled = false; // disable any weblogroutes
                    	}
                	} //END of foreach log routes
                
                	Yii::app()->end();
                
                }else{
                try {
                   $model->jo_updated = new CDbExpression('NOW()');
                   //$line, $days_allotted, $jo_id
                   //print_r(JoSewing::model()->updateSucceedingJos($model->line,  $model->days_allotted, $_POST['jo_id']));
                   if ($model->save()){
                   		$result = Yii::app()->joModule->updateSucceedingJos($model->line,  $model->days_allotted, $_POST['jo_id'],'JoSewing');
                        $msg = 'saved';
                        if($result){
                        	$msg = 'saved- jo\' adjusted';
                        }
                	}
                  
                    
                }
                catch (CDbException $e) {
                    
                    $error = $e;
                    
                    $_error = $error;
                    header('Content-type: application/json');
                    $this->layout = false;
                    echo json_encode(array(
                        'success' => false,
                        'msg' => $_error
                    ));
                    
                    foreach (Yii::app()->log->routes as $route) {
                        if ($route instanceof CWebLogRoute) {
                            $route->enabled = false; // disable any weblogroutes
                        }
                    } //END of foreach log routes
                    
                    Yii::app()->end();
                }
                
                }
                
                
            } else { //START of else for model valid
                
                //$error = CActiveForm::validate($model);
                //if($error!='[]'){
                ///echo json_encode($error);
                //print_r($model->getErrors());
                $error = $model->getErrors();
                if (isset($error[$_POST['name']][0]))
                    $_error = $error[$_POST['name']][0];
                else
                    $_error = $error;
                header('Content-type: application/json');
                $this->layout = false;
                echo json_encode(array(
                    'success' => false,
                    'msg' => $_error
                ));
                
                foreach (Yii::app()->log->routes as $route) {
                    if ($route instanceof CWebLogRoute) {
                        $route->enabled = false; // disable any weblogroutes
                    }
                } //END of foreach log routes
                
                Yii::app()->end();
                
                //}//END of if $error
                
                
            } //END of else if model valid 		
            
        } //END of isset
        

        echo json_encode(array(
            'msg' => $msg,
            'success' => true
        ));
        Yii::app()->end();
        
    }  
    
    public function actionUpdateJos(){
    
    	//$data = $_POST[''];
    	$msg = "default";
    
    	$data = $_POST['updated'];
    	
    	$response_data = array();
    	
    	if(sizeof($data)>1){
    		$line_jos=$data[0]['data'];
    		
    		if(isset($data[0]['skip_edit'])){
    			$skip_data=$data[0]['skip_edit'];
    		}else{
    			$skip_data=NULL;
    		}
    		
    		$response_data1 = Yii::app()->joModule->updateReorderedJos($data[0]['line'], $line_jos,$temp=TRUE,$skip_data,'TempSewing');
    		$response_data[]= $response_data1;
    		
    		
    		//$line_jos=$data[1]['data'];
    		
    		if(isset($data[1]['data'])){
    			$line_jos=$data[1]['data'];
				if(isset($data[1]['skip_edit'])){
					$skip_data=$data[1]['skip_edit'];
				}else{
					$skip_data=NULL;
				}
			
				$response_data2 = Yii::app()->joModule->updateReorderedJos($data[1]['line'], $line_jos,$temp=TRUE,$skip_data,'TempSewing');
				$response_data[]= $response_data2;
    		}
    		
    		// $response_data = array(
//     			$response_data1,
//     			$response_data2
//     		);
    		
    		$msg="2 Lines";
    		
    	}
    	
    	elseif(sizeof($data)==1 ){
    		$line_jos=$data[0]['data'];
    		
    		if(isset($data[0]['skip_edit'])){
    			$skip_data=$data[0]['skip_edit'];
    		}else{
    			$skip_data=NULL;
    		}
    		
    		$response_data1 = Yii::app()->joModule->updateReorderedJos($data[0]['line'], $line_jos,$temp=TRUE,$skip_data,'TempSewing');
    	
    		$response_data = array(
    			$response_data1
    		);
    	
    		$msg="1 Line";
    	}else{
    		$msg=$data;
    		
    		
    	}
    	
    	//updateReorderedJos($line, $line_jos,$temp=TRUE)
    	header('Content-type: application/json');
    	$this->layout = false;
    	
    	echo json_encode(array(
            'msg' => $msg,
            'data'=>$response_data,
            'success' => true
        ));
       
       
       foreach (Yii::app()->log->routes as $route) {
			if ($route instanceof CWebLogRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		} //END of foreach log routes

		Yii::app()->end();
        
    
    }
    
    
}
