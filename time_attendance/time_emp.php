<ol class="breadcrumb">
  <li><a href="#">เข้า-ออกงาน</a></li>
  <li class="active">ข้อมูลเวลา</li>
</ol>

<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ข้อมูลเวลาพนักงาน</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST" enctype="multipart/form-data">
	<div class="form-group">
    	<label>พนักงาน</label>
		<select class="form-control" name="emp" required>
		<option value="">เลือก</option>
<?
$sql = "SELECT * FROM employees ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
?>      
	<option value="<?=$dbarr['emp_id']?>"><?=$dbarr['emp_name']?> <?=$dbarr['emp_last_name']?></option>
<? } ?> 	
        </select>
     </div>
	<div class="form-group">
    	<label>วันที่</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
        	</div>
        	<input class="form-control datepicker" name="date_start" value="<?=conver_dateSQL($dbarr["emp_jobstart"])?>"  type="text">
		</div>
     </div>
     <div class="form-group">
    	<label>ถึงวันที่</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
        	</div>
        	<input class="form-control datepicker" name="date_end" value="<?=conver_dateSQL($dbarr["emp_jobstart"])?>"  type="text">
		</div>
     </div> 
     <button type="submit" class="btn btn-primary">ค้นหา</button>    
</form>
<!------------------------------------------------------------------------------------>
	</div>
</div><!-- /.box -->
<?
if($_POST){
	
$status_arr['01'] = "ปกติ";
$status_arr['02'] = "สาย";
$status_arr['03'] = "ขาด";
$status_arr['04'] = "ลา";
$status_arr['05'] = "วันหยุดบริษัท";
$status_arr['06'] = "วันหยุดเทศกาล";

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
            <th><center>รหัสพนักงาน</center></th>
            <th><center>ชื่อนามสกุล</center></th>
            <th><center>แก้ไข</center></th>
         </tr>
<?
while($dbarr = mysql_fetch_array($query)){
?>
	<tr>
      <td><center><?=conver_dateSQL($dbarr["time_day"])?></center></td>
      <td><center><?=TimeRep($dbarr["time_in"])?> - <?=TimeRep($dbarr["time_out"])?></center></td>
      <td><center><?=$status_arr[$dbarr["time_status"]]?></center></td>
      <td><center><?=$dbarr['emp_code']?></center></td>
      <td><?=$dbarr['emp_name']?> <?=$dbarr['emp_last_name']?></td>
      <td>
      	<center>
      		<div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=time_add&act=edit&time_id=<?=$dbarr["time_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<!--<a href="index.php?m=<?=$m?>&p=employees_del&id=<?=$dbarr["leave_type_id"]?>" onclick="return confirm('ลบ <?=$dbarr["leave_type_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>-->
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
	
});
</script>