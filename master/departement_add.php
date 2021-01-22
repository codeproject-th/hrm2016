<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

$title = "เพิ่มแผนก";
if($_GET["act"]=="edit"){
	$title = "แก้ไขแผนก";
	
	$sql = "SELECT * FROM master_department WHERE department_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO master_department(department_name,party_id) VALUES('".$_POST["dep"]."','".$_POST["party_id"]."')";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE master_department SET department_name='".$_POST["dep"]."' , party_id='".$_POST["party_id"]."' WHERE department_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
}

?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">แผนก</li>
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
        <select class="form-control" name="party_id" required>
			<option value="">เลือก</option>
<?
$sql = "SELECT * FROM master_party";
$query = mysql_query($sql);
while($dbarr_party = mysql_fetch_array($query)){
?>
	<option <? if($dbarr_party['party_id']==$dbarr['party_id']){ ?>selected<? } ?> value="<?=$dbarr_party["party_id"]?>"><?=$dbarr_party["party_name"]?></option>
<? } ?>
		</select>
     </div>
	<div class="form-group">
    	<label>แผนก</label>
        <input class="form-control" name="dep" value="<?=$dbarr["department_name"]?>" placeholder="" type="text" required>
     </div>
	 <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->