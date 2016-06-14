//All JS functions for After Sortable Event

var PAGE_SIZE = 50;

$(document).ready(function() {
	Array.prototype.max = function() {
	  return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
	  return Math.min.apply(null, this);
	};


	$("tbody").sortable({         
	    
	    start: function(event, ui) {
        	ui.item.data('originIndex', ui.item.index());
		},
		
		beforeStop: function(event, ui) {
            newIndex = $(ui.helper).index("tbody tr");
            theID = ui.helper.attr("id");
            
    		var originIndex = ui.item.data('originIndex');
          	var currentIndex = ui.placeholder.index();
          	
          	//if (currentIndex > originIndex)
          	//{
              //currentIndex -= 1;
          	//}

          	console.log("Original Position : "+originIndex+" -- Current Position : "+currentIndex);
			
			var changed_id = theID;
			
			
			$("input#changed_id").val(changed_id);
			$("input#changed_index").val(currentIndex-1);
			
        } ,
        
        stop: function (event, ui) { 
        	console.log("------------------------------------------------");
        	var row_pos	=	$("input#changed_index").val();
        
        	var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
            $("body").append(div_val);
            
        	//Element attribute ID of moved row
        	var changed_id = $("input#changed_id").val();
				
        		//Get ROW Element of moved row
        		var row = $("#"+changed_id).closest("tr");
    
        		
        		var rowElement 		=	getAfterSortableRowElements();
        		
			
					var current_line	=	rowElement.current.line;
				
					var prev_line		=	rowElement.previous.line;
				
					var next_line		=	rowElement.next.line;
			
			
			var param_jos	 	= 	{};
				param_jos[0]	= 	{};
				param_jos[0]['line']	= 	{};
				param_jos[0]['data']	= 	{};
				param_jos[0]['skip_edit']	= 	{};
				
				
			   /*--START
				*  to be used to update DN & DA, then TED
				*   	triggers model to update ^
			    */
					data_updated = {};
					data_updated["name"] = {};
					data_updated["jo_id"] = {};
					data_updated["name"] = 'priority';
					data_updated["jo_id"] = changed_id;
					
					param_jos[0]['skip_edit']	= 	data_updated;
			   /*
			    *--END
			    */
		
			//Check if has PREVIOUS row
			if (prev_line !== 'undefined' && prev_line >= 0){
				
				//Check if has NEXT row	
				if (next_line !== 'undefined' && next_line >= 0){
					
					console.log("BEFORE-AFTER");
				
					//if BEFORE and AFTER is same with CURRENT ---OR--- //if BEFORE is same with CURRENT
					if(current_line == prev_line && current_line == next_line){
						console.log("---same Line with BEFORE and AFTER");
						
						
					
						var line_jos	=	getSameLineJos(current_line);
						
						//console.log(line_jos.id);
						//console.log(line_jos.priority);
				 		var min_max_of_line	=	getMinMaxPriorityNumber(current_line);
				 		
						param_jos[0]['line']	= 	current_line;
						param_jos[0]['data']	= 	sortSameLinePriorityNumber(current_line,line_jos,min_max_of_line);
				 		passUpdatedRows(param_jos);
						
						
					}
				
					//if either BEFORE and AFTER is NOT same with CURRENT
					else if(current_line != next_line && current_line != prev_line){
					
						console.log("---not same with BEFORE-AFTER");
						
						console.log("---CHOOSE which LINE--");
					
						if(next_line==prev_line){
							//when two (2) different Lines are involved
							console.log("---in between 2 same LINE--");
						
							var line_jos = getSameLineJos(prev_line);
							param_jos	=	moveRowToAnotherLine(prev_line,line_jos, changed_id);
							
							
							passUpdatedRows(param_jos);
						}
						else{
							//when three (3) different Lines are involved
							console.log("---in between 2 different LINE--");
							console.log(prev_line+" - "+next_line+" - "+current_line);
							
							
							
							if( (parseInt(prev_line)>=0 && next_line=='') || (prev_line=='' && parseInt(next_line)) ){
								/*SORT and UPDATE whatever is selected among 2 Lines*/
								//showLineSelectModal(prev_line, next_line);
							//}else{
								
								if(parseInt(prev_line)>=0){
									chosen_line=parseInt(prev_line);
								}else if(parseInt(next_line)>=0){
									chosen_line=parseInt(next_line);
								
								}
								
								var line_jos	=	getSameLineJos(chosen_line);
						
								//console.log(line_jos.id);
								//console.log(line_jos.priority);
						
								if(inArray(chosen_line,line_jos.id)){
									console.log("-----has chosen SAME LINE - "+chosen_line);
									var min_max_of_line	=	getMinMaxPriorityNumber(chosen_line);
									
									sortSameLinePriorityNumber(chosen_line,line_jos,min_max_of_line);
								}else{
									console.log("-----has chosen DIFFERENT Line - "+chosen_line);
			
			
									var changed_row_id = $("input#changed_id").val();
			
									var params = {};
									params = moveRowToAnotherLine(chosen_line,line_jos, changed_row_id);
									//console.log(params);
			
			
									passUpdatedRows(params);
								}
									
								//remove loading div					
								removeLoadingDiv();
								
							} else{
							
								showLineSelectModal(prev_line, next_line);
							}
							
							
						}
						
					}
					//if BEFORE is same with CURRENT
					else if(current_line == prev_line){
						console.log("---same with BEFORE");
						console.log("---CHOOSE which LINE--");
						
						//console.log("here");
						//showLineSelectModal(prev_line, next_line);
						
						if(parseInt(next_line)>0){
						
							showLineSelectModal(prev_line, next_line);
						
						
						}else{
						
						
							var line_jos	=	getSameLineJos(current_line);
						
							//console.log(line_jos.id);
							//console.log(line_jos.priority);
							var min_max_of_line	=	getMinMaxPriorityNumber(current_line);
						
						
							param_jos[0]['line']	= 	current_line;
							param_jos[0]['data']	= 	sortSameLinePriorityNumber(current_line,line_jos,min_max_of_line);
							passUpdatedRows(param_jos);
						
						}
					}
					//if AFTER is same with CURRENT
					else if(current_line == next_line){
						console.log("---same with NEXT.");
						console.log("----Previous Line is "+prev_line);
						if(prev_line !== 'undefined' && prev_line >= 0 && prev_line!=='' && prev_line!=='null' && row_pos >0){
							console.log("---CHOOSE which LINE--");
							showLineSelectModal(prev_line, next_line);
						}else{
							console.log("---is on TOP of LINE in current view table--");
							updateJoTargetEndDates(current_line);
						}
				 
					}
				
				//has NO NEXT row. ONLY PREVIOUS row
				}
				else{
		
					console.log("BEFORE only");
			
					//if BEFORE is same with CURRENT
					if(current_line == prev_line){
						console.log("---same with BEFORE");
						
						var line_jos	=	getSameLineJos(current_line);
						
						//console.log(line_jos.id);
						//console.log(line_jos.priority);
						var min_max_of_line	=	getMinMaxPriorityNumber(current_line);
				 		
				 		param_jos[0]['line']	= 	current_line;
						param_jos[0]['data']	= 	sortSameLinePriorityNumber(current_line,line_jos,min_max_of_line);
				 		passUpdatedRows(param_jos);
					}
			
				}
			
			//has NO PREVIOUS row. ONLY NEXT row
			}
			else{
		
				console.log("AFTER only");
		
				if (next_line !== 'undefined' && next_line >= 0){
				
					//if and AFTER is same with CURRENT
					if(current_line == next_line){
						console.log("---same with NEXT");
				
						
						var line_jos	=	getSameLineJos(current_line);
						
						//console.log(line_jos.id);
						//console.log(line_jos.priority);
						var min_max_of_line	=	getMinMaxPriorityNumber(current_line);
				 		
				 		param_jos[0]['line']	= 	current_line;
						param_jos[0]['data']	= 	sortSameLinePriorityNumber(current_line,line_jos,min_max_of_line);
				 		passUpdatedRows(param_jos);
				 		
					}//END OF if(current_line == next_line)
					
					
					
					
				}//END OF if (next_el.is("tr"))
				
			}//END of else
			
			
			//console.log(param_jos);
        }
	});

    $("button[id=option_2]").click(function() {
    	//$("#chosen_line").val($(this).children("span").text());
    	$("#chosen_line").val($(this).children("span#line_B").attr("data-line"));
    	
    	
    	var chosen_line	= $(this).children("span#line_B").attr("data-line");
    	
    	var line_jos	=	getSameLineJos(chosen_line);
						
		console.log(line_jos.id);
		console.log(line_jos.priority);
		
		if(inArray(chosen_line,line_jos.id)){
			console.log("-----has chosen SAME LINE - "+chosen_line);
			var min_max_of_line	=	getMinMaxPriorityNumber(chosen_line);
			
			sortSameLinePriorityNumber(chosen_line,line_jos,min_max_of_line);
		}else{
			console.log("-----has chosen DIFFERENT Line - "+chosen_line);
			
			var changed_row_id = $("input#changed_id").val();
        	
        	/*SORT and UPDATE Line JO's of new Line*/
        	var params = {};
        		params = moveRowToAnotherLine(chosen_line,line_jos, changed_row_id);
				console.log(params);
			
				passUpdatedRows(params);
		}
		
    });
    $("button[id=option_1]").click(function() {
    	//$("#chosen_line").val($(this).children("span").text());
    	$("#chosen_line").val($(this).children("span#line_A").attr("data-line"));
    	
    	
    	var chosen_line	= $(this).children("span#line_A").attr("data-line");
    	
    	var line_jos	=	getSameLineJos(chosen_line);
						
		console.log(line_jos.id);
		console.log(line_jos.priority);
				 		
		if(inArray(chosen_line,line_jos.id)){
			console.log("-----has chosen SAME LINE - "+chosen_line);
			var min_max_of_line	=	getMinMaxPriorityNumber(chosen_line);
			
			sortSameLinePriorityNumber(chosen_line,line_jos,min_max_of_line);
		}else{
			console.log("-----has chosen DIFFERENT Line - "+chosen_line);
			
			
        	var changed_row_id = $("input#changed_id").val();
			
			var params = {};
        	params = moveRowToAnotherLine(chosen_line,line_jos, changed_row_id);
			console.log(params);
			
			
			passUpdatedRows(params);
		}
    });
    
});
	function passUpdatedRows(data){
		
		pathArray = location.href.split( '/' );
		protocol = pathArray[0];
		host = pathArray[2];
		url = protocol + '//' + host;
		
		var active_tab = getActiveTab();
		
		if(active_tab.input_model == "Finishing"){
			var url=location.origin+"/jo_manager_live/joFinishing/updateJos";
		}else{
			var url=location.origin+"/jo_manager_live/joSewing/updateJos";
			
		}
		
		
		$.ajax({
			url: url,
			type: "POST",
			data: {updated : data},
			dataType:'json',
			success: function(data){
				console.log(data.data);
				
				for(var i in data.data){
				//update Target End Date
					//console.log(ctr);
					for(var ctr in data.data[i]){
					   var target_end_date	=	data.data[i][ctr]['target_end_date'];
					   var line			= 	data.data[i][ctr]['line'];
					   var line_name	= 	data.data[i][ctr]['line_name'];
					   var jo_id		= 	data.data[i][ctr]['jo_id'];
					   var days_needed	= 	data.data[i][ctr]['days_needed'];
					   var allowance	= 	data.data[i][ctr]['allowance'];
					   var days_allotted= 	data.data[i][ctr]['days_allotted'];
					   
					   console.log(data.data[i][ctr]['target_end_date']);
					
					   var row_id = jo_id+"_"+line;
					   $("#gridview-val"+active_tab.input_id+" tr#"+row_id).children("td#target_end_date").text(target_end_date);
					   $("#gridview-val"+active_tab.input_id+" tr#"+row_id).children("td#days_needed").text(days_needed);
					   $("#gridview-val"+active_tab.input_id+" tr#"+row_id).children("td#allowance").text(allowance);
					   $("#gridview-val"+active_tab.input_id+" tr#"+row_id).children("td#days_allotted").text(days_allotted);
					   
					   
					   $("#gridview-val"+active_tab.input_id+" tr#"+row_id+" td#line").children("a").html(line_name);
					   $("#gridview-val"+active_tab.input_id+" tr#"+row_id+" td#line").children("a").attr("data-value",line);
					}
				}
				
				//Remove Loading GIF
				removeLoadingDiv();
			}
		});
		
	}

	function removeLoadingDiv(){
	
		//Remove Loading GIF
		var oP = document.getElementById("loading_div");
		if(document.body.contains(oP)){
			document.body.removeChild(oP);
		}
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
    
    
	function getAfterSortableRowElements(){
		var active_tab = getActiveTab();
	
		line_jos = new Array();
		
		line_jos["previous"] = new Array();
		line_jos["current"] = new Array();
		line_jos["next"] = new Array();
		
		
			 line_jos["previous"]["id"] = new Array();
			 line_jos["current"]["id"] = new Array();
			 line_jos["next"]["id"] = new Array();
		
			 line_jos["previous"]["priority"]=	new Array();
			 line_jos["current"]["priority"]=	new Array();
			 line_jos["next"]["priority"]	=	new Array();
		
		
			 line_jos["previous"]["line"] = new Array();
			 line_jos["current"]["line"] = new Array();
			 line_jos["next"]["line"] = new Array();
		
		
		
		//Element attribute ID of moved row
		var changed_id = $("input#changed_id").val();
		line_jos["current"]["id"]	=	changed_id;
		
			//console.log("Current row-"+changed_id);
			
			//Get ROW Element of moved row
			var row = $("#"+changed_id).closest("tr");
		
		
		
		//Set moved row as CURRENT element
		var current_el 	= $("#"+changed_id);
		
		
		var pn = $("#gridview-val"+active_tab.input_id+" tr#"+changed_id).children("td.Jo"+active_tab.input_model+"_priority").text();
		
		//var pn_of_current_row = parseInt(document.getElementById(changed_id).firstChild.firstChild.innerHTML);
		var pn_of_current_row = parseInt(pn);
		line_jos["current"]["priority"] = pn_of_current_row;
		
			var n = changed_id.indexOf("_");
			var current_line = changed_id.substr((n + 1), (changed_id.length));
			line_jos["current"]["line"] = current_line;
		
		
		// Get the PREVIOUS element of moved row
		var previous_el = row.prev("tr");
		
			// Check to see if PREVIOUS row is a row (tr) element
			if (previous_el.is("tr")) {
			
				//console.log("Previous Row-"+previous_el.attr("id"));
				
				//Get ID of PREVIOUS row
				var prev_id = previous_el.attr("id");
				line_jos["previous"]["id"] = prev_id;
				
				//get priority number of prev row
				//var pn_of_prev_row = parseInt(document.getElementById(prev_id).firstChild.firstChild.innerHTML);
				var pn = $("#gridview-val"+active_tab.input_id+" tr#"+prev_id).children("td.Jo"+active_tab.input_model+"_priority").text();
				var pn_of_prev_row = parseInt(pn);
				line_jos["previous"]["priority"] = pn_of_prev_row;
				
					var n = prev_id.indexOf("_");
					var prev_line = prev_id.substr((n + 1), (prev_id.length));
					line_jos["previous"]["line"] = prev_line;
					
			}
		
		//Get NEXT row of moved row
		var next_el 	= $("tr#"+changed_id).next();
			
			// Check to see if NEXT row is a row (tr) element
		   if (next_el.is("tr")) {
		   
			   //console.log("Next Row-"+next_el.attr("id"));
			   
			   //Get ID of NEXT row
			   var next_id = next_el.attr("id");
			   line_jos["next"]["id"] = next_id;
			   
				//get priority number of next row
				//var pn_of_next_row = parseInt(document.getElementById(next_id).firstChild.firstChild.innerHTML);
				var pn = $("#gridview-val"+active_tab.input_id+" tr#"+next_id).children("td.Jo"+active_tab.input_model+"_priority").text();
				var pn_of_next_row = parseInt(pn);
				line_jos["next"]["priority"] = pn_of_next_row;
				
					var n = next_id.indexOf("_");
					var next_line = next_id.substr((n + 1), (next_id.length));
					line_jos["next"]["line"] = next_line;
		   }
		
		return line_jos;
	}
	
	function sortSameLinePriorityNumber(line_number,line_jos,min_max_of_line,callback){
		var active_tab = getActiveTab();
	
		var	line_jo_ids	=	line_jos.id;
		var	line_jo_prioritys	=	line_jos.priority;
		
		//var min_priority	=	line_jo_prioritys.min();
		var min_priority	=	parseInt(min_max_of_line.min_priority);
		//console.log(line_jos);
			
		//var max_priority	=	line_jo_prioritys.max();
		var max_priority	=	parseInt(min_max_of_line.max_priority);
	
		console.log("--Line: "+line_number+" - MIN: "+min_priority+ " - MAX: "+max_priority);
	
		var table_rows_holder = [];
		
		var param_jos = {};
	
		var param_ctr	=	0;
		
		$("#gridview-val"+active_tab.input_id+" tr[id*=_"+line_number+"]").each(function(i,val) {
		//$("tbody > tr[id*=_"+line_number+"]").each(function(i,val) {
			if(inArray(this.id,table_rows_holder)){
				return false;
			}else{
				var row_id	= 	this.id;
				table_rows_holder.push(row_id);
				
				var priority	=	min_priority + i;
				//console.log("#gridview-val"+active_tab.input_id+" tr#"+row_id+" td.Jo"+active_tab.input_model+"_priority");
				//console.log("OLD -- "+$("#gridview-val"+active_tab.input_id+" tr#"+row_id+" td.Jo"+active_tab.input_model+"_priority").children("a").html());
				$("#gridview-val"+active_tab.input_id+" tr#"+row_id+" td.Jo"+active_tab.input_model+"_priority").children("a").html(priority);
				//console.log("NEW -- "+$("#gridview-val"+active_tab.input_id+" tr#"+row_id+" td.Jo"+active_tab.input_model+"_priority").children("a").html());
				//var current_row	=	document.getElementById(row_id).firstChild.firstChild;
				//console.log(current_row.innerHTML);
				//current_row.innerHTML	=	priority;
				//console.log(row_id +" New priority num - "+priority);
				
				var days_allotted	= 	$("#gridview-val"+active_tab.input_id+" tr#"+row_id).children("td#days_allotted").html();
				//var days_allotted = $("tr#"+row_id).children("td#days_allotted").text();
				//console.log("P:"+priority+"  -------------DA------------");
				//console.log(days_allotted);
				
				var quantity 		= 	$("#gridview-val"+active_tab.input_id+" tr#"+row_id).children("td#quantity").html(); 
				//console.log("-------------QTY------------");
				//console.log(quantity);
				param_jos[param_ctr] = {};
				
				
				param_jos[param_ctr]["jo_id"] = {};
				param_jos[param_ctr]["priority"] = {};
				param_jos[param_ctr]["days_allotted"] = {};
				param_jos[param_ctr]["line"] = {};
				param_jos[param_ctr]["quantity"] = {};
				
				var n = row_id.indexOf("_");
				var jo_id = row_id.substr(0,(n));
				
				param_jos[param_ctr]["jo_id"] = jo_id;
				param_jos[param_ctr]["priority"] = priority;
				param_jos[param_ctr]["days_allotted"] = days_allotted;
				param_jos[param_ctr]["line"] = line_number;
				param_jos[param_ctr]["quantity"] = quantity;
				
				param_ctr++;
			}
		});
		
		//console.log(param_jos);
		//return param_jos;
		
		if(callback){
			callback(param_jos);
		}else{
			return param_jos;
		}
	
	}
	
	function getSameLineJos(line_number, callback){
		var active_tab = getActiveTab();
	
		var line_jo_ids	=	[];	
		var line_jo_prioritys	=	[];
		var line_jo_lines	=	[];	
			
		$("#gridview-val"+active_tab.input_id+" tr[id*=_"+line_number+"]").each(function(i,val) {
			//console.log(val);
			if(inArray(this.id,line_jo_ids)){
				return false;
			}else{
			
				if(	i	<=	(PAGE_SIZE-1)	){
				
					line_jo_ids.push(this.id);
					
			  		var _id = this.id;
			  		var pn = $("#gridview-val"+active_tab.input_id+" tr#"+_id).children("td.Jo"+active_tab.input_model+"_priority").text();
					var priority	=	 parseInt(pn);
					//var priority	=	 parseInt(document.getElementById(this.id).firstChild.firstChild.innerHTML);
					line_jo_prioritys.push(priority);
			  
					var curr_id	=	this.id;
					var n = curr_id.indexOf("_");
					var row_line = curr_id.substr((n + 1), (curr_id.length));
					line_jo_lines.push(row_line);
					
				}
			}
			
		});
		//console.log(line_jo_ids);
		//console.log(line_jo_prioritys);
		

		//console.log("Max priority - "+line_jo_prioritys.max());
		//console.log("Min priority - "+line_jo_prioritys.min());
		
		line_jos = {};
		line_jos["id"] = {};
		line_jos["priority"] = {};
		line_jos["line"] = {};
		
		line_jos["id"] 		=	line_jo_ids;
		line_jos["priority"]=	line_jo_prioritys;
		line_jos["line"]=	line_jo_lines;
		
		//return line_jos;
		
		if(callback){
			callback(line_jos);
		}else{
			return line_jos;
		}
	}
    	
	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}

	function showLineSelectModal(option_1, option_2){
	
		if(parseInt(option_1)>=0){

			document.getElementById("option_1").style.display = "block";
			$("#line_select .modal-body div button#option_1 span#line_A").html(option_1); 
			$("#line_select .modal-body div button#option_1 span#line_A").attr("data-line", option_1);
			
			if(parseInt(option_1)==0){
				$("#line_select .modal-body div button#option_1 span#line_A").html("None"); 
				$("#line_select .modal-body div button#option_1 span#line_A").attr("data-line", "0");
			} 
			
		}else{
			
			document.getElementById("option_1").style.display = "none";
		}
		
		
		if(parseInt(option_2)>=0){

			document.getElementById("option_2").style.display = "block";
			$("#line_select .modal-body div button#option_2 span#line_B").html(option_2); 
			$("#line_select .modal-body div button#option_2 span#line_B").attr("data-line", option_2);
			
			if(parseInt(option_2)==0){
				$("#line_select .modal-body div button#option_2 span#line_B").html("None"); 
				$("#line_select .modal-body div button#option_2 span#line_B").attr("data-line", "0");
			} 
			
		}else{
			
			document.getElementById("option_2").style.display = "none";
		}
		
		
		//$("#line_select .modal-body div button#option_1 span#line_A").html(option_1); 
		//$("#line_select .modal-body div button#option_2 span#line_B").html(option_2); 
		
		
		$("#line_select").modal({backdrop: "static",
			keyboard: false  // to prevent closing with Esc button (if you want this too)
		})	
		//$('#line_select').modal('show');
	
	}

	function getMinMaxPriorityNumber(line_number){
		//console.log("-getMaxPriorityNumber------for LINE: "+line_number);
		
		var active_tab 	= 	getActiveTab();
		
		var min_priority=	null;
		var max_priority=	null;
		
		var line_arr = $( "#gridview-val"+active_tab.input_id+"  tr[id*=_"+line_number+"] td.Jo"+active_tab.input_model+"_priority a" ).toArray();
		
		var line_prioritys	=	[];	
		//console.log("--ARRAY "+line_arr.length);
		//console.log($( "#gridview-val"+active_tab.input_id+"  tr[id*=_"+line_number+"] td.JoSewing_priority a" ).toArray());
		$( "#gridview-val"+active_tab.input_id+"  tr[id*=_"+line_number+"] td.Jo"+active_tab.input_model+"_priority a" ).each(function(i,val) {
		
			//console.log(i+"--"+this.innerHTML);
			
			line_prioritys.push(parseInt(this.innerHTML));
		
		});
		
		line_prioritys.sort(function(a, b){return a-b});
		min_priority	=	line_prioritys[0];
		max_priority	=	line_prioritys[(parseInt(line_arr.length)-1)];
		
		line_priority	=	{};
		line_priority["min_priority"]	=	{};
		line_priority["max_priority"]	=	{};
		
		line_priority["min_priority"]	=	min_priority;
		line_priority["max_priority"]	=	max_priority;
		
		
		//console.log(line_priority);
		return	line_priority;
		
	}

	function moveRowToAnotherLine(chosen_line,line_jos, changed_row_id){
	
		
			console.log("----CHOSEN LINE "+chosen_line);
			var n = changed_row_id.indexOf("_");
			var changed_row_line = changed_row_id.substr((n + 1), (changed_row_id.length));
			var changed_row_jo_id = changed_row_id.substr(0,(n));
			var new_id	=	changed_row_jo_id+"_"+chosen_line;
			//console.log("NEW ID - "+new_id);
				
				//console.log("--FOR NEW LINE--");
				var min_max_new_line	=	getMinMaxPriorityNumber(chosen_line);
			
				//console.log("--FOR OLD LINE--");
				var min_max_old_line	=	getMinMaxPriorityNumber(changed_row_line);
				
			$("#"+changed_row_id).attr("id",new_id);
			
			var param_jos	 	= 	{};
				param_jos[0]	= 	{};
				param_jos[0]['line']	= 	{};
				param_jos[0]['data']	= 	{};
				param_jos[1]	= 	{};
				param_jos[1]['line']	= 	{};
				param_jos[1]['data']	= 	{};
			
			
			//console.log("--Rearrange new Line "+changed_row_line);
			
			//rearrang new belonged Line
			param_jos[0]['data']	=	sortSameLinePriorityNumber(chosen_line,line_jos,min_max_new_line);
			param_jos[0]['line']	=	chosen_line;
			
			
			//console.log("--Rearrange prev Line "+changed_row_line);
			/*--START
			 *	this will TRIGGER the backend to ONLY update DAYS_ALLOTTED when...
			 *	value being edited is QTY, else leave DAYS ALLOTTED as is
			 *	 and base the computation of TED from unchanged DA
			 */
			param_jos[0]['skip_edit']	= 	{};
			
				data_updated = {};
				data_updated["name"] = {};
				data_updated["jo_id"] = {};
				data_updated["name"] = 'priority';
				data_updated["jo_id"] = changed_row_jo_id;
					
			param_jos[0]['skip_edit']	=	data_updated;
			/*--END
			*/
			
			//console.log(line_jos);
			//then rearrange rows of previous Line
			param_jos[1]['data']	=	sortSameLinePriorityNumber(changed_row_line,line_jos,min_max_old_line);
			param_jos[1]['line']	=	changed_row_line;
			
			return	param_jos;
	}

