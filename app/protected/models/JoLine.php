<?php

/**
 * This is the model class for table "jo_line".
 *
 * The followings are the available columns in table 'jo_line':
 * @property string $line_id
 * @property string $name
 * @property string $working_days
 * @property string $start_date
 * @property integer $standard_average_output
 * @property string $date_added
 * @property string $datetime_created
 * @property string $line_updated
 * @property integer $admin_id
 */
class JoLine extends CActiveRecord
{
	const MON_FRI = "Monday-Friday";
	const MON_SAT = "Monday-Saturday";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jo_line';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,working_days, start_date, standard_average_output', 'required','on'=>'create,update'),
			array('name', 'unique', 'on' => 'create'),
			
			array('name', 'unique_name', 'on' => 'update'),
			
			array('standard_average_output', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('working_days', 'length', 'max'=>15),
			array('date_added, datetime_created, line_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('line_id, name, working_days, start_date, standard_average_output, date_added, datetime_created, line_updated, admin_id', 'safe', 'on'=>'search'),
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
			//'josewing'=>array(self::HAS_MANY, 'JoSewing', 'line'),
			'sewing' => array(self::HAS_MANY, 'JoSewing', 'line'),
			'finishing' => array(self::HAS_MANY, 'JoFinishing', 'line'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'line_id' => 'Line',
			'name' => 'Name',
			'working_days' => 'Working Days',
			'start_date' => 'Start Date',
			'standard_average_output' => 'Standard Average Output',
			'date_added' => 'Date Added',
			'datetime_created' => 'Datetime Created',
			'line_updated' => 'Line Updated',
			'admin_id' => 'Admin',
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

		$criteria->compare('line_id',$this->line_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('working_days',$this->working_days,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('standard_average_output',$this->standard_average_output);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('datetime_created',$this->datetime_created,true);
		$criteria->compare('line_updated',$this->line_updated,true);
		$criteria->compare('admin_id',$this->admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
            	'pageSize' => 50,
        	),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JoLine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/*
	Working days selection
	*/
	public function workingDays(){
	 return array(
	 		""=>"Select Working Days",
            self::MON_FRI => self::MON_FRI,
			self::MON_SAT => self::MON_SAT,
        );
	}
	
	/*
	Working days selection
	*/
	public function LineList($form = NULL){
		if($form  == "admin_single"){
			$jo_arr[""] = "Select Line";
		}else if($form != "admin"){
			$jo_arr["all"] = "All Line";
		}
		$jo_line = Yii::app()->db->createCommand()
			->select('name,line_id')
			->from('jo_line')
			->queryAll();
		if(!empty($jo_line)){
			foreach($jo_line as $name){
				$jo_arr[$name["line_id"]] = $name["name"];
			}
		}
	 return $jo_arr;
	}
	
	/*
	Lines
	*/
	public function SingleLineList($form = NULL){
		if($form != "admin"){
			$jo_arr["all"] = "All Line";
		}
		$jo_line = Yii::app()->db->createCommand()
			->select('name,line_id')
			->from('jo_line')
			->queryAll();
		if(!empty($jo_line)){
			foreach($jo_line as $name){
				$jo_arr[$name["line_id"]] = $name["name"];
			}
		}
	 return $jo_arr;
	}
	
	public function unique_name($attribute_name){
		$jo_name = Yii::app()->db->createCommand()
			->select('*')
			->from('jo_line')
			->where('name=:name',array(':name'=>$this->name))
			->limit(1)
			->queryRow();
		if(!empty($jo_name)){
			if($jo_name["line_id"] != $this->line_id){
				$this->addError($attribute_name, Yii::t('name', 'Name already exist. '));
			}	
		}
		
	}
	
	/*
	return Line Name
	*/
	public function LineName($line_id){
		$jo_line_name = "";
		$jo_line = Yii::app()->db->createCommand()
			->select('name')
			->from('jo_line')
			->where('line_id=:line_id', array(':line_id'=>$line_id))
			->queryRow();
		if(!empty($jo_line)){
			$jo_line_name = $jo_line["name"];
		}
	 return $jo_line_name;
	}
	
	/*
	*Before saving the users data
	*/
	public function beforeSave(){
		
		if ($this->isNewRecord){
			$this->date_added = date('Y-m-d');
			$this->admin_id = Yii::app()->user->id;
		}
		return parent::beforeSave();
	}

	
	public function getAvgOutput($line_id){
		
		$jo_line = Yii::app()->db->createCommand()
			->select('standard_average_output')
			->from('jo_line')
			->where('line_id=:id', array(':id'=>$id))
    		->queryRow();
	}
}
