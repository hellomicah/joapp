<?php

/**
 * This is the model class for table "calendar".
 *
 * The followings are the available columns in table 'calendar':
 * @property string $calendar_id
 * @property string $event
 * @property string $date
 * @property string $date_added
 * @property string $datetime_created
 * @property string $date_updated
 * @property integer $admin_id
 */
class Calendar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calendar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event', 'required'),
			array('admin_id', 'numerical', 'integerOnly'=>true),
			array('date, date_added, datetime_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('calendar_id, event, date, date_added, datetime_created, date_updated, admin_id', 'safe', 'on'=>'search'),
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
			'calendar_id' => 'Calendar',
			'event' => 'Event',
			'date' => 'Date',
			'date_added' => 'Date Added',
			'datetime_created' => 'Datetime Created',
			'date_updated' => 'Date Updated',
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

		$criteria->compare('calendar_id',$this->calendar_id,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('datetime_created',$this->datetime_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('admin_id',$this->admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Calendar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function monthList(){
		$month_info = cal_info(0);
		return $month_info["months"];
	}
	
	public function yearList(){
		$year = date("Y"); 
		$year++;
		for ($i = 0; $i <= 50; $i++) {
			$yearList[$year] = $year;
			$year--;
		}
		return $yearList;
	}
	
	
	public function updateAllLine($line,$line_status,$month,$date,$year){
		$jo_lines = Yii::app()->db->createCommand()
			->select('line_id')
			->from('jo_line')
			->queryAll();
		
		foreach($jo_lines as $line){
			$this->updateStatus($line["line_id"],$line_status,$month,$date,$year);
		}
		
	}
	
	public function updateStatus($line,$line_status,$month,$date,$year){
		$selected_date = strtotime($year."-".$month."-".$date);
		$db_date = date("Y-m-d",$selected_date);
		//select if combination exist
		$date_arr = $this->checkInCalendar($line,$db_date);
		//if yes update the value
		if(empty($date_arr)){
			//insert
			$command = Yii::app()->db->createCommand()
				->insert('calendar', array(
    				'line_id'=>$line,
    				'event'=>$line_status,
    				'date'=>$db_date,
    				'date_added'=>date("Y-m-d"),
    				'datetime_created'=>date("Y-m-d H:i:m"),
    				'admin_id'=> Yii::app()->user->id
				));
		}else{
			//update
			$command = Yii::app()->db->createCommand()
				->update('calendar', array(
						'event'=>$line_status,
					), 'line_id=:line_id AND date=:date', array(':line_id'=>$line,':date'=>$db_date));
		}
		//if no insert
		
	}
	private function checkInCalendar($line,$db_date){
		$date_arr = Yii::app()->db->createCommand()
			->select('*')
			->from('calendar')
			->where('line_id=:line_id AND date=:date',array(':line_id'=>$line,':date'=>$db_date))
			->limit(1)
			->queryRow();
		return $date_arr;	
	}
	
public function drawCalendar($month,$year,$line = "all"){
	$selected_running_day = 6;
	if($line != "all"){
		$jo_line = Yii::app()->db->createCommand()
					->select('line_id,working_days')
					->from('jo_line')
					->where('line_id=:line_id',array(':line_id'=>$line))
					->limit(1)
					->queryRow();
		$parsed_arr =  explode("-",$jo_line["working_days"]);
		if($parsed_arr[1] == "Saturday"){
			$selected_running_day = "";
		}		
	}				
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$jo_calendar = array();
		$calendar.= '<td id="per-day-'.$list_day.'" onclick="showData(this)"  class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			if($line != "all"){
				/*$jo_lines = Yii::app()->db->createCommand()
					->select('line_id,working_days')
					->from('jo_line')
					->where('line_id=:line_id',array(':line_id'=>$line))
					->limit(1)
					->queryRow();*/
				$selected_date = strtotime($year."-".$month."-".$list_day);
				$db_date = date("Y-m-d",$selected_date);	
				$jo_calendar = $this->checkInCalendar($line,$db_date);
				//select from line to check the working_days
			}
			//$calendar.= str_repeat('<p> </p>',2);
			if($running_day == $selected_running_day || $running_day == 0):
				if(!empty($jo_calendar)){
					$event = $jo_calendar["event"];
				}else{
					$event = "No Work";
				}
				$calendar.= '<p id="status-'.$list_day.'">'.$event.'</p>';
			else:
				if(!empty($jo_calendar)){
					$event = $jo_calendar["event"];
				}else{
					$event = "Working";
				}
				$calendar.= '<p id="status-'.$list_day.'">'.$event.'</p>';
			endif;
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}

/*for getting number of non working days*/
public function getNonWorkingDays($line_id,$start_date,$days_allotted,$working_days){
	$nonworking_count = 0;
	$nowork_array = array();
	$work_array = array();
	$weekends_array = array();
	$days_allotted = $days_allotted -1;
	$end_date =  date('Y-m-d', strtotime($start_date.' +' . $days_allotted . ' days'));
	$selected_running_day = "Friday";
	$parsed_arr =  explode("-",$working_days);
		if($parsed_arr[1] == "Saturday"){
			$selected_running_day = "Saturday";
		}	
	//select count of rows from calendar
	$nowork_arr = Yii::app()->db->createCommand()
			->select('date')
			->from('calendar')
			->where('line_id=:line_id AND event!="Working" AND date BETWEEN :start AND :end',array(':line_id'=>$line_id,':start'=>$start_date,':end'=>$end_date))
			->queryAll();
	foreach($nowork_arr as $nowork_date){
		$nowork_array[]=$nowork_date["date"];
	}
	$work_arr = Yii::app()->db->createCommand()
			->select('date')
			->from('calendar')
			->where('line_id=:line_id AND event="Working" AND date BETWEEN :start AND :end',array(':line_id'=>$line_id,':start'=>$start_date,':end'=>$end_date))
			->queryAll();	
	foreach($work_arr as $work_date){
		$work_array[]=$work_date["date"];
	}
	
	$weekends_array = $this->getWeekendDateArr($start_date,$end_date,$days_allotted,$selected_running_day);
	//remove the assigned working days from weekdays_array
	$final_arr = array_diff($weekends_array,$work_array);
	//combined weekends and nonworking days ,must be unique dates
	$final_arr = array_unique(array_merge($final_arr,$nowork_array));
	
	$nonworking_count = count($final_arr);
    
	return $nonworking_count;
}

private function getWeekendDateArr($start_date,$end_date,$days_allotted,$selected_running_day){

	$date = $start_date;
	$days_result = array();
	for($x=0;$x<$days_allotted;$x++){
		$str_date = strtotime($date);
		if($selected_running_day == "Friday"){
		
			if(date('w', $str_date) == 6 || date('w', $str_date) == 0){
        	//saturday and sunday
        		$days_result[] = date('Y-m-d', $str_date);
        	}
		}else{
			if(date('w', $str_date) == 0){
        	//saturday and sunday
        		$days_result[] = date('Y-m-d', $str_date);
        	}
		}
		
        
        $str_date += (24 * 3600);
		$date = date('Y-m-d',$str_date );
	}
	
	return $days_result;
}
}
