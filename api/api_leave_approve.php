<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$sql = "SELECT l.* , e1.*  , e2.emp_name as emp_name2 , e2.emp_last_name as emp_last_name2 , t.leave_type_name FROM  `leave` l
		LEFT JOIN employees e1 ON e1.emp_id=l.emp_id 
		LEFT JOIN employees e2 ON e2.emp_id=l.leave_endorser_emp 
		LEFT JOIN master_leave_type t ON t.leave_type_id=l.leave_type 
		WHERE l.leave_endorser_emp='".$userLogin["emp_id"]."'  
		ORDER BY leave_start_day DESC ";
	$query = mysql_query($sql);
	//echo $sql;
	$no = 0;
	while($dbarr = mysql_fetch_array($query)){
		$leave_end_day = date("Y-m-d", strtotime("+1 day", strtotime($dbarr["leave_end_day"])));
		$status = "รออนุมัติ";
		if($dbarr["leave_status"]=="1"){
			$status = "อนุมัติ";
		}else if($dbarr["leave_status"]=="2"){
			$status = "ไม่อนุมัติ";
		}else if($dbarr["leave_status"]=="3"){
			$status = "ยกเลิก";
		}
		
		$full = "";
		switch($dbarr["leave_full"]){
			case "1" : $full = "เต็มวัน"; break;
			case "2" : $full = "ครึ่งวันเช้า"; break;
			case "3" : $full = "ครึ่งวันบ่าย"; break;
		}
	
		$no++;
		$day[] = array(
					"no" => $no,
					"id" => $dbarr["leave_id"],
					"title" => $dbarr["leave_type_name"]."(".$full.")",
					"start" => $dbarr["leave_start_day"],
					"end" => $leave_end_day,
					"leaveFull" => conver_dateSQL($dbarr["leave_start_day"])."  -  ".conver_dateSQL($dbarr["leave_end_day"]),
					"leave_type" => $dbarr['leave_type_name'],
					"backgroundColor" => $status_color[$dbarr["leave_status"]],
					"borderColor" => "#ffffff",
					"status" => $status,
					"status_int" => $dbarr["leave_status"],
					"emp_name" => $dbarr['emp_name'],
					"emp_last_name" => $dbarr['emp_last_name'],
					"full_name" => $dbarr['emp_name']." ".$dbarr['emp_last_name'],
					"url" => "index.php?m=user_calendar&p=user_leave_detail&id=".$dbarr["leave_id"],
					"allDay" => true
				);
	}
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode($day).');';
?>