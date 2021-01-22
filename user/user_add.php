<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;
$error = "";
$title = "เพิ่มผู้ใช้งาน";
if($_GET["act"]=="edit"){
	$title = "แก้ไขผู้ใช้งาน";
}

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "SELECT COUNT(*) AS N FROM user WHERE user_name='".$_POST["user_name"]."'";
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		if($dbarr["N"]=="0"){
			$sql = "INSERT INTO user(
							user_name,
							user_pwd,
							user_type,
							employees_id,
							create_date
						) VALUES(
							'".$_POST["user_name"]."',
							'".$_POST["user_pwd"]."',
							'".$_POST["user_type"]."',
							'".$_POST["employees_id"]."',
							NOW()
						)";
			$query = mysql_query($sql);
			$save = true;
		}else{
			$error = "ชื่อผู้ใช้งานมีอยู่ในระบบแล้วไม่สามารถเพิ่มได้";
		}
	}else if($_GET["act"]=="edit"){
		
		$sql = "SELECT COUNT(*) AS N FROM user WHERE user_name='".$_POST["user_name"]."' AND user_id!='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		if($dbarr["N"]=="0"){
			$sql = "UPDATE user SET 
							user_name='".$_POST["user_name"]."',
							user_pwd='".$_POST["user_pwd"]."',
							user_type='".$_POST["user_type"]."',
							employees_id='".$_POST["employees_id"]."' 
						WHERE user_id='".$_GET['id']."'";
			$query = mysql_query($sql);
			$save = true;
		}else{
			$error = "ชื่อผู้ใช้งานมีอยู่ในระบบแล้วไม่สามารถเพิ่มได้";
		}
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
  <li class="active">ข้อมูลผู้ใช้งาน</li>
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
    	<h3 class="box-title"><?=$title?></h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST">
	<div class="form-group">
    	<label>ชื่อ-นามสกุล</label>
        <select class="form-control" name="employees_id" required>
			<option value="">เลือก</option>
<?
$sql = "SELECT * FROM employees ORDER BY emp_name";
$query = mysql_query($sql_emp);
while($dbarr_emp = mysql_fetch_array($query)){
?>
	<option value="<?=$dbarr_emp["emp_id"]?>" <? if($dbarr["employees_id"]==$dbarr_emp["emp_id"]){ ?> selected <? } ?>><?=$dbarr_emp["emp_name"]?> <?=$dbarr_emp["emp_last_name"]?></option>
<? } ?>
		</select>
     </div>
	<div class="form-group">
    	<label>ประเภทผู้ใช้งาน</label>
        <select class="form-control" name="user_type" required>
			<option value="">เลือก</option>
			<option value="1" <? if($dbarr["user_type"]=="1"){ ?> selected <? } ?>>ผู้ดูแลระบบ</option>
			<option value="2" <? if($dbarr["user_type"]=="2"){ ?> selected <? } ?>>ผู้ใช้งาน</option>
			<option value="3" <? if($dbarr["user_type"]=="3"){ ?> selected <? } ?>>พนักงาน</option>
		</select>
     </div>
	 <div class="form-group">
    	<label>ชื่อผู้ใช้งาน</label>
        <input class="form-control" name="user_name" value="<?=$dbarr["user_name"]?>" placeholder="" type="text" required />
     </div>
	 <div class="form-group">
    	<label>รหัสผ่าน</label>
        <input class="form-control" name="user_pwd" value="<?=$dbarr["user_pwd"]?>" placeholder="" type="text" required />
     </div>
	 <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->