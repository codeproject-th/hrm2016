<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");
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

function TimeDel($emp_v,$daet_start,$daet_end){
	$countDay = round((strtotime($daet_end)-strtotime($daet_start))/(24*60*60),0)+1;
	$time_attendance = new time_attendance();
	for($i=0;$i<=($countDay-1);$i++){
		$tDay = date("Y-m-d", strtotime("+".$i." day", strtotime($daet_start)));
		$sql = "DELETE FROM time_attendance_emp WHERE emp_id='".$emp_v."' AND time_day='".$tDay."'";
		$query = mysql_query($sql);
	}
}

$save = false;
$error = "";

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$sql = "SELECT * FROM leave_endorser WHERE emp_id='".$userLogin["emp_id"]."'";
	$query = mysql_query($sql);
	$endorser = mysql_fetch_array($query);
	$_REQUEST["act"] = "add";
	if($_REQUEST["act"]=="add" and $userLogin['emp_id']!=''){
		
		$leave = new leave();
		$leave->data_start = dateSQL($_REQUEST["leave_start_day"]);
		$leave->data_end = dateSQL($_REQUEST["leave_end_day"]);
		$leave->leave_full = $_REQUEST["leave_full"];
		$leave->leave_type = $_REQUEST["leave_type"];
		$leave->emp_id = $userLogin['emp_id'];
		$leave->Add();
		//print_r($leave->results);
		
		$sql = "INSERT INTO `leave`(
					emp_id,
					leave_type,
					leave_start_day,
					leave_end_day,
					leave_comment,
					leave_status,
					leave_endorser_emp,
					leave_n,
					leave_full,
					create_date
				) VALUES(
					'".$userLogin['emp_id']."',
					'".$_REQUEST["leave_type"]."',
					'".dateSQL($_REQUEST["leave_start_day"])."',
					'".dateSQL($_REQUEST["leave_end_day"])."',
					'".$_REQUEST["leave_comment"]."',
					'".$_REQUEST["leave_status"]."',
					'".$endorser["leave_endorser_emp"]."',
					'".$leave->results["use_day"] ."',
					'".$_REQUEST["leave_full"]."',
					NOW()
				)";
		
		if($leave->results["ok"]==true and $leave->results["use_day"]>'0'){	
			
			$query = mysql_query($sql);
			$insert_id = mysql_insert_id();
			push_leave($insert_id);	
			if(count($leave->results["day"])>0){
				foreach($leave->results["day"] as $val){
					$sql="INSERT INTO leave_detail(
							leave_id,
							emp_id,
							leave_date,
							status
						) VALUES(
							'".$insert_id."',
							'".$userLogin['emp_id']."',
							'".$val."',
							'".$_REQUEST["leave_status"]."'
						)";
					mysql_query($sql);
				}	
					
			}
			
			$save = true;
		}else{
			$error = $leave->error[0];
			if($leave->results["use_day"]=='0'){
				$error = "คุณลาวันนี้แล้วไม่สามารถลาได้อีก";
			}
			$save = false;
		}
	}
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode(array('status'=>$save,'error'=>$error)).');';
?>