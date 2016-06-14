<?php

/**
 * This is the model class for table "temp_finishing".
 *
 * The followings are the available columns in table 'temp_finishing':
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
 * @property integer $sort_order
 */
class TempFinishing extends CActiveRecord
{
	public $delivery_date_modal;
	public $date_received_modal;
	public $audit_date_modal;
	/**
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temp_finishing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jo_id, admin_id, session_id', 'required'),
			array('priority, quantity, line, output, balance, admin_id', 'numerical', 'integerOnly'=>true),
			array('jo, color', 'length', 'max'=>60),
			array('brand, category, status, comments, washing_info, delivery_receipt', 'length', 'max'=>32),
			array('days_needed, days_allotted, allowance', 'length', 'max'=>7),
			array('date_received, target_end_date, date_added, datetime_created, jo_updated', 'safe'),
			
			
			//custom
			array('jo','unique'),
			array(
            	'jo',
            	'match', 'pattern' => '/^[a-zA-Z\d]+$/',
            	'message' => 'Invalid characters in JO.',
        	),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jo_id, priority, jo, brand, quantity, category, color, date_received, days_needed, days_allotted, allowance, target_end_date, delivery_date, line, status, output, balance, comments, washing_info, delivery_receipt, date_added, datetime_created, jo_updated, admin_id', 'safe', 'on'=>'search'),
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
			'delivery_receipt' => 'Delivery Receipt',
			
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
			//'sort_order' => 'Sort Order',
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

		$criteria->compare('jo_id',$this->jo_id,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('jo',$this->jo,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('date_received',$this->date_received,true);
		$criteria->compare('days_needed',$this->days_needed,true);
		$criteria->compare('days_allotted',$this->days_allotted,true);
		$criteria->compare('allowance',$this->allowance,true);
		$criteria->compare('target_end_date',$this->target_end_date,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('line',$this->line);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('output',$this->output);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('washing_info',$this->washing_info,true);
		$criteria->compare('delivery_receipt',$this->delivery_receipt,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('datetime_created',$this->datetime_created,true);
		$criteria->compare('jo_updated',$this->jo_updated,true);
		$criteria->compare('admin_id',$this->admin_id);
		//$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TempFinishing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave(){
		if(strtotime($this->date_received) > strtotime('1970-01-01') ){
   			$this->date_received = date ('Y-m-d', strtotime ($this->date_received));
   		}
   		if(strtotime($this->delivery_date) > strtotime('1970-01-01') ){
   			$this->delivery_date = date ('Y-m-d', strtotime ($this->delivery_date));
   		}
   		if(strtotime($this->target_end_date)  > strtotime('1970-01-01') ){
   			$this->target_end_date = date ('Y-m-d', strtotime ($this->target_end_date));
   		}
   		if(strtotime($this->audit_date)  > strtotime('1970-01-01') ){
   			$this->audit_date = date ('Y-m-d', strtotime ($this->audit_date));
   		}
     
        
   		return parent::beforeSave();
	}
		
	



    protected function beforeValidate ()
    {
            // convert to storage format
        
        if(strtotime($this->date_received) > strtotime('1970-01-01') ){
        $this->date_received = strtotime ($this->date_received);
        $this->date_received = date ('Y-m-d', $this->date_received);
		}
        if(strtotime($this->target_end_date)  > strtotime('1970-01-01') ){
        $this->target_end_date = strtotime ($this->target_end_date);
        $this->target_end_date = date ('Y-m-d', $this->target_end_date);
        
        }
        if(strtotime($this->delivery_date) > strtotime('1970-01-01')){
        $this->delivery_date = strtotime ($this->delivery_date);
        $this->delivery_date = date ('Y-m-d', $this->delivery_date);
        }
        if(strtotime($this->audit_date)  > strtotime('1970-01-01')){
        $this->audit_date = strtotime ($this->audit_date);
        $this->audit_date = date ('Y-m-d', $this->audit_date);
		}        
        
        return parent::beforeValidate ();
    }
		
	protected function afterFind ()
    {
            // convert to display format
        /*
        if(strtotime($this->date_received) > strtotime('1970-01-01') ){
        $this->date_received = strtotime ($this->date_received);
        $this->date_received = date ('M/d/y', $this->date_received);
		}else{
			$this->date_received = 'none';
		}
        if(strtotime($this->target_end_date)  > strtotime('1970-01-01')){
        $this->target_end_date = strtotime ($this->target_end_date);
        $this->target_end_date = date ('M/d/y', $this->target_end_date);
		}else{
			$this->target_end_date = 'none';
		}
        if(strtotime($this->delivery_date) > strtotime('1970-01-01')){
        $this->delivery_date = strtotime ($this->delivery_date);
        $this->delivery_date = date ('M/d/y', $this->delivery_date);
		}else{
			$this->delivery_date = 'none';
		}
        if(strtotime($this->date_received_modal)  > strtotime('1970-01-01')){
        $this->date_received_modal = strtotime ($this->date_received_modal);
        $this->date_received_modal = date ('M/d/y', $this->date_received_modal);
        }else{
			$this->date_received_modal = 'none';
		}
        if(strtotime($this->audit_date)  > strtotime('1970-01-01')){
        	$this->audit_date = strtotime ($this->audit_date);
        	$this->audit_date = date ('M/d/y', $this->audit_date);
        }else{
			$this->audit_date = 'none';
		}
        
        parent::afterFind ();
        */
    }
	
}
