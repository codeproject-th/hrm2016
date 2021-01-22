<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">ประเภทการลา</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ประเภทการลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=leave_type_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
            <th>ประเภทการลา</th>
			<th>จำนวนวันที่ใช้ได้</th>
			<th>วันที่ตัดรอบ</th>
			<th>เดือนที่ตัดรอบ</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?
$sql="SELECT * FROM master_leave_type";
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td align="center"><?=$i?></td>
            <td><?=$dbarr["leave_type_name"]?></td>
			<td><?=$dbarr["leave_number"]?></td>
			<td><?=$dbarr["leave_cut_day"]?></td>
			<td><?=$dbarr["leave_cut_month"]?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=leave_type_add&act=edit&id=<?=$dbarr["leave_type_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=leave_type_del&id=<?=$dbarr["leave_type_id"]?>" onclick="return confirm('ลบ <?=$dbarr["leave_type_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

