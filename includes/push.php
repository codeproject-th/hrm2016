<?php

function push_leave($l_id=''){
	$sql = "SELECT l.* , t.leave_type_name FROM `leave` l LEFT JOIN master_leave_type t ON t.leave_type_id=l.leave_type WHERE l.leave_id='".$l_id."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	
	$sql = "SELECT * FROM employees WHERE emp_id='".$dbarr["emp_id"]."'";
	$query = mysql_query($sql);
	$dbarr2 = mysql_fetch_array($query);
	
	$title = "คุณ".$dbarr2['emp_name']." ".$dbarr2['emp_last_name']." ขอ".$dbarr['leave_type_name'];
	$message = $title." วันที่ ".conver_dateSQL($dbarr['leave_start_day'])." ถึง ".conver_dateSQL($dbarr['leave_end_day']);
	
	$pusher = new Pusher(API_KEY);
	$msg = array(  
    			'message' => $message,  
    			'title' => $title,  
    			'type' => "leave",
    			'id' => $l_id
			); 
			
	$sql = "SELECT * FROM employees WHERE emp_id='".$dbarr["leave_endorser_emp"]."'";
	$query = mysql_query($sql);
	//echo "-----";
	while($dbarr = mysql_fetch_array($query)){
		$regId[] = $dbarr['mobile_id'];
		//echo ">>".$dbarr['mobile_id'];
	}
	
	$pusher->notify($regId, $msg);  
	$pusher->getOutputAsArray();  
}

function push_approve($l_id=''){
	$sql = "SELECT l.* , t.leave_type_name FROM `leave` l LEFT JOIN master_leave_type t ON t.leave_type_id=l.leave_type WHERE l.leave_id='".$l_id."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	if($dbarr['leave_status']=="1"){
		$title = "การ".$dbarr['leave_type_name']."ได้รับการอนุมัติ";
		$message = $dbarr['leave_type_name']." วันที่ ".conver_dateSQL($dbarr['leave_start_day'])." ถึง ".conver_dateSQL($dbarr['leave_end_day'])." ได้รับการอนุมัติ";
	}else if($dbarr['leave_status']=="2"){
		$title = "การ".$dbarr['leave_type_name']."ไม่ได้รับการอนุมัติ";
		$message = $dbarr['leave_type_name']." วันที่ ".conver_dateSQL($dbarr['leave_start_day'])." ถึง ".conver_dateSQL($dbarr['leave_end_day'])." ไม่ได้รับการอนุมัติ";
	}
	
	
	$sql = "SELECT * FROM employees WHERE emp_id='".$dbarr["emp_id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	$mobile_id = $dbarr['mobile_id'];
	$pusher = new Pusher(API_KEY);
	$msg = array(  
    			'message' => $message,  
    			'title' => $title,  
    			'type' => "approve",
    			'id' => $l_id
			); 
	
	$regId[] = $mobile_id;
	$pusher->notify($regId, $msg);  
	$pusher->getOutputAsArray();  
}


?>