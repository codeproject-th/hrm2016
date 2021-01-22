<?
error_reporting ( E_ALL & ~ E_NOTICE );

include_once("./lib/time_attendance.lib.php");

function ChkDate($emp,$time){
	
	$sql = "SELECT * FROM employees WHERE emp_code='".$emp."'";
	$query = mysql_query($sql);
	$emp_row = mysql_fetch_array($query);
	
	$sql = "SELECT * FROM time_attendance_log WHERE time_log_date='".$time."' AND emp_id='".$emp_row['emp_id']."'";
	$query = mysql_query($sql);
	$num_row = mysql_num_rows($query);
	if($emp_row['emp_id']!='' and $num_row=='0'){
		$sql = "INSERT INTO time_attendance_log(time_log_date,emp_id) VALUES('".$time."','".$emp_row['emp_id']."')";
		//echo $sql."<br>";
		mysql_query($sql);
	}
	
}

function TimeSave(){
	$toDay = date('Y-m-d');
	$oldDay = date("Y-m-d",strtotime("-30 day", strtotime($toDay)));
	$sql = "SELECT * FROM employees WHERE emp_jobstart <='".$oldDay."'";
	$query = mysql_query($sql);
	while($dbarr = mysql_fetch_array($query)){
		$emp[] = $dbarr['emp_id'];
	}
	
	$time_attendance = new time_attendance();
	for($i=0;$i<=15;$i++){
		$dateChk = date("Y-m-d",strtotime("+".$i." day", strtotime($oldDay)));
		foreach($emp as $emp_v){
			$time_attendance->chkDateInOut($emp_v,$dateChk);
		}
	}
}



function TimeEX($t){
	$t_ex = explode(" ",$t);
	$retrun['day'] = $t_ex[0];
	$time_ex = explode(":",$t_ex[1]);
	$retrun['time'] = $time_ex[0].":".$time_ex[1];
	return $retrun;
}

$save = false;
if($_FILES){
	//echo '--';
	if($_FILES["file_name"]["name"]!=""){
		$file_ex = explode(".",$_FILES["file_name"]["name"]);
		$file_type = end($file_ex);
		$file_type = strtolower($file_type);
		if($file_type=="txt"){
			move_uploaded_file($_FILES["file_name"]["tmp_name"],"./uploads/time.txt");
			$save = true;
		}else{
			$error = "ชนิดไฟล์ไม่ถูกต้อง";
		}
	}
	
	$text = file('./uploads/time.txt');
	foreach($text as $value){
    	$ex = explode("\t",$value);
		ChkDate($ex[0],$ex[1]);
		//echo "<br><br>";
	}
	TimeSave();
}

?>

<ol class="breadcrumb">
  <li><a href="#">เข้า-ออกงาน</a></li>
  <li class="active">นำเข้าข้อมูลเวลา</li>
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
    	<h3 class="box-title">นำเข้าข้อมูลเวลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST" enctype="multipart/form-data">
	<div class="form-group">
    	<label>Text ไฟล์</label>
       	<input type="file" name="file_name" />
	</div>
	<button type="submit" class="btn btn-primary">Upload</button>
<!-- -->
</form>	 
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

