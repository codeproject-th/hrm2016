<?
//ลบข้อมูลเงินเดือน
$sql = "DELETE FROM salary_detail WHERE salary_id='".$_GET['id']."'";
mysql_query($sql);
$sql = "DELETE FROM salary WHERE salary_id='".$_GET['id']."'";
mysql_query($sql);
$save = true;
?>

<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    ลบข้อมูลเรียบร้อย 
	<i class="fa fa-fw fa-hand-o-right"></i><a href="index.php?m=salary&p=salary">ไปหน้าเงินเดือน</a>
</div>
<? } ?>