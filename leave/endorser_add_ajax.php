<?

$sql = "SELECT COUNT(*) AS N FROM leave_endorser WHERE emp_id='".$_POST["emp_id"]."'";
$query = mysql_query($sql);
$dbarr = mysql_fetch_array($query);
if($dbarr["N"]=="0"){
	$sql = "INSERT INTO leave_endorser(emp_id,leave_endorser_emp) VALUES('".$_POST["emp_id"]."','".$_POST["endorser_emp"]."')";
}else{
	$sql = "UPDATE leave_endorser SET leave_endorser_emp='".$_POST["endorser_emp"]."'WHERE emp_id='".$_POST["emp_id"]."'";
}

mysql_query($sql);
?>