function showTime(id){
	var Digital = new Date();
	var hours = Digital.getHours();
	var minutes = Digital.getMinutes();
	var seconds = Digital.getSeconds();
	//alert(hours.toString().length);
	if(hours.toString().length==1){
		hours="0"+hours;
	}
	
	if(minutes.toString().length==1){
		minutes="0"+minutes;
	}
	
	$("#"+id).html(hours+":"+minutes);
	//alert(hours+":"+minutes);
	setTimeout("showTime('"+id+"')",3000);
}