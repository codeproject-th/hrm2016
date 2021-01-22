<?
error_reporting ( E_ALL & ~ E_NOTICE );
include_once("./lib/leave.lib.php");
include_once("./lib/pusher.php");
include_once("./includes/push.php");

$save = false;
$error = "";
$title = "ขอลา";

if($_POST){
	
	$sql = "SELECT * FROM leave_endorser WHERE emp_id='".$_POST["emp_id"]."'";
	$query = mysql_query($sql);
	$endorser = mysql_fetch_array($query);
	if($_GET["act"]=="add"){
		
		$leave = new leave();
		$leave->data_start = dateSQL($_POST["leave_start_day"]);
		$leave->data_end = dateSQL($_POST["leave_end_day"]);
		$leave->leave_full = $_POST["leave_full"];
		$leave->leave_type = $_POST["leave_type"];
		$leave->emp_id = $_POST["emp_id"];
		$leave->Add();
		//print_r($leave->results);
		
		$sql = "INSERT INTO `leave`(
					emp_id,
					leave_type,
					leave_start_day,
					leave_end_day,
					leave_comment,
					leave_status,
					leave_endorser_emp,
					leave_n,
					leave_full,
					create_date
				) VALUES(
					'".$_SESSION["login"]["emp_id"]."',
					'".$_POST["leave_type"]."',
					'".dateSQL($_POST["leave_start_day"])."',
					'".dateSQL($_POST["leave_end_day"])."',
					'".$_POST["leave_comment"]."',
					'0',
					'".$endorser["leave_endorser_emp"]."',
					'".$leave->results["use_day"]."',
					'".$_POST["leave_full"]."',
					NOW()
				)";
		
		if($leave->results["ok"]==true and $leave->results["use_day"]>'0'){	
			
			$query = mysql_query($sql);
			$insert_id = mysql_insert_id();
			push_leave($insert_id);
			if(count($leave->results["day"])>0){
				foreach($leave->results["day"] as $val){
					$sql="INSERT INTO leave_detail(
							leave_id,
							emp_id,
							leave_date,
							status
						) VALUES(
							'".$insert_id."',
							'".$_SESSION["login"]["emp_id"]."',
							'".$val."',
							'0'
						)";
					mysql_query($sql);
				}
			}
			
			$save = true;
		}else{
			$error = $leave->error[0];
			if($leave->results["use_day"]=='0'){
				$error = "คุณลาวันนี้แล้วไม่สามารถลาได้อีก";
			}
		}
	}
}

?>
<ol class="breadcrumb">
  <li><a href="#">ปฏิทิน</a></li>
  <li class="active">ขอลา</li>
</ol>
<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    บันทึกข้อมูลเรียบร้อย
</div>
<? } ?>
<? if($error!=""){ ?>
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
    	<label>พนักงาน</label>
        <select class="form-control" name="emp_id" required>
<?
$sql = "SELECT * FROM employees WHERE emp_id='".$_SESSION["login"]["emp_id"]."' ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr_emp = mysql_fetch_array($query)){
?>
	<option value="<?=$dbarr_emp["emp_id"]?>" <? if($_SESSION["login"]["emp_id"]==$dbarr_emp["emp_id"]){ ?> selected <? } ?>><?=$dbarr_emp["emp_name"]?> <?=$dbarr_emp["emp_last_name"]?></option>
<? } ?>
		</select>
     </div>
	<div class="form-group">
    	<label>ประเภทการลา</label>
        <select class="form-control" name="leave_type" required>
			<option value="">เลือก</option>
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
        		<input type="radio" name="leave_full" <? if($dbarr["leave_full"]=="1" or $dbarr["leave_full"]==""){ ?> checked <? } ?> value="1"/> เต็มวัน &nbsp;&nbsp;&nbsp;
				<input type="radio" name="leave_full" <? if($dbarr["leave_full"]=="2"){ ?> checked <? } ?> value="2"/> ครึ่งวันเช้า &nbsp;&nbsp;&nbsp;
				<input type="radio" name="leave_full" <? if($dbarr["leave_full"]=="3"){ ?> checked <? } ?> value="3"/> ครึ่งวันบ่าย &nbsp;&nbsp;&nbsp;
			</label>
		</div>
     </div>
	 <div class="form-group">
    	<label>วันที่</label>
        <input class="form-control datepicker" name="leave_start_day" value="<?=conver_dateSQL($dbarr["leave_start_day"])?>" placeholder="" type="text" required />
     </div>
	 <div class="form-group">
    	<label>ถึงวันที่</label>
        <input class="form-control datepicker" name="leave_end_day" value="<?=conver_dateSQL($dbarr["leave_end_day"])?>" placeholder="" type="text" required />
     </div>
	 <div class="form-group">
    	<label>สาเหตุการลา</label>
        <textarea class="form-control" rows="3" name="leave_comment" placeholder=""><?=$dbarr["leave_comment"]?></textarea>
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