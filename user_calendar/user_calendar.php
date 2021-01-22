<?php


$sql = "SELECT l.* , t.leave_type_name FROM `leave` l 
		LEFT JOIN master_leave_type t ON t.leave_type_id = l.leave_type 
		WHERE l.emp_id='".$_SESSION['login']['emp_id']."' AND l.leave_status!='3'";

$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
	$status_color['0'] = "#f39c12";
	$status_color['1'] = "#00a65a";
	$status_color['2'] = "#dd4b39";
	
	$full = "";
	
	switch($dbarr["leave_full"]){
		case "1" : $full = "เต็มวัน"; break;
		case "2" : $full = "ครึ่งวันเช้า"; break;
		case "3" : $full = "ครึ่งวันบ่าย"; break;
	}
	
	$leave_end_day = date("Y-m-d", strtotime("+1 day", strtotime($dbarr["leave_end_day"])));
	$day[] = array(
					"id" => $dbarr["leave_id"],
					"title" => $dbarr["leave_type_name"]."(".$full.")",
					"start" => $dbarr["leave_start_day"],
					"end" => $leave_end_day,
					"backgroundColor" => $status_color[$dbarr["leave_status"]],
					"borderColor" => "#ffffff",
					"url" => "index.php?m=user_calendar&p=user_leave_detail&id=".$dbarr["leave_id"],
					"allDay" => true
				);
}

?>
<ol class="breadcrumb">
  <li><a href="#">ปฏิทิน</a></li>
  <li class="active">ปฏิทินการลา</li>
</ol>

<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ปฏิทินการลา</h3>
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
        	<h4 class="box-title">สถานะการลา</h4>
        </div>
		<div class="box-body">
        <!-- the events -->
        	<div id="external-events">
				 <div style="position: relative;" class="external-event bg-yellow ui-draggable ui-draggable-handle">รอออนุมัติ</div>
                <div style="position: relative;" class="external-event bg-green ui-draggable ui-draggable-handle">อนุมัติ</div>
                <div style="position: relative;" class="external-event bg-red ui-draggable ui-draggable-handle">ไม่อนุมัติ</div>
                
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