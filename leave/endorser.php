<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">การลา</a></li>
  <li class="active">สิทธิ์การอนุมัติ</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">สิทธิ์การอนุมัติ</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=endorser_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
        	<th>รหัสพนักงาน</th>
			<th>พนักงาน</th>
            <th>ผู้อนุมัติ</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?
$sql = "SELECT l.* , e1.*  , e2.emp_name as emp_name2 , e2.emp_last_name as emp_last_name2 FROM leave_endorser l
		LEFT JOIN employees e1 ON e1.emp_id=l.emp_id 
		LEFT JOIN employees e2 ON e2.emp_id=l.leave_endorser_emp "; //ดึงข้อมูลผู้แนุมัตน์ 
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td align="center"><?=$i?></td>
        	<td><?=$dbarr["emp_code"]?></td>
			<td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
			<td><?=$dbarr["emp_name2"]?> <?=$dbarr["emp_last_name2"]?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=endorser_add&act=edit&endorser_emp=<?=$dbarr["leave_endorser_emp"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=endorser_del&emp_id=<?=$dbarr["emp_id"]?>" onclick="return confirm('ลบ')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

