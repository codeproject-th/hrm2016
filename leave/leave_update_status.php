<?

$sql="SELECT * FROM ".DB_NAME.".leave WHERE leave_id='".$_POST["id"]."'";
$query=mysql_query($sql);
$dbarr=mysql_fetch_array($query);

if($_POST["status"]==1){

if($dbarr["leave_startday"]!=$dbarr["leave_endday"]){
	$day=Dbetween($dbarr["leave_startday"],$dbarr["leave_endday"]);
	foreach($day as $value){
		//print $value."<br>";
		$sql="INSERT INTO leave_approve(
			employees_id,
			leave_id,
			leave_approve_day,
			leave_approve_starttime,
			leave_approveendtime,
			leave_approve_comment,
			create_date,
			create_user
			) VALUES(
			'".$dbarr["employees_id"]."',
			'".$dbarr["leave_id"]."',
			'".$value."',
			'".$dbarr["leave_starttime"]."',
			'".$dbarr["leave_endtime"]."',
			'".$dbarr["leave_comment"]."',
			NOW(),
			'".$_SESSION["login"]["emp_id"]."'
			)";
			//print $sql."<br>";
			mysql_query($sql);
	}
}
else{
	$sql="INSERT INTO leave_approve(
			employees_id,
			leave_id,
			leave_approve_day,
			leave_approve_starttime,
			leave_approveendtime,
			leave_approve_comment,
			create_date,
			create_user
			) VALUES(
			'".$dbarr["employees_id"]."',
			'".$dbarr["leave_id"]."',
			'".$dbarr["leave_startday"]."',
			'".$dbarr["leave_starttime"]."',
			'".$dbarr["leave_endtime"]."',
			'".$dbarr["leave_comment"]."',
			NOW(),
			'".$_SESSION["login"]["emp_id"]."'
			)";
		//print $sql."<br>";
		mysql_query($sql);
}

}
$sql="UPDATE ".DB_NAME.".leave SET leave_status='".$_POST["status"]."' WHERE leave_id='".$_POST["id"]."'";
$query=mysql_query($sql);

$query=mysql_query($sql);

if($query){
	print "
		<script>
			alert('บันทึกข้อมูลเรียบร้อย');
			window.location='index.php?m=leave&page=leave_lis';
		</script>
	";
}
else{
	print "
		<script>
			alert('ERROR');
			window.location='index.php?m=leave&page=leave_lis';
		</script>
	";
}

?>