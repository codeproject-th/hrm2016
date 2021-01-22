<?
if($_POST){
	foreach($_POST['data'] as $key => $val){
		$sql = "UPDATE setting_salary SET setting_salary_value='".$val."' WHERE setting_salary_code='".$key."'";
		mysql_query($sql);
	}
}
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">OTและประกันสังคม</li>
</ol>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title">รายการ</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
	 <div class="pull-right">
             
      </div>
	  <br><br>
<form method="post">
	<table class="table table-striped">
    	<tr>
        	<th width="10%">ลำดับ</th>
            <th>รายการเงินเดือน</th>
            <th width="10%">แก้ไข</th>
        </tr>	
<?
$sql="SELECT * FROM setting_salary";
$query=mysql_query($sql);
$i=0;
while($dbarr=mysql_fetch_array($query)){
	$i++;
?>
		<tr>
        	<td><?=$i?></td>
            <td><?=$dbarr["setting_salary_comment"]?></td>
            <td>
            <div class="btn-group">
            	<input type="text" name="data[<?=$dbarr["setting_salary_code"]?>]" value="<?=$dbarr["setting_salary_value"]?>" class="form-control">
            </div>
           </td>
        </tr>	
<? } ?>
	</table>
<!------------------------------------------------------------------------------------>
	<button type="submit" class="btn btn-primary">บันทึก</button>
</form>
  	</div>
</div><!-- /.box -->

