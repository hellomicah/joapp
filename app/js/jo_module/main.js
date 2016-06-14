//General JS file for JO Module
function testLog(){
	console.log("test include function");
}

function updateJoTargetEndDates(current_line,skip_edit){

	console.log("executing updateJoTargetEndDates function ...");

	getSameLineJos(current_line, function(data){
	
		console.log("--inside getSameLineJos function callback");
	
		var param_jos	 	= 	{};
			param_jos[0]	= 	{};
			param_jos[0]['line']	= 	{};
			
			param_jos[0]['data']	= 	{};
	
		param_jos[0]['line']	= 	current_line;
		//console.log("Show Current Line value");
		//console.log(current_line);
	
			//console.log(data);
		
		var min_max_of_line	=	getMinMaxPriorityNumber(current_line);	
		
		sortSameLinePriorityNumber(current_line,line_jos,min_max_of_line, function(data){
		
			console.log("----inside sortSameLinePriorityNumber function callback");
			
			param_jos[0]['data']	= 	data;
			//console.log(data);
			
			
			/*--START
			 *	this will TRIGGER the backend to ONLY update DAYS_ALLOTTED when...
			 *	value being edited is QTY, else leave DAYS ALLOTTED as is
			 *	 and base the computation of TED from unchanged DA
			 */
			if(skip_edit){
				
				param_jos[0]['skip_edit']	= 	{};
				
				if(skip_edit['name']=="quantity"){
					param_jos[0]['skip_edit']	= 	skip_edit;
				}
			}
			/*--END
			*/
			
			//console.log(param_jos);
			passUpdatedRows(param_jos);
		});
	
	
	});

}

