<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$sql = "UPDATE employees SET mobile_id='".$_REQUEST["regID"]."' WHERE emp_id='".$userLogin["emp_id"]."'";
	mysql_query($sql);
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode(array('status'=>true)).');';
?>