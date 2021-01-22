<?

function department(){
	$sql="SELECT * FROM master_department";
	$query=mysql_query($sql);
	$data=array();
	while($dbarr=mysql_fetch_array($query)){
		$data[]=$dbarr;
	}
	
	return $data;
}

function office(){
	$sql="SELECT * FROM master_office";
	$query=mysql_query($sql);
	while($dbarr=mysql_fetch_array($query)){
		$data[]=$dbarr;
	}
	
	return $data;
}

function employees($id){
	$sql="SELECT * FROM employees WHERE employees_id='".$id."'";
	$query=mysql_query($sql);
	$dbarr=mysql_fetch_array($query);
	return $dbarr;
}

function conver_dateSQL($date){
	$new_date=explode("-",$date);
	$new_date_day=$new_date[2];
	$new_date_month=$new_date[1];
	$new_date_year=$new_date[0];
	
	$new_d=$new_date_day."-".$new_date_month."-".$new_date_year;
	if($date==""){
		$new_d="";
	}
	return $new_d;
}

function dateSQL($date){
	$new_date=explode("-",$date);
	$new_date_day=$new_date[0];
	$new_date_month=$new_date[1];
	$new_date_year=$new_date[2];
	
	if(strlen($new_date_day)==1){
		$new_date_day="0".$new_date_day;
	}
	if(strlen($new_date_month)==1){
		$new_date_month="0".$new_date_month;
	}
	
	$new_d=$new_date_year."-".$new_date_month."-".$new_date_day;
	return $new_d;
}

function admin_type($type){
	switch($type){
		case"1" : $text="ผู้ดูแลระบบ"; break;
		case"2" : $text="พนักงาน"; break;
		case"0" : $text=""; break;
	}
	
	return $text;
}

function conver_datetime($date,$t="-"){

	$date_ex=explode(" ",$date);
	$new_date=explode("-",$date_ex[0]);
	$new_date_day=$new_date[2];
	$new_date_month=$new_date[1];
	$new_date_year=$new_date[0];
	
	$date_ex[1]=substr($date_ex[1],0,5);
	
	$new_d=$date_ex[1]." ".$new_date_day.$t.$new_date_month.$t.$new_date_year;
	return $new_d;
}

function conver_datetime2($date,$t="-"){

	$date_ex=explode(" ",$date);
	$new_date=explode("-",$date_ex[0]);
	$new_date_day=$new_date[2];
	$new_date_month=$new_date[1];
	$new_date_year=$new_date[0];
	
	$date_ex[1]=substr($date_ex[1],0,5);
	
	$new_d=$new_date_day.$t.$new_date_month.$t.$new_date_year;
	return $new_d;
}

function leave_status($status){
	switch($status){
		case"0" : $text="รอการพิจารณา"; break;
		case"1" : $text="อนุมัติ"; break;
		case"2" : $text="ไม่อนุมัติ"; break;
		case"3" : $text="ยกเลิก"; break;
	}
	
	return $text;
}

function leave_type($type){
	switch($type){
		case"1" : $text="ลากิจ"; break;
		case"2" : $text="ลาป่วย"; break;
	}
	
	return $text;
}

function Dbetween($Datestart, $Dateend){
    $Oday = 60*60*24; #วัน
    $Datestart = strtotime($Datestart); #แปลงวันที่เป็น unixtime
    $Dateend = strtotime($Dateend); #แปลงวันที่เป็น unixtime
    $Diffday = round(($Dateend - $Datestart)/$Oday); 
    $arrayDate = array();
    $arrayDate[] = date('Y-m-d',$Datestart);    
    for($x = 1; $x < $Diffday; $x++){
        $arrayDate[] = date('Y-m-d',($Datestart+($Oday*$x)));
    }
    $arrayDate[] = date('Y-m-d',$Dateend);
    return $arrayDate;
}

function CheckingHoliday($month,$year){
	$sql="SELECT * FROM holiday WHERE holiday_date LIKE '".$year."-".$month."%'";
	//print $sql;
	$query=mysql_query($sql);
	$day=array();
	while($dbarr=mysql_fetch_array($query)){
		$day[$dbarr["holiday_date"]]=$dbarr["holiday_date"];
	}
	
	$sql="SELECT * FROM weekend";
	$query=mysql_query($sql);
	$dbarr=mysql_fetch_array($query);
	
	$day_holi[0]=$dbarr["sunday"];
	$day_holi[1]=$dbarr["saturday"];
	$day_holi[2]=$dbarr["monday"];
	$day_holi[3]=$dbarr["tuesday"];
	$day_holi[4]=$dbarr["wednesday"];
	$day_holi[5]=$dbarr["thursday "];
	$day_holi[6]=$dbarr["friday "];
	
	$num_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	for($i=1;$i<=$num_days;$i++){
		$strStartDate=$year."-".$month."-".str_pad($i,2,"0",STR_PAD_LEFT);
		
		$DayOfWeek = date("w", strtotime($strStartDate));
		//print $dbarr["sunday"]."<br>";
		if($day_holi[$DayOfWeek]=="0"){  // 0 = Sunday, 6 = Saturday;
			$day[$strStartDate]=$strStartDate;
		}
	}
	
	return $day;
}

