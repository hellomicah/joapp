function updatePriorityRow(event,p_value){
	//VALUE OF TEXTBOX
	var priority_val = $.trim(p_value);


	var row_id = $(event).closest("tr").attr("id");

	//FIRST VALUE 
	var orig_priority_val = document.getElementById(row_id).firstChild.firstChild.innerHTML;
	var n = row_id.indexOf("_");
	var data_line = row_id.substr((n + 1), (row_id.length));

	var move_else_down = 0;
	var row = null;
	
	console.log("LINE -- "+data_line);
	console.log("ROW ID -- "+row_id);
	console.log("Orig P Value -- "+orig_priority_val);
	
	var active_tab = getActiveTab();
	
	var min_max_of_line	=	getMinMaxPriorityNumber(data_line);	
	var min_priority	=	min_max_of_line['min_priority'];
	
	$("#gridview-val"+active_tab.input_id+" tr[id*=_"+data_line+"]").each(function(i, val) {
		var find_row_id = this.id;

		//CURRENT VALUE IN ROWS LOOPED
		//var find_priority_val = document.getElementById(find_row_id).firstChild.firstChild.innerHTML;
		var find_priority_val = $("#gridview-val"+active_tab.input_id+" tr#"+find_row_id).children("td.Jo"+active_tab.input_model+"_priority").text();
		
		
			console.log("-- item: "+i+" - P: "+find_priority_val);
		
		// console.log(document.getElementById(find_row_id).firstChild.firstChild.innerHTML);

		console.log(priority_val+" "+find_priority_val+" "+orig_priority_val);
		
		//Check if value entered is EQUAL to this.priority row
			//BUT
				//not EQAUl original/previous value
		if (priority_val == find_priority_val && priority_val == orig_priority_val) {
			//alert(find_row_id);
		} else if (priority_val == find_priority_val && priority_val != orig_priority_val) {
			move_else_down = 1;

			if (orig_priority_val < find_priority_val) {
				
				console.log("move_else_down -- move updated row: " + row_id + " after row:" + find_row_id);
				$("#gridview-val"+active_tab.input_id+" tr#" + row_id).insertAfter("tr#" + find_row_id);
				//delete event line when have created backtrace function
				//document.getElementById(find_row_id).firstChild.firstChild.innerHTML = priority_val - 1;
				
				console.log("---- ROW: "+find_row_id+" New val - "+i);
				//$("#gridview-val"+active_tab.input_id+" tr#"+find_row_id+" td.Jo"+active_tab.input_model+"_priority").children("a").html(i);
				
				$("#gridview-val"+active_tab.input_id+" tr[id*=_"+data_line+"]").each(function(i, val) {

					/*
						TRAVERSE ALL PRIORITY NUM BEFORE THIS TO ADJUST NUM
					*/
					if (this.id == find_row_id) {
						return false;
					} else {
						//document.getElementById(this.id).firstChild.firstChild.innerHTML = i + 1;
						$("#gridview-val"+active_tab.input_id+" tr#"+this.id+" td.Jo"+active_tab.input_model+"_priority").children("a").html(i + 1);
						
						console.log("-------- eROW: "+this.id+" New val - "+(i + 1));
					}
				});

			} else if (orig_priority_val > find_priority_val) {
				
				console.log("move_else_up -- move updated row: " + row_id + " before row:" + find_row_id);
				$("#gridview-val"+active_tab.input_id+" tr#" + row_id).insertBefore("tr#" + find_row_id);
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
				//document.getElementById(find_row_id).firstChild.firstChild.innerHTML = parseInt(find_priority_val) + 1;
				//$("#gridview-val"+active_tab.input_id+" tr#"+find_row_id+" td.Jo"+active_tab.input_model+"_priority").children("a").html((i+1) + 1);
				
				console.log("---- (med)ROW: "+find_row_id+" New val - "+((i+1) + 1));
			}
		}
		/*
		ADD VALIDATIONS HERE

		if input number is > (max + 1) ---- get the max number and promopt admin the correct number (update to correct max priority num?), if YES - apply max num +1 
		if input number has same input ---- move to that row and adjust everything downwards

		*/
	});
	
		return '';
	
	}


	//document.getElementById("change_status").value = "changed";	
	
