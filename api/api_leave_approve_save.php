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

function TimeSave($emp_v,$daet_start,$daet_end){
	$countDay = round((strtotime($daet_end)-strtotime($daet_start))/(24*60*60),0)+1;
	$time_attendance = new time_attendance();
	
	for($i=0;$i<=($countDay-1);$i++){
		$tDay = date("Y-m-d", strtotime("+".$i." day", strtotime($daet_start)));
		$time_attendance->chkDateInOut($emp_v,$tDay);
	}
	
}
if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	if($_REQUEST["approve_status"]=="y"){
		
		$sql = "UPDATE `leave` SET leave_status='1' , leave_approve_date=NOW() 
 			WHERE leave_endorser_emp = '".$userLogin["emp_id"]."' 
			AND leave_id='".$_REQUEST["id"]."'";
		mysql_query($sql);

		$sql = "UPDATE `leave_detail` SET leave_status='1' 
 			WHERE  leave_id='".$_REQUEST["id"]."'";
		mysql_query($sql);

		$sql = "SELECT * FROM `leave` WHERE leave_id='".$_REQUEST["id"]."'";
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		TimeSave($dbarr['emp_id'],$dbarr['leave_start_day'],$dbarr['leave_end_day']);
		push_approve($_REQUEST["id"]);	
	}else if($_REQUEST["approve_status"]=="n"){
		$sql = "UPDATE `leave` SET leave_status='2' , leave_approve_date=NOW() , leave_approve_comment='".$_POST["msg"]."'  
 		WHERE leave_endorser_emp = '".$userLogin["emp_id"]."' 
		AND leave_id='".$_REQUEST["id"]."'";
		mysql_query($sql);

		$sql = "UPDATE `leave_detail` SET leave_status='2' 
 		WHERE  leave_id='".$_REQUEST["id"]."'";
		mysql_query($sql);
		push_approve($_REQUEST["id"]);
	}
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode(array("status"=>"ok")).');';
?>