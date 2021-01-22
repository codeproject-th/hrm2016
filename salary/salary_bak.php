<?
error_reporting ( E_ALL & ~ E_NOTICE );
?>
<ol class="breadcrumb">
  <li><a href="#">เงินเดือน</a></li>
  <li class="active">การจ่ายเงินเดือน</li>
</ol>
<!------------------------------------------------------------------------------------>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ค้นหา</h3>
  	</div>
  	<div class="box-body">
<!--- --->
<form role="form" method="GET">
	<div class="form-group">
    	<label>เดือน</label>
        <select class="form-control" name="salary_month" required>
			<option value="">เลือก</option>
<?
		for($i=1;$i<=12;$i++){
?>
		<option value="<?=$i?>" <? if($_GET['salary_month']==$i){ ?> selected <? } ?>><?=monthThai($i)?></option>
<? 		
		} 
?>
		</select>
     </div>
     <div class="form-group">
    	<label>ปี</label>
        <select class="form-control" name="salary_year" required>
			<option value="">เลือก</option>
<?
		$y = date('Y')-2;
		for($i=1;$i<=2;$i++){
			$y = $y+1;
?>
		<option value="<?=$y?>"  <? if($_GET['salary_year']==$y){ ?> selected <? } ?>><?=$y?></option>
<? 		
		} 
?>
		</select>
    </div>
    <input type="hidden" name="m" value="salary"/>
    <input type="hidden" name="p" value="salary"/>
    <button type="submit" class="btn btn-primary">ค้นหา</button>
</form>
<!------->	
	</div>
</div>
<!------------------------------------------------------------------------------------>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">เงินเดือน</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=salary_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
			<th>ชื่อ</th>
            <th>เงินเดือน</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?

$where = " WHERE s.salary_month='".date("m")."' AND s.salary_year='".date("Y")."'";

if($_GET['salary_month']!='' and $_GET['salary_year']!=''){
	$where = " WHERE s.salary_month='".$_GET['salary_month']."' AND s.salary_year='".$_GET['salary_year']."'";
}

$sql="SELECT s.* , e.* FROM salary s LEFT JOIN employees e ON e.emp_id=s.employees_id ".$where;
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td align="center"><?=$i?></td>
			<td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
            <td><?=number_format($dbarr["salary_money"])?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=salary_add&act=edit&id=<?=$dbarr["salary_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=salary_del&id=<?=$dbarr["salary_id"]?>" onclick="return confirm('ลบ <?=$dbarr["department_name"]?>')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

