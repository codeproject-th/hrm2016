<?php

class leave_day{
	/*
	จัดการการลา
	
	*/

	public function Get($emp_id="",$leave_type="",$year=""){
		/*
		ดึงข้อมูลการลา
		*/
		$sql = "SELECT * FROM master_leave_type WHERE leave_type_id='".$leave_type."'";//ดึงของมูลประเภทการลา
		$query = mysql_query($sql);
		$dbarr = mysql_fetch_array($query);
		
		$leave_n = $dbarr["leave_number"];
		$date_cut = $year."-".str_pad($dbarr["leave_cut_month"],2,'0',STR_PAD_LEFT)."-".str_pad($dbarr["leave_cut_day"],2,'0',STR_PAD_LEFT);//แปลงรูปแบบวันที่
		$date_cut_old = ($year-1)."-".str_pad($dbarr["leave_cut_month"],2,'0',STR_PAD_LEFT)."-".str_pad($dbarr["leave_cut_day"],2,'0',STR_PAD_LEFT);
		$sql = "SELECT * FROM `leave` WHERE emp_id='".$emp_id."' 
				AND leave_type='".$leave_type."' 
				AND leave_end_day <= '".$date_cut."' 
				AND leave_end_day >= '".$date_cut_old."'";//query ข้อมูลการลาของพนักงาน โดยระบุวันที่เริ่ม แลสิ้นสุด
		
		$query = mysql_query($sql);
		$count_day = 0;
		while($dbarr=mysql_fetch_array($query)){
			if($dbarr["leave_status"]=="0" or $dbarr["leave_status"]=="1"){
				$count_day = $count_day+$dbarr["leave_n"];
			}
		}
		
		$return["use"] = $count_day;//ใช้ไป
		$return["balance"] = $leave_n-$count_day;//คงเหลือ
		$return["cut"] = $date_cut;//วันที่ตัด
		$return["cut_old"] = $date_cut_old;//วันที่ตัดก่อนหน้า
		return $return;
	}
	

}

?>