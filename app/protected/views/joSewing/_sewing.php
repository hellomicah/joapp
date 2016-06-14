<?php
//Yii::app()->booster->registerAssetCss('booster-datepicker.css');
//Yii::app()->booster->registerAssetJs('booster.datepicker.js');
?>
<script src="<?php
echo Yii::app()->request->baseUrl;
?>/js/jquery.ui.touch-punch.min.js"></script>
<script>

$(document).ready(function(){
/*$("ul.pagination li a").click(function(){
	//alert("yo");
	console.log(document.getElementById("gridview-val").rows);
	console.log("paginated");
});

$("table#gridview-val").change(function(){
	alert("yo");
	//document.getElementById("myTable").rows.item(0).innerHTML
});
*/
window.onload=fillHolder();

function fillHolder(){
		var rows = [];
		$("tbody > tr[id*=_]").each(function(i,val) {
    	
    		rows.push(this.firstChild.firstChild.innerHTML);
    	});
    	
    	//console.log(rows);
    	document.getElementById("row_priority").value=JSON.stringify(rows);
}
var status_val = $('tbody').find('a[rel=JoSewing_status]');
//console.log(x);
$(status_val).each(function(i,val) {
	//alert($(this).attr("data-value"));
	//alert(this.className);
	var row = $(this).closest("tr");
	
	if($(this).attr("data-value")=="For Loading"){
			
			//console.log($(row).attr("id"));
			var row_id = $(row).attr("id");
			document.getElementById(row_id).childNodes[1].firstChild.style.color="red";
			document.getElementById(row_id).childNodes[2].firstChild.style.color="red";
			//row.secondChild.style.font="red";
			//row[0].style.font="red";
	}
	
	
}); 


document.getElementById("delivery_date").style="color: #428BCA; text-decoration: none; border-bottom: 1px dashed #08C;";

  
  
$( "td[id=delivery_date]" ).click(function() {
  //alert( "Handler for .click() called." );
  //console.log($(this).html());
  var row = $(this).closest("tr");
  var row_id = $(row).attr("id");
  	var n = row_id.indexOf("_");
 
  var delivery_date_id	=	row_id.substr(0,n);
  var delivery_date 	=	$(this).html();
  
  //var form_action = $("form#dateForm").attr("action");
  //$("form#dateForm").attr("action",form_action+"/"+delivery_date_id);
  
  $("#JoSewing_jo_id").val(delivery_date_id);
  $("form#dateForm > div > div > div > input#JoSewing_delivery_date").val(delivery_date);
  
  $("#JoSewing_delivery_date").data({autoclose: true});
  	$('#JoSewing_delivery_date').datepicker('setDate', new Date(delivery_date));
	$('#JoSewing_delivery_date').datepicker('update');
  //.datepicker("update", delivery_date);
  
  $("#date_delivery_modal").modal({backdrop: "static",
    		keyboard: false  // to prevent closing with Esc button (if you want this too)
		})	
	});


$( "td[id=date_received]" ).click(function() {
  //alert( "Handler for .click() called." );
  //console.log($(this).html());
  var row = $(this).closest("tr");
  var row_id = $(row).attr("id");
  	var n = row_id.indexOf("_");
 
  var date_id	=	row_id.substr(0,n);
  var date_received 	=	$(this).html();
  
  //var form_action = $("form#dateForm").attr("action");
  //$("form#dateForm").attr("action",form_action+"/"+delivery_date_id);
  
  $("#JoSewing_jo_id").val(date_id);
  $("form#dateForm_received > div > div > div > input#JoSewing_date_received").val(date_received);
  
  $("#JoSewing_date_received").data({autoclose: true});
  	$('#JoSewing_date_received').datepicker('setDate', new Date(date_received));
	$('#JoSewing_date_received').datepicker('update');
  //.datepicker("update", delivery_date);
  
  $("#date_received_modal").modal({backdrop: "static",
    		keyboard: false  // to prevent closing with Esc button (if you want this too)
		})	
	});
	
	
$( "td[id=comments]" ).click(function() {	
  var row = $(this).closest("tr");
  var row_id = $(row).attr("id");
  	var n = row_id.indexOf("_");
 
  var date_id	=	row_id.substr(0,n);
  var comments 	=	$(this).html();
  
  //var form_action = $("form#dateForm").attr("action");
  //$("form#dateForm").attr("action",form_action+"/"+delivery_date_id);
  
  	$("#JoSewing_jo_id").val(date_id);
  	if(comments!='none'){
  		$("form#comments_form > div > div > textarea#JoSewing_comments").val(comments);
  	}else{
  		
  		$("form#comments_form > div > div > textarea#JoSewing_comments").attr("placeholder","Enter Comment");
  	}

  
  	$("#comments_modal").modal({backdrop: "static",
    		keyboard: false  // to prevent closing with Esc button (if you want this too)
			
	});
});
	
});


