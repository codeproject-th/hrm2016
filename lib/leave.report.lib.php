<?php

class leave_report{
	/* รายงานการลา */
	public $year;
	public $party;
	public $department;
	public $Data = array();
	public $Emp = array();
	
	public function GetReport(){
		//หาแผนก ฝ่าย
		if($this->party!='' AND $this->department==''){
			$sql = "SELECT * FROM employees WHERE emp_party='".$this->party."'";
		}else if($this->party!='' AND $this->department!=''){
			$sql = "SELECT * FROM employees WHERE emp_department='".$this->department."'";
		}else{
			$sql = "SELECT * FROM employees";
		}
		
		
		$query = mysql_query($sql);
		$i = 0;
		$in = "";
		$empName = array();
		while($dbarr = mysql_fetch_array($query)){
			//จัดคำสั่ สำหรับดึงข้อมูลพนักงาน
			$empName[$dbarr["emp_id"]] = $dbarr["emp_name"]." ".$dbarr["emp_last_name"];
			if($i==0){
				$in .= "'".$dbarr["emp_id"]."'";
			}else{
				$in .= ",'".$dbarr["emp_id"]."'";
			}
			
			$i++;
		}
		
		if($in==""){
			$in = "'0'";
		}
		
		$sql = "SELECT * FROM master_leave_type";
		$query = mysql_query($sql);
		$year = $this->year;
		while($dbarr = mysql_fetch_array($query)){
			/*
			loop ดึงข้อมูลการลา
			*/
			$leave_n = $dbarr["leave_number"];
			$date_cut = $year."-".str_pad($dbarr["leave_cut_month"],2,'0',STR_PAD_LEFT)."-".str_pad($dbarr["leave_cut_day"],2,'0',STR_PAD_LEFT);
			$date_cut_old = ($year-1)."-".str_pad($dbarr["leave_cut_month"],2,'0',STR_PAD_LEFT)."-".str_pad($dbarr["leave_cut_day"],2,'0',STR_PAD_LEFT);
			$sql2 = "SELECT * FROM `leave` WHERE emp_id IN(".$in.")  
				AND leave_type = '".$dbarr["leave_type_id"]."' 
				AND leave_end_day <= '".$date_cut."' 
				AND leave_end_day >= '".$date_cut_old."'";
			$query2 = mysql_query($sql2);
			$count_day = 0;
			while($dbarr2=mysql_fetch_array($query2)){
				if($dbarr2["leave_status"]=="1"){
					//เก็บค่าลงตัวแปร array
					$count_day = $count_day+$dbarr2["leave_n"];
					$this->Emp[$dbarr2["emp_id"]][$dbarr["leave_type_id"]] = $this->Emp[$dbarr2["emp_id"]][$dbarr["leave_type_id"]]+$dbarr2["leave_n"];
					$this->Emp[$dbarr2["emp_id"]]["name"] = $empName[$dbarr2["emp_id"]];
				}
			}
			
			$this->Data[$dbarr["leave_type_id"]]["name"] = $dbarr["leave_type_name"];
			$this->Data[$dbarr["leave_type_id"]]["day"] = $count_day;
		}
		return $this->Data;
	}
	

}

?>