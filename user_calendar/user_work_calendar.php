<?php

include_once("lib/calendar.php");
$calendar = new calendar();
$weekend = $calendar->weekend();
$holiday = $calendar->holiday();
$empLeave = $calendar->empLeave($_SESSION['login']['emp_id']);
$empLate = $calendar->empLate($_SESSION['login']['emp_id']);
$empTimework = $calendar->empTimework($_SESSION['login']['emp_id']);
$empTimeAtt = $calendar->empTimeAtt($_SESSION['login']['emp_id']);

if(count($weekend)>0){
	foreach($weekend as $val){
		$day[] = $val;
	}
}

if(count($holiday)>0){
	foreach($holiday as $val){
		$day[] = $val;
	}
}

if(count($empLeave)>0){
	foreach($empLeave as $val){
		$day[] = $val;
	}
}

if(count($empLate)>0){
	foreach($empLate as $val){
		$day[] = $val;
	}
}

if(count($empTimework)>0){
	foreach($empTimework as $val){
		$day[] = $val;
	}
}

if(count($empTimeAtt)>0){
	foreach($empTimeAtt as $val){
		$day[] = $val;
	}
}


$sql = "SELECT l.* , t.leave_type_name FROM `leave` l 
		LEFT JOIN master_leave_type t ON t.leave_type_id = l.leave_type 
		WHERE l.emp_id='".$_SESSION['login']['emp_id']."' AND l.leave_status!='3'";

$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
	$status_color['0'] = "#f39c12";
	$status_color['1'] = "#00a65a";
	$status_color['2'] = "#dd4b39";
	
}

?>
<ol class="breadcrumb">
  <li><a href="#">ปฏิทิน</a></li>
  <li class="active">ปฏิทินการทำงาน</li>
</ol>

<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ปฏิทินการทำงาน</h3>
  	</div>
  	<div class="box-body">
<!---- ---->
<div class="col-md-9">
	<div id='calendar'></div>
</div>
<!-- -->
<div class="col-md-3">
	<div class="box box-solid">
		<div class="box-header with-border">
        	<h4 class="box-title">สถานะ</h4>
        </div>
		<div class="box-body">
        <!-- the events -->
        	<div id="external-events">
        		<div style="position: relative;" class="external-event bg-green ui-draggable ui-draggable-handle">วันหยุด</div>
        		<div style="position: relative;" class="external-event bg-blue ui-draggable ui-draggable-handle">ลา</div>
				<div style="position: relative;" class="external-event bg-yellow ui-draggable ui-draggable-handle">สาย</div>
                <div style="position: relative;" class="external-event bg-red ui-draggable ui-draggable-handle">ขาดงาน</div>
                
            </div>
		<!-- -->
        </div>
       <!-- /.box-body -->
     </div>
</div>

<!---- ---->
	</div>
</div><!-- /.box -->
<script>
$(document).ready(function() {
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		lang: "th",
		defaultDate: '<?=date("Y-m-d")?>',
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: <?=json_encode($day)?>
	});	
});

</script>