//All JS functions for After Sortable Event
$(document).ready(function() {

	var PAGE_SIZE = 10;

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
        
        
        	//Element attribute ID of moved row
        	var changed_id = $("input#changed_id").val();
				
        		//Get ROW Element of moved row
        		var row = $("#"+changed_id).closest("tr");
    
        		
        		var rowElement 		=	getAfterSortableRowElements();
        		
			
					var current_line	=	rowElement.current.line;
				
					var prev_line		=	rowElement.previous.line;
				
					var next_line		=	rowElement.next.line;
			
			
					
			
		
			//Check if has PREVIOUS row
			if (prev_line !== 'undefined' && prev_line >= 0){
				
				//Check if has NEXT row	
				if (next_line !== 'undefined' && next_line >= 0){
					
					console.log("BEFORE-AFTER");
				
					//if BEFORE and AFTER is same with CURRENT ---OR--- //if BEFORE is same with CURRENT
					if(current_line == prev_line && current_line == next_line){
						console.log("---same Line with BEFORE and AFTER");
						
						
					
						var line_jos	=	getSameLineJos(current_line);
						
						console.log(line_jos.id);
						console.log(line_jos.priority);
				 		
				 		sortSameLinePriorityNumber(current_line,line_jos);
						
						
					}
				
					//if either BEFORE and AFTER is NOT same with CURRENT
					else if(current_line != next_line && current_line != prev_line){
					
						console.log("---not same with BEFORE-AFTER");
						
						console.log("---CHOOSE which LINE--");
					
						if(next_line==prev_line){
							var line_jos = getSameLineJos(prev_line);
							moveRowToAnotherLine(prev_line,line_jos, changed_id);
						}else{
							showLineSelectModal(prev_line, next_line);
						}
						
					}
					//if BEFORE is same with CURRENT
					else if(current_line == prev_line){
						console.log("---same with BEFORE");
						console.log("---CHOOSE which LINE--");
						
						
						showLineSelectModal(prev_line, next_line);
						
					}
					//if AFTER is same with CURRENT
					else if(current_line == next_line){
						console.log("---same with NEXT");
						console.log("---CHOOSE which LINE--");
					
						
						showLineSelectModal(prev_line, next_line);
				 
					}
				
				//has NO NEXT row. ONLY PREVIOUS row
				}
				else{
		
					console.log("BEFORE only");
			
					//if BEFORE is same with CURRENT
					if(current_line == prev_line){
						console.log("---same with BEFORE");
						
						var line_jos	=	getSameLineJos(current_line);
						
						console.log(line_jos.id);
						console.log(line_jos.priority);
				 		
				 		sortSameLinePriorityNumber(current_line,line_jos);
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
						
						console.log(line_jos.id);
						console.log(line_jos.priority);
				 		
				 		sortSameLinePriorityNumber(current_line,line_jos);
				 		
				 		
					}//END OF if(current_line == next_line)
					
					
					
					
				}//END OF if (next_el.is("tr"))
				
			}//END of else
			
			
			
        }
	});
	
	function getAfterSortableRowElements(){
	
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
		
			console.log("Current row-"+changed_id);
			
			//Get ROW Element of moved row
			var row = $("#"+changed_id).closest("tr");
		
		
		
		//Set moved row as CURRENT element
		var current_el 	= $("#"+changed_id);
		
		var pn_of_current_row = parseInt(document.getElementById(changed_id).firstChild.firstChild.innerHTML);
		line_jos["current"]["priority"] = pn_of_current_row;
		
			var n = changed_id.indexOf("_");
			var current_line = changed_id.substr((n + 1), (changed_id.length));
			line_jos["current"]["line"] = current_line;
		
		
		// Get the PREVIOUS element of moved row
		var previous_el = row.prev("tr");
		
			// Check to see if PREVIOUS row is a row (tr) element
			if (previous_el.is("tr")) {
			
				console.log("Previous Row-"+previous_el.attr("id"));
				
				//Get ID of PREVIOUS row
				var prev_id = previous_el.attr("id");
				line_jos["previous"]["id"] = prev_id;
				
				//get priority number of prev row
				var pn_of_prev_row = parseInt(document.getElementById(prev_id).firstChild.firstChild.innerHTML);
				line_jos["previous"]["priority"] = pn_of_prev_row;
				
					var n = prev_id.indexOf("_");
					var prev_line = prev_id.substr((n + 1), (prev_id.length));
					line_jos["previous"]["line"] = prev_line;
					
			}
		
		//Get NEXT row of moved row
		var next_el 	= $("tr#"+changed_id).next();
			
			// Check to see if NEXT row is a row (tr) element
		   if (next_el.is("tr")) {
		   
			   console.log("Next Row-"+next_el.attr("id"));
			   
			   //Get ID of NEXT row
			   var next_id = next_el.attr("id");
			   line_jos["next"]["id"] = next_id;
			   
				//get priority number of next row
				var pn_of_next_row = parseInt(document.getElementById(next_id).firstChild.firstChild.innerHTML);
				line_jos["next"]["priority"] = pn_of_next_row;
				
					var n = next_id.indexOf("_");
					var next_line = next_id.substr((n + 1), (next_id.length));
					line_jos["next"]["line"] = next_line;
		   }
		
		return line_jos;
	}
	
	function sortSameLinePriorityNumber(line_number,line_jos){
	
		var	line_jo_ids	=	line_jos.id;
		var	line_jo_prioritys	=	line_jos.priority;
		
		var min_priority	=	line_jo_prioritys.min();
		var max_priority	=	line_jo_prioritys.max();
		
		//console.log("Min priority - "+line_jo_prioritys.min());
	
		var table_rows_holder = [];
	
		$("tbody > tr[id*=_"+line_number+"]").each(function(i,val) {
			if(inArray(this.id,table_rows_holder)){
				return false;
			}else{
				table_rows_holder.push(this.id);
				
				var priority	=	min_priority + i;
			
				var current_row	=	document.getElementById(this.id).firstChild.firstChild;
				current_row.innerHTML	=	priority;
			
				console.log(this.id +" New priority num - "+priority);
			}
		});
	
	}
	
	function getSameLineJos(line_number){
	
	
		var line_jo_ids	=	[];	
		var line_jo_prioritys	=	[];
		var line_jo_lines	=	[];	
			
		$("tbody > tr[id*=_"+line_number+"]").each(function(i,val) {
			//console.log(val);
			if(inArray(this.id,line_jo_ids)){
				return false;
			}else{
			
				if(	i	<=	(PAGE_SIZE-1)	){
				
					line_jo_ids.push(this.id);
			  
					var priority	=	 parseInt(document.getElementById(this.id).firstChild.firstChild.innerHTML);
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
		
		line_jos = new Array();
		line_jos["id"] = new Array();
		line_jos["priority"] = new Array();
		line_jos["line"] = new Array();
		
		line_jos["id"] 		=	line_jo_ids;
		line_jos["priority"]=	line_jo_prioritys;
		line_jos["line"]=	line_jo_lines;
		
		return line_jos;
	}
    	
	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}

	function showLineSelectModal(option_1, option_2){
	
		
		$("#line_select .modal-body div button#option_1 span#line_A").html(option_1); 
		$("#line_select .modal-body div button#option_2 span#line_B").html(option_2); 
		$("#line_select").modal({backdrop: "static",
			keyboard: false  // to prevent closing with Esc button (if you want this too)
		})	
		$('#line_select').modal('show');
	
	}

	function moveRowToAnotherLine(chosen_line,line_jos, changed_row_id){
	
		
		
			var n = changed_row_id.indexOf("_");
			var changed_row_line = changed_row_id.substr((n + 1), (changed_row_id.length));
			var changed_row_jo_id = changed_row_id.substr(0,(n));
			var new_id	=	changed_row_jo_id+"_"+chosen_line;
			console.log("NEW ID - "+new_id);
			
			$("#"+changed_row_id).attr("id",new_id);
			
			//rearrang new belonged Line
			sortSameLinePriorityNumber(chosen_line,line_jos);
			
			//then rearrange rows of previous Line
			sortSameLinePriorityNumber(changed_row_line,line_jos);
	}

    $("button[id=option_2]").click(function() {
    	$("#chosen_line").val($(this).children("span").text());
    	
    	
    	var chosen_line	= $(this).children("span").text();
    	
    	var line_jos	=	getSameLineJos(chosen_line);
						
		console.log(line_jos.id);
		console.log(line_jos.priority);
		
		if(inArray(chosen_line,line_jos.id)){
			console.log("-----has chosen SAME LINE - "+chosen_line);
			sortSameLinePriorityNumber(chosen_line,line_jos);
		}else{
			console.log("-----has chosen DIFFERENT Line - "+chosen_line);
			
			var changed_row_id = $("input#changed_id").val();
        	
        	moveRowToAnotherLine(chosen_line,line_jos, changed_row_id);
				
		}
		
    });
    $("button[id=option_1]").click(function() {
    	$("#chosen_line").val($(this).children("span").text());
    	
    	
    	var chosen_line	= $(this).children("span").text();
    	
    	var line_jos	=	getSameLineJos(chosen_line);
						
		console.log(line_jos.id);
		console.log(line_jos.priority);
				 		
		if(inArray(chosen_line,line_jos.id)){
			console.log("-----has chosen SAME LINE - "+chosen_line);
			sortSameLinePriorityNumber(chosen_line,line_jos);
		}else{
			console.log("-----has chosen DIFFERENT Line - "+chosen_line);
			
			
        	var changed_row_id = $("input#changed_id").val();
			
			moveRowToAnotherLine(chosen_line,line_jos, changed_row_id);
				
		}
    });
});