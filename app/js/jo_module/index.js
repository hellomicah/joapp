$(document).ready(function() {

	//index file
	//checks the status value
	var status_val_index = $('tbody').find('tr');
     $(status_val_index).each(function(i, val) {
     	var status_value = $(this).find('td[id*=status]').html();
     	if(status_value  == "" || status_value  == "For Loading"){
     		$(this).find('td[id*=status]').html("For Loading");
     		var color = "red";
     	}else{
     		var color = "#24CE3E";
     	}
     	
     	$(this).find('td[id*=jo]').attr('style', 'color: '+color+' !important');
     	$(this).find('td[id*=brand]').attr('style', 'color: '+color+' !important');
     	
     	
     	//for date
     	ted_value = $(this).find('td[id*=target_end_date]').html();
     	dd_value = $(this).find('td[id*=delivery_date]').html();
     	
     	if(ted_value != null){
     	var date_diff = dateDiffInDays(ted_value, dd_value);
     
     		if(date_diff > 0 && date_diff < 7){
     			$(this).find('td[id*=target_end_date]').attr('style', 'color: red !important');
     		}
     	}
     });
     

     
   

// a and b are javascript Date objects
function dateDiffInDays(a, b) {
var _MS_PER_DAY = 1000 * 60 * 60 * 24;
	var start = new Date(a);
	var end = new Date(b);
	var y = start.getFullYear();
  // Discard the time and time-zone information.
  var utc1 = Date.UTC(start.getFullYear(), start.getMonth(), start.getDate());
  var utc2 = Date.UTC(end.getFullYear(), end.getMonth(), end.getDate());

  //return utc2+utc1;
  return Math.floor((utc2 - utc1) / _MS_PER_DAY);
  //return y;
}

});