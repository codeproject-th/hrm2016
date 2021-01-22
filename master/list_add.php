<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO master_list(list_name,list_type) VALUES('".$_POST["list_name"]."','".$_POST['list_type']."')";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE master_list SET list_name='".$_POST["list_name"]."' , list_type='".$_POST['list_type']."' WHERE list_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
}

$title = "เพิ่มรายการเงินเดือน";
if($_GET["act"]=="edit"){
	$title = "แก้ไขรายการเงินเดือน";
	
	$sql = "SELECT * FROM master_list WHERE list_id='".$_GET["id"]."' ORDER BY list_name";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">รายการเงินเดือน</li>
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
    	<label>รายการเงินเดือน</label>
        <input class="form-control" name="list_name" value="<?=$dbarr["list_name"]?>" placeholder="" type="text" required>
     </div>
     <div class="form-group">
    	<label>ประเภท</label>
        <select class="form-control" name="list_type" required="">
        	<option value="">เลือก</option>
        	<option value="1" <? if($dbarr['list_type']=="1"){ ?> selected <? } ?>>รายการรับ</option>
        	<option value="2" <? if($dbarr['list_type']=="2"){ ?> selected <? } ?>>รายการหัก</option>
        </select>
     </div>
	 <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->