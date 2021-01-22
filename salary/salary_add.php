<?
//เพิ่มเงินเดือน'
error_reporting ( E_ALL & ~ E_NOTICE );

function getList($id){
	//ดึงmaster รายการเงินเดือน
	$sql = "SELECT * FROM master_list WHERE list_id='".$id."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	return $dbarr;
}


$save = false;

$title = "บันทึกการจ่ายเงิเดือน";
if($_GET["act"]=="edit"){
	$title = "แก้ไขบันทึกการจ่ายเงิเดือน";
	
	$sql = "SELECT * FROM salary WHERE salary_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	$emp_edit = $dbarr['employees_id'];
	$m_edit = $dbarr['salary_month'];
	$y_edit = $dbarr['salary_year'];
	$sql = "SELECT * FROM salary_detail WHERE salary_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	while($dbarr=mysql_fetch_array($query)){
		$listData[$dbarr['list_id']] = $dbarr['money'];
	}
}


?>
<ol class="breadcrumb">
  <li><a href="#">เงินเดือน</a></li>
  <li class="active">การจ่ายเงินเดือน</li>
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
    	<label>เดือน</label>
        <select class="form-control" name="salary_month" required>
			<option value="">เลือก</option>
<?
		for($i=1;$i<=12;$i++){
?>
		<option value="<?=$i?>" <? if($m_edit==$i){ ?> selected <? } ?>><?=monthThai($i)?></option>
<? 		
		} 
?>
		</select>
     </div>
     <div class="form-group">
    	<label>ปี</label>
        <select class="form-control"  name="salary_year" required>
			<option value="">เลือก</option>
<?
		$y = date('Y')-2;
		for($i=1;$i<=2;$i++){
			$y = $y+1;
?>
		<option value="<?=$y?>" <? if($y_edit==$y){ ?> selected <? } ?>><?=$y?></option>
<? 		
		} 
?>
		</select>
    </div>
	<div class="form-group">
    	<label>พนักงาน</label>
        <select class="form-control" name="employees_id" required>
        	<option value="">เลือก</option>
<?
$sql = "SELECT * FROM employees ORDER BY emp_name";//ดึงข้อมูลพนักงาน
$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
?>
		<option value="<?=$dbarr['emp_id']?>" <? if($dbarr['emp_id']==$emp_edit){ ?> selected <? } ?>><?=$dbarr['emp_code']?>-<?=$dbarr['emp_name']?> <?=$dbarr['emp_last_name']?></option>
<? } ?>
        </select>
     </div>
     <input type="hidden" name="salary_id" value="<?=$_GET['id']?>"/>
	 <button type="submit" class="btn btn-primary">ค้นหา</button>
</form>

<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->


<? 
if($_POST){ 
	include("./salary/salary_time.php");
} 
?>