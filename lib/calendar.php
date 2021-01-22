<?php
/*
ปฏิทิน
คำนวณการแสดงผลปฏิทิน
การดึงจะดึงย้อนหลัง 1 ปี และ ล่วงหน้า 1 ปี
*/
class calendar{
	
	
	public function weekend(){
		/* หาค่าวันหยุดบริษัท
		
		 */
		$sql = "SELECT * FROM weekend";
		$query = mysql_query($sql);
		$w_row = mysql_fetch_array($query);
		
		/*เก็บค่าที่ได้จากการquery ลงตวแปร array */
		$w[0] = $w_row['sunday'];
		$w[1] = $w_row['monday'];
		$w[2] = $w_row['tuesday'];
		$w[3] = $w_row['wednesday'];
		$w[4] = $w_row['thursday'];
		$w[5] = $w_row['friday'];
		$w[6] = $w_row['saturday'];
		
		
		$year = date("Y");//ปีปัจจุบัน
		$yearOld = $year-1;//ปีก่อนหน้า 
		$yearNext = $year+1;//ปีถัดไป
		
		//วนลูปหาค่า จากปีที่แล้ว จนถึงปีหน้า
		for($y=$yearOld;$y<=$yearNext;$y++){
			for($m=1;$m<=12;$m++){
				$countDay = $d = cal_days_in_month(CAL_GREGORIAN,$m,$y);//function หาจำนวนวันในแต่ละเดือน
				for($d=1;$d<=$countDay;$d++){
					$StrDate = $y."-".str_pad($m,2,"0",STR_PAD_LEFT)."-".str_pad($d,2,"0",STR_PAD_LEFT);//จัดรูปแบบวันที่
					$DayOfWeek = date("w", strtotime($StrDate));
					if($w[$DayOfWeek]=="0"){
						$DayDate = '';
						//เก็บค่าลง array ค่าปกติเป็นวันหยุดบริษัท
						$r[] = array(
							"id" => "",//id 
							"title" => "วันหยุดบริษัท",//ส่วรแสดงข้อความในปฏิทิน
							"start" => $StrDate,//วันที่เริ่ม
							"end" => $StrDate,//วันที่สิ้นสุด
							"backgroundColor" => "#00a65a",//สีพื้นหลัง
							"borderColor" => "#00a65a",//สีเส้น
							"url" => "",
							"allDay" => true
						);
						//
					}
				}
			}
		}
		
		return $r;
	}
	
	public function holiday(){
		/* หาวันหยุดราชการ */
		$year = date("Y");
		$yearOld = $year-1;
		$yearNext = $year+1;
		
		$d_start = $yearOld."-01-01"; 
		$d_end = $yearNext."-12-31"; 
		
		$sql = "SELECT * FROM holiday WHERE holiday_date  BETWEEN '".$d_start."' AND '".$d_end."' ";//select จากฐานข้อมูล
		
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			//เก็บค่าลงarray
			$r[] = array(
							"id" => "",
							"title" => $dbarr['holiday_name'],
							"start" => $dbarr['holiday_date'],
							"end" => $dbarr['holiday_date'],
							"backgroundColor" => "#00a65a",
							"borderColor" => "#00a65a",
							"url" => "",
							"allDay" => true
						);
		}
		
		return $r;
	}
	
	public function empLeave($emp_id=''){
		/* 
		หาวันลาพนักงาน
		$emp_id คือ id พนักงาน
		*/
		$year = date("Y");
		$yearOld = $year-1;
		$yearNext = $year+1;
		
		$d_start = $yearOld."-01-01"; 
		$d_end = $yearNext."-12-31"; 
		
		$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$emp_id."' 
				AND time_status='04'
		 ";// select ข้อมูล จากตารางเวลาเข้ออกงานพนักงาน
		 
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			$r[] = array(
							"id" => "",
							"title" => "ลา",
							"start" => $dbarr['time_day'],
							"end" => $dbarr['time_day'],
							"backgroundColor" => "#0073b7",
							"borderColor" => "#0073b7",
							"url" => "",
							"allDay" => true
						);
		}
		
		return $r;
	}
	
	public function empLate($emp_id=''){
		/* 
		หาเวลาสาย
		$emp_id คือ id พนักงาน
		*/
		$year = date("Y");
		$yearOld = $year-1;
		$yearNext = $year+1;
		
		$d_start = $yearOld."-01-01"; 
		$d_end = $yearNext."-12-31"; 
		
		$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$emp_id."'
				AND time_status='02'
		 ";//ดึงข้อมูล ที่มีสถานะ เท่ากับ2คือสาย
		 
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			//เก็บลงarray
			$r[] = array(
							"id" => "",
							"title" => "สาย(".$this->TimeRep($dbarr['time_in'])."-".$this->TimeRep($dbarr['time_out']).")",
							"start" => $dbarr['time_day'],
							"end" => $dbarr['time_day'],
							"backgroundColor" => "#f39c12",
							"borderColor" => "#f39c12",
							"url" => "",
							"allDay" => true
						);
		}
		
		return $r;
	}
	
	public function empTimework($emp_id=''){
		$year = date("Y");
		$yearOld = $year-1;
		$yearNext = $year+1;
		
		$d_start = $yearOld."-01-01"; 
		$d_end = $yearNext."-12-31"; 
		
		$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$emp_id."'
				AND time_status='03'
		 ";
		 
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			$r[] = array(
							"id" => "",
							"title" => "ขาดงาน",
							"start" => $dbarr['time_day'],
							"end" => $dbarr['time_day'],
							"backgroundColor" => "#dd4b39",
							"borderColor" => "#dd4b39",
							"url" => "",
							"allDay" => true
						);
		}
		
		return $r;
	}
	
	public function empTimeAtt($emp_id=''){
		/*
		ดึงเวลาเข้างาน
		*/
		$year = date("Y");
		$yearOld = $year-1;
		$yearNext = $year+1;
		
		$d_start = $yearOld."-01-01"; 
		$d_end = $yearNext."-12-31"; 
		
		$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$emp_id."'
				AND time_status='01'
		 ";
		 
		$query = mysql_query($sql);
		while($dbarr = mysql_fetch_array($query)){
			$r[] = array(
							"id" => "",
							"title" => $this->TimeRep($dbarr['time_in'])."-".$this->TimeRep($dbarr['time_out']),
							"start" => $dbarr['time_day'],
							"end" => $dbarr['time_day'],
							"backgroundColor" => "#FBFBEF",
							"borderColor" => "#FBFBEF",
							"textColor" => "#000000",
							"url" => "",
							"allDay" => true
						);
		}
		
		return $r;
	}
	
	public function TimeRep($t=''){
		/*
		แยกวันที่กับเวลา
		*/
		if($t != ''){
			$tx = explode(":",$t);
			return $tx[0].':'.$tx[1];
		}
	}
	
	
}

?>