<?php
include('./lib/leave.day.lib.php');
$leave_day = new leave_day();
$sql = "SELECT * FROM master_leave_type ORDER BY  leave_type_name";
$query = mysql_query($sql);
?>
<ol class="breadcrumb">
  <li><a href="#">ปฏิทิน</a></li>
  <li class="active">สถิติการลา</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">สถิติการลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<table class="table table-striped">
    	<tr>
            <th>ประเภทการลา</th>
            <th width="10%"><center>จำนวนวัน</center></th>
			<th width="10%"><center>ใช้ไป</center></th>
			<th width="10%"><center>คงเหลือ</center></th>
			<th width="10%"><center>ตัดรอบ</center></th>
        </tr>	
<?
while($dbarr = mysql_fetch_array($query)){
	$data = $leave_day->get($_SESSION["login"]["emp_id"],$dbarr["leave_type_id"],date("Y"));
?>
		<tr>
			<td><?=$dbarr["leave_type_name"]?></td>
			<td align="center"><?=$dbarr["leave_number"]?></td>
			<td align="center"><?=$data["use"]?></td>
			<td align="center"><?=$data["balance"]?></td>
			<td align="center"><?=conver_dateSQL($data["cut"])?></td>
		</tr>
<? } ?>
</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->