<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">วันหยุดนักขัตฤกษ์</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">วันหยุดนักขัตฤกษ์</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=holiday_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
            <th>วันที่</th>
			<th>เทศกาล</th>
			<th>หมายเหตุ</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?
$sql="SELECT * FROM holiday";
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td><?=$i?></td>
            <td><?=conver_dateSQL($dbarr["holiday_date"])?></td>
			<td><?=$dbarr["holiday_name"]?></td>
			<td><?=$dbarr["holiday_comment"]?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=holiday_add&act=edit&id=<?=$dbarr["holiday_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=holiday_del&id=<?=$dbarr["holiday_id"]?>" onclick="return confirm('ลบ <?=$dbarr["holiday_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

