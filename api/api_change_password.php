<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$password_old = $_REQUEST['password_old'];
	$password_new = $_REQUEST['password_new'];
	$sql = "UPDATE user SET user_pwd='".$password_new."' WHERE employees_id='".$userLogin["emp_id"]."' AND user_pwd='".$password_old."'";
	$query = mysql_query($sql);
	if($query){
		$status = true;
	}else{
		$status = false;
	}
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode(array("status"=>$status)).');';
?>