<?php

class JoModule extends CApplicationComponent {
 
 		
	public function getOptions(){
		
		$select = Yii::app()->db->createCommand()
    		->select('dropdown_id, name, values')
    		->from('form_dropdown')
    		//->where('dropdown_id=:id', array(':id'=>$id))
    		->queryAll();
    		
    		$drop_downs = array();
    		
    		foreach($select as $data){
    			$vals = array();
    			foreach(json_decode($data['values']) as $values){
    				if($values=='Done'){
    					continue;
    				}
    				$vals[$values]=$values;
    			}
    			$drop_downs[str_replace(' ', '_', $data['name'])]=$vals;
    		}
    
    	//print_r(json_decode($brands['values']));
		return $drop_downs;
		
	}
	public function getBrands(){
		$id=5;
		$brands = Yii::app()->db->createCommand()
    		->select('dropdown_id, values')
    		->from('form_dropdown')
    		->where('dropdown_id=:id', array(':id'=>$id))
    		->queryRow();
    
    	//print_r(json_decode($brands['values']));
		return json_decode($brands['values']);
		
	}
	
	public function getLines(){
	
		$line = Yii::app()->db->createCommand()
    		->select('line_id, name')
    		->from('jo_line')
    		->queryAll();
    
    	$drop_downs = array();
    	$drop_downs[0]='For Loading';	
    		
    		foreach($line as $data){
    			
    			$drop_downs[$data['line_id']]=$data['name'];
    		}
    
    	//print_r(json_decode($brands['values']));
		return $drop_downs;
		
	}

 
    public function getAssignedLines($admin_id){
    	//select count of rows from calendar
    	$line_id_arr = array();
		$line_info_arr = Yii::app()->db->createCommand()
			->select('line_id')
			->from('admin_line')
			->where('admin_id=:admin_id',array(':admin_id'=>$admin_id))
			->queryAll();
		
		if(count($line_info_arr) > 0){
			foreach($line_info_arr as $line_data){
				$line_id_arr[] = $line_data["line_id"];
			}
		}	
		return $line_id_arr;
    }
    
    public function getMaxPriority($line,$table){
		$status="Done";
		if(isset($line)){
			$data = Yii::app()->db->createCommand('SELECT (max(priority) + 1) as max FROM '.$table.' WHERE line='.$line.' AND status!="'.$status.'";');            
           	$priority =  $data->queryRow();  
           	
           	//print_r($priority['max']);
            //echo $priority['max'];  
            if($priority['max'] >=1)     {   
            	return $priority['max'] ;
            
            }else{
            	return 1;
            }
            
        }
        
        return 0;
	}
	
		
	public function getBalance($quantity, $output){
		
		if(isset($quantity) && isset($output)){
			if($quantity >0 && $output>0){
				if($quantity>$output){
					$balance	=	$quantity - $output;
					if (preg_match('/\.\d{3,}/', $balance)) {
    					return number_format((float)$balance, 2, '.', '');
					} else {
    					return $balance;
					}
					
				}
			}
		}
	
		return 0;
	}
 
 		
	public function getDaysNeeded($quantity, $line, $avg_output=NULL){
		
		if(isset($line) && isset($quantity)){
			if($line>0){
				
				if($avg_output===NULL){
					$jo_line	=	JoLine::model()->findByPk($line);
					$avg_output	=	$jo_line->standard_average_output;
				}
				
				$days_needed=$quantity/$avg_output;
				
				if (preg_match('/\.\d{3,}/', $days_needed)) {
    				return number_format((float)$days_needed, 2, '.', '');
				} else {
    				return $days_needed;
				}
			}
		}
	
		return 0;
	}
	
	public function getDaysAllotted($days_needed){
		
		if(isset($days_needed)){
		
			if($days_needed>0){
			
				return	(ceil($days_needed) + 0);
				
			}
		}
		return 0;
	}
	
