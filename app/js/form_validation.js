 function displayLineList(dropdownlist){
	if(dropdownlist.value == "Sewing Output & Status Controller" || dropdownlist.value == "Finishing Output & Status Controller"){
		document.getElementById("line-div").style.display = "block";
		
	}else{
		document.getElementById("line-div").style.display = "none";
	}
}	


function numbersOnly(e){
	var key;
	var keychar;
	if (window.event)
		key = window.event.keyCode;
	else if (e)
			key = e.which;
		else
			return true;
			keychar = String.fromCharCode(key);
			keychar = keychar.toLowerCase();

			// control keys
			if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
				   return true;

			// alphas and numbers
			else if ((("0123456789").indexOf(keychar) > -1))
				return true;
			else
				return false;
}	



function addDropdownValue(){
	var new_dropdown_value_ctr = $("#dropdown_div div#per_dropdown").length;
	new_dropdown_value_ctr = new_dropdown_value_ctr +1;
	$("#dropdown_div").append(' <div id="per_dropdown">\
					<input type="button" class="close" id="remove-value-'+new_dropdown_value_ctr+'" onclick="removeValue(this)" value="&times;"/> <br>\
					<input type="text" class="form-control" id="dropdown_value" name="FormDropdown[value][]"/>\
					<div id="dropdown_value_error_'+new_dropdown_value_ctr+'" class="errorMessage"></div>\
					</div>');
}

function removeValue(e){
	var the_object_id = e.id;
	var arr_id = the_object_id.split("-");
	var original_val = "dropdown_value_original_"+arr_id[2];
	var error_div = "dropdown_value_error_"+arr_id[2];

	if(document.getElementById(original_val) == null){
		e.parentNode.remove(e);
	}else{
		var baseURL =location.protocol+'//'+location.host+ '/jo_manager_live/'; //UPDATE 
		var category = document.getElementById("dropdown_name").value;
		$(document).ready(function(){
			$.post(baseURL + "formDropdown/checkValue", {name:category,value:document.getElementById(original_val).value,} ,function(result){
             	if(result == "0"){
					e.parentNode.remove(e);
				}else if(result == "2"){
					e.parentNode.remove(e);
				}else{
					document.getElementById(error_div).innerHTML= '<label>Cannot be deleted.</label>'; 
					document.getElementById(error_div).style.display = 'block';
				}
    		});
    	});
	}

}


$(document).ready(function(){
	//ADD NEW DROPDOWN VALUE 
         $('#add-new-value').click(function(e){
        	 e.preventDefault();
       	 	addDropdownValue();
        }); 
        
    //ONCLICK SUBMIT
    	//$('#submit-form-1').click(function(e){
    	$('#form-dropdown-form').submit(function(e){
        	 e.preventDefault();
        	 var error = false;
        	 var arr_values = [];
				
        	 $("div#per_dropdown").each(function() {
        	 	
        	 	if($(this).find('#dropdown_value').val().trim() == 0){
					error = true;
					$(this).find('.errorMessage').fadeIn(500);
					$(this).find('.errorMessage').html('<label>Required field.</label>');
					
				}else{
					//$(this).find('.errorMessage').fadeOut(500);
					if ($.inArray($(this).find('#dropdown_value').val().trim().toLowerCase(), arr_values) != -1){
						error = true;
						$(this).find('.errorMessage').html('<label>Duplicate value.</label>');
						$(this).find('.errorMessage').fadeIn(500);
					}else{
            			$(this).find('.errorMessage').fadeOut(500);
						arr_values.push($(this).find('#dropdown_value').val().trim().toLowerCase());
					}
					
				}	
			 });
			 
			 if(error === false){
             	this.submit();
			}
        }); 
        
        //check if value exist
	
	
$('#move_selected').on('click',function(){
    
    var $selected = $('option:selected','#Admin_line_list');
    $selected.each(function(i,e){
        console.log(e.value + e.innerHTML);
        $('#Admin_selected_line').append(
            $('<option />').val(e.value).html(e.innerHTML).attr('selected', true)
        );
    });
    $selected.remove();
});
$('#delete_selected').on('click',function(){
    
    var $selected = $('option:selected','#Admin_selected_line');
    $selected.each(function(i,e){
        console.log(e.value + e.innerHTML);
        $('#Admin_line_list').append(
            $('<option />').val(e.value).html(e.innerHTML)
        );
        $('#Admin_selected_line option').attr('selected', true);
    });
    $selected.remove();
});

}); //document.ready