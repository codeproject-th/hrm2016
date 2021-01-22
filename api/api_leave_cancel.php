<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$sql = "SELECT * FROM `leave` WHERE leave_id='".$_GET["id"]."' and emp_id='".$userLogin["emp_id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	if($dbarr["leave_status"]!="0"){
		$sql = "UPDATE `leave` SET leave_status='3' WHERE leave_id='".$_GET["id"]."' and emp_id='".$userLogin["emp_id"]."'";
		mysql_query($sql);
	}
	$save = true;
}
header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode(array('status'=>$save)).');';
?>