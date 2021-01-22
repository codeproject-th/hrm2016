<?
include_once("./lib/log_web.php");
include_once("./lib/time_attendance.lib.php");
include_once("./lib/pusher.php");
include_once("./includes/push.php");
function TimeSave($emp_v,$daet_start,$daet_end){
	$countDay = round((strtotime($daet_end)-strtotime($daet_start))/(24*60*60),0)+1;
	$time_attendance = new time_attendance();
	
	for($i=0;$i<=($countDay-1);$i++){
		$tDay = date("Y-m-d", strtotime("+".$i." day", strtotime($daet_start)));
		$time_attendance->chkDateInOut($emp_v,$tDay);
	}
	
}


$sql = "UPDATE `leave` SET leave_status='1' , leave_approve_date=NOW() 
 		WHERE leave_endorser_emp = '".$_SESSION['login']['emp_id']."' 
		AND leave_id='".$_POST["id"]."'";
mysql_query($sql);

$sql = "UPDATE `leave_detail` SET leave_status='1' 
 		WHERE  leave_id='".$_POST["id"]."'";
mysql_query($sql);

$sql = "SELECT * FROM `leave` WHERE leave_id='".$_POST["id"]."'";
$query = mysql_query($sql);
$dbarr = mysql_fetch_array($query);
TimeSave($dbarr['emp_id'],$dbarr['leave_start_day'],$dbarr['leave_end_day']);
push_approve($dbarr["leave_id"]);
?>