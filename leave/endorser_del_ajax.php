<?

$sql = "DELETE FROM leave_endorser WHERE emp_id='".$_POST["emp_id"]."'";//ลบข้อมูลผู้อนุมัตื
$query = mysql_query($sql);
?>