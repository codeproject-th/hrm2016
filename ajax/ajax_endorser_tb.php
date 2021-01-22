<?php
include("./../includes/config.inc.php");
include("./../includes/conn.php");
include("./../includes/function.php");
$party_id = $_POST["party_id"];
$sql = "SELECT l.* , e1.*  , e2.emp_name as emp_name2 , e2.emp_last_name as emp_last_name2 FROM leave_endorser l
		LEFT JOIN employees e1 ON e1.emp_id=l.emp_id 
		LEFT JOIN employees e2 ON e2.emp_id=l.leave_endorser_emp 
	 	WHERE l.leave_endorser_emp='".$_POST["endorser_emp"]."'";
$query = mysql_query($sql);
?>

<table id="empData" class="table">
	<tr>
		<th>พนักงาน</th>
		<th>ผู้อนุมัติ</th>
        <th width="10%">ลบ</th>
	</tr>
	<tbody>
<?
while($dbarr = mysql_fetch_array($query)){
?>
	<tr>
		<td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
		<td><?=$dbarr["emp_name2"]?> <?=$dbarr["emp_last_name2"]?></td>
		<td><button type='button' class='btn btn-xs btn-default' onclick="DelEmp('<?=$dbarr["emp_id"]?>')"><i class='fa fa-fw fa-trash'></i></button></td>
	</tr>
<? } ?>	
	</tbody>	
</table>