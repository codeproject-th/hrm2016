<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO master_office(office_name) VALUES('".$_POST["office_name"]."')";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE master_office SET office_name='".$_POST["office_name"]."' WHERE office_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
}

$title = "เพิ่มตำแหน่งาน";
if($_GET["act"]=="edit"){
	$title = "แก้ไขตำแหน่งงาน";
	
	$sql = "SELECT * FROM master_office WHERE office_id='".$_GET["id"]."' ORDER BY office_name";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">ตำแหน่งงาน</li>
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
    	<label>ตำแหน่งงาน</label>
        <input class="form-control" name="office_name" value="<?=$dbarr["office_name"]?>" placeholder="" type="text" required>
     </div>
	 <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->