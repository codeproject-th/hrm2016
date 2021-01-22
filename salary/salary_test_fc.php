<?
error_reporting( E_ALL & ~ E_NOTICE );
include('./lib/ot.php');
$ot = new ot();
$ot->month = "03";
$ot->year = "2016";
$ot->emp_id = "1";
$ot->get_ot();
print_r($ot->OtArr);
?>
