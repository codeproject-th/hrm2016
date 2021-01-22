<?php
include_once("../includes/config.inc.php");
include_once("../includes/conn.php");
include_once("../includes/function.php");
include_once("../lib/pusher.php");

$pusher = new Pusher(API_KEY); 

$sql = "SELECT * FROM employees";
$query = mysql_query($sql);
while($rs = mysql_fetch_array($query)){
	if($rs['mobile_id']!=""){
    	$regId[] = $rs['mobile_id'];
    	echo $rs['mobile_id']."<br>";
    }  
}  


$msg = array  
(  
    'message'   => 'ทดสอบ',  
    'title'     => 'Push',
    'id' => '999-1'
);  
$pusher->notify($regId, $msg);  
 echo "<pre>";  
print_r($pusher->getOutputAsArray());  
echo "</pre>";  
?>