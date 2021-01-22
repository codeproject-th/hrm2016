<?
error_reporting ( E_ALL & ~ E_NOTICE );
/* บันทึกการลา */
//echo ">>".dateSQL($_POST["leave_start_day"])."<br>";
//echo ">>".dateSQL($_POST["leave_end_day"]);

include_once("./lib/leave.lib.php");

include_once("./lib/time_attendance.lib.php");
function TimeSave($emp_v,$daet_start,$daet_end){
	$countDay = round((strtotime($daet_end)-strtotime($daet_start))/(24*60*60),0)+1;
	$time_attendance = new time_attendance();
	
	for($i=0;$i<=($countDay-1);$i++){
		$tDay = date("Y-m-d", strtotime("+".$i." day", strtotime($daet_start)));
		$time_attendance->chkDateInOut($emp_v,$tDay);
	}
	
}

function TimeDel($emp_v,$daet_start,$daet_end){
	$countDay = round((strtotime($daet_end)-strtotime($daet_start))/(24*60*60),0)+1;
	$time_attendance = new time_attendance();
	
	for($i=0;$i<=($countDay-1);$i++){
		$tDay = date("Y-m-d", strtotime("+".$i." day", strtotime($daet_start)));
		$sql = "DELETE FROM time_attendance_emp WHERE emp_id='".$emp_v."' AND time_day='".$tDay."'";
		$query = mysql_query($sql);
	}
}

