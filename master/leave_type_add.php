<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO master_leave_type (
						leave_type_name,
						leave_number,
						leave_cut_day,
						leave_cut_month
					) VALUES(
						'".$_POST["leave_type_name"]."',
						'".$_POST["leave_number"]."',
						'".$_POST["leave_cut_day"]."',
						'".$_POST["leave_cut_month"]."'
					)";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE master_leave_type SET 
					leave_type_name='".$_POST["leave_type_name"]."',
					leave_number='".$_POST["leave_number"]."',
					leave_cut_day='".$_POST["leave_cut_day"]."',
					leave_cut_month='".$_POST["leave_cut_month"]."'
				WHERE leave_type_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
}

$title = "เพิ่มประเภทการลา";
if($_GET["act"]=="edit"){
	$title = "แก้ไขประเภทการลา";
	
	$sql = "SELECT * FROM master_leave_type WHERE leave_type_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">ประเภทการลา</li>
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
    	<h3 class="box-title"><?=$title?></h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST">
	<div class="form-group">
		<label>การลา</label>
        <input class="form-control" name="leave_type_name" value="<?=$dbarr["leave_type_name"]?>"  type="text">
		<!-- /.input group -->
     </div>
     <!-- /.form group -->
	 <div class="form-group">
    	<label>จำนวนครั้งที่ใช้ได้</label>
        <input class="form-control" name="leave_number" value="<?=$dbarr["leave_number"]?>" placeholder="" type="number" required>
     </div>
	 <div class="form-group">
    	<label>วันที่ตัดรอบ</label>
        <input class="form-control" name="leave_cut_day" value="<?=$dbarr["leave_cut_day"]?>" placeholder="" type="number">
     </div>
	 <div class="form-group">
    	<label>เดือนที่ตัดรอบ</label>
        <input class="form-control" name="leave_cut_month" value="<?=$dbarr["leave_cut_month"]?>" placeholder="" type="number">
     </div>
	 <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

<script>
$(function() {
	$('.datepicker').datepicker({
    	format: 'dd-mm-yyyy',
	});
});
</script>