$(document).ready(function() {

	//START ---- 
		var status_val_index = $("tbody").find("tr");
     	$(status_val_index).each(function(i, val) {
     		ted_value = $(this).find("td[id*=target_end_date]").html();
     		dd_value = $(this).find("td[id*=delivery_date]").html();
     	
     		var _MS_PER_DAY = 1000 * 60 * 60 * 24;
			var start = new Date(ted_value);
			var end = new Date(dd_value);
			var y = start.getFullYear();
  // Discard the time and time-zone information.
  			var utc1 = Date.UTC(start.getFullYear(), start.getMonth(), start.getDate());
  			var utc2 = Date.UTC(end.getFullYear(), end.getMonth(), end.getDate());

  //return utc2+utc1;
  			var date_diff =  Math.floor((utc2 - utc1) / _MS_PER_DAY);
     		
     		if(ted_value != null){
     			if(date_diff > 0 && date_diff < 7){
     				$(this).find("td[id*=target_end_date]").attr("style", "color: red !important");
     			}
     		}
     	});

    //START ----- Marks JO and Brand Fields if Status is Blank or 'For Loading'
    
    var status_val = $('tbody').find('a[rel*=_status]');
  
  
    
    $(status_val).each(function(i, val) {
		  //alert(val);
        var row = $(this).closest("tr");
        
            var row_id = $(row).attr("id");

        if ($(this).attr("data-value") == "For Loading" || $(this).attr("data-value") == "") {
			var color = "red";
			$(this).attr("data-value").value = "For Loading";
        }else{
        	var color = "#24CE3E";
        
        }

            //document.getElementById(row_id).childNodes[1].firstChild.style.color = color;
            //document.getElementById(row_id).childNodes[2].firstChild.style.color = color;
            if($(this).attr("rel") == "JoSewing_status"){
				$(row).find('td[class*=JoSewing_jo]').children().attr('style', 'color: '+color+' !important');
				$(row).find('td[class*=JoSewing_brand]').children().attr('style', 'color: '+color+' !important');
			}else{
				$(row).find('td[class*=JoFinishing_jo]').children().attr('style', 'color: '+color+' !important');
				$(row).find('td[class*=JoFinishing_brand]').children().attr('style', 'color: '+color+' !important');
			}
    });
    
	//END ----- Marks JO and Brand Fields if Status is Blank or 'For Loading'


	/*	START ---- Target End Date field value must be RED 
	 *					if date difference value from Delivery Date is less than 7 days 
	 *					both before and after update
	*/

	$("ul.nav-tabs li").click(function() {
	//alert($(this).text());
		var active_tab = $(this).text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
		}else{
			var input_model="Sewing";
	
		}
		
		    var date_val = $('tbody').find('td#Jo'+input_model+'_target_end_date');
			//console.log(date_val);
			$('td[id*=_target_end_date]').each(function(i, val) {

				var row = $(this).closest("tr");
		
					var row_id = $(row).attr("id");
			
		
				var target_end_date = $("tr#"+row_id+" #Jo"+input_model+"_target_end_date").html();
				var delivery_date = $("tr#"+row_id+" #Jo"+input_model+"_delivery_date").html();
				
				//alert(target_end_date);

				checkDeliveryDate(target_end_date, delivery_date );

			});
	});
	

	//	END ---- Target End Date field value must be RED 


	/*
	 * 	COMPUTES the difference between 'Target End Date' and 'Delivery Date'
	*/
	function checkDeliveryDate(target_end_date, delivery_date ){
	

		var parts =target_end_date.split('/');
			var date_str = parts[0]+" "+parts[1]+" "+("20"+parts[2]);
			var new_target_end_date = new Date(date_str); 
			
		
		var parts =delivery_date.split('/');
			var date_str = parts[0]+" "+parts[1]+" "+("20"+parts[2]);
			var new_delivery_date = new Date(date_str); 

		try {
        	var diff = Math.abs(new_delivery_date - new_target_end_date);
        	console.log('DD and TD diff '+row_id+' -- '+diff);
        	if(diff<7){
        		$("#Jo"+input_model+"_target_end_date").css("color","red !important;");
        		console.log($("#Jo"+input_model+"_target_end_date").text());
        	}
			return true;
		} catch (e){
		
			return false;
		}
	
	}
	//ENDOF - checkDeliveryDate function
	

	//Changes CSS style of Delivery Date Column fields to indicate as editable field (for using bootstrap method for Delivery Date)
    document.getElementById("delivery_date").style = "color: #428BCA; text-decoration: none; border-bottom: 1px dashed #08C;";

	//Enables Editable field for Delivery Date Column fields
    $("td[id=delivery_date]").click(function() {
        
        
        if(allowEditable("delivery_date")){
        
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var delivery_date_id = row_id.substr(0, n);
        var delivery_date = $(this).html();

        var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
		}else{
			var input_model="Sewing";
			
		}
		
		$("#Jo"+input_model+"_jo_id").val(delivery_date_id);
        

       
        if(delivery_date.indexOf('none') > -1 || delivery_date.indexOf('0000-00-00') > -1){
			console.log(delivery_date+"--NONE");
			
			var today = new Date(); 
			
			$("form#Jo"+input_model+"_dateForm > div > div > div > input#Jo"+input_model+"_delivery_date").val("");
			
        }else{
			
			var parts =delivery_date.split('/');
			var date_str = parts[0]+" "+parts[1]+" "+("20"+parts[2]);
			var today = new Date(date_str); 
			
			$("form#Jo"+input_model+"_dateForm > div > div > div > input#Jo"+input_model+"_delivery_date").val(today);
			var dateFormat = $( '#Jo'+input_model+'_delivery_date').datepicker( "option", "dateFormat" );
 

			$('#Jo'+input_model+'_delivery_date').datepicker( "option", "dateFormat", "M/D/y" );
			$('#Jo'+input_model+'_delivery_date').datepicker('setDate', today);
        	$('#Jo'+input_model+'_delivery_date').datepicker('update');
		}

        $("#Jo"+input_model+"_date_delivery_modal").modal({
            backdrop: "static",
            keyboard: false // to prevent closing with Esc button (if you want this too)
        });
        }
    });

	//Enables Editable field for Delivery Date Column fields
    $("td[id=audit_date]").click(function() {
        
        if(allowEditable("audit_date")){
        
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var audit_date_id = row_id.substr(0, n);
        var audit_date = $(this).html();

        var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
		}else{
			var input_model="Sewing";
			
		}
		
		$("#Jo"+input_model+"_jo_id").val(audit_date_id);
        

       
        if(audit_date.indexOf('none') > -1 || audit_date.indexOf('0000-00-00') > -1){
			console.log(audit_date+"--NONE");
			
			var today = new Date(); 
			
			$("form#Jo"+input_model+"_dateForm_audit > div > div > div > input#Jo"+input_model+"_audit_date").val("");
			
        }else{
			
			var parts =audit_date.split('/');
			var date_str = parts[0]+" "+parts[1]+" "+("20"+parts[2]);
			var today = new Date(date_str); 
			
			$("form#Jo"+input_model+"_dateForm_audit > div > div > div > input#Jo"+input_model+"_audit_date").val(today);
			var dateFormat = $( '#Jo'+input_model+'_audit_date').datepicker( "option", "dateFormat" );
 

			$('#Jo'+input_model+'_audit_date').datepicker( "option", "dateFormat", "M/D/y" );
			$('#Jo'+input_model+'_audit_date').datepicker('setDate', today);
        	$('#Jo'+input_model+'_audit_date').datepicker('update');
		}


        $("#audit_date_modal").modal({
            backdrop: "static",
            keyboard: false // to prevent closing with Esc button (if you want this too)
        });
        }
    });
	//Enables Editable field for Date Received Column fields
    $("td[id=date_received]").click(function() {
        //alert( "Handler for .click() called." );
        if(allowEditable("date_received")){
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        var date_received = $(this).html();

        //var form_action = $("form#dateForm").attr("action");
        //$("form#dateForm").attr("action",form_action+"/"+delivery_date_id);

		var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
		}else{
			var input_model="Sewing";
			
		}
		console.log(date_id+"--Jo"+input_model+"_dateForm_received");
        $("#Jo"+input_model+"_jo_id").val(date_id);
        

       
        if(date_received.indexOf('none') > -1 || date_received.indexOf('0000-00-00') > -1){
			console.log(date_received+"--NONE");
			
			var today = new Date(); 
			
			$("form#Jo"+input_model+"_dateForm_received > div > div > div > input#Jo"+input_model+"_date_received").val("");
			
        }else{
			
			var parts =date_received.split('/');
			var date_str = parts[0]+" "+parts[1]+" "+("20"+parts[2]);
			var today = new Date(date_str); 
			
			$("form#Jo"+input_model+"_dateForm_received > div > div > div > input#Jo"+input_model+"_date_received").val(today);
			var dateFormat = $( '#Jo'+input_model+'_date_received').datepicker( "option", "dateFormat" );
 

			$('#Jo'+input_model+'_date_received').datepicker( "option", "dateFormat", "M/D/y" );
			$('#Jo'+input_model+'_date_received').datepicker('setDate', today);
        	$('#Jo'+input_model+'_date_received').datepicker('update');
		}

        
        //.datepicker("update", delivery_date);

        $("#Jo"+input_model+"_date_received_modal").modal({
            backdrop: "static",
            keyboard: false // to prevent closing with Esc button (if you want this too)
        });
        }
    });

	//Enables Editable field for Comments Column fields
    $("td[id=comments]").click(function() {
    
    	if(allowEditable("comments")){
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        var comments = $(this).html();

		
		var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
		}else{
			var input_model="Sewing";
			
		}
		
        $("#Jo"+input_model+"_jo_id").val(date_id);
        
        if (comments != 'none') {
            $("form#Jo"+input_model+"_comments_form > div > div > textarea#Jo"+input_model+"_comments").val(comments);
        } else {

            $("form#Jo"+input_model+"_comments_form > div > div > textarea#Jo"+input_model+"_comments").attr("placeholder", "Enter Comment");
        }
		console.log("#Jo"+input_model+"_comments_modal");
        $("#Jo"+input_model+"_comments_modal").modal({
            backdrop: "static",
            keyboard: false // to prevent closing with Esc button (if you want this too)

        });
        }
    });
    $("td[id=output]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        
        
		var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
			var input_controller="finishing";
			var input_id="-finishing";
			
		}else{
			var input_model="Sewing";
			var input_controller="sewing";
			var input_id="";
			
			
		}
        if(allowEditable("output")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Output',
                           name:  'output',
                           url:   input_controller+'/edit/',  
                           placement: 'left',
                           params: function(params) {
                           //"td.Jo"+input_model+"_
        					//originally params contain pk, name and value
        						//get Quantity
        						var quantity=$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_quantity").html();
        						var balance=$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_balance").html();
        						//compute new Balance value = QUANTITY - OUTPUT
        						var new_balance = parseInt(quantity) - parseInt(params.value);
        						
        						
        						console.log(quantity + " " + params.value  + " old - " + balance  + " new - " + new_balance)
        						if(new_balance==0){
        							$("#gridview-val"+input_id+" tr#"+row_id).children("td#status").text("Done");
        						}else{
        							if( balance == '0' || balance ==0){
        								if(parseInt(params.value) < parseInt(quantity)){
        								$("table > tbody > tr#"+row_id).children("td.Jo"+input_model+"_status").html('<a class="editable editable-click editable-empty" data-value="For Loading" href="#" rel="'+input_model+'_status" data-pk="'+params.pk+'">For Loading</a>');
        								}
        							}
        						}
        						
        						$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_balance").html(new_balance);
        						//pass new Balance value to parameter
        						params.balance = new_balance;
        						return params;
    						},


                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
    
    
    $("td[id=quantity]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        var current_line = row_id.substr((n + 1), (changed_id.length));
        //console.log("output");
        
        
		var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
			var input_controller="finishing";
			var input_id="-finishing";
			
		}else{
			var input_model="Sewing";
			var input_controller="sewing";
			var input_id="";
			
			
		}
        if(allowEditable("quantity")){
         $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Quantity',
                           name:  'quantity',
                           url:   input_controller+'/edit/',  
                           placement: 'right',
                           params: function(params) {
                           //"td.Jo"+input_model+"_
        					//originally params contain pk, name and value
        						//get Quantity
        						var output=$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_output").html();
        						var balance=$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_balance").html();
        						//compute new Balance value = QUANTITY - OUTPUT
        						var new_balance = parseInt(params.value) - parseInt(output);
        						
        						
        						console.log(params.value  + " old BAL - " + balance  + " new BAL - " + new_balance)
        						if(new_balance==0){
        							$("#gridview-val"+input_id+" tr#"+row_id).children("td#status").text("Done");
        						}else{
        							if( balance == '0' || balance ==0){
        								//if(parseInt(params.value) < parseInt(quantity)){
        								//$("table > tbody > tr#"+row_id).children("td.Jo"+input_model+"_status").html('<a class="editable editable-click editable-empty" data-value="For Loading" href="#" rel="'+input_model+'_status" data-pk="'+params.pk+'">For Loading</a>');
        								//}
        							}
        						}
        						
        						
        						$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_balance").html(new_balance);
        						
        						//pass new Balance value to parameter
        						params.balance = new_balance;
        						params.line = current_line;
        						return params;
    						},


                           success: function(response, newValue) {
                				//console.log(response.oldValue);
                				response=JSON.parse(response);
  								if (!response.success) {
    								return response.msg;
    								
    							}else{
    								$("#gridview-val"+input_id+" tr#"+row_id).children("td#quantity").html(response.field_value); 
    								$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_days_needed").html(response.data_params['days_needed']);
        							$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_days_allotted").html(response.data_params['days_allotted']);
        							$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_allowance").html(response.data_params['allowance']);
        							//$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_quantity").html(response.data_params['field_value']);
        						
        							var current_line=	response.data_params['line'];
        							//var line_jos	=	getSameLineJos(current_line);
    				
    								//SKIPPING Days Allotted to be updated to prevent being overriden
    									
											data_updated = {};
											data_updated["name"] = {};
											data_updated["jo_id"] = {};
											data_updated["name"] = 'quantity';
											data_updated["jo_id"] = date_id;
    							
    				
    				
    								//Update Target End Dates of the same Line to reflect new dates based on new QTY value
        							updateJoTargetEndDates(current_line,data_updated /*TO-SKIP-EDIT-OF-DA*/);
    				

    							
    							}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
    $("td[id=days_allotted]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        
        
		var active_tab = $("ul.nav-tabs li.active").text();
		
        if(active_tab.trim() == "Finishing"){
			var input_model="Finishing";
			var input_controller="finishing";
			var input_id="-finishing";
			
		}else{
			var input_model="Sewing";
			var input_controller="sewing";
			var input_id="";
			
			
		}
		
		if(allowEditable("days_allotted")){
		console.log("editable");
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Days Allotted',
                           name:  'days_allotted',
                           url:   input_controller+'/edit/',  
                           placement: 'left',
                           params: function(params) {
                           //"td.Jo"+input_model+"_
        					//originally params contain pk, name and value
        						//get Quantity
        						var days_needed=$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_days_needed").html();
        						var days_alotted=params.value;
        						//compute new Balance value = QUANTITY - OUTPUT
        						var new_allowance = (parseFloat(days_alotted) - parseFloat(days_needed)).toFixed(2);
        						
        						
        						var checkAllowance = Math.ceil(new_allowance) - new_allowance;
        						
        						if(checkAllowance == 1 || checkAllowance == 0){
        							 new_allowance = parseFloat(new_allowance);
        						}
        						
        						console.log(days_alotted + " - " + days_needed  + " - " + new_allowance);

        						//pass new Balance value to parameter
        						params.allowance = new_allowance;
        						return params;
    						},

							
							/*onShown: function(event) {
					
								var tip = $(this).data("editableContainer").tip();
					
								//Retrieves the actual row data value and auto-fill the input/select field on popover editable
								tip.find("span.select2-chosen").html($(this).select2("data").text());
								tip.find("input.select2-offscreen").val($(this).select2("data").attr("id"))

					
							}',*/
							
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
                				response=JSON.parse(response);
  								if (!response.success) {
    								return response.msg;
    								
    							}else{
    								$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_allowance").html(response.data_params['allowance']);
        							$("#gridview-val"+input_id+" tr#"+row_id).children("td#days_allotted").html(response.field_value); 
        							
        							var current_line=	response.data_params['new_target_end_date']['line'];
        							//var line_jos	=	getSameLineJos(current_line);
    				
    								
    								//Update Target End Dates of the same Line to reflect new dates based on new DA value
        							updateJoTargetEndDates(current_line);
        							
        							$(this).val(response.field_value);
        						}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var days_needed=$("#gridview-val"+input_id+" tr#"+row_id).children("td.Jo"+input_model+"_days_needed").html();
        						
    						
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}else if(parseFloat(value) < parseFloat(days_needed) ){
    								return "value must be at least equal to Days Needed value.";
    							}
    							
    						}
						}
        });
        }
    });
    
    
    $("td[id=delivery_1]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("delivery_1")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Delivery 1',
                           name:  'delivery_1',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "delivery_1",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
    
    $("td[id=delivery_2]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("delivery_2")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Delivery 2',
                           name:  'delivery_2',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "delivery_2",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
    
    $("td[id=delivery_3]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("delivery_3")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Delivery 3',
                           name:  'delivery_3',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "delivery_3",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
    
    
    
    $("td[id=delivery_4]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("delivery_4")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Delivery 4',
                           name:  'delivery_4',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "delivery_4",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
    
    
    $("td[id=delivery_5]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("delivery_5")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Delivery 5',
                           name:  'delivery_5',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "delivery_5",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });


	function getTotalDelivered(row_id, param, value){
    	var tab = getActiveTab();
    	//console.log(tab.input_id);
    	
    	var salesman_sample	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_salesman_sample").html();
    	var delivery_1	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_delivery_1").html();
    	var delivery_2	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_delivery_2").html();
    	var delivery_3	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_delivery_3").html();
    	var delivery_4	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_delivery_4").html();
    	var delivery_5	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_delivery_5").html();
    	var second_quality	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_second_quality").html();
    	var unfinished	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_unfinished").html();
    	var lacking	=	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_lacking").html();
    	
    	if(param=="salesman_sample"){
    		salesman_sample = value;
    	}
    	else if(param=="delivery_1"){
    		delivery_1 = value;
    	}
    	
    	else if(param=="delivery_2"){
    		delivery_2 = value;
    	}
    	else if(param=="delivery_3"){
    		delivery_3 = value;
    	}
    	else if(param=="delivery_4"){
    		delivery_4 = value;
    	}
    	else if(param=="delivery_5"){
    		delivery_5 = value;
    	}
    	
    	else if(param=="second_quality"){
    		second_quality = value;
    	}
    	
    	else if(param=="unfinished"){
    		unfinished = value;
    	}
    	
    	else if(param=="lacking"){
    		lacking = value;
    	}
		//compute new Total Delivered value
		var new_total_delivered = parseInt(salesman_sample) + parseInt(delivery_1) + parseInt(delivery_2) + parseInt(delivery_3) + parseInt(delivery_4) + parseInt(delivery_5) + parseInt(second_quality) + parseInt(unfinished) + parseInt(lacking);
    	$("#gridview-val"+tab.input_id+" tr#"+row_id).children("td.Jo"+tab.input_model+"_total_delivered").html(new_total_delivered);	
    				
        return new_total_delivered;
    }
    
    function getActiveTab(){
    
    	var params = {};
    
    	var active_tab = $("ul.nav-tabs li.active").text();
		
		if(active_tab.trim() == "Finishing"){
			params['input_model']="Finishing";
			params['input_controller']="finishing";
			params['input_id']="-finishing";
			
		}else{
			params['input_model']="Sewing";
			params['input_controller']="sewing";
			params['input_id']="";
			
			
		}
		
		return params;
    }
    
    function getCurrentRole(){
    	return 	document.getElementById("access").value;
    }
    
    function allowEditable(field){
    
    	var role	=	getCurrentRole();
    
    	switch (role) {
			case "Global Viewer":
				return false;
				break;
			case "Production Head":
				return true;
				break;
			case "Sewing Output & Status Controller":
				if(field=="status" || field=="output"){
					return true;
				}
				break;
			case "Finishing Output & Status Controller":
				if(field=="status" || field=="output" || field=="total_delivered" || field=="salesman_sample" || field=="unfinished" || field=="lacking" || field=="second_quality" || field=="delivery_1" || field=="delivery_12" || field=="delivery_3" || field=="delivery_4" || field=="delivery_5"){
					return true;
				}
				break;
			case "Line Head":
				if(field=="status"){
					return true;
				}
				break;
			default:
				return false;
		} 
    }
    
    $("td[id=salesman_sample]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        
        if(allowEditable("salesman_sample")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Salesman Sample',
                           name:  'salesman_sample',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "salesman_sample",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        
        }
    });
    
    $("td[id=second_quality]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("second_quality")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Second Quality',
                           name:  'second_quality',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "second_quality",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });   
    
    $("td[id=unfinished]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("unfinished")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter Unfinished',
                           name:  'unfinished',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "unfinished",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    

    $("td[id=lacking]").click(function() {
        var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);
        //console.log("output");
        if(allowEditable("lacking")){
        $(this).editable({
        	                type:  'text',
                           pk:    date_id,
                           title: 'Enter lacking',
                           name:  'lacking',
                           url:   'finishing/edit/',  
                           placement: 'left',
                           
			params: function(params) {
                    //alert("success");
					var new_total_delivered = getTotalDelivered(row_id, "lacking",params.value);
					
					
        			
        			params.total_delivered = new_total_delivered;
        			return params;
    		},
                           success: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
						},
                		validate: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
						}
        });
        }
    });
    
  

});