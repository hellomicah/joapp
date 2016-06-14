<?php

/**
 * This is the model class for table "temp_sewing".
 *
 * The followings are the available columns in table 'temp_sewing':
 * @property string $temp_sewing_id
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
 * @property string $admin_id
 * @property string $session_id
 * @property string $datetime_created
 */
class TempSewing extends CActiveRecord
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
		return 'temp_sewing';
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
			array('priority, quantity, line, output, balance', 'numerical', 'integerOnly'=>true),
			array('jo_id, admin_id', 'length', 'max'=>8),
			array('jo, brand, category, color, days_needed, status', 'length', 'max'=>60),
			array('days_allotted, allowance', 'length', 'max'=>6),
			array('washing_info', 'length', 'max'=>32),
			array('delivery_receipt', 'length', 'max'=>16),
			array('session_id', 'length', 'max'=>120),
			array('date_received, target_end_date, delivery_date, comments', 'safe'),
			
			//custom
			array('jo','unique'),
			array(
            	'jo',
            	'match', 'pattern' => '/^[a-zA-Z\d]+$/',
            	'message' => 'Invalid characters in JO.',
        	),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('temp_sewing_id, jo_id, priority, jo, brand, quantity, category, color, date_received, days_needed, days_allotted, allowance, target_end_date, delivery_date, line, status, output, balance, comments, washing_info, delivery_receipt, admin_id, session_id, datetime_created', 'safe', 'on'=>'search'),
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
			'temp_sewing_id' => 'Temp Sewing',
			'jo_id' => 'Jo',
			'priority' => 'Priority',
			'jo' => 'Jo',
			'brand' => 'Brand',
			'quantity' => 'Quantity',
			'category' => 'Category',
			'color' => 'Color',
			'date_received' => 'Data Received',
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
			'admin_id' => 'Admin',
			'session_id' => 'Session',
			'datetime_created' => 'Datetime Created',
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

		$criteria->compare('temp_sewing_id',$this->temp_sewing_id,true);
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
		$criteria->compare('admin_id',$this->admin_id,true);
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('datetime_created',$this->datetime_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TempSewing the static model class
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
            
        
        return parent::beforeValidate ();
    }
		
	
}
