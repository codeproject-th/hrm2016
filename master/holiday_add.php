<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO holiday(
						holiday_name,
						holiday_date,
						holiday_comment,
						create_date
					) VALUES(
						'".$_POST["holiday_name"]."',
						'".dateSQL($_POST["holiday_date"])."',
						'".$_POST["holiday_comment"]."',
						NOW()
					)";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE holiday SET 
					holiday_name = '".$_POST["holiday_name"]."',
					holiday_date = '".dateSQL($_POST["holiday_date"])."',
					holiday_comment = '".$_POST["holiday_comment"]."'
				WHERE holiday_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
}

$title = "เพิ่มวันหยุดนักขัตฤกษ์";
if($_GET["act"]=="edit"){
	$title = "แก้ไขวันหยุดนักขัตฤกษ์";
	
	$sql = "SELECT * FROM holiday WHERE holiday_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">วันหยุดนักขัตฤกษ์</li>
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
		<label>วันที่</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
            </div>
            <input class="form-control datepicker" name="holiday_date" value="<?=conver_dateSQL($dbarr["holiday_date"])?>"  type="text">
        </div>
		<!-- /.input group -->
     </div>
     <!-- /.form group -->
	 <div class="form-group">
    	<label>เทศกาล</label>
        <input class="form-control" name="holiday_name" value="<?=$dbarr["holiday_name"]?>" placeholder="" type="text" required>
     </div>
	 <div class="form-group">
    	<label>หมายเหตุ</label>
        <input class="form-control" name="holiday_comment" value="<?=$dbarr["holiday_comment"]?>" placeholder="" type="text">
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
		language: "th"
	});
});
</script>