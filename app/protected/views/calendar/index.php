<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this CalendarController */
/* @var $dataProvider CActiveDataProvider */


/*$this->menu=array(
	array('label'=>'Create Calendar', 'url'=>array('create')),
	array('label'=>'Manage Calendar', 'url'=>array('admin')),
);*/
?>
<style>
/* calendar */
.calendar-div {
	padding-top:10px;
}
table.calendar		{ border-left:1px solid #999; }
tr.calendar-row	{  }
td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
td.calendar-day:hover	{ background:#eceff5; }
td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
/* shared */
td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
</style>
<script>

function showData(e){
	var baseURL =location.protocol+'//'+location.host+ '/jo_manager_live/'; //UPDATE
	var working_status ;
	var nowork_status ;
	var special_status ;
	var regular_status ;
	var year = document.getElementById("year").value;
	var month = document.getElementById("month").value;
	var line = document.getElementById("line").value;
	var line_value = $("#line option:selected").text();
	var id = e.id;
	var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	var date_arr = id.split("-");
	var title = months[month - 1]+" " +date_arr[2]+" ,"+year;
	var line_status = document.getElementById("status-"+date_arr[2]).innerHTML;
	
	switch(line_status){
		case "Working":
			working_status = "selected";
			break;
		case "No Work":
			nowork_status = "selected";
			break;
		case "Special Non-working Holiday":
			special_status = "selected";
			break;
		case "Regular Holiday":
			regular_status = "selected";
			break;
	}
	bootbox.dialog({
                title: title,
                message: '<div>  ' +
                   // '<div class="col-md-12"> ' +
                    '<form class="form-horizontal"> ' +
                   // '<div class="form-group"> ' +
                    '<label class="col-md-4 control-label" for="name">Set as :</label> ' +
                    '<div class="col-md-4"> ' +
                    '<select class="form-control" name="work_status" id="work_status"> ' +
					'<option value="Working" '+working_status+'>Working</option>'+
					'<option value="No Work" '+nowork_status+'>No Work</option>'+
					'<option value="Special Non-working Holiday" '+special_status+'>Special Non-working Holiday</option>'+
					'<option value="Regular Holiday" '+regular_status+'>Regular Holiday</option></select>' +
                    '<span class="help-block">Apply to '+line_value+'</span></div> ' +
                   // '</div> ' +
                    '</div>' +
                    '</form> </div>',
                buttons: {
                    success: {
                        label: "Update",
                        className: "btn-success",
                        callback: function () {
                            var new_work_status = $('#work_status').val();
                            document.getElementById("status-"+date_arr[2]).innerHTML = new_work_status;
                            $(document).ready(function(){
								$.post(baseURL + "calendar/updateStatus", {line_status:new_work_status,line:line,month:month,year:year,date:date_arr[2]} ,function(result){
         
    							});
    						});
                        }
                    }
                }
            }
        );
}
</script>
<?php //$this->widget('zii.widgets.CListView', array('dataProvider'=>$dataProvider,'itemView'=>'_view')); ?>

<div class = "calendar-div">
<?php
/* sample usages */

	echo CHtml::dropDownList('month',$month, Calendar::model()->monthList(),
        array(
            //'onchange' => 'changeDateClass(this.value)',
            'ajax' => array(
                'url'=>CController::createUrl('calendar/alterCalendar'), 
				'data'=> 'js:{"year": $("#year").val(),"month": $("#month").val(),"line": $("#line").val()}',  
				'update'=>'#activities'
				),
			//'class' => 'form-control'
			//'style' => 	'margin:10px;'	
				
			)
		); 
			
	echo CHtml::dropDownList('year',$year, Calendar::model()->yearList(),
        array(
            //'onchange' => 'changeDateClass(this.value)',
            'ajax' => array(
                'url'=>CController::createUrl('calendar/alterCalendar'),
				'data'=> 'js:{"year": $("#year").val(),"month": $("#month").val(),"line": $("#line").val()}',  
                'update'=>'#activities',
            	),
            //'class' => 'form-control',
             //'style' => 	'margin:10px;'
            )); 
    
    echo CHtml::dropDownList('line','', JoLine::model()->LineList(),
        array(
            //'onchange' => 'changeDateClass(this.value)',
            'ajax' => array(
                'url'=>CController::createUrl('calendar/alterCalendar'),
				'data'=> 'js:{"year": $("#year").val(),"month": $("#month").val(),"line": $("#line").val()}',  
                'update'=>'#activities',
            	),
            //'class' => 'form-control'
            'style' => 	'margin-left:20px;'
            )); 

?>
	<div id="activities" style="margin-top:10px;">
	<?php
		$this->renderPartial('_calendar', array('calendar'=>$calendar));
	?>
	</div>
</div>