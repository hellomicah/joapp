//Javascript functions and events for Adding New JO functionality

	function assignLowestPriority(lowest_priority) {
		//console.log(lowest_priority);
		$("form#add_new_jo_form input#JoSewing_priority").val(lowest_priority);
	}
$(document).ready(function() {
$('#add_new_button').click(function(event){
	event.preventDefault();
			$.ajax({
				url: location.origin+"/jo_manager_live/jo/addNew",
				type: "POST",
				data: $("#add_new_jo_form").serialize(),
				dataType:"json",
				success: function(data) {
                	console.log(data);
                	//remove loading GIF
                	$("#loading_div").remove();
                    
                    if(data.result){
                         
                        //close modal 
                        $("#add_new_jo_modal").modal("hide");
                        //$("#gridview-val").yiiGridView("update");
                        var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    	$("body").append(div_val);
                    		window.location.reload();
                        
                  		return true;
                    }
                    else{
                    	data=JSON.parse(data);
                    	
                    	var ctr = 0;
                    	var first_err = null;
                    	
                    	$(".error").removeClass("error");
                    	$("[id$=_error]").children().remove();
                    	
                    	
                        $.each(data, function(key, val) {
                        	
                        	var error_dif ="<div id=\""+key+"_error\"><span style=\"color:red;\">"+val+"</span></div>";
                        	$(error_dif).insertAfter("form#add_new_jo_form #"+key);
                        	console.log(key+" "+val);
                        	$("#"+key).addClass( "error" );
                        	
                        	if(ctr==0){
                        		first_err="#"+key;
                        	}
                        	ctr++;
                        });
                        
                       //scroll top top of modal when has errors
                        $("#add_new_jo_modal").animate({ scrollTop: $(first_err).offset().top }, "slow");
                        	
                    }       
                },
                beforeSend: function(){                       
                           //$("#AjaxLoader").show();
                           var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    		$("#add_new_jo_modal").append(div_val);
                    }
			});
});
$('#add_new_jo_modal').on('show.bs.modal', function () {
	$('#add_new_jo_modal select').each(function(i,val) {
		$(this).select2();
	});
	
	$('#add_new_jo_modal label[for*=JoSewing_priority]').html("Priority <span class='required'>*</span>");
	$('#add_new_jo_modal label[for*=JoSewing_jo]').html("Jo <span class='required'>*</span>");
	$('#add_new_jo_modal label[for*=JoSewing_brand]').html("Brand <span class='required'>*</span>");
	$('#add_new_jo_modal label[for*=JoSewing_quantity]').html("Qty <span class='required'>*</span>");
	$('#add_new_jo_modal label[for*=JoSewing_category]').html("Category <span class='required'>*</span>");
	$('#add_new_jo_modal label[for*=JoSewing_color]').html("Color <span class='required'>*</span>");
	$('#add_new_jo_modal label[for*=JoSewing_date_received_modal]').html("Date Received <span class='required'>*</span>");
	
	
    $('#add_new_jo_modal input[id*=date]').each(function(i,val) {
		$(this).data({
			format: "yyyy-dd-mm",
            autoclose: true,
		}).on('changeDate', function (ev) {
			$(this).datepicker('hide');
		});;

        $(this).datepicker('update');
	});
    
    console.log("MODAL - SHOW");
});

$('#add_new_jo_modal').on('hide.bs.modal', function () {
	var oP = document.getElementById("loading_div");
	if(document.body.contains(oP)){
    	document.body.removeChild(oP);
    }
});
});