<?
$save = false;
if($_POST){
	$sql = "UPDATE weekend SET monday='0' , tuesday='0' , wednesday='0' , thursday='0' , friday='0' , saturday='0' , sunday='0'";
	$query = mysql_query($sql);
	$sql = "UPDATE weekend SET 
			monday='".$_POST["monday"]."' , 
			tuesday='".$_POST["tuesday"]."' , 
			wednesday='".$_POST["wednesday"]."' , 
			thursday='".$_POST["thursday"]."' , 
			friday='".$_POST["friday"]."' , 
			saturday='".$_POST["saturday"]."' , 
			sunday='".$_POST["sunday"]."' , 
			job_in='".$_POST["in"]."' , 
			job_out='".$_POST["out"]."'";
	$query=mysql_query($sql);
	$save = true;
}


$sql="SELECT * FROM weekend";
$query=mysql_query($sql);
$dbarr=mysql_fetch_array($query);
?>
<ol class="breadcrumb">
  <li><a href="#">ข้อมูลมาตราฐาน</a></li>
  <li class="active">เวลาทำการบริษัท</li>
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
    	<h3 class="box-title">เวลาทำการบริษัท</h3>
  	</div>
  	<div class="box-body">
<!------------------------------------------------------------------------------------>
<form role="form" method="POST">
	<div class="form-group">
		<label>เวลาเข้างาน </label>
        <div class="input-group bootstrap-timepicker timepicker">
        	<input class="form-control timepicker" name="in" value="<?=$dbarr["job_in"]?>" type="text">
            <div class="input-group-addon">
				<i class="fa fa-clock-o"></i>
            </div>
       </div>
	   <label>เวลาออกงาน </label>
       <div class="input-group bootstrap-timepicker timepicker">
        	<input class="form-control timepicker" name="out" value="<?=$dbarr["job_out"]?>" type="text">
            <div class="input-group-addon">
				<i class="fa fa-clock-o"></i>
            </div>
       </div>
       <!-- /.input group -->
    </div>
	<table class="table table-striped">
    	<tr>
			<td width="10%">&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="monday" value="1" <? if($dbarr["monday"]==1){ ?> checked="checked" <? }?> /></td>
			<td>วันจันทร์</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="tuesday" value="1" <? if($dbarr["tuesday"]==1){ ?> checked="checked" <? }?> /></td>
			<td>วันอังคาร</td>
        </tr>	
		<tr>
			<td>&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="wednesday" value="1" <? if($dbarr["wednesday"]==1){ ?> checked="checked" <? }?> /></td>
			<td>วันพุธ</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="thursday" value="1" <? if($dbarr["thursday"]==1){ ?> checked="checked" <? }?> /></td>
			<td>วันพฤหัสบดี</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="friday" value="1" <? if($dbarr["friday"]==1){ ?> checked="checked" <? }?>  /></td>
			<td>วันศุกร์</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="saturday" value="1" <? if($dbarr["saturday"]==1){ ?> checked="checked" <? }?> /></td>
			<td>วันเสาร์</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
        	<td width="1%"><input type="checkbox" name="sunday" value="1" <? if($dbarr["sunday"]==1){ ?> checked="checked" <? }?> /></td>
			<td>วันอาทิตย์</td>
        </tr>	
	</table>
	<button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<!------------------------------------------------------------------------------------>
  	</div>
</div><!-- /.box -->
<script>
$(function() {
	$(".timepicker").timepicker({
		showSeconds: false,
        showMeridian: false           
	});
});
</script>
