<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");


$sql = "SELECT * FROM master_leave_type";
$query = mysql_query($sql);
$data = array();
$i = 0;
while($dbarr = mysql_fetch_array($query)){
	$data[$i]['leave_type_id'] = $dbarr['leave_type_id'];
	$data[$i]['leave_type_name'] = $dbarr['leave_type_name'];
	$i++;
}



header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode($data).');';
?>