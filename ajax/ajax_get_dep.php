<?php
include("./../includes/config.inc.php");
include("./../includes/conn.php");
include("./../includes/function.php");
$party_id = $_POST["party_id"];
$sql = "SELECT * FROM master_department WHERE party_id='".$party_id."' ORDER BY department_name";
$query = mysql_query($sql);
$data = array();
$i = 0;
while($dbarr = mysql_fetch_array($query)){
	$data[$i] = $dbarr;
	$i++;
}

echo json_encode($data);
?>