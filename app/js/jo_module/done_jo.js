
$(document).ready(function() {

	$("button#confirm-revert").click(function(e) {
    	
    	
    	var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);

        $("#revert_modal #JoSewing_jo_id").val(date_id);
        
        
        var quantity_val = $("tr#"+row_id).children("td#quantity").html();
       
        $("form#revertForm #JoSewing_quantity").val(quantity_val);
        
        
        var output_val = $("tr#"+row_id).children("td#output").html();
       
        $("form#revertForm #JoSewing_output").val(output_val);
        $("form#revertForm #JoSewing_output").attr("autofocus","autofocus");
       // $("input#JoSewing_output").get(0).focus();
        $("form#revertForm input[type='text']").on("focus", function () {
   			$(this).select();
		});

        $("#revert_modal").modal({
            backdrop: "static",
            keyboard: false // to prevent closing with Esc button (if you want this too)

        });
	});  
	$("button#confirm-revert2").click(function(e) {
    	
    	
    	var row = $(this).closest("tr");
        var row_id = $(row).attr("id");
        var n = row_id.indexOf("_");

        var date_id = row_id.substr(0, n);

        $("#revert_modal2 #JoFinishing_jo_id").val(date_id);
        
        
        var quantity_val = $("tr#"+row_id).children("td#quantity").html();
       
        $("form#revertForm2 #JoFinishing_quantity").val(quantity_val);
        
        
        var output_val = $("tr#"+row_id).children("td#output").html();
       
        console.log(output_val);
        $("form#revertForm2 #JoFinishing_output").val(output_val);
        $("form#revertForm2 #JoFinishing_output").attr("autofocus","autofocus");
       // $("input#JoSewing_output").get(0).focus();
        $("form#revertForm2 input[type='text']").on("focus", function () {
   			$(this).select();
		});

        $("#revert_modal2").modal({
            backdrop: "static",
            keyboard: false // to prevent closing with Esc button (if you want this too)

        });
	});  
	
	$('#done-refresh-button').on('click',function(e) {
    	//jQuery.noConflict();
        //e.preventDefault();
        //$('#gridview-done-sewing').yiiGridView('update');
    });
	
	$('#revert_modal2').on('shown.bs.modal', function () {
        $("form#revertForm2 #JoFinishing_output").focus();
	});
	$('#revert_modal').on('shown.bs.modal', function () {
        $("form#revertForm #JoSewing_output").focus();
	});
});  