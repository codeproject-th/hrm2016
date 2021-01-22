<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");
include_once("../lib/pusher.php");
include_once("../includes/push.php");
include_once("../lib/pusher.php");
include_once("../includes/push.php");
include_once("../lib/calendar.php");

$userLogin = getUser($_REQUEST["emp_id"]);
$calendar = new calendar();
$weekend = $calendar->weekend();
$holiday = $calendar->holiday();
$empLeave = $calendar->empLeave($userLogin["emp_id"]);
$empLate = $calendar->empLate($userLogin["emp_id"]);
$empTimework = $calendar->empTimework($userLogin["emp_id"]);
$empTimeAtt = $calendar->empTimeAtt($userLogin["emp_id"]);

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
		WHERE l.emp_id='".$userLogin["emp_id"]."' AND l.leave_status!='3'";

$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
	$status_color['0'] = "#f39c12";
	$status_color['1'] = "#00a65a";
	$status_color['2'] = "#dd4b39";
	
}
;  
        
header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode($day).');';    
?>