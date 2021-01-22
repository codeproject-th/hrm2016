<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/leave.lib.php");
include_once("../lib/time_attendance.lib.php");

if($_REQUEST){
	$userLogin = getUser($_REQUEST["emp_id"]);
	$sql = "SELECT e.* , d.department_name , p.office_name , pa.party_name FROM  employees e 
			LEFT JOIN master_department d ON e.emp_department=d.department_id
			LEFT JOIN master_party pa ON e.emp_party=pa.party_id 
			LEFT JOIN master_office p ON e.emp_party=p.office_id
			WHERE e.emp_id='".$userLogin["emp_id"]."'";
	//echo $sql;
	$query = mysql_query($sql);
	while($dbarr = mysql_fetch_array($query)){
		if($dbarr["emp_img"]==""){
			$dbarr["emp_img"] = WEB_URL."/employees_img/anonymous.png";
		}else{
			$dbarr["emp_img"] = WEB_URL."/employees_img/".$dbarr["emp_img"];
		}
		$data[] = array(
					"fullName" => $dbarr["emp_name"]." ".$dbarr["emp_last_name"],
					"office_name" => $dbarr["office_name"],
					"party_name" => $dbarr["party_name"],
					"department_name" => $dbarr["department_name"],
					"img" => $dbarr["emp_img"]
				);
	}
}

header('Content-Type: application/json');
echo $_GET['callback'].'('.json_encode($data).');';
?>