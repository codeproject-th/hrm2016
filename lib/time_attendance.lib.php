<?php

class time_attendance{
	/* คำนวณเวลาพนักงาน */
	public function chkDateInOut($emp_id,$day){
		/* ตรวจสอบเวลาเข้างาน */
		$sql = "SELECT * FROM weekend";
		$query = mysql_query($sql);
		$w_row = mysql_fetch_array($query);
		$w_in = $w_row['job_in'];
		$w_out = $w_row['job_out'];
		$sql = "SELECT * FROM time_attendance_log WHERE emp_id='".$emp_id."' AND DATE(time_log_date)='".$day."'";//ดึงข้อมูลจาก time_attendance_log เก็บข้อมูลจากืtext ไฟล์ทั้งหมด
		//echo $sql."<br>";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		//echo '->'.mysql_num_rows($query);
		if(mysql_num_rows($query)=='0'){
			$sql = "SELECT * FROM `leave` 
				WHERE emp_id = '".$emp_id."' 
				AND leave_status = '1' 
				AND (leave_start_day <= '".$day."' AND leave_end_day >= '".$day."') 
				";//ดึงข้อมูลวันที่ลา
				
			//$log_web = new log_web($sql);
			
			$query = mysql_query($sql);
			//echo '>'.mysql_num_rows($query);
			if(mysql_num_rows($query)>'0'){
				$dbarr = mysql_fetch_array($query);
				if($dbarr['leave_full']=='1'){ //ตรวจสอบว่าลาครึ่งวีนหรือเต็มวัน ถ้าเต็มใ้มีสถานะวันลา
					$this->EmpTimeInsert(array('emp_id'=>$emp_id,'time_day'=>$day,'time_status'=>'04'));
				}else if($dbarr['leave_full']=='2' or $dbarr['leave_full']=='3'){//ถ่าลา เท่ากัยครึ้งเช้า หรือบ่าย ให้ตรวจสอบเวลาเข้างาน
					$sql = "SELECT * FROM time_attendance_log WHERE emp_id='".$emp_id."' AND DATE(time_log_date)='".$day."' ORDER BY time_log_date ";
					$query = mysql_query($sql);
					$i = 0;
					while($dbarr=mysql_fetch_array($query)){
						if($i=='0'){
							$TimeEX = $this->TimeEX($dbarr['time_log_date']);
							$time_in = $TimeEX['time'];
						}else{
							$TimeEX = $this->TimeEX($dbarr['time_log_date']);
							$time_chk = $TimeEX['time'];
							$time_in_chk =  date("H:i",strtotime("+15 minutes", strtotime($time_in)));
							if(str_replace(",","",number_format(str_replace(":","",$time_chk)))>str_replace(",","",number_format(str_replace(":","",$time_in_chk))))
							{
								$time_out = $TimeEX['time'];	
							}			
						}
						$i++;
					}
				
					if($time_in==""){
						$time_in = "0";
					}
					if($time_out==""){
						$time_out = "0";
					}
				
					$time_in_re = str_replace(",","",number_format(str_replace(":","",$time_in)));
					$time_out_re = str_replace(",","",number_format(str_replace(":","",$time_out)));
					$w_in_re = str_replace(",","",number_format(str_replace(":","",$w_in)));
					$w_out_re = str_replace(",","",number_format(str_replace(":","",$w_out)));
					$time_status = "04";
					if($dbarr['leave_full']=='2'){
						if($time_in_re > $w_in_re or $time_out_re < $w_out_re ){
							$time_status = "02";
						}else{
							$time_status = "04";
						}
					}
					$this->EmpTimeInsert(array('emp_id'=>$emp_id,'time_day'=>$day,'time_status'=>$time_status,'time_in'=>$time_in,'time_out'=>$time_out));
				}
			//
			}else{
				//ขาดงาน
				$this->EmpTimeInsert(array('emp_id'=>$emp_id,'time_day'=>$day,'time_status'=>'03'));
				//ตรวจสอบว่าเป็นวันหยุดหรือเปล่า
				$this->ChkWeekend($emp_id,$day);
				$this->ChkHoliday($emp_id,$day);
			}
		}else{
	
		//กรณีเวลา
			$sql = "SELECT * FROM time_attendance_log WHERE emp_id='".$emp_id."' AND DATE(time_log_date)='".$day."' ORDER BY time_log_date ";
			$query = mysql_query($sql);
			$i = 0;
			while($dbarr=mysql_fetch_array($query)){
				if($i=='0'){
					$TimeEX = $this->TimeEX($dbarr['time_log_date']);
					$time_in = $TimeEX['time'];
				}else{
					$TimeEX = $this->TimeEX($dbarr['time_log_date']);
					$time_chk = $TimeEX['time'];
					$time_in_chk =  date("H:i",strtotime("+15 minutes", strtotime($time_in)));
					//echo "->".$time_in_chk;
					if(str_replace(",","",number_format(str_replace(":","",$time_chk)))>str_replace(",","",number_format(str_replace(":","",$time_in_chk))))
					{
						$time_out = $TimeEX['time'];	
					}			
				}
				$i++;
			}
		
			if($time_in==""){
				$time_in = "0";
			}
			if($time_out==""){
				$time_out = "0";
			}
		
			$time_in_re = str_replace(",","",number_format(str_replace(":","",$time_in)));
			$time_out_re = str_replace(",","",number_format(str_replace(":","",$time_out)));
			$w_in_re = str_replace(",","",number_format(str_replace(":","",$w_in)));
			$w_out_re = str_replace(",","",number_format(str_replace(":","",$w_out)));
			$time_status = "01";
		
			if($time_in_re > $w_in_re or $time_out_re < $w_out_re ){
				$time_status = "02";
			}else{
				$time_status = "01";
			}
		
			$this->EmpTimeInsert(array('emp_id'=>$emp_id,'time_day'=>$day,'time_status'=>$time_status,'time_in'=>$time_in,'time_out'=>$time_out));
		
		}
	
	/////
		
	}
////////////////////////////////
	public function EmpTimeInsert($arr=array()){
		/* insert ผลการประมวลเข้างานออกงาน ลง table */
		$sql_emp = "SELECT * FROM employees WHERE emp_id='".$arr['emp_id']."' AND emp_jobstart <= '".$arr['time_day']."' ";
		$query_emp = mysql_query($sql_emp);
		if($arr['emp_id']!='' and mysql_num_rows($query_emp)>'0'){//emp id ต้องไม่ว่า  และมากกว่า0
			$sql = "SELECT * FROM time_attendance_emp WHERE emp_id='".$arr['emp_id']."' and time_day='".$arr['time_day']."' ";
			$query = mysql_query($sql);
			if(mysql_num_rows($query)=='0'){	
				$sql = "INSERT INTO time_attendance_emp(
					emp_id,
					time_day,
					time_in,
					time_out,
					time_status
				) VALUES(
					'".$arr['emp_id']."',
					'".$arr['time_day']."',
					'".$arr['time_in']."',
					'".$arr['time_out']."',
					'".$arr['time_status']."'
				)";	
			}else{
				$sql = "UPDATE time_attendance_emp SET 
					time_in='".$arr['time_in']."' , 
					time_out='".$arr['time_out']."' , 
					time_status='".$arr['time_status']."' 
					WHERE emp_id='".$arr['emp_id']."'	AND time_day='".$arr['time_day']."'		
					";
			}
			mysql_query($sql);
		
		}
	}
	
	
	////////วันหยุด
	
	//วันหยุดบริษัท
	public function ChkWeekend($emp_id,$day){
		$sql = "SELECT * FROM weekend";
		$query = mysql_query($sql);
		$w_row = mysql_fetch_array($query);
		
		$w[0] = $w_row['sunday'];
		$w[1] = $w_row['monday'];
		$w[2] = $w_row['tuesday'];
		$w[3] = $w_row['wednesday'];
		$w[4] = $w_row['thursday'];
		$w[5] = $w_row['friday'];
		$w[6] = $w_row['saturday'];
		$DayOfWeek = date("w", strtotime($day));
		if($w[$DayOfWeek]=="0"){
			$this->EmpTimeInsert(
				array(
						'emp_id'=>$emp_id,
						'time_day'=>$day,
						'time_status'=>'05',
						'time_in'=>'00:00',
						'time_out'=>"00:00"
					)
				);
		}
	}
	
	//วันหยุดเทศการ
	public function ChkHoliday($emp_id,$day){
		$sql = "SELECT * FROM holiday WHERE holiday_date='".$day."'";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)>'0'){
			$this->EmpTimeInsert(
				array(
						'emp_id'=>$emp_id,
						'time_day'=>$day,
						'time_status'=>'06',
						'time_in'=>'00:00',
						'time_out'=>"00:00"
					)
				);
		}
	}
	
	////////
	public function TimeEX($t){
		$t_ex = explode(" ",$t);
		$retrun['day'] = $t_ex[0];
		$time_ex = explode(":",$t_ex[1]);
		$retrun['time'] = $time_ex[0].":".$time_ex[1];
		return $retrun;
	}
	///////
}

?>