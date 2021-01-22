<?

$sql = "SELECT * FROM setting_salary ";
$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
	$set[$dbarr['setting_salary_code']] = $dbarr['setting_salary_value'];
}

//print_r($set);

$salary_month = $_POST['salary_month'];
$salary_year = $_POST['salary_year'];
$employees_id = $_POST['employees_id'];

$time_status = array(
					"01" => "ปกติ",
					"02" => "สาย",
					"03" => "ขาด",
					"04" => "วันหยุดบริษัท",
					"05" => "วันหยุดราชการ"
				);//สร้า array ตามสถานะ เพื่อได้ไม่ต้องเขียนซ้ำๆๆ

////////////////
$sql = "SELECT * FROM salary WHERE salary_month = '".str_pad($salary_month,2,"0",STR_PAD_LEFT)."' AND salary_year='".$salary_year."' AND employees_id='".$employees_id."'";//ดึงข้อมูลเงินเดือน
$query = mysql_query($sql);
$salary_data = mysql_fetch_array($query);
if($salary_data['salary_id']==''){
	$act = "add";
}else{
	$act = "edit";
}


$sql = "SELECT * FROM salary_detail WHERE salary_id='".$salary_data['salary_id']."'";
$salary_detail_query = mysql_query($sql);
while($dbarr = mysql_fetch_array($salary_detail_query)){
	$salary_detail_arr[$dbarr['list_id']] = $dbarr['money'];
}

////////////////
$sql = "SELECT * FROM employees WHERE emp_id='".$employees_id."'";
$query = mysql_query($sql);
$emp_data = mysql_fetch_array($query);


/* OT */
include('./lib/ot.php');
$ot = new ot();
$ot->month = str_pad($salary_month,2,"0",STR_PAD_LEFT);
$ot->year = $salary_year;
$ot->emp_id = $employees_id;
$ot->get_ot();
/* END */

$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$employees_id."' 
				AND time_day BETWEEN '".$salary_year."-".str_pad($salary_month,2,"0",STR_PAD_LEFT)."-01' 
				AND '".$salary_year."-".str_pad($salary_month,2,"0",STR_PAD_LEFT)."-31'";//ดึงข้อมูล
$query = mysql_query($sql);
?>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title"><?=$emp_data["emp_name"]?> <?=$emp_data["emp_last_name"]?></h3>
  	</div>
  	<div class="box-body">
  		<div class="table-responsive">
  			<table class="table table-hover">
  				<thead>
  					<th>วันที่</th>
  					<th>เวลาเข้างาน</th>
  					<th>เวลาออกงาน</th>
  					<th>สถานะ</th>
  					<th>โอที/ชัวโมง</th>
  				</thead>
<?
//print_r($ot->OtArr);
while($dbarr = mysql_fetch_array($query)){
	$ot_money = $ot_money+$ot->OtArr[$dbarr['time_day']]['money'];
	//echo $ot->OtArr[$dbarr['time_day']]['money']."<br>";
?>
	<tr>
		<td><?=conver_datetime($dbarr['time_day'])?></td>
		<td><?=$dbarr['time_in']?></td>
  		<td><?=$dbarr['time_out']?></td>
  		<td><?=$time_status[$dbarr['time_status']]?></td>
  		<td><?=$ot->OtArr[$dbarr['time_day']]['hour']?></td>
	</tr>
<?
}
?>
			</table>
		</div>
  	</div>
</div>
<!------------------------------------------------------>
<form role="form" method="POST" action="index.php?m=salary&p=salary_save&act=<?=$act?>">
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">รานการเงินเดือน</h3>
  	</div>
  	<div class="box-body">
  		<div class="table-responsive">
  			<table class="table table-hover">
  				<thead>
  					<th>รายการ</th>
  					<th>จำนวนเงิน</th>
  				</thead>
<?
$sql = "SELECT * FROM master_list WHERE list_type='1'";
$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
	$s_val = "";
	if($salary_data['salary_id']==''){
		if($dbarr['list_code']=="01"){
			$s_val = $emp_data["emp_salary"];
		}
		
		if($dbarr['list_code']=="03"){
			$s_val = $ot_money;
		}
	}else{
		$s_val = $salary_detail_arr[$dbarr['list_id']];
	}
	?>
		<tr>
			<td><?=$dbarr['list_name']?>(+)</td>
			<td>
				<input type="text" name="list[<?=$dbarr['list_id']?>]" value="<?=$s_val?>"/>
			</td>
		</tr>
	<?
}
?>

<?
$sql = "SELECT * FROM master_list WHERE list_type='2'";
$query = mysql_query($sql);
while($dbarr = mysql_fetch_array($query)){
	$s_val = "";
	if($salary_data['salary_id']==''){
		if($dbarr['list_code']=="01"){
			$s_val = $emp_data["emp_salary"];
		}
		
		if($dbarr['list_code']=="03"){
			$s_val = $ot_money;
		}
		
		if($dbarr['list_code']=="02"){
			$s_val = $emp_data["emp_salary"]*($set['02']/100);
			if($s_val>$set['03']){
				$s_val = $set['03'];
			}
		}
		
	}else{
		$s_val = $salary_detail_arr[$dbarr['list_id']];
	}
	
	
?>
		<tr>
			<td><?=$dbarr['list_name']?>(-)</td>
			<td>
				<input type="text" name="list[<?=$dbarr['list_id']?>]" value="<?=$s_val?>"/>
			</td>
		</tr>
	<?
}
?>
  			</table>
  			<input type="hidden" name="salary_id" value="<?=$salary_data['salary_id']?>"/>
  			<input type="hidden" name="employees_id" value="<?=$employees_id?>"/>
  			<input type="hidden" name="salary_month" value="<?=str_pad($salary_month,2,"0",STR_PAD_LEFT)?>"/>
  			<input type="hidden" name="salary_year" value="<?=$salary_year?>"/>
	 		<button type="submit" class="btn btn-primary">บันทึก</button>
  		</div>
  	</div>
</div>
</form>