$save = false;
$error = "";
$title = "เพิ่มข้อมูลการลา";

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
					'".$_POST["emp_id"]."',
					'".$_POST["leave_type"]."',
					'".dateSQL($_POST["leave_start_day"])."',
					'".dateSQL($_POST["leave_end_day"])."',
					'".$_POST["leave_comment"]."',
					'".$_POST["leave_status"]."',
					'".$endorser["leave_endorser_emp"]."',
					'".$leave->results["use_day"] ."',
					'".$_POST["leave_full"]."',
					NOW()
				)";
		
		if($leave->results["ok"]==true and $leave->results["use_day"]>'0'){	
			
			$query = mysql_query($sql);
			$insert_id = mysql_insert_id();
			if(count($leave->results["day"])>0){
				foreach($leave->results["day"] as $val){
					$sql="INSERT INTO leave_detail(
							leave_id,
							emp_id,
							leave_date,
							status
						) VALUES(
							'".$insert_id."',
							'".$_POST["emp_id"]."',
							'".$val."',
							'".$_POST["leave_status"]."'
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
	}else if($_GET["act"]=="edit"){
		
		$sql = "SELECT * FROM `leave` WHERE leave_id='".$_GET["id"]."'";
		$query = mysql_query($sql);
		$DataRowl = mysql_fetch_array($query);
		if($DataRowl['leave_status']=='1'){
			TimeDel($DataRowl['emp_id'],$DataRowl['leave_start_day'],$DataRowl['leave_end_day']);
		}
		
		$sql = "UPDATE `leave` SET leave_n = '0' ,
					leave_start_day = '',
					leave_end_day = '' 
					WHERE leave_id='".$_GET["id"]."'";
		mysql_query($sql);
		
		$sql = "DELETE FROM leave_detail WHERE leave_id='".$_GET["id"]."'";
		mysql_query($sql);
		
		$leave = new leave();
		$leave->data_start = dateSQL($_POST["leave_start_day"]);
		$leave->data_end = dateSQL($_POST["leave_end_day"]);
		$leave->leave_full = $_POST["leave_full"];
		$leave->leave_type = $_POST["leave_type"];
		$leave->emp_id = $_POST["emp_id"];
		$leave->Add();
		//print_r($leave->results);
		
		$sql = "UPDATE `leave` SET 
					emp_id = '".$_POST["emp_id"]."',
					leave_type = '".$_POST["leave_type"]."',
					leave_start_day = '".dateSQL($_POST["leave_start_day"])."',
					leave_end_day = '".dateSQL($_POST["leave_end_day"])."',
					leave_comment = '".$_POST["leave_comment"]."',
					leave_status = '".$_POST["leave_status"]."',
					leave_endorser_emp = '".$endorser["leave_endorser_emp"]."',
					leave_n = '".$leave->results["use_day"] ."',
					leave_full = '".$_POST["leave_full"]."' 
					WHERE leave_id='".$_GET["id"]."'
				";
		//echo $sql;
		if($leave->results["ok"]==true and $leave->results["use_day"]>'0'){	
		
			$query = mysql_query($sql);
			
			//Update row time
			if($_POST["leave_status"]=="1"){
				$sqlx = "SELECT * FROM `leave` WHERE leave_id='".$_GET["id"]."'";
				$query = mysql_query($sqlx);
				$DataRowl = mysql_fetch_array($query);
				//print_r($DataRowl);
				if($_POST["leave_status"]=='1'){
					TimeSave($DataRowl['emp_id'],$DataRowl['leave_start_day'],$DataRowl['leave_end_day']);
				}
			}
			
			$insert_id = $_GET["id"];
			if(count($leave->results["day"])>0){
				foreach($leave->results["day"] as $val){
					$sql="INSERT INTO leave_detail(
							leave_id,
							emp_id,
							leave_date,
							status
						) VALUES(
							'".$insert_id."',
							'".$_POST["emp_id"]."',
							'".$val."',
							'".$_POST["leave_status"]."'
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

if($_GET["act"]=="edit"){
	$title = "แก้ไขข้อมูลการลา";
	$sql = "SELECT * FROM `leave` WHERE leave_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarrData = mysql_fetch_array($query);
}


?>
<ol class="breadcrumb">
  <li><a href="#">การลา</a></li>
  <li class="active">ข้อมูลการลา</li>
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
			<option value="">เลือก</option>
<?
$sql = "SELECT * FROM employees ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr_emp = mysql_fetch_array($query)){
?>
	<option value="<?=$dbarr_emp["emp_id"]?>" <? if($dbarrData["emp_id"]==$dbarr_emp["emp_id"]){ ?> selected <? } ?>><?=$dbarr_emp["emp_name"]?> <?=$dbarr_emp["emp_last_name"]?></option>
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
	<option value="<?=$dbarr_leave["leave_type_id"]?>" <? if($dbarrData["leave_type"]==$dbarr_leave["leave_type_id"]){ ?> selected <? } ?>><?=$dbarr_leave["leave_type_name"]?></option>
<? } ?>
		</select>
     </div>
	 <div class="form-group">
    	<label>การลา</label>
		 <div class="checkbox">
         	<label>
        		<input type="radio" name="leave_full" <? if($dbarrData["leave_full"]=="1" or $dbarrData["leave_full"]==""){ ?> checked <? } ?> value="1"/> เต็มวัน &nbsp;&nbsp;&nbsp;
				<input type="radio" name="leave_full" <? if($dbarrData["leave_full"]=="2"){ ?> checked <? } ?> value="2"/> ครึ่งวันเช้า &nbsp;&nbsp;&nbsp;
				<input type="radio" name="leave_full" <? if($dbarrData["leave_full"]=="3"){ ?> checked <? } ?> value="3"/> ครึ่งวันบ่าย &nbsp;&nbsp;&nbsp;
			</label>
		</div>
     </div>
	 <div class="form-group">
    	<label>วันที่</label>
        <input class="form-control datepicker" name="leave_start_day" value="<?=conver_dateSQL($dbarrData["leave_start_day"])?>" placeholder="" type="text" required />
     </div>
	 <div class="form-group">
    	<label>ถึงวันที่</label>
        <input class="form-control datepicker" name="leave_end_day" value="<?=conver_dateSQL($dbarrData["leave_end_day"])?>" placeholder="" type="text" required />
     </div>
	 <div class="form-group">
    	<label>สาเหตุการลา</label>
        <textarea class="form-control" rows="3" name="leave_comment" placeholder=""><?=$dbarrData["leave_comment"]?></textarea>
     </div>
	  <div class="form-group">
    	<label>สถานะการลา</label>
		 <div class="checkbox">
         	<label>
				<input type="radio" name="leave_status" <? if($dbarrData["leave_status"]=="0" or $dbarrData["leave_status"]==""){ ?> checked <? } ?> value="0"/> รออนุมัติ &nbsp;&nbsp;&nbsp;
        		<input type="radio" name="leave_status" <? if($dbarrData["leave_status"]=="1"){ ?> checked <? } ?> value="1"/> อนุมัติ &nbsp;&nbsp;&nbsp;
				<input type="radio" name="leave_status" <? if($dbarrData["leave_status"]=="2"){ ?> checked <? } ?> value="2"/> ไม่อนุมัติ &nbsp;&nbsp;&nbsp;
				<input type="radio" name="leave_status" <? if($dbarrData["leave_status"]=="3"){ ?> checked <? } ?> value="3"/> ยกเลิก &nbsp;&nbsp;&nbsp;
			</label>
		</div>
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