function chk_day($emp,$month,$year,$holiday){
	//$sql="SELECT * FROM job_in WHERE employees_id='".$emp."' AND date_day LIKE '".$year."-".$month."%'";
	/*
	for($holiday as $value){
		$sql.=" AND date_day!='".$value."'";
	}
	*/
	
	$sql="SELECT * FROM weekend";
	$query=mysql_query($sql);
	$data=array();
	$data=mysql_fetch_array($query);
	
	$sql="SELECT COUNT(*) FROM job_in WHERE employees_id='".$emp."' AND date_day LIKE '".$year."-".$month."%'";
	$query=mysql_query($sql);
	$emp_day=mysql_result($query,0);
	
	$sql="SELECT COUNT(*) FROM leave_approve WHERE employees_id='".$emp."' AND leave_approve_day LIKE '".$year."-".$month."%'";
	$query=mysql_query($sql);
	$emp_leav=mysql_result($query,0);
	
	$num_days = cal_days_in_month(CAL_GREGORIAN,$month,$year)-count($holiday);
	
	$sql="SELECT COUNT(*) FROM job_in WHERE employees_id='".$emp."' AND date_in>'".str_replace(".",":",$data["job_in"])."'  AND date_day LIKE '".$year."-".$month."%'";
	$query=mysql_query($sql);
	$emp_l=mysql_result($query,0);
	
	
	$day[1]=($num_days-$emp_day)-$emp_leav;
	$day[2]=$emp_leav;
	$day[3]=$emp_l;
	
	return $day;
}


function CheckingHoliday2($month,$year){
	$sql="SELECT * FROM holiday WHERE holiday_date LIKE '".$year."-".$month."%'";
	//print $sql;
	$query=mysql_query($sql);
	$day=array();
	while($dbarr=mysql_fetch_array($query)){
		$day[$dbarr["holiday_date"]]=$dbarr["holiday_date"];
	}
	
	$sql="SELECT * FROM weekend";
	$query=mysql_query($sql);
	$dbarr=mysql_fetch_array($query);
	
	$day_holi[0]=$dbarr["sunday"];
	$day_holi[1]=$dbarr["saturday"];
	$day_holi[2]=$dbarr["monday"];
	$day_holi[3]=$dbarr["tuesday"];
	$day_holi[4]=$dbarr["wednesday"];
	$day_holi[5]=$dbarr["thursday "];
	$day_holi[6]=$dbarr["friday "];
	
	$num_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	for($i=1;$i<=$num_days;$i++){
		$strStartDate=$year."-".$month."-".str_pad($i,2,"0",STR_PAD_LEFT);
		
		$DayOfWeek = date("w", strtotime($strStartDate));
		//print $dbarr["sunday"]."<br>";
		if($day_holi[$DayOfWeek]=="0"){  // 0 = Sunday, 6 = Saturday;
			$day[$strStartDate]=$strStartDate;
		}
	}
	
	return $day;
}

function Pagination($sql="",$page="1",$limit="10"){
	$sql = $sql;
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	$count_page = ceil($dbarr["N"]/$limit);
	if($page==""){
		$page = 1;
	}
	$page_start = ($limit*$page)-$limit;
	
	$return = array(
				'AllPage' => $count_page,
				'PageStart' => $page_start,
				'No' => $page_start
			);
	
	return $return;
}

function TimeRep($t=""){
	if($t != ''){
		$tx = explode(":",$t);
		return $tx[0].':'.$tx[1];
	}
}

function getUser($UserName=''){
	$sql = "SELECT u.* , e.* FROM user u LEFT JOIN employees e ON u.employees_id=e.emp_id WHERE u.user_name='".$UserName."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	return $dbarr;
}

function monthThai($i){
	$m['1'] = "มกราคม";
	$m['2'] = "กุมภาพันธ์";
	$m['3'] = "มีนาคม";
	$m['4'] = "เมษายน";
	$m['5'] = "พฤษภาคม";
	$m['6'] = "มิถุนายน";
	$m['7'] = "กรกฎาคม";
	$m['8'] = "สิงหาคม";
	$m['9'] = "กันยายน";
	$m['10'] = "ตุลาคม";
	$m['11'] = "พฤศจิกายน";
	$m['12'] = "ธันวาคม";
	return $m[$i];
}

?>