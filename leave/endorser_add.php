<?
error_reporting ( E_ALL & ~ E_NOTICE );
$save = false;

$title = "เพิ่มสิทธิ์การอนุมัติ";
if($_GET["act"]=="edit"){
	$title = "แก้ไขสิทธิ์การอนุมัติ";
}

?>
<ol class="breadcrumb">
  <li><a href="#">การลา</a></li>
  <li class="active">สิทธิ์การอนุมัติ</li>
</ol>
<? if($save==true){ ?>
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    บันทึกข้อมูลเรียบร้อย
</div>
<? } ?>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title"><?=$title?></h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST">
	<div class="form-group">
    	<label>ผู้อนุมัติ</label>
        <select class="form-control" name="endorser_empp" id="endorser_emp">
			<option value="">เลือก</option>
<?
$sql = "SELECT e.* FROM employees e INNER JOIN master_office o ON e.emp_office=o.office_id WHERE o.office_name LIKE 'หัวหน้า%' ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr_emp = mysql_fetch_array($query)){
?>
	<option <? if($dbarr_emp["emp_id"]==$_GET["endorser_emp"]){ ?>selected<? } ?> value="<?=$dbarr_emp["emp_id"]?>"><?=$dbarr_emp["emp_name"]?>  <?=$dbarr_emp["emp_last_name"]?></option>
<? } ?>
		</select>
     </div>
	 
	<div class="form-group">
    	<label>พนักงาน</label>
	  	<div class="input-group input-group-sm">
      		<select class="form-control" name="emp_id" id="emp_id">
				<option value="">เลือก</option>
<?
$sql = "SELECT * FROM employees ORDER BY emp_name";
$query = mysql_query($sql);
while($dbarr_emp = mysql_fetch_array($query)){
?>
	<option  value="<?=$dbarr_emp["emp_id"]?>"><?=$dbarr_emp["emp_name"]?>  <?=$dbarr_emp["emp_last_name"]?></option>
<? } ?>
			</select>
       		<span class="input-group-btn">
        		<button type="button" class="btn btn-info btn-flat" id="Add">เพิ่ม</button>
        	</span>
      	</div>
	 </div>
<!-- Table -->
<div id="DataTable">
<table id="empData" class="table table-striped">
    	<tr>
			<th>พนักงาน</th>
			<th>ผู้อนุมัติ</th>
            <th width="10%">ลบ</th>
        </tr>
		<tbody>
			
		</tbody>	
</table>
</div>
<!-- -->
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->

<script>
$(function() {
	
	html = "";
	
	$('.datepicker').datepicker({
    	format: 'dd-mm-yyyy',
		language: "th"
	});
	
	$("#Add").click(function(){
		//alert($("#endorser_emp option:selected").text());
		
		$.ajax({
			type: "POST",
			url: "index.php?m=leave&p=endorser_add_ajax",
			data: "emp_id="+$("#emp_id option:selected").val()+"&endorser_emp="+$("#endorser_emp option:selected").val(),
			success: function(data){
				GetDataTable();
			}
		});
		
		
		/*html = "<tr><td>"+$("#emp_id option:selected").text()+"</td><td>"+$("#endorser_emp option:selected").text()+"</td><td><button type='button' class='btn btn-xs btn-default'><i class='fa fa-fw fa-trash'></i></button></td></tr>";
		$("#empData").append(html);*/
	});
	
	
	$("#endorser_emp").change(function(){
		GetDataTable();
	}); 
});


function GetDataTable(){
	$.ajax({
		type: "POST",
		url: "./ajax/ajax_endorser_tb.php",
		data: "endorser_emp="+$("#endorser_emp option:selected").val(),
		success: function(data){
				$("#DataTable").html(data);
		}
	});
}

function DelEmp(EmpID){
	con = confirm("ลบ");
	if(con == true){
		$.ajax({
			type: "POST",
			url: "index.php?m=leave&p=endorser_del_ajax",
			data: "emp_id="+EmpID,
			success: function(data){
				GetDataTable();
			}
		});
	}
}

GetDataTable();
</script>	