function testLog(){

console.log("test");
}
</script>
<style>
body {
font-size: 10px !important;
}
thead {
font-size: 6px !important;
}
#delivery_date, #date_received, #comments{
color: #428BCA !important;
text-decoration: none !important; 
//border-bottom: 1px dashed #08C !important;
cursor: pointer;
}
</style>
<input type="text" value ='' id="row_priority" />
<input type="text" value ='' id="row_priority2" />
<input type="text" value ='not_changed' id="change_status" /><?php
	$options=JoSewing::model()->getOptions();
	$lines=JoSewing::model()->getLines();
	
/*
	$cs=Yii::app()->clientScript;
       $cs->scriptMap=array(
         'jquery.js'=>false,
         'jquery.ui.js' => false,
        'jquery.min.js'=>false
                ); 
                */
$gridWidget = $this->widget('booster.widgets.TbExtendedGridView', array(
    
    //'fixedHeader' => true,
    
    'sortableRows' => true,
    
    'sortableAttribute' => 'sort_order',
    'sortableAjaxSave' => 'true',
    'sortableAction' => 'joSewing/sortable',
    'afterAjaxUpdate'=>'js:function(tr,rowid,data){
    	//alert("yeess!");
    	console.log("afterAjaxUpdate");
    	document.getElementById("change_status").value="not_changed";
    	//bootbox.alert("I have afterAjax events too! This will only happen once for row with id: "+position);
     	
    	var rows = [];
    	
    	$("tbody > tr[id*=_]").each(function(i,val) {
    	
    		rows.push(this.firstChild.firstChild.innerHTML);
    	});
    	
    	//console.log(rows);
    	
    	document.getElementById("row_priority").value=JSON.stringify(rows);
    }',
    'afterSortableUpdate' => 'js:function(data){
    	//console.log(id);
     	//alert(id+" Yay!"); console.log(id);
     	//console.log($(this));
     	
     		var changed_ids = [];
     		
     		var changed_el_ids = [];
     		
     		var row_vals = [];
     		
     		var data_line1=0;
     		var row_pos = 0;
     		
     	
     	var row_order=JSON.parse(document.getElementById("row_priority").value);
     	
     	var changed_start = 0;
     	
     	var changed_id=null;
     	
     	var get_last = 0;
     	
     	//bootbox.modal("I have afterAjax events too! This will only happen once for row with id: "+position);
     	var line_data=123;
     	//$("#viewModal .modal-body p").html(line_data); 
     	/*$("#viewModal").modal({backdrop: "static",
    		keyboard: false  // to prevent closing with Esc button (if you want this too)
		})		 
     	*/
     	$("tbody > tr[id*=_]").each(function(i,val) {
     	var priority_num = document.getElementById(this.id).firstChild.firstChild.innerHTML;
     	//console.log(row_order[i]+" "+priority_num);
     	///CHANGE THIS
     		if(row_order[i] != priority_num){
     		
     			//CHECK if first changed id
     			if(!changed_start){
     				console.log("start here "+this.id);
     				
     					changed_id=this.id;
     				
     			}else if(changed_start==1){
     					var second = parseInt(document.getElementById(this.id).firstChild.firstChild.innerHTML);
     					var first_plus_1 = (parseInt(document.getElementById(changed_id).firstChild.firstChild.innerHTML)+1);
     					//console.log(second+" "+first_plus_1);
     					if(second == first_plus_1){
     						get_last=1;
     					}
     			}
     		
     			//UNCOMMENT to---------
     			//document.getElementById(this.id).firstChild.firstChild.innerHTML=row_order[i];
     			changed_ids.push(this.id);
     		
     			//DITO ILAGAY
     			
     			changed_start++;
     		}
     	});
     	
     	
     	console.log(changed_ids);
     	var first = 0,
     	 second = 0,
     	 last = 0 ,
     	 second_last = 0;
     	
     	var changed_count = changed_ids.length;
     	var last_index = changed_count - 1;
     	
     	
     	var first =  changed_ids[0];
     	var second = changed_ids[1];
     	var last = changed_ids[last_index] ;
     	var second_last = changed_ids[last_index-1] ;
     	//console.log(first+" "+second+" "+last+" "+second_last);
     	
     	var first_priority_no =  document.getElementById(first).firstChild.firstChild.innerHTML;
     	var second_priority_no = document.getElementById(second).firstChild.firstChild.innerHTML;
     	var last_priority_no = document.getElementById(last).firstChild.firstChild.innerHTML;
     	var second_last_priority_no = document.getElementById(second_last).firstChild.firstChild.innerHTML;
     	
     	//console.log(first_priority_no+" "+second_priority_no+" "+last_priority_no+" "+second_last_priority_no);
     	
     	var changed_id=null;
     	
     	
     	
     	if(parseInt(second_priority_no) == (parseInt(first_priority_no)+1)){
     		changed_id=last;
     	}else if(parseInt(second_priority_no) == (parseInt(first_priority_no)-1)){
     		changed_id=last;
     	}else{
     		changed_id=first;
     	}
     	console.log("changed priority num -- "+changed_id);
     	
     	
     	
     	
     	
     	//console.log(changed_ids);
     	var row = $("#"+changed_id).closest("tr");
     	var rows= $("#"+changed_id).next("tr").attr("id");
 
    	// Get the previous element in the DOM
    	var previous_el = row.prev("tr");
    	var next_el 	= row.next("tr");
    	var current_el 	= $("#"+changed_id);
    	
 
    // Check to see if it is a row
    if (previous_el.is("tr")) {
    	
     	console.log("Current row-"+changed_id);
    	console.log(console.log("Previous Row-"+previous_el.attr("id")));
     	console.log("Next Row-"+next_el.attr("id"));
    }else{
    	
     	console.log("Current row-"+changed_id);
    	console.log(console.log("Previous Row - NONE"));
     	console.log("Next Row-"+next_el.attr("id"));
    }
     	
     	
     	
     			
     	var pn_of_current_row = parseInt(document.getElementById(changed_id).firstChild.firstChild.innerHTML);
     		var n = changed_id.indexOf("_");
  			var current_line = changed_id.substr((n + 1), (changed_id.length));
     	
     	//Check if has PREVIOUS row
     	if (previous_el.is("tr")){
     	var prev_id = previous_el.attr("id");
     	
     	
     		//get priority number of prev row
     		var pn_of_prev_row = parseInt(document.getElementById(prev_id).firstChild.firstChild.innerHTML);
     			var n = prev_id.indexOf("_");
  				var prev_line = prev_id.substr((n + 1), (prev_id.length));
  				
  			//Check if has NEXT row	
     		if (next_el.is("tr")){
     		var next_id = next_el.attr("id");
     		console.log("BEFORE-AFTER");
     		
     			//get priority number of next row
     			var pn_of_next_row = parseInt(document.getElementById(next_id).firstChild.firstChild.innerHTML);
     			var n = next_id.indexOf("_");
  				var next_line = next_id.substr((n + 1), (next_id.length));
     			
     			
     			//console.log(pn_of_prev_row+" "+pn_of_next_row);
     			console.log("Previous row Priority no: "+pn_of_prev_row+" -- Next row Priority no: "+pn_of_next_row);
     			
     			
     			//if BEFORE and AFTER is same with CURRENT ---OR--- //if BEFORE is same with CURRENT
     			if(current_line == prev_line && current_line == next_line){
     			 	console.log("-same");
     			 	//document.getElementById(changed_id).firstChild.firstChild.innerHTML=(parseInt(pn_of_prev_row)+1);
     			 	var itr = pn_of_current_row - 1;
     			 	var itr_up = pn_of_prev_row;
     			 	
     			 	//detect if moving up or down
     			 	var moving = null;
     			 		//if changed id is index 0 -- moved up
     			 		if(	parseInt(changed_id) 	== 	parseInt(	changed_ids[0]	)	){
     			 			moving="UP";
     			 		}
     			 		//if changed id is index length-1 -- moved down
     			 		else if(	parseInt(changed_id) == parseInt(	changed_ids[	(changed_ids.length - 1)	]	)	){
     			 			moving="DOWN";
     			 		}
     			 	
     			 	$.each(changed_ids,function(i,val) {
     		 			
     		 			var next_priority_num = document.getElementById(val).firstChild.firstChild.innerHTML;
     		 			
     		 			
     		 			if(moving == "DOWN"){
     		 				console.log("moving "+moving);
     		 				console.log(next_priority_num+ " - prev(max) " + pn_of_prev_row);
     		 				if(next_priority_num<=(parseInt(pn_of_prev_row))){
     		 					itr = itr+1;
     		 					document.getElementById(val).firstChild.firstChild.innerHTML=itr;
     		 					console.log("new --"+itr);
     		 				}
     		 			}else if(moving == "UP"){
     		 				
     		 				console.log("moving "+moving);
     		 				console.log(next_priority_num+ " - prev(max) " + pn_of_current_row);
     		 				if(next_priority_num<=(parseInt(pn_of_current_row))){
     		 					itr_up = itr_up+1;
     		 					document.getElementById(val).firstChild.firstChild.innerHTML=itr_up;
     		 					console.log("new --"+itr_up);
     		 				}
     		 			}
     		 		} );
     			}
     			
     			//if either BEFORE and AFTER is NOT same with CURRENT
     			else if(current_line != next_line && current_line != prev_line){
     				
     				console.log("not BEFORE-AFTER");
     			 	console.log("not same");
     			 	
     			 	//bootbox.alert("I have afterAjax events too! This will only happen once for row with id: "+position);
     			 
     			}
     			//if BEFORE is same with CURRENT
     			else if(current_line == prev_line){
     			 	console.log("-same with BEFORE");
     			 	//document.getElementById(changed_id).firstChild.firstChild.innerHTML=(parseInt(pn_of_prev_row)+1);
     			 	var itr = pn_of_current_row - 1;
     			 	
     			 	$.each(changed_ids,function(i,val) {
     		 			var next_priority_num = document.getElementById(val).firstChild.firstChild.innerHTML;
     		 			console.log(next_priority_num);
     		 			if(next_priority_num<=(pn_of_prev_row)){
     		 				itr = itr+1;
     		 				document.getElementById(val).firstChild.firstChild.innerHTML=itr;
     		 				console.log("new --"+itr);
     		 			}
     		 		} );
     			}
     			//if AFTER is same with CURRENT
     			else if(current_line == next_line){
     		 		console.log("-same with NEXT");
     		 		
     		 		$("tbody > tr[id*=_"+next_line+"]").each(function(i,val) {
     		 			var next_priority_num = document.getElementById(this.id).firstChild.firstChild.innerHTML;
     		 			console.log(next_priority_num);
     		 			if(next_line<=pn_of_current_row){
     		 				var itr = i+1;
     		 				document.getElementById(this.id).firstChild.firstChild.innerHTML=itr;
     		 				console.log("new --"+itr);
     		 			}
     		 		} );
     			 
     			}
     			
     		//has NO NEXT row. ONLY PREVIOUS row
     		}else{
     	
     		
     		
     		console.log("BEFORE only");
     		
     			//if BEFORE is same with CURRENT
     			if(current_line == prev_line){
     			 	console.log("-same --"+current_line+"--"+prev_line);
     			 	//document.getElementById(changed_id).firstChild.firstChild.innerHTML=(parseInt(pn_of_prev_row)+1);
     			 	var itr = pn_of_current_row - 1;
     			 	
     			 	console.log("Previous row Priority no: "+pn_of_prev_row+"-- Next row Priority no.: NONE");
     			 	
     			 	$.each(changed_ids,function(i,val) {
     		 			var next_priority_num = document.getElementById(val).firstChild.firstChild.innerHTML;
     		 			console.log(next_priority_num);
     		 			if(next_priority_num<=(pn_of_prev_row)){
     		 				itr = itr+1;
     		 				document.getElementById(val).firstChild.firstChild.innerHTML=itr;
     		 				console.log("new --"+itr);
     		 			}
     		 		} );
     			}
     		
     		}
     		
     	//has NO PREVIOUS row. ONLY NEXT row
     	}else{
     	
     		console.log("AFTER only");
     	
     		if (next_el.is("tr")){
     		var next_id = next_el.attr("id");
     		console.log("BEFORE-AFTER");
     		
     			//get priority number of next row
     			var pn_of_next_row = parseInt(document.getElementById(next_id).firstChild.firstChild.innerHTML);
     			var n = next_id.indexOf("_");
  				var next_line = next_id.substr((n + 1), (next_id.length));
     			
     			//if and AFTER is same with CURRENT
     			if(current_line == next_line){
     		 		console.log("-same with NEXT");
     		 	
     		 	
     		 		//get priority number of next row
     				var pn_of_next_row = parseInt(document.getElementById(next_id).firstChild.firstChild.innerHTML);
     				var n = next_id.indexOf("_");
  					var next_line = next_id.substr((n + 1), (next_id.length));
     			
     			
     				console.log("Previous row Priority no: NONE -- Next row Priority no.: "+pn_of_next_row);
     		 	
     		 		//document.getElementById(changed_id).firstChild.firstChild.innerHTML=(parseInt(pn_of_prev_row)+1);
     			 	var itr = pn_of_next_row;
     			 	
     			 	$.each(changed_ids,function(i,val) {
     		 			var next_priority_num = document.getElementById(val).firstChild.firstChild.innerHTML;
     		 			console.log(next_priority_num);
     		 			if(next_priority_num<=(pn_of_current_row)){
     		 				
     		 				document.getElementById(val).firstChild.firstChild.innerHTML=itr;
     		 				console.log("new --"+itr);
     		 				itr = itr+1;
     		 			}
     		 		} );
     			 
     			}//END OF if(current_line == next_line)
     		}//END OF if (next_el.is("tr"))
     			
     	}
     	
     	
     	
     	
     }',
    //'responsiveTable' => true,
    
    'type' => 'striped',
    'headerOffset' => 40,
    // 40px is the height of the main navigation at bootstrap
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{pager}{items}{pager}",
    
    //GRIDVIEW Columns:
    'columns' => array(
		//Priority Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'priority',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
                /*'options' => array(
                	'params' => array('target_end_date'=>"js: function(data){
                			console.log(data);
                		  var row_id = $(this).closest('tr').attr('id');
  						  //var row_id = $(row).attr('id');
  						  
  							var target_end_date = $('#'+row_id).children('td#target_end_date').html();
  							console.log(target_end_date);
  							console.log(row_id);
                		return target_end_date;
                
                	}"),
                ),
                */
                                        
                'success' => 'js: function(response, newValue) {
                				console.log(response.data_params);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							//console.log(response.msg);
				}',
				
				'onShown' => 'js: function(event) {
					var row_id = $(this).closest("tr").attr("id");
					var row_priority_val = document.getElementById(row_id).firstChild.firstChild.innerHTML;
					
  					var tip = $(this).data("editableContainer").tip();
  					tip.find("input").val(row_priority_val);
  					
  					//console.log($(this).closest("tr").attr("id"));
  				}',
  				
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
  							    return "This field is required";
  							} else if ($.trim(value) == "0" || $.trim(value) == 0) {
  							    return "Input must be greater than 0.";
  							} else {
  								//VALUE OF TEXTBOX
  							    var priority_val = $.trim(value);
  								console.log("New Priority No.: "+priority_val);

  							  
  							    var row_id = $(this).closest("tr").attr("id");
  							    
  							    //FIRST VALUE 
  							    var orig_priority_val = document.getElementById(row_id).firstChild.firstChild.innerHTML;
  								console.log("Original Priority No.: "+orig_priority_val);
  							    var n = row_id.indexOf("_");
  							    var data_line = row_id.substr((n + 1), (row_id.length));
  							    
  								console.log("Row ID: "+row_id);
  								console.log("Row Assigned Line: "+data_line);

  							    var move_else_down = 0;
  							    var row = null;

  							    $("tbody > tr[id*=_" + data_line + "]").each(function(i, val) {
  							        var find_row_id = this.id;
  							        
  									console.log("Row "+(i+1)+" ID: "+find_row_id);
  							        
  							        //CURRENT VALUE IN ROWS LOOPED
  							        var find_priority_val = document.getElementById(find_row_id).firstChild.firstChild.innerHTML;
  							       // console.log(document.getElementById(find_row_id).firstChild.firstChild.innerHTML);
  							        
  							        
  							        if (priority_val == find_priority_val && priority_val == orig_priority_val) {
  							            //alert(find_row_id);
  							        } else if (priority_val == find_priority_val && priority_val != orig_priority_val) {
  							            move_else_down = 1;
  							            //console.log("move_else_down " + row_id + " after " + find_row_id);

  							            if (orig_priority_val <= find_priority_val) {
  							                $("tr#" + row_id).insertAfter("tr#" + find_row_id);
  							                //delete this line when have created backtrace function
  							                document.getElementById(find_row_id).firstChild.firstChild.innerHTML = priority_val - 1;
  							                $("tbody > tr[id*=_" + data_line + "]").each(function(i, val) {
												
												/*
  							                	TRAVERSE ALL PRIORITY NUM BEFORE THIS TO ADJUST NUM
  							                	*/
  							                    //if (this.id == find_row_id) {
  							                     //   return false;
  							                    //} else {
  							                        document.getElementById(this.id).firstChild.firstChild.innerHTML = i + 1;
  							                    //}
  							                });
  							                
  							            } else if (orig_priority_val > find_priority_val) {
  							                $("tr#" + row_id).insertBefore("tr#" + find_row_id);
  							                /*
  							                	TRAVERSE ALL PRIORITY NUM AFTER THIS TO ADJUST NUM
  							                	see move_else_down if-else below
  							                	no changes to Priority number but will adjust other val within the row
  							                */
  							            }
  							        }

  							        if (move_else_down) {

  							            if (find_priority_val > orig_priority_val) {
  							                return false;
  							            } else {
  							                document.getElementById(find_row_id).firstChild.firstChild.innerHTML = parseInt(find_priority_val) + 1;
  							            }
  							        }
  							        /*
  							        ADD VALIDATIONS HERE
    								
  							        if input number is > (max + 1) ---- get the max number and promopt admin the correct number (update to correct max priority num?), if YES - apply max num +1 
  							        if input number has same input ---- move to that row and adjust everything downwards
    								
  							        */
  							    });
  							}
  							
  							
    						document.getElementById("change_status").value="changed";
  							}'
            )
        ),
        //JO Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jo',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") 
    							return "This field is required";
					}'
            )
        ),
        //Brand Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'brand',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                'mode' => 'inline',
                'type' => 'select2',
                'source' => $options['Brand'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
				
            )
        ),
        //Quantity Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'quantity',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'attribute'=>'quantity',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )
        ),
        //Category Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'category',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                'mode' => 'inline',
                'type' => 'select2',
                'source' => $options['Category'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
				
            )
        ),
        //Color Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'color',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							
    							var rx = new RegExp(/^[a-zA-Z]+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						
					}'
            )
        ),
        //Date Received Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'date_received',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'type'=>'date',
                
                
            ),
            'htmlOptions' => array('id'=>'date_received',),
        ),
        //Days_needed Field
        array(
            'name' => 'days_needed',
            'value' => '$data->days_needed',
            'htmlOptions' => array('id'=>'days_needed',),
        ),
        //Days_allotted Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'days_allotted',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'days_allotted',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )
        ),
        //Allowance
        array(
            'name' => 'allowance',
            'value' => '$data->allowance',
            'htmlOptions' => array('id'=>'allowance','onclick'=>'testLog();'),
        ),
        //Target End Date Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'target_end_date',
            'sortable' => true,
            'htmlOptions' => array('id'=>'target_end_date',),
        ),
        //Delivery Date Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_date',
            'htmlOptions' => array('id'=>'delivery_date',),
           
        ),
        //Line Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'line',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'brand',
                'mode' => 'inline',
                'type' => 'select2',
                'source' => $lines,
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}'
            )
        ),
        //Status Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'status',
            'sortable' => true,
            'id' => 'status',
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'emptytext' => 'For Loading',
                'mode' => 'inline',
                'type' => 'select2',
                'source' => $options['Status'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}'
            )
        ),
        //Output Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'output',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )
        ),
       //Balance Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'balance',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'balance',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )
        ),
        //Comments Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'comments',
            'sortable' => true,
         	'value'=>'$data->comments==null ? "none" : $data->comments',
           'htmlOptions' => array('id'=>'comments',),
        ),
        //Washing_info Field
         array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'washing_info',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'select2',
                'source' => $options['Washing_Info'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
				'htmlOptions' => array(
        			'options' => array( 
        				'placeholder' => 'for loading',
        			)
    			),
            )
        ),
         //Delivery Receipt
         array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_receipt',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'select2',
                'source' => $options['Delivery_Receipt'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}'
            )
        ),

    ),
    
    'htmlOptions' => array(        
    	'id' => 'gridview-val',
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results', array(
    'class' => 'btn btn-info pull-right'
));

