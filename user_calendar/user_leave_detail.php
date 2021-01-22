<?php

if($_POST){
	$sql = "SELECT * FROM `leave` WHERE leave_id='".$_GET["id"]."' and emp_id='".$_SESSION["login"]["emp_id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	if($dbarr["leave_status"]!="0"){
		$sql = "UPDATE `leave` SET leave_status='3' WHERE leave_id='".$_GET["id"]."' and emp_id='".$_SESSION["login"]["emp_id"]."'";
		mysql_query($sql);
	}
	$save = true;
}


$sql = "SELECT * FROM `leave` WHERE leave_id='".$_GET["id"]."' and emp_id='".$_SESSION["login"]["emp_id"]."'";
$query = mysql_query($sql);
$dbarr = mysql_fetch_array($query);
?>
<ol class="breadcrumb">
  <li><a href="#">ปฏิทิน</a></li>
  <li class="active">รายละเอียดการลา</li>
</ol>

<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    ยกเลิกการลาเรียบร้อย
</div>
<? } ?>

<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">รายละเอียดการลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST">
	<div class="form-group">
    	<label>พนักงาน</label>
        <select class="form-control" name="emp_id" readonly required>
<?
$sql = "SELECT * FROM employees WHERE emp_id='".$dbarr["emp_id"]."' ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr_emp = mysql_fetch_array($query)){
?>
	<option value="<?=$dbarr_emp["emp_id"]?>" <? if($dbarr["emp_id"]==$dbarr_emp["emp_id"]){ ?> selected <? } ?>><?=$dbarr_emp["emp_name"]?> <?=$dbarr_emp["emp_last_name"]?></option>
<? } ?>
		</select>
     </div>
	<div class="form-group">
    	<label>ประเภทการลา</label>
        <select class="form-control" name="leave_type" readonly required>
<?
$sql = "SELECT * FROM master_leave_type  ORDER BY leave_type_name";
$query = mysql_query($sql);
while($dbarr_leave = mysql_fetch_array($query)){
?>
	<option value="<?=$dbarr_leave["leave_type_id"]?>" <? if($dbarr["leave_type"]==$dbarr_leave["leave_type_id"]){ ?> selected <? } ?>><?=$dbarr_leave["leave_type_name"]?></option>
<? } ?>
		</select>
     </div>
	 <div class="form-group">
    	<label>การลา</label>
		 <div class="checkbox">
         	<label>
        	 <? if($dbarr["leave_full"]=="1" or $dbarr["leave_full"]==""){ ?>  เต็มวัน <? } ?>
			 <? if($dbarr["leave_full"]=="2"){ ?> ครึ่งวันเช้า <? } ?>
			 <? if($dbarr["leave_full"]=="3"){ ?> ครึ่งวันบ่าย <? } ?>
			</label>
		</div>
     </div>
	 <div class="form-group">
    	<label>วันที่</label>
        <input class="form-control datepicker" name="leave_start_day" value="<?=conver_dateSQL($dbarr["leave_start_day"])?>" placeholder="" type="text" readonly required />
     </div>
	 <div class="form-group">
    	<label>ถึงวันที่</label>
        <input class="form-control datepicker" name="leave_end_day" value="<?=conver_dateSQL($dbarr["leave_end_day"])?>" placeholder="" type="text" readonly required />
     </div>
	 <div class="form-group">
    	<label>สาเหตุการลา</label>
        <textarea class="form-control" readonly rows="3" name="leave_comment" placeholder=""><?=$dbarr["leave_comment"]?></textarea>
     </div>
	  <div class="form-group">
    	<label>สถานะการลา</label>
		 <div class="checkbox">
         	<label>
				<? if($dbarr["leave_status"]=="0" or $dbarr["leave_status"]==""){ ?> รออนุมัติ <? } ?>
        		<? if($dbarr["leave_status"]=="1"){ ?> อนุมัติ <? } ?>
				<? if($dbarr["leave_status"]=="2"){ ?> ไม่อนุมัติ <? } ?>
				<? if($dbarr["leave_status"]=="3"){ ?> ยกเลิก <? } ?>
			</label>
		</div>
     </div>
	  <? if($dbarr["leave_status"]=="2"){ ?>
	 	<div class="form-group has-error">
    		<label>สาเหตุไม่อนุมัติ</label>
			<textarea class="form-control" readonly rows="3"  placeholder=""><?=$dbarr["leave_approve_comment"]?></textarea>
		</div>
	  <? } ?>
	 <br>
	 <? if($dbarr["leave_status"]<>"0" and $dbarr["leave_status"]<>"2"  and $save!=true){ ?>
	 <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-ban"></i> ยกเลิกการลา</button>
	 <? } ?>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->