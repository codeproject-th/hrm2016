<?

$sql = "UPDATE `leave` SET leave_n = '0' ,
	leave_start_day = '',
	leave_end_day = '' 
	WHERE leave_id='".$_GET["id"]."'";
mysql_query($sql);
$sql = "DELETE FROM leave_detail WHERE leave_id='".$_GET["id"]."'";
mysql_query($sql);
$save = true;
?>

<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    ลบข้อมูลเรียบร้อย 
	<i class="fa fa-fw fa-hand-o-right"></i><a href="index.php?m=leave&p=leave">ไปหน้าข้อมูลการลา</a>
</div>
<? } ?>