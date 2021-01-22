<?php

class leave{
	/*
	บันทึกการลา
	*/
	public $emp_id = "";//ID พนักงาน
	public $data_start = ""; //วันที่เริ่มลา
	public $data_end = "";//วันที่สิ้นสุด
	public $leave_full = "";//1=ลาเตมวัน 2=ลาครึ่งวันเช้า 3=ลาครึ่งวันบ่าย
	public $leave_type = "";//ประเภทการลา
	public $day_move = array();//เก็บวันที่ถูกลบออกเนื่อจากเป้นวันหยุด
	public $error = array();//เก็บ error ต่างๆ
	public $results = array();
	
	public function Add(){
		/* ตรวจสอบการลาก่อน insert ลงฐานข้อมูล */
		$day_n = $this->ClaimDays($this->data_start,$this->data_end);//หาวันที่ห่างกัน
		$day_number = $day_n;
		$day_n = $this->GetWeekend($day_n,$this->data_start);//หาวันหยุดของบริษัท
		$day_n = $this->GetHoliday($day_n,$this->data_start,$this->data_end);//หาวันหยุด
		$day_n = $this->GetOldLeave($this->emp_id,$day_n,$this->data_start,$this->data_end);//หาวันลากรณีมีในระบบแล้ว
		$day_n = $this->CulDay($day_n,$this->leave_full);//คำนวนกรณีลาครึ่งวัน หรือเต็มวัน
		$day_n = $this->GetLeaveType($this->leave_type,$this->emp_id,$day_n,$this->data_start);//ตรวจสอบข้อมูลประเภทการลาว่าเกิดกำหนดหรือยัง
		
		$this->results["count_day"] = $day_n;//เก็บผลที่ได้
		if($day_n <= '-1'){
			$this->error[] = "ไม่สามารถลาได้ เนื่องจากวันลาเกิด";
		}else{
			$this->results["ok"] = true;
			for($i=0;$i<=$day_number-1;$i++){
				$strStartDate = $this->data_start;
				$strNewDate = date("Y-m-d", strtotime("+".$i." day", strtotime($strStartDate)));
				if($this->day_move[$strNewDate]==""){
					$this->results["day"][] = $strNewDate;
				}
			}
		}
		
		
	}
	
	public function ClaimDays($day1,$day2){ //หาวันที่ห่างกัน
		return round((strtotime($day2)-strtotime($day1))/(24*60*60),0)+1;
	}
	
	public function GetWeekend($day_n=0,$strStartDate=""){//หาวันหยุดของบริษัท
		$sql = "SELECT * FROM weekend";//select ข้อมูลวันหยุด
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		for($i=0;$i<=$day_n-1;$i++){
			/*
			loop เพื่อจัดรูปแบบวันที่
			*/
			$strStartDate = $strStartDate;
			$strNewDate = date("Y-m-d", strtotime("+".$i." day", strtotime($strStartDate)));
			$strDay = date('l', strtotime($strNewDate));
			$strDay = strtolower($strDay);
			if($dbarr[$strDay]=="0"){
				$this->day_move[$strNewDate] = $strNewDate;
				$day_n = $day_n-1;
			}
		}
		
		return $day_n;
	}
	
	public function GetHoliday($day_n=0,$data_start="",$data_end=""){//หาวันหยุด
		$sql = "SELECT * FROM holiday WHERE holiday_date BETWEEN '".$data_start."' AND '".$data_end."'";//ดึงข้อมูลวันหยุด
		$query = mysql_query($sql);
		$day = array();
		while($dbarr=mysql_fetch_array($query)){
			$day[$dbarr["holiday_date"]] = $dbarr["holiday_date"]; //เก็บค่าลง array
		}
		
		//
		if(count($day)>0){
			foreach($day as $val){
			/////////////////////
				for($i=0;$i<=$day_n-1;$i++){
					$strStartDate = $data_start;
					$strNewDate = date("Y-m-d", strtotime("+".$i." day", strtotime($strStartDate)));
					if($val==$strNewDate AND $this->day_move[$strNewDate]=="" ){
						$this->day_move[$strNewDate] = $strNewDate;
						$day_n = $day_n-1;
					}
				}
			////////////////////	
			}
		}
		//
		return $day_n;
	}
	
	public function GetOldLeave($emp_id="",$day_n=0,$data_start="",$data_end=""){//หาวันลากรณีมีในระบบแล้ว
		$sql = "SELECT * FROM leave_detail WHERE leave_date BETWEEN '".$data_start."' AND '".$data_end."' AND emp_id='".$emp_id."'";
		$query = mysql_query($sql);
		while($dbarr=mysql_fetch_array($query)){
			//
			for($i=0;$i<=$day_n-1;$i++){
				$strStartDate = $data_start;
				$strNewDate = date("Y-m-d", strtotime("+".$i." day", strtotime($strStartDate)));
				if($dbarr['leave_date']==$strNewDate AND $this->day_move[$strNewDate]=="" AND ($dbarr["status"]=="0" OR $dbarr["status"]=="1")){
					$this->day_move[$strNewDate] = $strNewDate;
					$day_n = $day_n-1;
				}
			}
			//
		}
		return $day_n;
	}
	
	public function CulDay($day_n=0,$leave_full="1"){//คำนวนกรณีลาครึ่งวัน หรือเต็มวัน
		if($leave_full=="1"){
			$day_n = $day_n*1;
		}else if($leave_full=="2" or $leave_full=="3"){
			$day_n = $day_n*0.5;
		}
		
		return $day_n;
	}
	
	public function GetLeaveType($type="",$emp_id="",$day_n=0,$data_start=""){//ตรวจสอบข้อมูลประเภทการลาว่าเกิดกำหนดหรือยัง
		$sql = "SELECT * FROM master_leave_type WHERE leave_type_id='".$type."'";
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		$leave_n = $dbarr["leave_number"];
		$date_cut = date("Y")."-".str_pad($dbarr["leave_cut_month"],2,'0',STR_PAD_LEFT)."-".str_pad($dbarr["leave_cut_day"],2,'0',STR_PAD_LEFT);
		$date_cut_old = (date("Y")-1)."-".str_pad($dbarr["leave_cut_month"],2,'0',STR_PAD_LEFT)."-".str_pad($dbarr["leave_cut_day"],2,'0',STR_PAD_LEFT);
		$sql = "SELECT * FROM `leave` WHERE emp_id='".$emp_id."' 
				AND leave_type='".$type."' 
				AND leave_end_day <= '".$date_cut."' 
				AND leave_end_day >= '".$date_cut_old."'";
		
		$query = mysql_query($sql);
		$count_day = 0;
		while($dbarr=mysql_fetch_array($query)){
			if($dbarr["leave_status"]=="0" or $dbarr["leave_status"]=="1"){
				$count_day = $count_day+$dbarr["leave_n"];
			}
		}
		
		$count_day = $count_day+$day_n;
		
		$this->results["use_day"] = $day_n;
		
		$count_day = $leave_n-$count_day;
		//$count_day = $count_day - 0.5;
		return $count_day;
	}
}

?>