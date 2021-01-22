<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");

$user = $_GET['user'];
$pass = $_GET['pass'];
$regID = $_GET['regID'];

$sql = "SELECT * FROM user WHERE user_name='".$user."' AND user_pwd='".$pass."'";
$query = mysql_query($sql);
$dbarr = mysql_fetch_array($query);
$data['username'] = $dbarr['user_name'];
$data['password'] = $dbarr['user_pwd'];
$r = false;

if($data['username']==$user and $data['password']==$pass){
	$r = true;
	$sql = "UPDATE employees SET mobile_id='".$regID."' WHERE emp_id='".$dbarr['employees_id']."'";
	//mysql_query($sql);
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode(array('status'=>$r)).');';
?>