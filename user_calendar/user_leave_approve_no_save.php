<?
include_once("./lib/log_web.php");
include_once("./lib/time_attendance.lib.php");
include_once("./lib/pusher.php");
include_once("./includes/push.php");

$sql = "UPDATE `leave` SET leave_status='2' , leave_approve_date=NOW() , leave_approve_comment='".$_POST["msg"]."'  
 		WHERE leave_endorser_emp = '".$_SESSION['login']['emp_id']."' 
		AND leave_id='".$_POST["id"]."'";
mysql_query($sql);

$sql = "UPDATE `leave_detail` SET leave_status='2' 
 		WHERE  leave_id='".$_POST["id"]."'";
mysql_query($sql);
push_approve($_POST["id"]);
?>