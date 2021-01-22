<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">พนักงาน</a></li>
  <li class="active">ข้อมูลพนักงาน</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ข้อมูลพนักงาน</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=employees_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
        	<th>รหัสพนักงาน</th>
            <th>ชื่อนาม-สกุล</th>
			<th>ตำแหน่ง</th>
			<th>ฝ่าย</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?
$sql="SELECT e.* , o.office_name , p.party_name FROM employees e 
	LEFT JOIN master_office o ON o.office_id=e.emp_office 
	LEFT JOIN master_party p ON p.party_id=e.emp_party
	";
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td><?=$i?></td>
        	<td><?=$dbarr["emp_code"]?></td>
            <td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
			<td><?=$dbarr["office_name"]?></td>
			<td><?=$dbarr["party_name"]?></td>
            <td>
            <div class="btn-group">
            	 <a href="index.php?m=<?=$m?>&p=employees_print&id=<?=$dbarr["emp_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-print"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=employees_add&act=edit&id=<?=$dbarr["emp_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=employess_del&id=<?=$dbarr["emp_id"]?>" onclick="return confirm('ลบ <?=$dbarr["leave_type_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->