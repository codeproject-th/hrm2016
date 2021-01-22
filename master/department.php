<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">แผนก</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">แผนก</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=departement_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
			<th>ฝ่าย</th>
            <th>แผนก</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?
$sql="SELECT master_department.* , master_party.party_name FROM master_department LEFT JOIN master_party ON master_department.party_id=master_party.party_id";
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td align="center"><?=$i?></td>
			<td><?=$dbarr["party_name"]?></td>
            <td><?=$dbarr["department_name"]?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=departement_add&act=edit&id=<?=$dbarr["department_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=depatment_del&id=<?=$dbarr["department_id"]?>" onclick="return confirm('ลบ <?=$dbarr["department_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

