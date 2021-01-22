<?php
include_once("./lib/time_attendance.lib.php");
$time_attendance = new time_attendance();
if($_POST){
	$sql = "DELETE FROM time_attendance_log WHERE emp_id='".$_POST['emp_id_h']."' AND DATE(time_log_date)='".dateSQL($_POST['time_day'])."'";
	mysql_query($sql);
	$sql = "INSERT INTO time_attendance_log(time_log_date,emp_id) VALUES('".dateSQL($_POST['time_day'])." ".$_POST['time_in'].":00','".$_POST['emp_id_h']."')";
	mysql_query($sql);
	$sql = "INSERT INTO time_attendance_log(time_log_date,emp_id) VALUES('".dateSQL($_POST['time_day'])." ".$_POST['time_out'].":00','".$_POST['emp_id_h']."')";
	//echo $sql;
	mysql_query($sql);
	$time_attendance->chkDateInOut($_POST['emp_id_h'],dateSQL($_POST['time_day']));
	$save = true;
}

$sql = "SELECT * FROM time_attendance_emp WHERE time_id='".$_GET['time_id']."'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
?>
<ol class="breadcrumb">
  <li><a href="#">เข้า-ออกงาน</a></li>
  <li class="active">ข้อมูลเวลา</li>
</ol>
<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    บันทึกข้อมูลเรียบร้อย
</div>
<? } ?>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">แก้ไขข้อมูลเวลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST" enctype="multipart/form-data">
	<div class="form-group">
    	<label>พนักงาน</label>
		<select class="form-control" name="emp" disabled="true" required>
		<option value="">เลือก</option>
<?
$sql = "SELECT * FROM employees ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
?>      
	<option value="<?=$dbarr['emp_id']?>" <? if($dbarr['emp_id']==$row['emp_id']){ ?> selected <?  }?>><?=$dbarr['emp_name']?> <?=$dbarr['emp_last_name']?></option>
<? } ?> 	
        </select>
     </div>
	<div class="form-group">
    	<label>วันที่</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
        	</div>
        	<input class="form-control datepicker" readonly name="time_day" value="<?=conver_dateSQL($row["time_day"])?>"  type="text">
		</div>
     </div>
     <div class="form-group">
    	<label>เวลาเข้างาน</label>
		<div class="input-group bootstrap-timepicker timepicker">
			<div class="input-group-addon">
				<i class="fa fa-clock-o"></i>
        	</div>
        	<input class="form-control timepicker" name="time_in" value="<?=$row['time_in']?>"  type="text">
		</div>
     </div> 
     <div class="form-group">
    	<label>เวลาออกงาน</label>
		<div class="input-group bootstrap-timepicker timepicker">
			<div class="input-group-addon">
				<i class="fa fa-clock-o"></i>
        	</div>
        	<input class="form-control timepicker" name="time_out" value="<?=$row['time_out']?>"   type="text">
		</div>
     </div> 
     <button type="submit" class="btn btn-primary">บันทึก</button>
     <input type="hidden" name="time_id" value="<?=$row['time_id']?>"/>  
     <input type="hidden" name="emp_id_h" value="<?=$row['emp_id']?>"/> 
</form>
<!------------------------------------------------------------------------------------>
	</div>
</div><!-- /.box -->
<?
if($_POST){
	
$status_arr['01'] = "-";
$status_arr['02'] = "สาย";
$status_arr['03'] = "ขาด";
$status_arr['04'] = "ลา";

$sql = "SELECT t.* ,e.* FROM time_attendance_emp t 
		LEFT JOIN employees e ON t.emp_id=e.emp_id 
		WHERE t.emp_id = '".$_POST['emp']."' 
		AND t.time_day BETWEEN '".conver_dateSQL($_POST['date_start'])."' 
		AND '".conver_dateSQL($_POST['date_end'])."'";
//echo $sql;
$query = mysql_query($sql);
if(mysql_num_rows($query)>'0'){
?>

<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ผลการค้นหา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>  	
<table class="table table-bordered">
	<tbody>
		<tr>
        	<th style=""><center>วันที่</center></th>
            <th><center>เวลา</center></th>
            <th><center>สถานะ</center></th>
            <th><center>ชื่อนามสกุล</center></th>
            <th><center>แก้ไข/ลบ</center></th>
         </tr>
<?
while($dbarr = mysql_fetch_array($query)){
?>
	<tr>
      <td><center><?=$dbarr["time_day"]?></center></td>
      <td><center><?=$dbarr["time_in"]?> - <?=$dbarr["time_out"]?></center></td>
      <td><center><?=$status_arr[$dbarr["time_status"]]?></center></td>
      <td><?=$dbarr['emp_name']?> <?=$dbarr['emp_last_name']?></td>
      <td>
      	<center>
      		<div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=time_add&act=edit&time_id=<?=$dbarr["time_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=employees_del&id=<?=$dbarr["leave_type_id"]?>" onclick="return confirm('ลบ <?=$dbarr["leave_type_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
        </center>
      </td>
    </tr>
<? } ?>
     </tbody>
</table>
<!------------------------------------------------------------------------------------>  	
  	</div>
</div>
<? } ?>
<? } ?>
<script>
$(function() {	
	$('.datepicker').datepicker({
    	format: 'dd-mm-yyyy',
		language: "th"
	});
	
	$(".timepicker").timepicker({
		showSeconds: false,
        showMeridian: false           
	});
	
});
</script>