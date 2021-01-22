<?
error_reporting ( E_ALL & ~ E_NOTICE );
//แสดงข้อมูลการลา
?>
<ol class="breadcrumb">
  <li><a href="#">การลา</a></li>
  <li class="active">ข้อมูลการลา</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">ข้อมูลการลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             <a href="index.php?m=<?=$m?>&p=leave_add&act=add"><button type="button" class="btn btn-success "><i class="fa fa-fw  fa-plus-square"></i> เพิ่ม</button></a>
      </div>
	  <br><br>
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
        	<th>รหัสพนักงาน</th>
			<th>พนักงาน</th>
			<th>วันที่ลา</th>
			<th>จำนวนวัน</th>
            <th>สถานะการลา</th>
            <th width="10%">แก้ไข/ลบ</th>
        </tr>	
<?

$page = $_GET["page"];
if($page==""){
	$page = 1;
}
$Pagination = Pagination("SELECT COUNT(*) AS N FROM `leave`",$page,20);
$no = $Pagination["No"];

$sql = "SELECT l.* , e1.*  , e2.emp_name as emp_name2 , e2.emp_last_name as emp_last_name2 FROM  `leave` l
		LEFT JOIN employees e1 ON e1.emp_id=l.emp_id 
		LEFT JOIN employees e2 ON e2.emp_id=l.leave_endorser_emp ORDER BY leave_start_day DESC LIMIT ".$Pagination["PageStart"].",20";
$query=mysql_query($sql);
$i=$no;
while($dbarr=mysql_fetch_array($query)){
	$i++;
	$status = "รออนุมัติ";
	if($dbarr["leave_status"]=="1"){
		$status = "อนุมัติ";
	}else if($dbarr["leave_status"]=="2"){
		$status = "ไม่อนุมัติ";
	}else if($dbarr["leave_status"]=="3"){
		$status = "ยกเลิก";
	}
?>
		<tr>
        	<td><?=$i?></td>
        	<td><?=$dbarr["emp_code"]?></td>
			<td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
			<td><?=conver_dateSQL($dbarr["leave_start_day"])?> - <?=conver_dateSQL($dbarr["leave_end_day"])?></td>
			<td><?=$dbarr["leave_n"]?></td>
			<td><?=$status?></td>
            <td>
            <div class="btn-group">
            	<a href="index.php?m=<?=$m?>&p=leave_add&act=edit&id=<?=$dbarr["leave_id"]?>"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-edit"></i></button></a>
            	<a href="index.php?m=<?=$m?>&p=leave_del&id=<?=$dbarr["leave_id"]?>" onclick="return confirm('ลบ')"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-fw fa-trash"></i></button></a>
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
  	</div>
<div class="box-footer">
<? if($Pagination["AllPage"]>"1"){ ?>
<ul class="pagination" style="margin: 0px;">
<? for($i=1;$i<=$Pagination["AllPage"];$i++){ ?>
  <li class="paginate_button <? if($page=="$i"){ ?>active<? } ?>" ><a href="index.php?m=leave&p=leave&page=<?=$i?>"><?=$i?></a></li>
<? } ?>
</ul>
<? } ?>
</div>
</div><!-- /.box -->

