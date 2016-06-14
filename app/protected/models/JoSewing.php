<?php

/**
 * This is the model class for table "jo_sewing".
 *
 * The followings are the available columns in table 'jo_sewing':
 * @property string $jo_id
 * @property integer $priority
 * @property string $jo
 * @property string $brand
 * @property integer $quantity
 * @property string $category
 * @property string $color
 * @property string $date_received
 * @property string $days_needed
 * @property string $days_allotted
 * @property string $allowance
 * @property string $target_end_date
 * @property string $delivery_date
 * @property integer $line
 * @property string $status
 * @property integer $output
 * @property integer $balance
 * @property string $comments
 * @property string $washing_info
 * @property string $delivery_receipt
 * @property string $date_added
 * @property string $datetime_created
 * @property string $jo_updated
 * @property integer $admin_id
 */
class JoSewing extends CActiveRecord
{
	public $delivery_date_modal;
	public $date_received_modal;
	
	public $revert;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jo_sewing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('priority, jo, brand, quantity, color, category, date_received_modal', 'required','on'=>'addNew'),
			
			array('priority','checkPriority','on'=>'addNew'),
			array('quantity','quantitySize','on'=>'addNew'),
			array('days_allotted','checkValidDA','on'=>'addNew'),
			array('jo_id, status, output', 'required','on'=>'revert'),
			
			array('priority, quantity, line, output, balance, admin_id', 'numerical', 'integerOnly'=>true),
			array('jo, brand, color, days_needed', 'length', 'max'=>60,'on'=>'insert,update'), //edited for search
			array('category', 'length', 'max'=>10,'on'=>'insert,update'),//edited for search
			array('days_allotted, allowance', 'length', 'max'=>6,'on'=>'insert,update'),//edited for search
			array('status', 'length', 'max'=>11,'on'=>'insert,update'),//edited for search
			array('washing_info', 'length', 'max'=>8,'on'=>'insert,update'),//edited for search
			array('delivery_receipt', 'length', 'max'=>7,'on'=>'insert,update'),//edited for search
			array('jo,date_added, datetime_created, jo_updated', 'safe'),
			array('jo','unique','allowEmpty'=>false),
			
			//rray('sortOrder', 'numerical', 'integerOnly'=>true),  
			
