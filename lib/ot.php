<?php

class ot{
	/*
	การหา OT
	*/
	
	public $job_day = 30;//จำนวนวันที่คิด
	public $time_out = "";//ไว้เก็บเวลาออกงาน
	public $salary = "";//ไว้เกบเงินเดือน
	public $emp_id = "";//ไว้เก็บ id พนักงาน
	public $month = "";//ไว้เก็บเดือน
	public $year = "";//ปี
	public $ot_price = "";//เงินค่า ot
	public $OtArr = array();//วันที่ทำ ot
	
	public function get_ot(){
		//Query Master OT
		$sql = "SELECT * FROM setting_salary ";
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			$set[$dbarr['setting_salary_code']] = $dbarr['setting_salary_value'];
		}
		//ดึงข้อมูลพนักงาน
		$sql = "SELECT * FROM employees WHERE emp_id='".$this->emp_id."'";
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		//$this->ot_price = $dbarr['emp_salary']/$this->job_day;
		//$this->ot_price = round($this->ot_price,2,PHP_ROUND_HALF_ODD)/9;//คำนวนหาค่าจ้างรายชัวโมง
		//$this->ot_price = round($this->ot_price,2,PHP_ROUND_HALF_ODD);
		$this->ot_price = $set['01'];
		/* หาวันหยุด */
		$sql = "SELECT * FROM weekend";
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		$this->time_out = $dbarr['job_out'];
		//echo $this->time_out;
		
		//ดึงข้อมูล time ที่มาทำงาน หรือเข้างานสาย
		$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$this->emp_id."' 
				AND time_day BETWEEN '".$this->year."-".$this->month."-01' 
				AND '".$this->year."-".$this->month."-31'";
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			if($dbarr['time_status']=="01" or $dbarr['time_status']=="02"){
				$t = str_replace(":","",$this->setTime($dbarr['time_out']))-str_replace(":","",$this->time_out);//เอาเวลาออกงาน ลบเวลาที่สแกนออกงาน
				//echo $this->time_out.":".$this->setTime($dbarr['time_out'])."=".$t."";
				if($t>=100){
					$hour = floor($t/100);
					$money = $hour*$this->ot_price;
					$this->OtArr[$dbarr['time_day']] = array('hour'=>$hour,'money'=>$money);
				}
				//echo "<br>";
			}
		}
	}
	
	public function setTime($t){
		$tx = explode(":",$t);
		return $tx[0].":".$tx[1];
	}
	
}

?>