<?

$sql="DELETE FROM employees WHERE emp_id='".$_GET["id"]."'";
$query=mysql_query($sql);

?>
<script>
	alert("ลบข้อมูลเรียบร้อย");
	window.location="index.php?m=employees&p=employees";
</script>