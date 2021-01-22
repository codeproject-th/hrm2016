<?
include("./lib/leave.report.lib.php");

if($UserData["emp_level"]=="01"){ 
	exit;
}

if($_POST){
	
	$leave_report = new leave_report();
	$leave_report->year = $_POST["year"];
	$leave_report->party = $_POST["emp_party"];
	$leave_report->department = $_POST["emp_department"];
	$Data = $leave_report->GetReport();
	
}

?>
<ol class="breadcrumb">
  <li><a href="#">รายงาน</a></li>
  <li class="active">รายงานการลา</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">รายงานการลา</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form method="POST">
	<div class="form-group">
    	<label>ฝ่าย</label>
		<select class="form-control" name="emp_party">
			<option value="">เลือก</option> 
<?
$sql = "SELECT * FROM  master_party ORDER BY party_name";
$query = mysql_query($sql);
while($party_array = mysql_fetch_array($query)){
?>      
		<option value="<?=$party_array["party_id"]?>" <? if($party_array["party_id"]==$_POST["emp_party"]){ ?> selected <? } ?>><?=$party_array["party_name"]?></option> 
<? } ?>                  
        </select>
     </div>	
	 <div class="form-group">
    	<label>แผนก</label>
		<select class="form-control" name="emp_department" id="emp_department">
			<option value="">เลือก</option>
<?
if($_POST['emp_party']!=''){
	$party_id = $_POST["emp_party"];
	$sql = "SELECT * FROM master_department WHERE party_id='".$party_id."' ORDER BY department_name";
	
	$query = mysql_query($sql);
	while($dbarr_p = mysql_fetch_array($query)){
		$s = "";
		if($dbarr_p["department_id"]==$_POST["emp_department"]){
			$s = "selected";
		}
		echo "<option value='".$dbarr_p["department_id"]."' ".$s.">".$dbarr_p["department_name"]."</option>";
	}
}
?>
        </select>
     </div>
	 <div class="form-group">
    	<label>ปี</label>
		<input class="form-control" name="year" value="<?=$_POST["year"]?>" placeholder="" type="number" required>
     </div>
	 <button type="submit" class="btn btn-primary">แสดงรายงาน</button>
</form>

<!------------------------------------------------------------------------------------>
	</div>
</div><!-- /.box -->

<? if($_POST){ ?>
<!--------------------------------->
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a aria-expanded="true" href="#tab_report1" data-toggle="tab">กราฟ</a></li>
		<li ><a aria-expanded="false" href="#tab_report2" data-toggle="tab">ตาราง</a></li>
		<li ><a aria-expanded="false" href="#tab_report3" data-toggle="tab">รายละเอียดรายบุคคล</a></li>
	</ul>
<!---- ---->
	<div class="tab-content">
		<div class="tab-pane active" id="tab_report1" role="tabpanel">
<!-- -->
			<div style="margin: 10px;">
				<center><canvas id="myChart" width="500" height="400"></canvas></center>
			</div>
<!-- -->
		</div>
		<div class="tab-pane" id="tab_report2" role="tabpanel">
			<table class="table table-striped">
    			<tr>
            		<th>ประเภทการลา</th>
            		<th width="10%"><center>จำนวนวัน</center></th>
        		</tr>
				<? 
				if(count($Data)>0){
					foreach($Data as $val){
						$labels_arr[] = $val["name"];
						$data_arr[] = $val["day"];
				?>
					<tr>
						<td><?=$val["name"]?></td>
						<td align="center"><?=$val["day"]?></td>
					</tr>
				<?		
					}
				}
				?>
		</table>
		</div>
		<!--- --->
		<div class="tab-pane" id="tab_report3" role="tabpanel">
			<table class="table table-striped">
    			<tr>
            		<th>พนักงาน</th>
					<? 
					if(count($Data)>0){
						foreach($Data as $val){
							
					?>
            			<th width="10%"><center><?=$val["name"]?></center></th>
					<? 
						} 
					} 
					?>
					<th width="10%"><center>รวม</center></th>
        		</tr>
				<?
				if(count($leave_report->Emp)>0){
					foreach($leave_report->Emp as $key => $val){
						$countDay = 0;
				?>
					<tr>
					<td width="10%"><?=$val["name"]?></td>
					<? 
					if(count($Data)>0){
						foreach($Data as $DataKey => $DataVal){
							$countDay = $countDay+$val[$DataKey];
					?>
            			<td width="10%"><center><?=number_format($val[$DataKey],2)?></center></td>
					<? 
						} 
					} 
					?>
					<!--- -->
						<td align="center"><?=number_format($countDay,2)?></td>
					</tr>
				<?		
					}	
				}
				?>
			</table>
		</div>
		<!-- --->
	</div>
<!---- ---->
</div>
<!---- ---->	
<? } ?>
<script>
$(function() {	
	$('.datepicker').datepicker({
    	format: 'dd-mm-yyyy',
		language: "th"
	});
	
	$("select[name=emp_party]").change(function(){
		GetDep($(this).val());
	});
	
	
	var ctx = $("#myChart").get(0).getContext("2d");
	
	var data = {
    labels: <?=json_encode($labels_arr)?>,
    datasets: [
        {
            label: "My Second dataset",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: <?=json_encode($data_arr)?>,
        }
    ]
};
	//Chart.defaults.global.responsive = true;
	var myLineChart = new Chart(ctx).Bar(data,{
		
	});

});

function GetDep(v){
	
	html = "<option value=''>เลือก</option>";
	$('#emp_department').empty();
	$.ajax({
		type: "POST",
		url: "ajax/ajax_get_dep.php",
		cache: false,
		dataType : "json",
		data: "party_id="+v,
		success: function(data){
			//alert(data);
			jQuery.each(data, function(index, item) {
				html += "<option value="+item.department_id+">"+item.department_name+"</option>"; 
        	});
			
			$('#emp_department').append(html);
		}
	});
}

</script>