<?
include_once("./lib/log_web.php");
?>
<ol class="breadcrumb">
  <li><a href="#">ปฏิทิน</a></li>
  <li class="active">การอนุมัติ</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">อนุมัติการลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
			<th>พนักงาน</th>
			<th>วันที่ลา</th>
			<th>จำนวนวัน</th>
            <th>สถานะการลา</th>
            <th width="10%">อนุมัติ</th>
        </tr>	
<?

$page = $_GET["page"];
if($page==""){
	$page = 1;
}
$Pagination = Pagination("SELECT COUNT(*) AS N FROM `leave` WHERE leave_endorser_emp='".$_SESSION["login"]['emp_id']."' ",$page,20);
$no = $Pagination["No"];

$sql = "SELECT l.* , e1.*  , e2.emp_name as emp_name2 , e2.emp_last_name as emp_last_name2 FROM  `leave` l
		LEFT JOIN employees e1 ON e1.emp_id=l.emp_id 
		LEFT JOIN employees e2 ON e2.emp_id=l.leave_endorser_emp 
		WHERE l.leave_endorser_emp='".$_SESSION["login"]['emp_id']."'  
		ORDER BY leave_start_day DESC LIMIT ".$Pagination["PageStart"].",20";

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
			<td><?=$dbarr["emp_name"]?> <?=$dbarr["emp_last_name"]?></td>
			<td><?=conver_dateSQL($dbarr["leave_start_day"])?> - <?=conver_dateSQL($dbarr["leave_end_day"])?></td>
			<td><?=$dbarr["leave_n"]?></td>
			<td><?=$status?></td>
            <td>
            <div class="btn-group">
			<? if($dbarr["leave_status"]=="0"){ ?>
            	<a href="javascript:Approve('<?=$dbarr["leave_id"]?>')"><button type="button" class="btn btn-xs btn-success"><i class="fa fa-fw fa-check-circle"></i></button></a>
				<span><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal<?=$dbarr["leave_id"]?>"><i class="fa fa-fw fa-ban"></i></button></span>
            <? } ?>
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
  <li class="paginate_button <? if($page=="$i"){ ?>active<? } ?>" ><a href="index.php?m=user_calendar&p=user_leave_approve&page=<?=$i?>"><?=$i?></a></li>
<? } ?>
</ul>
<? } ?>
</div>
</div><!-- /.box -->
<?
$query=mysql_query($sql);
while($dbarr=mysql_fetch_array($query)){
?>
<form method="POST" action="index.php?m=user_calendar&p=user_leave_no_approve">
<div id="myModal<?=$dbarr["leave_id"]?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">สาเหตุที่ไม่อนุมัติ</h4>
    </div>
    <div class="modal-body">
    	<textarea class="form-control" rows="3" name="LeaveComment<?=$dbarr["leave_id"]?>" id="LeaveComment<?=$dbarr["leave_id"]?>" placeholder=""><?=$dbarr["leave_comment"]?></textarea>
    </div>
   	<div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="NoApprove('<?=$dbarr["leave_id"]?>')">บันทึก</button>
  	</div>
</div>
</div>
</div>
<input type="hidden" name="Hid<?=$dbarr["leave_id"]?>" name="Hid<?=$dbarr["leave_id"]?>" value="<?=$dbarr["leave_id"]?>"/>
</form>
<? } ?>
<script>
function Approve(id){
	$.ajax({
		type: "POST",
		url: "index.php?m=user_calendar&p=user_leave_approve_save",
		cache: false,
		data: "id="+id,
		success: function(msg){
			//alert(msg);
			window.location.reload();
		}
	});

}

function NoApprove(id){
	$.ajax({
		type: "POST",
		url: "index.php?m=user_calendar&p=user_leave_approve_no_save",
		cache: false,
		data: "id="+id+"&msg="+$("#LeaveComment"+id).val(),
		success: function(msg){
			window.location.reload();
		}
	});

}
</script>