<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$sql = "SELECT l.* , t.leave_type_name FROM `leave` l LEFT JOIN master_leave_type t ON t.leave_type_id=l.leave_type WHERE l.leave_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	$data[0]['leave_id'] = $dbarr['leave_id'];
	$data[0]['emp_id'] = $dbarr['emp_id'];
	$data[0]['leave_type'] = $dbarr['leave_type'];
	$data[0]['leave_start_day'] = $dbarr['leave_start_day'];
	$data[0]['leave_end_day'] = $dbarr['leave_end_day'];
	$data[0]['leave_start_day_th'] = conver_dateSQL($dbarr['leave_start_day']);
	$data[0]['leave_end_day_th'] = conver_dateSQL($dbarr['leave_end_day']);
	$data[0]['leave_comment'] = $dbarr['leave_comment'];
	$data[0]['leave_status'] = $dbarr['leave_status'];
	$data[0]['leave_endorser_emp'] = $dbarr['leave_endorser_emp'];
	$data[0]['leave_n'] = $dbarr['leave_n'];
	$data[0]['leave_full'] = $dbarr['leave_full'];
	$data[0]['create_date'] = $dbarr['create_date'];
	$data[0]['leave_approve_date'] = $dbarr['leave_approve_date'];
	$data[0]['leave_approve_comment'] = $dbarr['leave_approve_comment'];
	$data[0]['leave_type_name'] = $dbarr['leave_type_name'];
	
	if($dbarr['leave_full']=='1'){
		$leave_full = 'เต็มวัน';
	}
	
	if($dbarr['leave_full']=='2'){
		$leave_full = 'ครึ่งวันเช้า';
	}
	
	if($dbarr['leave_full']=='3'){
		$leave_full = 'ครึ่งวันบ่าย';
	}
	
	$data[0]['leave_full_txt'] = $leave_full;
	
	if($dbarr['leave_status']=='0'){
		$leave_status_txt = 'รออนุมัติ';
	}
	
	if($dbarr['leave_status']=='1'){
		$leave_status_txt = 'อนุมัติ';
	}
	
	if($dbarr['leave_status']=='2'){
		$leave_status_txt = 'ไม่อนุมัติ';
	}
	
	if($dbarr['leave_status']=='3'){
		$leave_status_txt = 'ยกเลิก';
	}
	
	$data[0]['leave_status_txt'] = $leave_status_txt;
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode($data).');';
?>