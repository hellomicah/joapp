<?php

/**
 * This is the model class for table "jo_finishing".
 *
 * The followings are the available columns in table 'jo_finishing':
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
 * @property string $audit_date
 * @property integer $total_delivered
 * @property integer $salesman_sample
 * @property integer $delivery_1
 * @property integer $delivery_2
 * @property integer $delivery_3
 * @property integer $delivery_4
 * @property integer $delivery_5
 * @property integer $second_quality
 * @property integer $unfinished
 * @property integer $lacking
 * @property string $closed
 * @property string $date_added
 * @property string $datetime_created
 * @property string $jo_updated
 * @property integer $admin_id
 * @property integer $sort_order
 */
class JoFinishing extends CActiveRecord
{
	public $delivery_date_modal;
	public $date_received_modal;
	public $audit_date_modal;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jo_finishing';
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
			//array('priority, jo, color, delivery_date, sort_order', 'required'),
			array('priority, quantity, line, output, balance, total_delivered, salesman_sample, delivery_1, delivery_2, delivery_3, delivery_4, delivery_5, second_quality, unfinished, lacking, admin_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('jo, color', 'length', 'max'=>60, 'on'=>'addNew,insert,update'), //added for search
			array('brand, category, status, comments, washing_info, closed', 'length', 'max'=>32, 'on'=>'addNew,insert,update'), //added for search
			array('days_needed, days_allotted, allowance', 'length', 'max'=>7, 'on'=>'addNew,insert,update'), //added for search
			array('date_received, target_end_date, audit_date, date_added, datetime_created, jo_updated', 'safe'),
			array('audit_date', 'safe','on'=>'insert'), //added tine
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jo_id, priority, jo, brand, quantity, category, color, date_received, days_needed, days_allotted, allowance, target_end_date, delivery_date, line, status, output, balance, comments, washing_info, audit_date, total_delivered, salesman_sample, delivery_1, delivery_2, delivery_3, delivery_4, delivery_5, second_quality, unfinished, lacking, closed, date_added, datetime_created, jo_updated, admin_id, sort_order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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
			'quantity' => 'Quantity',
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
			'balance' => 'Balance',
			'comments' => 'Comments',
			'washing_info' => 'Washing Info',
			'audit_date' => 'Audit Date',
			'total_delivered' => 'Total Delivered',
			'salesman_sample' => 'Salesman Sample',
			'delivery_1' => 'Delivery 1',
			'delivery_2' => 'Delivery 2',
			'delivery_3' => 'Delivery 3',
			'delivery_4' => 'Delivery 4',
			'delivery_5' => 'Delivery 5',
			'second_quality' => 'Second Quality',
			'unfinished' => 'Unfinished',
			'lacking' => 'Lacking',
			'closed' => 'Closed',
			'date_added' => 'Date Added',
			'datetime_created' => 'Datetime Created',
			'jo_updated' => 'Jo Updated',
			'admin_id' => 'Admin',
			'sort_order' => 'Sort Order',
			
			'date_received_modal' => 'Date Received',
			'delivery_date_modal' => 'Delivery Date',
			'audit_date_modal' => 'Audit Date',
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

		/*$criteria->compare('jo_id',$this->jo_id,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('jo',$this->jo,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('color',$this->color,true);*/
		$criteria->compare('date_received',$this->date_received,true);
		/*$criteria->compare('days_needed',$this->days_needed,true);
		$criteria->compare('days_allotted',$this->days_allotted,true);
		$criteria->compare('allowance',$this->allowance,true);*/
		$criteria->compare('target_end_date',$this->target_end_date,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		/*$criteria->compare('line',$this->line);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('output',$this->output);
		$criteria->compare('balance',$this->balance);*/
		$criteria->compare('comments',$this->comments,true);
		//$criteria->compare('washing_info',$this->washing_info,true);
		$criteria->compare('audit_date',$this->audit_date,true);
		/*$criteria->compare('total_delivered',$this->total_delivered);
		$criteria->compare('salesman_sample',$this->salesman_sample);
		$criteria->compare('delivery_1',$this->delivery_1);
		$criteria->compare('delivery_2',$this->delivery_2);
		$criteria->compare('delivery_3',$this->delivery_3);
		$criteria->compare('delivery_4',$this->delivery_4);
		$criteria->compare('delivery_5',$this->delivery_5);
		$criteria->compare('second_quality',$this->second_quality);
		$criteria->compare('unfinished',$this->unfinished);
		$criteria->compare('lacking',$this->lacking);
		$criteria->compare('closed',$this->closed,true);*/
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
		
		if(empty($this->total_delivered)){
			$criteria->compare('total_delivered',$this->total_delivered,true);
		}else{
			$total_delivered_arr = explode(",", $this->total_delivered);
			if(empty($total_delivered_arr)){
				$criteria->compare('total_delivered',$this->total_delivered,true);
			}else{
				$criteria->addInCondition('total_delivered', $total_delivered_arr, 'AND');
			}
		}
		
		if(empty($this->salesman_sample)){
			$criteria->compare('salesman_sample',$this->salesman_sample,true);
		}else{
			$salesman_sample_arr = explode(",", $this->salesman_sample);
			if(empty($salesman_sample_arr)){
				$criteria->compare('salesman_sample',$this->salesman_sample,true);
			}else{
				$criteria->addInCondition('salesman_sample', $salesman_sample_arr, 'AND');
			}
		}
		
		if(empty($this->delivery_1)){
			$criteria->compare('delivery_1',$this->delivery_1,true);
		}else{
			$delivery_1_arr = explode(",", $this->delivery_1);
			if(empty($delivery_1_arr)){
				$criteria->compare('delivery_1',$this->delivery_1,true);
			}else{
				$criteria->addInCondition('delivery_1', $delivery_1_arr, 'AND');
			}
		}
		
		if(empty($this->delivery_2)){
			$criteria->compare('delivery_2',$this->delivery_2,true);
		}else{
			$delivery_2_arr = explode(",", $this->delivery_2);
			if(empty($delivery_2_arr)){
				$criteria->compare('delivery_2',$this->delivery_2,true);
			}else{
				$criteria->addInCondition('delivery_2', $delivery_2_arr, 'AND');
			}
		}
		
		if(empty($this->delivery_3)){
			$criteria->compare('delivery_3',$this->delivery_3,true);
		}else{
			$delivery_3_arr = explode(",", $this->delivery_3);
			if(empty($delivery_3_arr)){
				$criteria->compare('delivery_3',$this->delivery_3,true);
			}else{
				$criteria->addInCondition('delivery_3', $delivery_3_arr, 'AND');
			}
		}
		
		
		if(empty($this->delivery_4)){
			$criteria->compare('delivery_4',$this->delivery_4,true);
		}else{
			$delivery_4_arr = explode(",", $this->delivery_4);
			if(empty($delivery_4_arr)){
				$criteria->compare('delivery_4',$this->delivery_4,true);
			}else{
				$criteria->addInCondition('delivery_4', $delivery_4_arr, 'AND');
			}
		}
		
		if(empty($this->delivery_5)){
			$criteria->compare('delivery_5',$this->delivery_5,true);
		}else{
			$delivery_5_arr = explode(",", $this->delivery_5);
			if(empty($delivery_5_arr)){
				$criteria->compare('delivery_5',$this->delivery_5,true);
			}else{
				$criteria->addInCondition('delivery_5', $delivery_5_arr, 'AND');
			}
		}
		
		if(empty($this->second_quality)){
			$criteria->compare('second_quality',$this->second_quality,true);
		}else{
			$second_quality_arr = explode(",", $this->second_quality);
			if(empty($second_quality_arr)){
				$criteria->compare('second_quality',$this->second_quality,true);
			}else{
				$criteria->addInCondition('second_quality', $second_quality_arr, 'AND');
			}
		}
		
		if(empty($this->unfinished)){
			$criteria->compare('unfinished',$this->unfinished,true);
		}else{
			$unfinished_arr = explode(",", $this->unfinished);
			if(empty($unfinished_arr)){
				$criteria->compare('unfinished',$this->unfinished,true);
			}else{
				$criteria->addInCondition('unfinished', $unfinished_arr, 'AND');
			}
		}
		
		if(empty($this->lacking)){
			$criteria->compare('lacking',$this->lacking,true);
		}else{
			$lacking_arr = explode(",", $this->lacking);
			if(empty($lacking_arr)){
				$criteria->compare('lacking',$this->lacking,true);
			}else{
				$criteria->addInCondition('lacking', $lacking_arr, 'AND');
			}
		}
		
		if(empty($this->closed)){
			$criteria->compare('closed',$this->closed,true);
		}else{
			$closed_arr = explode(",", $this->closed);
			if(empty($closed_arr)){
				$criteria->compare('closed',$this->closed,true);
			}else{
				$criteria->addInCondition('closed', $closed_arr, 'AND');
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
	 * @return JoFinishing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterFind ()
    {
            // convert to display format
//         
//         if(strtotime($this->date_received) > strtotime('1970-01-01') ){
//         $this->date_received = strtotime ($this->date_received);
//         $this->date_received = date ('M/d/y', $this->date_received);
// 		}else{
// 			$this->date_received = 'none';
// 		}
//         if(strtotime($this->target_end_date) > strtotime('1970-01-01') ){
//         $this->target_end_date = strtotime ($this->target_end_date);
//         $this->target_end_date = date ('M/d/y', $this->target_end_date);
// 		}else{
// 			$this->target_end_date = 'none';
// 		}
//         if(strtotime($this->delivery_date) > strtotime('1970-01-01') ){
//         $this->delivery_date = strtotime ($this->delivery_date);
//         $this->delivery_date = date ('M/d/y', $this->delivery_date);
// 		}else{
// 			$this->delivery_date = 'none';
// 		}
//         if(strtotime($this->date_received_modal) > strtotime('1970-01-01') ){
//         $this->date_received_modal = strtotime ($this->date_received_modal);
//         $this->date_received_modal = date ('M/d/y', $this->date_received_modal);
//         }else{
// 			$this->date_received_modal = 'none';
// 		}
//         if(strtotime($this->audit_date) > strtotime('1970-01-01') ){
//         	$this->audit_date = strtotime ($this->audit_date);
//         	$this->audit_date = date ('M/d/y', $this->audit_date);
//         }else{
// 			$this->audit_date = 'none';
// 		}
//         
//         parent::afterFind ();
    }


    
    public function saveTempFinishing($admin_id, $session_id)
    {
        
        $criteria = new CDbCriteria;
				$criteria->select 	=	"priority, jo, jo_id,brand, quantity, category, color, date_received,
data_received, days_needed, days_allotted, allowance, target_end_date,
delivery_date, line, status, output, balance, comments, washing_info,
total_delivered, delivery_1,delivery_2,delivery_3,delivery_4,delivery_5,unfinished, lacking,second_quality, salesman_sample";	
				$criteria->condition = 'admin_id='.$admin_id.' AND session_id= "'.$session_id.'"';
				$criteria->order	=	"line, priority";
				$temp_jos=	TempFinishing::model()->findAll($criteria);
        
//print_r($temp_jos);
       	$temp_update = array();
       	
       	if($temp_jos !== NULL){
       		
			
			$transaction = Yii::app()->db->beginTransaction();
				 
			try {       		
       
				foreach($temp_jos as $temp){
				
						
				
						$model = Yii::app()->joModule->loadModel($temp->jo_id,'JoFinishing');
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
						if($temp->total_delivered !==NULL && $temp->total_delivered!=''){
							$model->total_delivered=$temp->total_delivered; 
						}
						
						if($temp->salesman_sample !==NULL && $temp->salesman_sample!=''){
							$model->salesman_sample=$temp->salesman_sample; 
						}
						
						if($temp->lacking !==NULL && $temp->lacking!=''){
							$model->lacking=$temp->lacking; 
						}
						
						if($temp->second_quality !==NULL && $temp->second_quality!=''){
							$model->second_quality=$temp->second_quality; 
						}
						
						if($temp->unfinished !==NULL && $temp->unfinished!=''){
							$model->unfinished=$temp->unfinished; 
						}
						
						if($temp->delivery_1 !==NULL && $temp->delivery_1!=''){
							$model->delivery_1=$temp->delivery_1; 
						}
						
						if($temp->delivery_2 !==NULL && $temp->delivery_2!=''){
							$model->delivery_2=$temp->delivery_2; 
						}
						
						if($temp->delivery_3 !==NULL && $temp->delivery_3!=''){
							$model->delivery_3=$temp->delivery_3; 
						}
						
						if($temp->delivery_4 !==NULL && $temp->delivery_4!=''){
							$model->delivery_4=$temp->delivery_4; 
						}
						
						if($temp->delivery_5 !==NULL && $temp->delivery_5!=''){
							$model->delivery_5=$temp->delivery_5; 
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
				
				Yii::app()->joModule->deleteTemp($admin_id, $session_id,'TempFinishing');
				
		   } catch (Exception $e) {
			   $transaction->rollBack();
			   // other actions to perform on fail (redirect, alert, etc.)
			   //echo 'TRANSACTION -- '.$e;
			   return false;
		   } 
		  
			
		 return $temp_jos;
	 }
       
		
		return false;
    }
   
    
}
