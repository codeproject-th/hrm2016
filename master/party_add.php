<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO master_party(party_name) VALUES('".$_POST["party"]."')";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE master_party SET party_name='".$_POST["party"]."' WHERE party_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
}

$title = "เพิ่มฝ่าย";
if($_GET["act"]=="edit"){
	$title = "แก้ไขฝ่าน";
	
	$sql = "SELECT * FROM master_party WHERE party_id='".$_GET["id"]."' ORDER BY party_name";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">ฝ่าย</li>
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
    	<label>ฝ่าย</label>
        <input class="form-control" name="party" value="<?=$dbarr["party_name"]?>" placeholder="" type="text" required>
     </div>
	 <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->