?>



<!-- EDIT Line Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'viewModal',

)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Line:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<div class="topleft" style="position: absolute; font-size: 18px; top: 8px; left: 16px;">
  		
  	
  	</div>
	<div class="topright" style="position: absolute; font-size: 18px; top: 8px; right: 16px;">
		<?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'Line 2',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal','id'=>'option_2'),
            )
        ); ?>
	</div>


</div>
<!-- Popup Footer -->
<div class="modal-footer">

<!-- close button -->

<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>




<!-- EDIT Delivery Date Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'date_delivery_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Delivery Date:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'dateForm',
		'type' => 'horizontal',
		'action'=> array('joSewing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoSewing[jo_id]" id="JoSewing_jo_id" value="" />
		<?php echo $form->datePickerGroup(
			$model,
			'delivery_date',
			
			array(
				'format' => 'yyyy-mm-dd',
				'viewformat' => 'MMM/dd/yy',
				'widgetOptions' => array(
					//'format' => 'yyyy-mm-dd',
        			
					'options' => array(
						'language' => 'en',
					),
				),
				'wrapperHtmlOptions' => array(
					//'value'=>'2016-02-02',
					'class' => 'col-sm-5',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
		<div class="form-actions">
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'ajaxSubmit',
				'context' => 'primary',
				'label' => 'Submit',
				//'type' => 'link',
				'url' => $this->createURL('joSewing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('joSewing/edit'),
                	'data' => "js:{name: 'delivery_date',value: $('#JoSewing_delivery_date').val(), pk: $('#JoSewing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoSewing_jo_id").val();
                				var row = $("tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				var jo_id = $("#"+row+"").children("td#delivery_date").html(data.field_value);
                				//console.log(response);
                                $("#date_delivery_modal").modal("toggle");
                       
                	}',
                )

			)
		); ?>
		</div>

<?php
$this->endWidget();
unset($form); ?>
	</div>
<!-- Popup Footer -->
<div class="modal-footer">

<!-- close button -->

<!-- close button ends-->
</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->


<!-- EDIT Date Received Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'date_received_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Select Date Received:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'dateForm_received',
		'type' => 'horizontal',
		'action'=> array('joSewing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoSewing[jo_id]" id="JoSewing_jo_id" value="" />
		<?php echo $form->datePickerGroup(
			$model,
			'date_received',
			
			array(
				'format' => 'yyyy-mm-dd',
				'viewformat' => 'MMM/dd/yy',
				'widgetOptions' => array(
					//'format' => 'yyyy-mm-dd',
        			
					'options' => array(
						'language' => 'en',
					),
				),
				'wrapperHtmlOptions' => array(
					//'value'=>'2016-02-02',
					'class' => 'col-sm-5',
				),
				//'hint' => 'Click inside! This is a super cool date field.',
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>
		<div class="form-actions">
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'ajaxSubmit',
				'context' => 'primary',
				'label' => 'Submit',
				//'type' => 'link',
				'url' => $this->createURL('joSewing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('joSewing/edit'),
                	'data' => "js:{name: 'date_received',value: $('#JoSewing_date_received').val(), pk: $('#JoSewing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoSewing_jo_id").val();
                				var row = $("tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				var jo_id = $("#"+row+"").children("td#date_received").html(data.field_value);
                				//console.log(response);
                                $("#date_received_modal").modal("toggle");
                       
                	}',
                )

			)
		); ?>
		</div>

	<?php
	$this->endWidget();
	unset($form); ?>
	</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->


<!-- EDIT Comments Popup  -->
<?php $this->beginWidget('booster.widgets.TbModal', array(
	'id'=>'comments_modal',
	'htmlOptions'=>array('style'=>'display:none')
)); ?>
<!-- Popup Header -->
<div class="modal-header">
<h4>Enter Comment:</h4>
</div>
<!-- Popup Content -->
<div class="modal-body" style="position: relative;">

	<!--CONTENT-->

  	<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'comments_form',
		'type' => 'horizontal',
		'action'=> array('joSewing/edit/'),
		//'enableAjaxValidation'=>true,
		
	)
); ?>
		<input type="hidden" name="JoSewing[jo_id]" id="JoSewing_jo_id" value="" />
		<?php echo $form->textAreaGroup(
			$model,
			'comments',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5),
				)
			)
		); ?>
		<div class="form-actions">
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'ajaxSubmit',
				'context' => 'primary',
				'label' => 'Submit',
				//'type' => 'link',
				'url' => $this->createURL('joSewing/edit'),
				'disabled' => false,
				
        		'ajaxOptions' => array(
                	'type' => 'Post',
                	'url' => $this->createURL('joSewing/edit'),
                	'data' => "js:{name: 'comments',value: $('#JoSewing_comments').val(), pk: $('#JoSewing_jo_id').val()}",
                	'success'=>'js:function(response){
                				var jo_id = $("#JoSewing_jo_id").val();
                				var row = $("tbody > tr[id^="+jo_id+"_]").attr("id");
                				
                				var data = JSON.parse(response);
                				
                				var jo_id = $("#"+row+"").children("td#comments").html(data.field_value);
                				//console.log(response);
                                $("#comments_modal").modal("toggle");
                       
                	}',
                )

			)
		); ?>
		</div>

		<?php
		$this->endWidget();
		unset($form); ?>
	</div>
<?php $this->endWidget(); ?>
<!-- View Popup ends -->

<script>
/*window.onbeforeunload = confirmExit;
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
  */
  $('#viewModal').on('hidden.bs.modal', function () {
    // do something…
    //alert("hi");
    console.log("MODAL - EXIT");
});
  $('#date_delivery_modal').on('hidden.bs.modal', function () {
    // do something…
    //alert("hi");
    console.log("MODAL datepicker - EXIT");
});
</script> 
