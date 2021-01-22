<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;
$error = "";
$title = "เพิ่มผู้ใช้งาน";
if($_GET["act"]=="edit"){
	$title = "แก้ไขผู้ใช้งาน";
}

if($_POST){
	
	if($_POST["user_pwd"]!=$_POST["user_pwd2"]){
		$error = "ยืนยันรหัสผ่านไม่ถูกต้อง";
	}
	
	if($error==""){	
		$sql = "UPDATE user SET 
			user_pwd='".$_POST["user_pwd"]."' 
			WHERE employees_id='".$_SESSION["login"]["emp_id"]."'";
		$query = mysql_query($sql);
		$save = true;
	}
		
}

if($_GET["act"]=="add"){
	$sql_emp = "SELECT * FROM employees WHERE emp_id NOT IN  (SELECT employees_id FROM user) ORDER BY emp_name";
}else if($_GET["act"]=="edit"){
	$sql = "SELECT * FROM user WHERE user_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);	
	$sql_emp = "SELECT * FROM employees WHERE emp_id='".$dbarr["employees_id"]."' ORDER BY emp_name";
}

?>
<ol class="breadcrumb">
  <li><a href="#">ผู้ใช้งาน</a></li>
  <li class="active">แก้ไขรหัสผ่าน</li>
</ol>
<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    บันทึกข้อมูลเรียบร้อย
</div>
<? } ?>
<? if($error!=''){ ?>
<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    <?=$error?>
</div>
<? } ?>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">เปลี่ยนรหัสผ่าน</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST">
	 <div class="form-group">
    	<label>รหัสผ่านใหม่</label>
        <input class="form-control" name="user_pwd" value="<?=$dbarr["user_pwd"]?>" placeholder="" type="password" required />
     </div>
	 <div class="form-group">
    	<label>ยืนยันรหัสผ่านใหม่</label>
        <input class="form-control" name="user_pwd2" value="<?=$dbarr["user_pwd"]?>" placeholder="" type="password" required />
     </div>
	 <button type="submit" class="btn btn-primary">เปลี่ยนรหัสผ่าน</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->