	public function getAllowance($days_allotted, $days_needed){
		
		if(isset($days_allotted) && isset($days_needed)){
			if($days_allotted >0 && $days_needed>0){
				if($days_allotted>$days_needed){
					$allowance	=	$days_allotted - $days_needed;
					if (preg_match('/\.\d{3,}/', $allowance)) {
    					return number_format((float)$allowance, 2, '.', '');
					} else {
    					return $allowance;
					}
					
				}
			}
		}
	
		return 0;
	}
 
 
 		
	public function loadTempModel($jo_id, $admin_id, $session_id,$model)
    {
        
        if($model=='TempSewing'){
			$model = TempSewing::model()->findByAttributes(array(
				'jo_id' => $jo_id,
				'admin_id' => $admin_id,
				'session_id' => $session_id
			));
        }elseif($model=='TempFinishing'){
			$model = TempFinishing::model()->findByAttributes(array(
				'jo_id' => $jo_id,
				'admin_id' => $admin_id,
				'session_id' => $session_id
			));

        }
        
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function loadModel($id,$model)
    {
    	if($model=='JoSewing'){
        	$model = JoSewing::model()->findByPk($id);
        }elseif($model=='JoFinishing'){
        	$model = JoFinishing::model()->findByPk($id);
        
        }
        
        return $model;
    }
    
    public function getPriorTargetEndDate($line_jos, $base_priority){
	
			foreach($line_jos as $item){
    			if($item->priority==($base_priority-1)){
      				return $item->target_end_date;
      				//break;
    			}
			}
			
			return false;
	}
	
	//Target End Date - COMPUTATION
	
	public function getTargetEndDate($start_date, $days_allotted, $non_working){
		//FORMULA
		
		$jo_days =  $days_allotted + $non_working;
			
		//New Target End Date
		$jo_target_end_datetime = strtotime("+".$jo_days." days", strtotime($start_date));
		$jo_target_end_date = date("Y-m-d", $jo_target_end_datetime);
		
		return $jo_target_end_date;
	}
	
	
	public function getNewTargetEndDate($jo_id, $priority, $line, $days_allotted, $admin_id, $session_id,$temp, $model){
	
		$target_end_date=false;
		//Get JO line
			if(isset($line) && $line!==null){
				$line	=	$temp->line;
			}
			else{
				if($model=='Sewing'){
					$main	=	JoSewing::model()->findByPk($jo_id);
				}else{
					$main	=	JoFinishing::model()->findByPk($jo_id);
				}
				
				if($main===NULL){
					return false;
				}
				$line	= 	$main->line;
			}
			
		
		//Get Jo Days Allotted	
			if(isset($days_allotted) && $days_allotted!==null){
				$days_allotted=	$temp->line;
			}
			else{
				if(!isset($main)){
					if($model=='Sewing'){
						$main	=	JoSewing::model()->findByPk($jo_id);
					}else{
						$main	=	JoFinishing::model()->findByPk($jo_id);
					}
				
				}
				$days_allotted	= $main->days_allotted;
			}
			
		$jo_line=JoLine::model()->findByPk($line);
		if($jo_line!==NULL){
			$start_date 	= 	$jo_line->start_date;
			$working_days	=	$jo_line->working_days;
			
			if($priority>1){
				
				if($model=='Sewing'){
			
					$temp=TempSewing::model()->findByAttributes(array('line'=> $line, 'priority'=>($priority-1),'admin_id'=>$admin_id,'session_id'=>$session_id));
				}else{
				
					$temp=TempFinishing::model()->findByAttributes(array('line'=> $line, 'priority'=>($priority-1),'admin_id'=>$admin_id,'session_id'=>$session_id));
				}
	
				//Get start date from Line
				if(isset($temp->target_end_date)){
					$start_date=$temp->target_end_date;
				}else{
					if($model=='Sewing'){
						$main=JoSewing::model()->findByAttributes(array('line'=> $line,'priority'=>($priority-1) 	)	);
					}else{
						$main=JoFinishing::model()->findByAttributes(array('line'=> $line,'priority'=>($priority-1) 	)	);
					}
					$start_date=$main->target_end_date;
				}
			}
			
			//getNonWorkingDays($line_id,$start_date,$days_allotted,$working_days)
			$non_working = Calendar::model()->getNonWorkingDays($line,$start_date,$days_allotted,$working_days);
		
			$days =  $days_allotted + $non_working;
		
			//New Target End Date
			$target_end_datetime = strtotime("+".$days." days", strtotime($start_date));
			$target_end_date = date("Y-m-d", $target_end_datetime);
			//return array($target_end_date, $start_date , $days_allotted , $non_working);
			
			return array('target_end_date'=>$target_end_date,'line'=>$line);
		}else{
			return false;
		}

		return array('target_end_date'=>$target_end_date);
	}
	

	
	/*
	 *	This called when Adding New JO
	 *
	 */
	public function updateSucceedingJos($line, $days_allotted, $jo_id, $base_priority=1,$model){
		$new_jo_set	=	$this->adjustLinePriority($line, $days_allotted, $jo_id,$base_priority,$model);
		
		if($new_jo_set!==NULL){
			$result	=	$this->updateNewJos($new_jo_set,$model);
		
			return	$result;
		}
		
		return true;
	}
	
	
    public function updateNewJos($new_jo_set, $model){
		
		$transaction = Yii::app()->db->beginTransaction();
		try {
    		foreach ($new_jo_set as $jo) {
    			if($model=='JoSewing'){
					$model = JoSewing::model()->findByPk($jo['jo_id']);
				}elseif($model=='JoFinishing'){
					$model = JoFinishing::model()->findByPk($jo['jo_id']);
		
				}
    			
        		$model->priority = $jo['priority'];
        		$model->target_end_date = $jo['target_end_date'];
        		$model->save();
    		}
    		$transaction->commit();
    		// actions to do on success (redirect, alert, etc.)
		} catch (Exception $e) {
    		$transaction->rollBack();
    		// other actions to perform on fail (redirect, alert, etc.)
    		return false;
		} 
		//print_r($new_jo_set);
		return true;
	}
    	
	//Derive Target End Date based on
	public function generateTargetEndDate($line, $jo_id, $working_days, $start_date, $days_allotted, $temp=FALSE, $priority=NULL, $base_target_end_date=NULL, $skipBaseRowCheck=FALSE){
		
		$null_date="0000-00-00";
		
		if($line!==NULL || $line>0){
			
		
			
			if($working_days!==NULL && $working_days!=''){	
				
				$non_working = Calendar::model()->getNonWorkingDays($line,$start_date,$days_allotted,$working_days);
				
				/*
				*	START
				*	This checking is removed after setting Start Date in Line is set to base date
				*		after UAT 1
				*/
				//IF BASE row, get Start Date in DB
				
				//THIS IF will optimize, since this will skip code of constantly checking BD is base row
				/*if(!$skipBaseRowCheck){
					if($this->isBaseRow($jo_id, $line, $priority, $temp)){ 
						return $this->getTargetEndDate($start_date, $days_allotted, $non_working);
					}
				}*/
				//ELSE NOT base row, use param for base target end date
				
				/*
				*
				*	END
				*/
				
				//This IF-ELSE replaced the old way of checking base row as mentioned above this
				try {
					if($priority !== NULL){
						if($priority==1 || $priority=='1'){
							return $this->getTargetEndDate($start_date, $days_allotted, $non_working);
						}else{
						
							return 	$this->getTargetEndDate($base_target_end_date, $days_allotted, $non_working);
						}
					}else{
				
						return 	$this->getTargetEndDate($base_target_end_date, $days_allotted, $non_working);
			
					}
				} catch (Exception $e) {
					$transaction->rollBack();
					 // other actions to perform on fail (redirect, alert, etc.)
					//echo 'TRANSACTION -- '.$e;
					return $null_date;
				} 
					
			}else{
				return $null_date;
			}
			
			
		}
		
		return $null_date;
	}

    
 
 	/*
	 *	This called as a part of Adding New JO process
	 *		this functions adjusts other rows with Priority no. lower that the row being updated
	 */
	public function adjustLinePriority($line, $days_allotted, $jo_id, $base_priority=1,$model){
		
		$new_target_end_date="0000-00-00";
		$jo_line=JoLine::model()->findByPk($line);
		
		if($line!==NULL){
		
			/*
			 * Get ALL JO's in the same Line that is not set to Done Status
			*/
			$status="Done";
			$criteria = new CDbCriteria;
			$criteria->select 	=	"jo_id, priority, days_allotted, target_end_date, line";	
			$criteria->condition = 'status!="'.$status.'" AND line= '.$line.' AND priority>='.($base_priority-1).' AND jo_id !='.$jo_id; //?? Should be >
			$criteria->order	=	"line, priority";
			
			if($model=='JoSewing'){
				$line_jos	=	JoSewing::model()->findAll($criteria);
			
			}else{
				$line_jos	=	JoFinishing::model()->findAll($criteria);
			
			}
		//print_r($line_jos);
			/* Start of ---------
			 * Derive *Start Date*
			 * 
			*/
			//echo $line_jos[0]->jo_id." -- ".$line_jos[0]->target_end_date;
			//print_r($line_jos);
			//Check if newly added JO is assigned to Priority 1
			if($base_priority>1){
			
				//NO - newly added JO is not assigned to Priority 1
					//but not necessarily means assigned to any Line, can be to none
					
				//Get Target End Date of row prior to this row on the same Line
					//to set as basisfor Start Date for TED computation later below
				//echo "<br/>here TED of Prior JO-".$line_jos[0]->target_end_date;
				
				$jo_TED = str_replace('/', '-', $line_jos[0]->target_end_date);

				$start_date		=	date('Y-m-d', strtotime($jo_TED)); //$this->getPriorTargetEndDate($line_jos, $base_priority);
				//echo "<br/>here- formatted $start_date";
			}
			
			else{
				//YES - newly added JO is assigned to Priority 1
				
				//Now, check if it is assigned to any Line
				if($jo_line!==NULL){
				
					//YES - newly added JO is assigned to a Line, not zero(0)
							//then set Start Date from assigned Line as Standard Start Date basis
					$start_date 	= 	$jo_line->start_date;
				
					
				}else{
				
					/* NO - newly added JO is not assigned to any Line, hence zero(0)
					 *		,since not assigned to any Line and no standard basis for Start date
					 */	
					$start_date		=	NULL;
				}
			}
			
			/*
			 * END of ---- Derive *Start Date* 
			*/
			
			
			
			/* Start -----
			 * Derive Target End Date of newly added JO 
			 *	
			 */
			 		 
			 //Checks if newly added JO is assigned to any LINE
			if($start_date !== NULL && $line >= 1){	
			
				//YES - get TED based on assigned Line data
			
				/* 
				 *   For Target End Date (TED) computation :
				 */
				 
					//Get Working Days based on assigned Line
					$working_days	=	$jo_line->working_days;
		
					//Get Total Non-working days based from the Calendar of assigned Line
					$non_working = Calendar::model()->getNonWorkingDays($line,$start_date,$days_allotted,$working_days);
					
					//Get total days to be added to Start Date	
					$days =  $days_allotted + $non_working;
		
					
				$new_target_end_date = date('Y-m-d', strtotime($start_date. "+ ".$days." days"));
				//echo "Computed TED: ".$new_target_end_date;
			}
			else{
			
				/* NO - newly added JO is not assigned to any Line
				 *			hence, no basis for TED computation
				 *			TED - assign to default date
				 */	
				$new_target_end_date = '0000-00-00';
				$non_working	=	0;
			}
			
			/* 
			 *  
			 *	END --- Derive Target End Date of newly added JO
			 */			
			 
			 
			
			//print_r($line_jos);
			
			//Check if there are other JO's under the same Line aside from the newly added JO
			if($line_jos!==NULL){
			
				//Initialize array variable holder for newly sorted and updated JO data values
				$new_line_jos	=	array();

					
				//If newly added JO is not first row OR not Priority 1
				if($base_priority>1){
					
					
					//To newly added row
					$new_line_jos[$base_priority]= array(
						'jo_id'		=>	$jo_id,
						'priority'	=>	$base_priority,
						'target_end_date'=>	$new_target_end_date,
					);
					
					
					//Start Date will be based from row set above which is the TED of newly added row
					$start_date	=	$new_target_end_date;
					
					//Start Priority count at after 2 rows (1st prior row, then 2nd is newly added row)
					$priority_ctr = $base_priority + 1;
					
					
				}
				//ELSE if newly added JO is FIRST ROW
					// means has priority number 1
				elseif($base_priority==1){
				
					//Assign newly Added JO data to first on the queue of sorted rows
					$new_line_jos[1]= array(
						'jo_id'		=>	$jo_id,
						'priority'	=>	$base_priority,
						'target_end_date'=>	$new_target_end_date,
					);
					
					//Start Date will be based from row set above which is the TED of newly added row
					$start_date	=	$new_target_end_date;
					//echo "\nStart - $base_priority";
					//Start Priority count at next no. which is 2
					$priority_ctr = 2;
					//echo "\nContine - $priority_ctr";
				}
				
				//Initialize vars
				$jo_days=0;

				
				//What is assigned to $ctr is the START of loop
				$ctr=0;
				
			
				foreach($line_jos as $jo){
				
					//Initial check if JO Priority no. is equal to newly added JO's Priority no.
						//this also detects if first row of queried values from same Line starting from prior row
					if(intval($priority_ctr) >= intval($base_priority)){
					
						if( $jo->jo_id == $line_jos[0]->jo_id && $base_priority>1){
							continue;	
						}
						
						if($line==0){
							$new_target_end_date = "0000-00-00";
							$new_line_jos[$priority_ctr]= array(
								'jo_id'		=>	$jo->jo_id,
								'priority'	=>	$priority_ctr,
								'target_end_date'=>	$new_target_end_date,
								'start_date'=>'none'
							);

							
						}elseif($line>=1){
							$non_working 	= 	Calendar::model()->getNonWorkingDays($line,date("Y-m-d", strtotime($start_date)),$jo->days_allotted,$working_days);
							//$new_target_end_date	=	$this->getTargetEndDate(date("Y-m-d", strtotime($start_date)), $jo->days_allotted, $non_working);
							//Get total days to be added to Start Date	
							$days =  $jo->days_allotted + $non_working;
		
							$target_end_datetime = strtotime("+".$days." days", strtotime($start_date));
				
							$new_target_end_date = date("Y-m-d", $target_end_datetime); 
							//echo "\n$priority_ctr - ".$new_target_end_date;
							//echo "\n- - $priority_ctr";
							$new_line_jos[$priority_ctr]= array(
								'jo_id'		=>	$jo->jo_id,
								'priority'	=>	$priority_ctr,
								'target_end_date'=>	$new_target_end_date,
							);
							
						}
						
						
						$priority_ctr++;
			
					}

				
				}//END for loop of $line_jos
				
				return $new_line_jos;
			}else{
				//No need to process any thing
				return false;
			}
		}else{
			return false;	
		}
	
	}

	public function updateReorderedJos($line, $line_jos,$temp=TRUE,$skip_data,$model){
	
		$null_date="0000-00-00";
		$session_id   = Yii::app()->getSession()->getSessionId();
		
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
						
						if($base_target_end_date==$null_date){
							
						
							$status="Done";
							$criteria = new CDbCriteria;
							$criteria->select 	=	"target_end_date";	
							$criteria->condition = 'status!="'.$status.'" AND line= '.$line.' AND priority>='.($priority-1).' AND session_id="'.$session_id.'"'; 
							$criteria->order	=	"line, priority";
							$criteria->limit	=	"1";
			
							if($model=='TempSewing'){
								$line_jos	=	TempSewing::model()->findAll($criteria);
								//print_r($line_jos);
								if($line_jos!==NULL && sizeof($line_jos)>0){
									$jo_TED = str_replace('/', '-', $line_jos[0]->target_end_date);

									$base_target_end_date		=	date('Y-m-d', strtotime($jo_TED)); //$this->getPriorTargetEndDate($line_jos, $base_priority);
								}else{
								
									$status="Done";
									$criteria = new CDbCriteria;
									$criteria->select 	=	"jo_id, priority, days_allotted, target_end_date, line";	
									$criteria->condition = 'status!="'.$status.'" AND line= '.$line.' AND priority>='.($priority-1); 
									$criteria->order	=	"line, priority";
									$criteria->limit	=	"1";
									
									$line_jos	=	JoSewing::model()->findAll($criteria);
									
									if($line_jos!==NULL){
										$jo_TED = str_replace('/', '-', $line_jos[0]->target_end_date);

										$base_target_end_date		=	date('Y-m-d', strtotime($jo_TED)); //$this->getPriorTargetEndDate($line_jos, $base_priority);
									}else{
								
									}
								}
			
							}else{
								$line_jos	=	TempFinishing::model()->findAll($criteria);
			
								if($line_jos!==NULL && sizeof($line_jos)>0){
									$jo_TED = str_replace('/', '-', $line_jos[0]->target_end_date);

									$base_target_end_date		=	date('Y-m-d', strtotime($jo_TED)); //$this->getPriorTargetEndDate($line_jos, $base_priority);
								}else{
								
									$status="Done";
									$criteria = new CDbCriteria;
									$criteria->select 	=	"jo_id, priority, days_allotted, target_end_date, line";	
									$criteria->condition = 'status!="'.$status.'" AND line= '.$line.' AND priority>='.($priority-1); 
									$criteria->order	=	"line, priority";
									$criteria->limit	=	"1";
									
									$line_jos	=	JoFinishing::model()->findAll($criteria);
									
									if($line_jos!==NULL){
										$jo_TED = str_replace('/', '-', $line_jos[0]->target_end_date);

										$base_target_end_date		=	date('Y-m-d', strtotime($jo_TED)); //$this->getPriorTargetEndDate($line_jos, $base_priority);
									}else{
								
									}
								}
							}
						}
					   	//$new_target_end_date	=	Yii::app()->joModule->generateTargetEndDate($line, $jo_id, $working_days, $start_date, $days_allotted, $temp, $priority, $base_target_end_date, $skipBaseRowCheck);
				   		
				   		$non_working = Calendar::model()->getNonWorkingDays($line,$base_target_end_date,$days_allotted,$working_days);
						$new_target_end_date	=	$this->getTargetEndDate($base_target_end_date, $days_allotted, $non_working);
				   	
				   		//echo $base_target_end_date.' '.$days_allotted.' '.$non_working;
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
							
							 if($model=='TempSewing'){
							 	$temp = new TempSewing;
							 }else{
							 	$temp = new TempFinishing;
							 }
						
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
					
								 $temp               = $this->loadTempModel($temp->jo_id, $temp->admin_id, $temp->session_id,$model);
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
	
	public function deleteTemp($admin_id, $session_id,$model)
    {

        if($model=='TempFinishing'){
			TempFinishing::model()->deleteAll(

				'admin_id = :admin_id AND session_id = :session_id',
				array(
					'admin_id' => $admin_id,
					'session_id' => $session_id
				)
			);
        
        }else{
 			TempSewing::model()->deleteAll(

				'admin_id = :admin_id AND session_id = :session_id',
				array(
					'admin_id' => $admin_id,
					'session_id' => $session_id
				)
			);
       
        
        }
        
        return TRUE;
    }
	
}

?>
