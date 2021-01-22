<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">ผู้ใช้งาน</a></li>
  <li class="active">ข้อมูลผู้ใช้งาน</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ข้อมูลผู้ใช้งาน</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=user_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
        	<th>รหัสพนักงาน</th>
			<th>ชื่อ-นามสกุล</th>
            <th>ชื่อผู้ใช้งาน</th>
			<th>ประเภทผู้ใช้งาน</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?
$sql="SELECT u.* ,emp.emp_code , emp.emp_name , emp.emp_last_name FROM `user` u LEFT JOIN employees emp ON emp.emp_id=u.employees_id";
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td><?=$i?></td>
        	<td><?=$dbarr["emp_code"]?></td>
			<td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
            <td><?=$dbarr["user_name"]?></td>
			<td><?=$dbarr["user_type"]?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=user_add&act=edit&id=<?=$dbarr["user_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=user_del&id=<?=$dbarr["user_id"]?>" onclick="return confirm('ลบ <?=$dbarr["user_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           	</td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

