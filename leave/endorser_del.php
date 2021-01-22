<?
$sql = "DELETE FROM leave_endorser WHERE emp_id='".$_GET["emp_id"]."'"; //ลบข้อมูลผู้อนุมัติ
$query=mysql_query($sql);
$save = true;
?>

<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    ลบข้อมูลเรียบร้อย 
	<i class="fa fa-fw fa-hand-o-right"></i><a href="index.php?m=leave&p=endorser">ไปหน้าสิทธิ์การอนุมัติ</a>
</div>
<? } ?>