			//custom
			array(
            	'jo',
            	'match', 'pattern' => '/^[a-zA-Z\d]+$/',
            	'message' => 'Invalid characters in JO.',
        	),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jo_id, priority, jo, brand, quantity, category, color, date_received, days_needed, days_allotted, allowance, target_end_date, delivery_date, line, status, output, balance, comments, washing_info, delivery_receipt, date_added, datetime_created, jo_updated, admin_id,sort_order', 'safe', 'on'=>'search'),
		);
	}
	

	protected function afterFind ()
    {
            // convert to display format
        // if(!$this->isNewRecord){
//         echo "\ngot here---";
// 			if(strtotime($this->date_received) > strtotime('1970-01-01') ){
// 			$date_received = strtotime ($this->date_received);
// 			$this->date_received = date ('M/d/y', $date_received);
// 			}else{
// 				$this->date_received = 'none';
// 			}
// 			if(strtotime($this->target_end_date) > strtotime('1970-01-01') ){
// 			$this->target_end_date = strtotime ($this->target_end_date);
// 			$this->target_end_date = date ('M/d/y', $this->target_end_date);
// 			}else{
// 				$this->target_end_date = 'none';
// 			}
// 			if(strtotime($this->delivery_date) > strtotime('1970-01-01') ){
// 			$this->delivery_date = strtotime ($this->delivery_date);
// 			$this->delivery_date = date ('M/d/y', $this->delivery_date);
// 			}else{
// 				$this->delivery_date = 'none';
// 			}
// 			if(strtotime($this->date_received) > strtotime('1970-01-01') ){
// 			$this->date_received = strtotime ($this->date_received);
// 			$this->date_received = date ('M/d/y', $this->date_received);
// 			}else{
// 				$this->date_received = 'none';
// 			}
// 			if(strtotime($this->date_received_modal) > strtotime('1970-01-01') ){
// 			$this->date_received_modal = strtotime ($this->date_received_modal);
// 			$this->date_received_modal = date ('M/d/y', $this->date_received_modal);
// 			}else{
// 				$this->date_received_modal = 'none';
// 			}
// 			if(strtotime($this->delivery_date_modal) > strtotime('1970-01-01') ){
// 			$this->delivery_date_modal = strtotime ($this->delivery_date_modal);
// 			$this->delivery_date_modal = date ('M/d/y', $this->delivery_date_modal);
// 			}else{
// 				$this->delivery_date_modal = 'none';
// 			}
// 		
// 			parent::afterFind ();
//         }
    }

	
	public function quantitySize($attribute,$params)
	{
		if( $_POST['JoSewing']['quantity'] >0){
		}else{
			$this->addError($attribute, 'Invalid value for output.');
		}
	}
	
	public function checkValidDA($attribute,$params)
	{
		if( $_POST['JoSewing']['days_allotted'] >0){
		
			if(isset($_POST['JoSewing']['line'])){
				if($_POST['JoSewing']['line'] > 0){
					$days_needed = Yii::app()->joModule->getDaysNeeded($_POST['JoSewing']['quantity'], $_POST['JoSewing']['line']);
					
					if($_POST['JoSewing']['days_allotted'] < $days_needed){
						$this->addError($attribute, 'Input must be equal or greater than <b>'.$days_needed.'</b> (pre-computed Days Needed)');
					}
				}
			}
		}
	}
	
	public function checkPriority($attribute,$params)
	{
		
		if(isset($_POST['JoSewing']['line']) && $_POST['JoSewing']['line']!==null  && $_POST['JoSewing']['line'] != ''){
		
			if($_POST['JoSewing']['line'] >= 0){
			  $max_priority	=	Yii::app()->joModule->getMaxPriority($_POST['JoSewing']['line'],'jo_sewing');
				if( $this->$attribute > $max_priority){
					$this->addError($attribute, $max_priority.' Invalid Priority input. Assign to lowest Priority? <a id="assign_lowest" onclick="assignLowestPriority('.$max_priority.')" data-lowest="'.$max_priority.'" style="text-decoration:underline !important; cursor:pointer !important;">Click here.</a>');
				}
			}
		}else{
		
			if(isset($_POST['JoSewing']['priority']) && $_POST['JoSewing']['line'] == ''){
				$max_priority	=	Yii::app()->joModule->getMaxPriority(0,'jo_sewing');
				if( $this->$attribute > $max_priority){
					$this->addError($attribute, 'Invalid Priority input. Assign to lowest Priority? <a id="assign_lowest" onclick="assignLowestPriority('.$max_priority.')" data-lowest="'.$max_priority.'" style="text-decoration:underline !important; cursor:pointer !important;">Click here.</a>');
				}
			
			}
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'joline'=>array(self::BELONGS_TO, 'JoLine', 'line_id'),
			'joline'    => array(self::BELONGS_TO, 'JoLine',    'line'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jo_id' => 'Jo',
			'priority' => 'Priority',
			'jo' => 'Jo',
			'brand' => 'Brand',
			'quantity' => 'Qty',
			'category' => 'Category',
			'color' => 'Color',
			'date_received' => 'Date Received',
			'days_needed' => 'Days Needed',
			'days_allotted' => 'Days Allotted',
			'allowance' => 'Allowance',
			'target_end_date' => 'Target End Date',
			'delivery_date' => 'Delivery Date',
			'line' => 'Line',
			'status' => 'Status',
			'output' => 'Output',
			'balance' => 'Bal',
			'comments' => 'Comments',
			'washing_info' => 'Washing Info',
			'delivery_receipt' => 'Delivery Receipt',
			'date_added' => 'Date Added',
			'datetime_created' => 'Datetime Created',
			'jo_updated' => 'Jo Updated',
			'admin_id' => 'Admin',
			'sort_order'=>'Sort Order',
			
			'date_received_modal' => 'Date Received',
			'delivery_date_modal' => 'Delivery Date',
			
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('jo_id',$this->jo_id,true);
		//$criteria->compare('priority',$this->priority);
		//$criteria->compare('jo',$this->jo,true);
		//$criteria->compare('brand',$this->brand,true);
		//$criteria->compare('quantity',$this->quantity);
		//$criteria->compare('category',$this->category,true);
		//$criteria->compare('color',$this->color,true);
		$criteria->compare('date_received',$this->date_received,true);
		//$criteria->compare('days_needed',$this->days_needed,true);
		//$criteria->compare('days_allotted',$this->days_allotted,true);
		//$criteria->compare('allowance',$this->allowance,true);
		$criteria->compare('target_end_date',$this->target_end_date,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
	//criteria->compare('joline.name',$this->line,true);
		//$criteria->compare('status',$this->status,true);
		//$criteria->compare('output',$this->output);
		//$criteria->compare('balance',$this->balance);
		$criteria->compare('comments',$this->comments,true);
		//$criteria->compare('washing_info',$this->washing_info,true);
		$criteria->compare('delivery_receipt',$this->delivery_receipt,true);
		
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('datetime_created',$this->datetime_created,true);
		$criteria->compare('jo_updated',$this->jo_updated,true);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->with = array('joline');
		
		if(empty($this->jo_id)){
			$criteria->compare('jo_id',$this->jo_id,true);
		}else{
			$jo_id_arr = explode(",", $this->jo_id);
			if(empty($jo_id_arr)){
				$criteria->compare('jo_id',$this->jo_id,true);
			}else{
				$criteria->addInCondition('jo_id', $jo_id_arr, 'AND');
			}
		}
		
		if(empty($this->priority)){
			$criteria->compare('priority',$this->priority,true);
		}else{
			$priority_arr = explode(",", $this->priority);
			if(empty($priority_arr)){
				$criteria->compare('priority',$this->priority,true);
			}else{
				$criteria->addInCondition('priority', $priority_arr, 'AND');
			}
		}
		
		if(empty($this->jo)){
			$criteria->compare('jo',$this->jo,true);
		}else{
			$jo_arr = explode(",", $this->jo);
			if(empty($jo_arr)){
				$criteria->compare('jo',$this->jo,true);
			}else{
				$criteria->addInCondition('jo', $jo_arr, 'AND');
			}
		}
		
		if(empty($this->brand)){
			$criteria->compare('brand',$this->brand,true);
		}else{
			$brand_arr = explode(",", $this->brand);
			if(empty($brand_arr)){
				$criteria->compare('brand',$this->brand,true);
			}else{
				$criteria->addInCondition('brand', $brand_arr, 'AND');
			}
		}
		
		if(empty($this->quantity)){
			$criteria->compare('quantity',$this->quantity,true);
		}else{
			$quantity_arr = explode(",", $this->quantity);
			if(empty($quantity_arr)){
				$criteria->compare('quantity',$this->quantity,true);
			}else{
				$criteria->addInCondition('quantity', $quantity_arr, 'AND');
			}
		}
		
		if(empty($this->category)){
			$criteria->compare('category',$this->category,true);
		}else{
			$category_arr = explode(",", $this->category);
			if(empty($category_arr)){
				$criteria->compare('category',$this->category,true);
			}else{
				$criteria->addInCondition('category', $category_arr, 'AND');
			}
		}
		
		
		if(empty($this->color)){
			$criteria->compare('color',$this->color,true);
		}else{
			$color_arr = explode(",", $this->color);
			if(empty($color_arr)){
				$criteria->compare('color',$this->color,true);
			}else{
				$criteria->addInCondition('color', $color_arr,'AND');
			}
		}
		
	
		if(empty($this->days_needed)){
			$criteria->compare('days_needed',$this->days_needed,true);
		}else{
			$days_needed_arr = explode(",", $this->days_needed);
			if(empty($days_needed_arr)){
				$criteria->compare('days_needed',$this->days_needed,true);
			}else{
				$criteria->addInCondition('days_needed', $days_needed_arr, 'AND');
			}
		}
		
		if(empty($this->days_allotted)){
			$criteria->compare('days_allotted',$this->days_allotted,true);
		}else{
			$days_allotted_arr = explode(",", $this->days_allotted);
			if(empty($days_allotted_arr)){
				$criteria->compare('days_allotted',$this->days_allotted,true);
			}else{
				$criteria->addInCondition('days_allotted', $days_allotted_arr, 'AND');
			}
		}
		
		if(empty($this->allowance)){
			$criteria->compare('allowance',$this->allowance,true);
		}else{
			$allowance_arr = explode(",", $this->allowance);
			if(empty($allowance_arr)){
				$criteria->compare('allowance',$this->allowance,true);
			}else{
				$criteria->addInCondition('allowance', $allowance_arr, 'AND');
			}
		}
		
		
		if( Yii::app()->user->isLineHead || Yii::app()->user->isSewingController  || Yii::app()->user->isFinishingController){
		
       	 	if(empty($this->line)){
				$line_arr = Yii::app()->joModule->getAssignedLines( Yii::app()->user->id );
        		$criteria->addInCondition('joline.line_id', $line_arr, 'AND');
			}else{
				$line_arr = explode(",", $this->line);
				if(empty($line_arr)){
					$criteria->compare('joline.name',$this->line,true);
				}else{
					$criteria->addInCondition('joline.name', $line_arr, 'AND');
				}
			}
		}else{
			if(empty($this->line)){
				$criteria->compare('joline.name',$this->line,true);
			}else{
				$line_arr = explode(",", $this->line);
				if(empty($line_arr)){
					$criteria->compare('joline.name',$this->line,true);
				}else{
					$criteria->addInCondition('joline.name', $line_arr, 'AND');
				}
			}
		
		}
		
		
		
		if(empty($this->status)){
			$criteria->compare('status',$this->status,true);
		}else{
			$status_arr = explode(",", $this->status);
			if(empty($status_arr)){
				$criteria->compare('status',$this->status,true);
			}else{
				$criteria->addInCondition('status', $status_arr, 'AND');
			}
		}
		
		if(empty($this->output)){
			$criteria->compare('output',$this->output,true);
		}else{
			$output_arr = explode(",", $this->output);
			if(empty($output_arr)){
				$criteria->compare('output',$this->output,true);
			}else{
				$criteria->addInCondition('output', $output_arr, 'AND');
			}
		}
		
		if(empty($this->balance)){
			$criteria->compare('balance',$this->balance,true);
		}else{
			$balance_arr = explode(",", $this->balance);
			if(empty($balance_arr)){
				$criteria->compare('balance',$this->balance,true);
			}else{
				$criteria->addInCondition('balance', $balance_arr, 'AND');
			}
		}
		
		if(empty($this->washing_info)){
			$criteria->compare('washing_info',$this->washing_info,true);
		}else{
			$washing_info_arr = explode(",", $this->washing_info);
			if(empty($washing_info_arr)){
				$criteria->compare('washing_info',$this->washing_info,true);
			}else{
				$criteria->addInCondition('washing_info', $washing_info_arr, 'AND');
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            	'pageSize' => 50,
        	),
        	'sort'=>array(
                'defaultOrder'=>'line, priority',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JoSewing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	/*
		Previously the function to check how to get Start Date
		..this function is not used anymore as of UAT 1 (Phase 1)
			afte setting Start Date in Line is now the base row
	*/
	public function isBaseRow($jo_id, $line, $priority, $temp=FALSE){
		$status="Done";
	
			$start_in_done = FALSE;
			$jo_is_base_row = FALSE;
			
			$criteria = new CDbCriteria;
			$criteria->select 	=	"jo_id";	
			$criteria->condition = 'status="'.$status.'" AND line= '.$line;
			$criteria->order	=	"jo_updated";
			$done_jos	=	JoSewing::model()->findAll($criteria);
			
			if($done_jos!==NULL){
				$start_in_done = TRUE;
				$row = 1;
				foreach($done_jos as $jo){
					if(($jo->jo_id == $jo_id) && $row==1){
						return TRUE;
					}
					
					$row++;
				}
			}
			
			if($temp){
				$criteria = new CDbCriteria;
				$criteria->select 	=	"jo_id";	
				$criteria->condition = 'status="'.$status.'" AND line= '.$line;
				$criteria->order	=	"date_updated";
				$done_jos	=	TempSewing::model()->findAll($criteria);
			
				if($done_jos!==NULL){
				
					$start_in_done = TRUE;
					$row = 1;
					
					foreach($done_jos as $jo){
						if(($jo->jo_id == $jo_id) && $row==1){
							return TRUE;
						}
					
						$row++;
					}
				}
			}
			
			
			if($temp===TRUE && !$start_in_done){
				if($priority==1){
					return TRUE;
				}
			}
			
			//MEANING there are no DONE jo's
			if(!$temp 	&&	!$start_in_done ){
			
				$criteria = new CDbCriteria;
				$criteria->select 	=	"jo_id";	
				$criteria->condition = 'status!="'.$status.'" AND line= '.$line.'" AND jo_id= '.$jo_id;
				$criteria->order	=	"priority";
				$jo	=	JoSewing::model()->findAll($criteria);
				
				if($jo->priority == 1){
					return TRUE;
				}
			}
	
			
			return FALSE;
			
	}
	
	public function updateReorderedJos($line, $line_jos,$temp=TRUE,$skip_data){
	
		$null_date="0000-00-00";
		
			$jo_line=JoLine::model()->findByPk($line);
			
			$baseRowNotSetYet	=	FALSE;
			$skipBaseRowCheck	=	FALSE;
			
			$base_target_end_date	=	$null_date;
			
			$updated_jos = array();
				$ctr = 0;
				
				//FOR LOOP
				foreach($line_jos as $jo){
				
					if($ctr>0){
						$skipBaseRowCheck = TRUE;
					}
				
					$jo_id	= 	$jo['jo_id'];
					$days_allotted	= 	$jo['days_allotted'];
					$priority	= 	$jo['priority'];
					$quantity	= 	$jo['quantity'];
					
					
				   if($jo_line!==NULL){	
						$working_days	=	$jo_line->working_days;
						$start_date 	= 	$jo_line->start_date;
						$line_name		=	$jo_line->name;
						
						
						$days_needed	=	Yii::app()->joModule->getDaysNeeded($quantity, $line, $jo_line->standard_average_output);
						
						
						/*--START
						 *	this will check if value being edited is QTY
						 *	ONLY then DAYS_ALLOTTED value is being overriden, else leave DAYS ALLOTTED as is
						 *	 and base the computation of TED from unchange DA
			 			*/
						if($skip_data!==NULL){
							if(($skip_data['name'] == 'quantity' || $skip_data['name'] == 'priority') && $skip_data['jo_id'] == $jo_id ){
								$days_allotted	=	Yii::app()->joModule->getDaysAllotted($days_needed);
							}
						}
						/*
						 *---END	
						 */
						
				   		$allowance	=	Yii::app()->joModule->getAllowance($days_allotted, $days_needed);
						
						if($priority==1){
							$base_target_end_date	= 	$start_date ;
						}
					   	$new_target_end_date	=	Yii::app()->joModule->generateTargetEndDate($line, $jo_id, $working_days, $start_date, $days_allotted, $temp, $priority, $base_target_end_date, $skipBaseRowCheck);
				   	
				   	
				   		$base_target_end_date	=	$new_target_end_date;
				   		$ctr++;
				   }else{
				   		$new_target_end_date	=	$null_date;
				   		$line_name				=	'';
				   		$days_needed			=	0;
				   		$allowance				=	0;
				   		$days_allotted			=	0;	
				   }
				   
				   
				   
				   
				   
				   	$updated_jos[] = array( 
				   		"jo_id"				=>	$jo_id,
				   		"line"				=> 	$line,
				   		"priority"			=>	$priority,
				   		"target_end_date"	=>	$new_target_end_date,
				   		"line_name"			=> 	$line_name,
				   		"quantity"			=>	$quantity,
				   		"days_needed"		=>	(float)($days_needed),
				   		"allowance"			=>	(float)($allowance),
				   		"days_allotted"		=>	(float)($days_allotted),
				   	);
                    
                	
				
				}//END OF foreach
			
			//print_r($updated_jos);
			
				if($temp && $updated_jos!==NULL){
				
					//START foreach updated rows here
					foreach($updated_jos as $updated){
					
						 $transaction = Yii::app()->db->beginTransaction();
						 
						 try {
							
							 $temp = new TempSewing;
						
							 $temp->target_end_date = $updated['target_end_date'];
							 $temp->jo_id        = $updated['jo_id'];
							 $temp->priority     = $updated['priority'];
							 $temp->line     = $updated['line'];
							 
							 
							 	 $temp->quantity      = intval($updated['quantity']);
							 	 $temp->days_needed   = strval($updated['days_needed']);
							 	 $temp->allowance     = strval($updated['allowance']);
							 	 $temp->days_allotted = strval($updated['days_allotted']);
							 	 
						
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
					
								 $temp               = Yii::app()->joModule->loadTempModel($temp->jo_id, $temp->admin_id, $temp->session_id,'TempSewing');
								 //print_r($temp);
								 $temp->isNewRecord  = false;
							
								 $temp->target_end_date = $updated['target_end_date'];
								 $temp->jo_id        = $updated['jo_id'];
							 	 $temp->priority     = $updated['priority'];
							 	 $temp->line     = $updated['line'];
							 	 
							 	 $temp->quantity      = intval($updated['quantity']);
							 	 $temp->days_needed   = strval($updated['days_needed']);
							 	 $temp->allowance     = strval($updated['allowance']);
							 	 $temp->days_allotted = strval($updated['days_allotted']);
							
								 $temp->admin_id     = Yii::app()->user->id;
								 $temp->session_id   = Yii::app()->getSession()->getSessionId();
								 $temp->date_updated = new CDbExpression('NOW()');
								 try {
								 	if ($temp->save())
									 	$msg = 'updated';
								 }
								 catch (CDbException $e) {
								 	//echo 'UPDATE -- '.$e;
								 }
									 
								//echo 'INSERT -- '.$e;
							 }
						
							 $transaction->commit();
							 // actions to do on success (redirect, alert, etc.)
						 } catch (Exception $e) {
							 $transaction->rollBack();
							 // other actions to perform on fail (redirect, alert, etc.)
							 //echo 'TRANSACTION -- '.$e;
							 return false;
						 } 
					}
						
						
					return $updated_jos;
				}//END of IF TEMP
                else{
                		//NO CODE YET FOR NON TEMP
                	return FALSE;
                }
	}
	
	
    
    public function saveTempSewing($admin_id, $session_id)
    {
        
        $criteria = new CDbCriteria;
				$criteria->select 	=	"priority, jo, jo_id,brand, quantity, category, color, date_received,
data_received, days_needed, days_allotted, allowance, target_end_date,
delivery_date, line, status, output, balance, comments, washing_info,
delivery_receipt";	
				$criteria->condition = 'admin_id='.$admin_id.' AND session_id= "'.$session_id.'"';
				$criteria->order	=	"line, priority";
				$temp_jos=	TempSewing::model()->findAll($criteria);
        
//print_r($temp_jos);
       	$temp_update = array();
       	
       	if($temp_jos !== NULL){
       		
			
			$transaction = Yii::app()->db->beginTransaction();
				 
			try {       		
       
				foreach($temp_jos as $temp){
				
						
				
						$model = Yii::app()->joModule->loadModel($temp->jo_id,'JoSewing');
				 		//$model->isNewRecord  = false;
                        //$model->attributes   = $temp;
                        
                        if($temp->jo_id !==NULL && $temp->jo_id!=''){
							$model->jo_id=$temp->jo_id;     
				  		}
                        if($temp->priority !==NULL && $temp->priority!=''){
							$model->priority=$temp->priority;     
				  		}
						if($temp->jo !==NULL && $temp->jo!=''){
							$model->jo=$temp->jo;         
						}
						if($temp->brand !==NULL && $temp->brand!=''){
							$model->brand=$temp->brand;         
						}
						if($temp->quantity !==NULL && $temp->quantity!=''){
							$model->quantity=$temp->quantity;         
						}
						if($temp->category !==NULL && $temp->category!=''){
							$model->category=$temp->category;         
						}
						if($temp->color !==NULL && $temp->color!=''){
							$model->color=$temp->color;         
						}
						if($temp->date_received !==NULL && $temp->date_received!=''){
							$model->date_received=$temp->date_received;
						}
						if($temp->days_needed !==NULL && $temp->days_needed!=''){
							$model->days_needed=$temp->days_needed;      
						}
						if($temp->days_allotted !==NULL && $temp->days_allotted!=''){
							$model->days_allotted=$temp->days_allotted;    
						}
						if($temp->allowance !==NULL && $temp->allowance!=''){
							$model->allowance=$temp->allowance;        
						}
						if($temp->target_end_date !==NULL && $temp->target_end_date!=''){
							$model->target_end_date=$temp->target_end_date;  
						}
						if($temp->delivery_date !==NULL && $temp->delivery_date!=''){
							$model->delivery_date=$temp->delivery_date;    
						}
						if($temp->line !==NULL && $temp->line!=''){
							$model->line=$temp->line;         
						}
						if($temp->status !==NULL && $temp->status!=''){
							$model->status=$temp->status;         
						}
						if($temp->output !==NULL && $temp->output!=''){
							$model->output=$temp->output;         
						}
						if($temp->balance !==NULL && $temp->balance!=''){
							$model->balance=$temp->balance;         
						}
						if($temp->comments !==NULL && $temp->comments!=''){
							$model->comments=$temp->comments;         
						}
						if($temp->washing_info !==NULL && $temp->washing_info!=''){
							$model->washing_info=$temp->washing_info;     
						}
						if($temp->delivery_receipt !==NULL && $temp->delivery_receipt!=''){
							$model->delivery_receipt=$temp->delivery_receipt; 
						}
						
						
						$temp_update[]=$temp;
				
					try {    
						
                        
                        if($model->save()){
						
							//echo "saved";
						}
						
					}
					catch (CDbException $e) {
						//echo 'DB -- '.$e;
					
					}
				}
				
				
				 $transaction->commit();
			   		// actions to do on success (redirect, alert, etc.)
				
				Yii::app()->joModule->deleteTemp($admin_id, $session_id,'TempSewing');
				
		   } catch (Exception $e) {
			   $transaction->rollBack();
			   // other actions to perform on fail (redirect, alert, etc.)
			   //echo 'TRANSACTION -- '.$e;
			   return false;
		   } 
		  
			
		 return $temp_update;
	 }
       
		
		return false;
    }
    
    

    
}
