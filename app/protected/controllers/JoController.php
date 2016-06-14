<?php

class JoController extends Controller
{
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
                    'index',
                    'done',
                    'edit',
                    'addNew',
                    'deleteTempJos',
                    'saveTempData',
                ),
                'users' => array(
                    '@'
                )
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'done',
                ),
                'expression'=>'$user->isProductionHead',
            ),
             array(
                'allow', // allow super admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'done',
                ),
                'expression'=>'$user->isSuperAdmin',
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            ),
            
            
            
        );
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
                'category',
                'color',
                'date_received',
                'days_needed',
                'days_allotted',
                'allowance',
                'target_end_date',
                'line',
                'status',
                'output',
                'balance',
                'comments',
                'washing_info',
                'delivery_receipt',
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
                'category',
                'color',
                'date_received',
                'days_needed',
                'days_allotted',
                'allowance',
                'target_end_date',
                'line',
                'status',
                'output',
                'balance',
                'comments',
                'washing_info',
                'audit_date',
                'total_delivered',
                'salesman_sample',
                'delivery_1',
                'delivery_2',
                'delivery_3',
                'delivery_4',
                'delivery_5',
                'second_quality',
                'unfinished',
                'lacking',
                'closed',
                
            ));
        }
        
                    					             
        $dataProvider2 = new CActiveDataProvider('JoFinishing', array(
            'criteria' => $criteria
        ));
        
        
        $startDate = '';
        $avgOutput = '';
        
		$options=Yii::app()->joModule->getOptions();
		$lines=Yii::app()->joModule->getLines();
        
        
        $this->render('index', array(
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
     /**
     * Lists all models.
     */
    public function actionEdit()
    {
		$admin_id     = Yii::app()->user->id;
		$session_id   = Yii::app()->getSession()->getSessionId();
        
        Yii::app()->joModule->deleteTemp($admin_id, $session_id,'TempSewing');
        Yii::app()->joModule->deleteTemp($admin_id, $session_id,'TempFinishing');
        
        $model = new JoSewing('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['JoSewing']))
            $model->attributes = $_GET['JoSewing'];
        if ($this->isExportRequest()) {
            $this->exportCSV($model->search(), array(
                'jo_id',
                'brand',
                'quantity',
                'color',
                'date_received',
                'days_needed',
                'days_allotted',
                'allowance',
                'target_end_date',
                'line',
                'status',
                'output',
                'balance',
                'comments',
                'washing_info',
                'audit_date',
                'total_delivered',
                'salesman_sample',
                'delivery_1',
                'delivery_2',
                'delivery_3',
                'delivery_4',
                'delivery_5',
                'second_quality',
                'unfinished',
                'lacking',
                'closed',
                
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
                'color',
                'date_received',
                'days_needed',
                'days_allotted',
                'allowance',
                'target_end_date',
                'line',
                'status',
                'output',
                'balance',
                'comments',
                'washing_info',
                'audit_date',
                'total_delivered',
                'salesman_sample',
                'delivery_1',
                'delivery_2',
                'delivery_3',
                'delivery_4',
                'delivery_5',
                'second_quality',
                'unfinished',
                'lacking',
                'closed',
            ));
        }
        
        
        $dataProvider2 = new CActiveDataProvider('JoFinishing', array(
            'criteria' => $criteria
        ));
        
        
        $startDate = '';
        $avgOutput = '';
        
		$options=Yii::app()->joModule->getOptions();
		$lines=Yii::app()->joModule->getLines();
        
        $this->render('edit', array(
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
    
        /**
     * Lists all models.
     */
    public function actionDone()
    {

        $model = new JoSewing('search');
        $model->unsetAttributes(); // clear any default values
        $model->status="Done";
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
            'condition' => 'status="Done"'
            
        ));
        $dataProvider = new CActiveDataProvider('JoSewing', array(
            'criteria' => $criteria
        ));
        
        
        $model2 = new JoFinishing('search');
        $model2->unsetAttributes(); // clear any default values
        $model2->status="Done";
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
        
        $this->render('done', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'model2' => $model2,
            'dataProvider2' => $dataProvider2,
            'startDate' => $startDate,
            'avgOutput' => $avgOutput,
        ));
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
    
    
    public function actionAddNew()
    {
        
        
        $model = new JoSewing('addNew');
        $data  = "200 OK";
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        
		$data="500 ERROR - NOT set";
        
        if (isset($_POST['JoSewing'])) {
				   
            
			$data="500 ERROR - Before model save";
			

            
			$date = new DateTime("now", new DateTimeZone('Asia/Manila'));
			//echo $date->format('Y-m-d H:i:s');
		
			$model->datetime_created = $date->format('Y-m-d H:i:s');
			$model->date_added       = $date->format('Y-m-d');
			$model->jo_updated       = $date->format('Y-m-d H:i:s');
		
			/*Assign custom attribute to ORIGNAL attribute
			-- Custom attribute to handle DatePicker conflict
			when 2 datepickers with the same attributes
			are initialized
			*/
			if (isset($_POST['JoSewing']['delivery_date_modal'])) {
				$model->delivery_date = $_POST['JoSewing']['delivery_date_modal'];
			}
		
		
			/*Assign custom attribute to ORIGNAL attribute
			-- Custom attribute to handle DatePicker conflict
			when 2 datepickers with the same attributes
			are initialized
			*/
			if (isset($_POST['JoSewing']['date_received_modal'])) {
				$date_received_modal = str_replace('/', '-',$_POST['JoSewing']['date_received_modal']);

				//$formatted_dRcv		=	date('Y-m-d', strtotime($date_received_modal));
				
				$formatted_dRcv		=	date('Y-m-d', strtotime($_POST['JoSewing']['date_received_modal']));
				$model->date_received = $formatted_dRcv;
			}
			
			if(isset($_POST['JoSewing']['comments'])) {
				$model->comments = $_POST['JoSewing']['comments'];
			}
			
			if(isset($_POST['JoSewing']['washing_info'])) {
				$model->washing_info = $_POST['JoSewing']['washing_info'];
			}
		
			$model->attributes = $_POST['JoSewing'];
			
			$data="500 ERROR - Before model validate";
			
            if ($model->validate()) {			
				$days_needed	=	0;
				$days_allotted 	= 	0;

				//IF Line is set 
				if(isset($_POST['JoSewing']['line']) && $_POST['JoSewing']['line']!==null  && $_POST['JoSewing']['line'] != ''){
			
					//AND if Line is not zero (0) - meaning has Line
					if($_POST['JoSewing']['line']>=0){
				
						//Assign Line 
					   $model->line		=	$_POST['JoSewing']['line'];
				   
						//Derive Days needed since Line is set:
					   $days_needed	=	Yii::app()->joModule->getDaysNeeded($_POST['JoSewing']['quantity'], $model->line);

					}
				 }
				 //ELSE IF Line is not set
				 else{
					//Assing zero (0) as Line
					$model->line	=	0;
				
					//And get MAX priority number of Line zero(0) in the database
					$max_priority	=	Yii::app()->joModule->getMaxPriority($model->line,'jo_finishing');
				
						//THEN, assign it as Priority number
						$model->priority	=	$max_priority;
			  			
				 }
				 
				 $model->quantity	=	$_POST['JoSewing']['quantity'];
				 				   
				//IF Priority is NOT set
				if($_POST['JoSewing']['priority']	== 0 || $_POST['JoSewing']['priority']===NULL || $_POST['JoSewing']['priority']==''){
			
					//Get MAX priority (+1)
					$max_priority	=	Yii::app()->joModule->getMaxPriority($model->line,'jo_finishing');
					//And assign it as Priority number
					$model->priority	=	$max_priority;
			
				}
				//ELSE
				else{
					 //And assign set priority as Priority number
					$model->priority	=	$_POST['JoSewing']['priority'];
				}
			
			
				//IF Out is NOT set
				if($_POST['JoSewing']['output']	== 0 || $_POST['JoSewing']['output']===NULL || $_POST['JoSewing']['output']==''){
						
					$model->output	=	0;
					$model->balance	=	$model->quantity;
					
				//ELSE
				}else{
					 
				
					 //And assign set values
					 $model->balance	= Yii::app()->joModule->getBalance($model->quantity, $_POST['JoSewing']['output']);
				}
					   
				$model->output	=	$_POST['JoSewing']['output'];
				
				 
			 
				if(isset($_POST['JoSewing']['days_allotted']) && $_POST['JoSewing']['days_allotted']!='' && $_POST['JoSewing']['days_allotted']!==null){
					  $days_allotted	=	$_POST['JoSewing']['days_allotted'];
				}else{
					  $days_allotted	=	Yii::app()->joModule->getDaysAllotted($days_needed);
				}
			 
				$allowance	=	Yii::app()->joModule->getAllowance($days_allotted, $days_needed);
			
				//Assign values
				$model->days_needed		=	$days_needed;
				$model->days_allotted	=	$days_allotted + 0;
				$model->allowance		=	$allowance;
				$model->status			=	"";
				
				$data="500 ERROR - Before model save";
          
          		$x=$model->priority;
          
          
            	if ($model->save()) {
					$new_jo_id	=	Yii::app()->db->getLastInsertId();
					$data = "200 OK - Saved ".$model->date_received.' '.$formatted_dRcv;
				
				
					//NO assigned LINE will be saved to DB as is, ELSE
					//IF Line is set
					if(isset($model->line)){
						//Check if Priority is also Set
						if(isset($model->priority) && $model->line >= 0){
				
				
							//Pre-condition -- Get Newly assigned JO ID after save *
							//Pre-condition -- Derived values (Days Needed, Days Allotted, Allowance) **
							$max_priority	=	Yii::app()->joModule->getMaxPriority($model->line,'jo_sewing');
                    
							if($model->priority > $max_priority){
								$model->priority	=	$max_priority;
							}
						
							//ADJUST affected rows
							$result	=	Yii::app()->joModule->updateSucceedingJos($model->line, $days_allotted, $new_jo_id, $model->priority,'JoSewing');	
							//print_r( $result);
						}
					}
                
                
                	$max_priority	=	Yii::app()->joModule->getMaxPriority($model->line,'jo_finishing');
                    
                    if($model->priority > $max_priority){
                    	$model->priority	=	$max_priority;
                    }
                    
            		$finishing             = new JoFinishing;
                    $finishing->attributes = $model->attributes;
                    //added by tine
					$finishing->audit_date      = date("Y-m-d");
					//end
                   // print_r($finishing->attributes);
                    //echo $finishing->audit_date ;
                    
                    
                     if ($finishing->save()) {
                     		$new_jo_id	=	Yii::app()->db->getLastInsertId();
                			$data = "200 OK - --Saved".$model->date_received;
                			
                     		//IF Line is set
							if(isset($model->line)){
								//Check if Priority is also Set
								if(isset($model->priority) && $model->line >= 0){
			   
			   
									//Pre-condition -- Get Newly assigned JO ID after save *
									//Pre-condition -- Derived values (Days Needed, Days Allotted, Allowance) **
					   
									//ADJUST affected rows
									Yii::app()->joModule->updateSucceedingJos($model->line, $days_allotted, $new_jo_id, $model->priority,'JoFinishing');	
				   
								}
							}
			   
                     }
                }
            } 
            
            else {
                
                header('Content-type: application/json');
                $this->layout = false;
                
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo json_encode($error);
                
                foreach (Yii::app()->log->routes as $route) {
                    if ($route instanceof CWebLogRoute) {
                        $route->enabled = false; // disable any weblogroutes
                    }
                } //END of foreach log routes
                
                Yii::app()->end();
                
                
            }
        }


        header('Content-type: application/json');
        $this->layout = false;
        echo json_encode(array(
            'result' => true,
            'data' => $data
        )); // Use CJSON::encode() instead of json_encode() if you are encoding a Yii model
        
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        } //END of foreach log routes
        Yii::app()->end(); // Properly end the app
    }
    
    public function actionDeleteTempJos()
    {
        
		$admin_id     = Yii::app()->user->id;
		$session_id   = Yii::app()->getSession()->getSessionId();
        
        Yii::app()->joModule->deleteTemp($admin_id, $session_id,'TempSewing');
        Yii::app()->joModule->deleteTemp($admin_id, $session_id,'TempFinishing');
        
        
        
    	header('Content-type: application/json');
        $this->layout = false;
        
        echo json_encode(array(
            'result' => true,
            'message' => "deleted"
        )); // Use CJSON::encode() instead of json_encode() if you are encoding a Yii model
        
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        } //END of foreach log routes
        Yii::app()->end(); // Properly end the app
    }
    
    public function actionSaveTempData(){
    
    	$msg = "default";
    	
    	$response_data = array();
    	
        
		$admin_id     = Yii::app()->user->id;
		$session_id   = Yii::app()->getSession()->getSessionId();
		
		
    	$response_data1 = JoSewing::model()->saveTempSewing($admin_id, $session_id);
    	$response_data = JoFinishing::model()->saveTempFinishing($admin_id, $session_id);
    
    	header('Content-type: application/json');
    	$this->layout = false;
    	
    	echo json_encode(array(
            'msg' => $msg,
            'data'=>$response_data1,
            'success' => true
        ));
       
       
       foreach (Yii::app()->log->routes as $route) {
			if ($route instanceof CWebLogRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		} //END of foreach log routes

		Yii::app()->end();
        
    
    }
    
    public function actionUpdateDays(){
    
    	$quantity = $_POST['quantity'];
    	$line = $_POST['line'];
    	
    	$days_needed = Yii::app()->joModule->getDaysNeeded($quantity, $line);
    	$days_allotted = Yii::app()->joModule->getDaysAllotted($days_needed);
    	
    	$data	=	array(
    		"days_needed" => $days_needed,
    		"days_allotted" => $days_allotted
    	);
    	
    	header('Content-type: application/json');
        $this->layout = false;
        
        
        echo json_encode(array(
            'result' => true,
            'data' => $data
        )); // Use CJSON::encode() instead of json_encode() if you are encoding a Yii model
        
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        } //END of foreach log routes
        Yii::app()->end(); 
    }

}