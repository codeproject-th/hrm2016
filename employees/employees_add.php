<?
$save = false;

if($_POST){
	
	$img_name = $_POST["img_h"];
	if($_FILES["emp_img"]["name"]!="" and $_POST['img_del']!='1'){
		$file_type = explode(".",$_FILES["emp_img"]["name"]);
		$file_ex = end($file_type);
		$file_ex = strtolower($file_ex);
		if($file_ex=="gif" or $file_ex=="jpg" or $file_ex=="jpeg" or $file_ex=="png" ){
			$img_name = date("YmdHis")."-".rand(1,100).".".$file_ex;
			move_uploaded_file($_FILES["emp_img"]["tmp_name"],'./employees_img/'.$img_name);
			if($_POST["img_h"]!=""){
				@unlink("./employees_img/".$_POST["img_h"]);
			}
		}
	}
	
	if($_POST['img_del']=='1'){
		@unlink("./employees_img/".$_POST["img_h"]);
		$img_name = "";
	}
	
	if($_GET["act"]=="add"){
		$sql = "INSERT INTO employees(
						emp_code,
						emp_prefix,
						emp_name,
						emp_last_name,
						emp_sex,
						emp_religion,
						emp_nationality,
						emp_nation,
						emp_birthday,
						emp_idcard,
						emp_status_people,
						emp_img,
						emp_academy,
						emp_education,
						emp_subjects,
						emp_yearend,
						emp_department,
						emp_office,
						emp_jobstart,
						emp_salary,
						emp_status,
						emp_address1,
						emp_sub_district1,
						emp_district1,
						emp_province1,
						emp_zipcod1,
						emp_address2,
						emp_sub_district2,
						emp_district2,
						emp_province2,
						emp_zipcod2,
						emp_party,
						create_date,
						emp_level
					) VALUES(
						'".$_POST["emp_code"]."',
						'".$_POST["emp_prefix"]."',
						'".$_POST["emp_name"]."',
						'".$_POST["emp_last_name"]."',
						'".$_POST["emp_sex"]."',
						'".$_POST["emp_religion"]."',
						'".$_POST["emp_nationality"]."',
						'".$_POST["emp_nation"]."',
						'".dateSQL($_POST["emp_birthday"])."',
						'".$_POST["emp_idcard"]."',
						'".$_POST["emp_status_people"]."',
						'".$img_name."',
						'".$_POST["emp_academy"]."',
						'".$_POST["emp_education"]."',
						'".$_POST["emp_subjects"]."',
						'".$_POST["emp_yearend"]."',
						'".$_POST["emp_department"]."',
						'".$_POST["emp_office"]."',
						'".dateSQL($_POST["emp_jobstart"])."',
						'".$_POST["emp_salary"]."',
						'".$_POST["emp_status"]."',
						'".$_POST["emp_address1"]."',
						'".$_POST["emp_sub_district1"]."',
						'".$_POST["emp_district1"]."',
						'".$_POST["emp_province1"]."',
						'".$_POST["emp_zipcod1"]."',
						'".$_POST["emp_address2"]."',
						'".$_POST["emp_sub_district2"]."',
						'".$_POST["emp_district2"]."',
						'".$_POST["emp_province2"]."',
						'".$_POST["emp_zipcod2"]."',
						'".$_POST["emp_party"]."',
						NOW(),
						'".$_POST["emp_level"]."'
					)";
		$query = mysql_query($sql);
		$save = true;
	}else if($_GET["act"]=="edit"){
		$sql = "UPDATE employees SET 
						emp_code='".$_POST["emp_code"]."',
						emp_prefix='".$_POST["emp_prefix"]."',
						emp_name='".$_POST["emp_name"]."',
						emp_last_name='".$_POST["emp_last_name"]."',
						emp_sex='".$_POST["emp_sex"]."',
						emp_religion='".$_POST["emp_religion"]."',
						emp_nationality='".$_POST["emp_nationality"]."',
						emp_nation='".$_POST["emp_nation"]."',
						emp_birthday='".dateSQL($_POST["emp_birthday"])."',
						emp_idcard='".$_POST["emp_idcard"]."',
						emp_status_people='".$_POST["emp_status_people"]."',
						emp_img='".$img_name."',
						emp_academy='".$_POST["emp_academy"]."',
						emp_education='".$_POST["emp_education"]."',
						emp_subjects='".$_POST["emp_subjects"]."',
						emp_yearend='".$_POST["emp_yearend"]."',
						emp_department='".$_POST["emp_department"]."',
						emp_office='".$_POST["emp_office"]."',
						emp_jobstart='".dateSQL($_POST["emp_jobstart"])."',
						emp_salary='".$_POST["emp_salary"]."',
						emp_status='".$_POST["emp_status"]."',
						emp_address1='".$_POST["emp_address1"]."',
						emp_sub_district1='".$_POST["emp_sub_district1"]."',
						emp_district1='".$_POST["emp_district1"]."',
						emp_province1='".$_POST["emp_province1"]."',
						emp_zipcod1='".$_POST["emp_zipcod1"]."',
						emp_address2='".$_POST["emp_address2"]."',
						emp_sub_district2='".$_POST["emp_sub_district2"]."',
						emp_district2='".$_POST["emp_district2"]."',
						emp_province2='".$_POST["emp_province2"]."',
						emp_zipcod2='".$_POST["emp_zipcod2"]."',
						emp_party='".$_POST['emp_party']."',
						emp_level='".$_POST["emp_level"]."'
				WHERE emp_id='".$_GET["id"]."'";
		
		$query = mysql_query($sql);
		$save = true;
	}
}

$title = "เพิ่มข้อมูลพนักงาน";
if($_GET["act"]=="edit"){
	$title = "แก้ไขข้อมูลพนักงาน";
	
	$sql = "SELECT * FROM employees WHERE emp_id='".$_GET["id"]."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
}
?>
<ol class="breadcrumb">
  <li><a href="#">พนักงาน</a></li>
  <li class="active">ข้อมูลพนักงาน</li>
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
<form role="form" method="POST" enctype="multipart/form-data">
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a aria-expanded="true" href="#tab_profile" data-toggle="tab">ข้อมูลส่วนตัว</a></li>
        <li class=""><a aria-expanded="false" href="#tab_edu" data-toggle="tab">ข้อมูลการศึกษา</a></li>
		<li class=""><a aria-expanded="false" href="#tab_work" data-toggle="tab">ข้อมูลการทำาน</a></li>
        <li class=""><a aria-expanded="false" href="#tab_address1" data-toggle="tab">ข้อมูลที่อยู่ปัจจุบัน</a></li>
		<li class=""><a aria-expanded="false" href="#tab_address2" data-toggle="tab">ข้อมูลที่อยู่ตามทะเบียนบ้าน</a></li>
	</ul>
<!---- ---->
<div class="tab-content">
<!---- ---->
<div class="tab-pane active" id="tab_profile">
	<div class="form-group">
    	<label>คำนำหน้าชื่อ</label>
		<select class="form-control" name="emp_prefix" required>
        	<option value="">เลือก</option>
			<option value="1" <? if($dbarr["emp_prefix"]=="1"){ ?> selected <? } ?> >นาย</option>
            <option value="2" <? if($dbarr["emp_prefix"]=="2"){ ?> selected <? } ?>>นาง</option>
            <option value="3" <? if($dbarr["emp_prefix"]=="3"){ ?> selected <? } ?>>นางสาว</option>
        </select>
     </div>
	 <div class="form-group">
    	<label>ชื่อ</label>
		<input class="form-control" name="emp_name" value="<?=$dbarr["emp_name"]?>" placeholder="" type="text" required>
     </div>
	 <div class="form-group">
    	<label>นามสกุล</label>
		<input class="form-control" name="emp_last_name" value="<?=$dbarr["emp_last_name"]?>" placeholder="" type="text" required>
     </div>
	 <div class="form-group">
    	<label>เพศ</label>
		<div class="radio">
			<label>
				<input type="radio" name="emp_sex" <? if($dbarr["emp_sex"]=="1"){ ?> checked <? } ?>  value="1" /> ชาย
			</label>
		</div>
		<div class="radio">
			<label>
		 		<input type="radio" name="emp_sex"  <? if($dbarr["emp_sex"]=="2"){ ?> checked <? } ?> value="2" /> หญิง
		 	</label>
		</div>
     </div>
	 <div class="form-group">
    	<label>ศาสนา</label>
		<input class="form-control" name="emp_religion" value="<?=$dbarr["emp_religion"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>สัญชาติ</label>
		<input class="form-control" name="emp_nationality" value="<?=$dbarr["emp_nationality"]?>" placeholder="" type="text" >
     </div>
	 <div class="form-group">
    	<label>เชือชาติ</label>
		<input class="form-control" name="emp_nation" value="<?=$dbarr["emp_nation"]?>" placeholder="" type="text" >
     </div>
	 <div class="form-group">
    	<label>วันเกิด</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
        	</div>
        	<input class="form-control datepicker" name="emp_birthday" value="<?=conver_dateSQL($dbarr["emp_birthday"])?>"  type="text">
		</div>
     </div>
	 <div class="form-group">
    	<label>หมายเลขบัตรประชาชน</label>
		<input class="form-control" name="emp_idcard" value="<?=$dbarr["emp_idcard"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>สถานะภาพ</label>
		<select class="form-control" name="emp_status_people">
			<option value="">เลือก</option>
        	<option value="1" <? if($dbarr["emp_status_people"]=="1"){ ?> selected <? } ?> >โสด</option>
            <option value="2" <? if($dbarr["emp_status_people"]=="2"){ ?> selected <? } ?>>แต่งงาน</option>
            <option value="3" <? if($dbarr["emp_status_people"]=="3"){ ?> selected <? } ?>>อย่าร้าง</option>
        </select>
     </div>
	  <div class="form-group">
    	<label>รูปภาพ</label>
		<input name="emp_img" value="" placeholder="" type="file" >
		<? if($dbarr["emp_img"]!=""){ ?>
			<input type="checkbox" value="1" name="img_del"/>	ลบ <a href="./employees_img/<?=$dbarr["emp_img"]?>" target="_blank"><?=$dbarr["emp_img"]?></a>
		<? } ?>
		<input type="hidden" name="img_h" value="<?=$dbarr["emp_img"]?>"/>
     </div>
</div>
<!-- -->
<div role="tabpanel" class="tab-pane" id="tab_edu">	
	<div class="form-group">
    	<label>สถานศึกษา</label>
		<input class="form-control" name="emp_academy" value="<?=$dbarr["emp_academy"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>ระดับการศึกษา</label>
		<select class="form-control" name="emp_education">
			<option value="">เลือก</option>
			<option value="1" <? if($dbarr["emp_education"]=="1"){ ?> selected <? } ?> >ปริญญาเอก</option>
            <option value="2" <? if($dbarr["emp_education"]=="2"){ ?> selected <? } ?>>ปริญญาโท</option>
            <option value="3" <? if($dbarr["emp_education"]=="3"){ ?> selected <? } ?>>ปริญญาตรี</option>
            <option value="4" <? if($dbarr["emp_education"]=="4"){ ?> selected <? } ?>>อนุปริญญา</option>
           	<option value="5" <? if($dbarr["emp_education"]=="5"){ ?> selected <? } ?>>ปวส.</option>
            <option value="6" <? if($dbarr["emp_education"]=="6"){ ?> selected <? } ?>>ปวท.</option>
            <option value="7" <? if($dbarr["emp_education"]=="7"){ ?> selected <? } ?>>ปวช.</option>
            <option value="8" <? if($dbarr["emp_education"]=="8"){ ?> selected <? } ?>>มัธยมศึกษาตอนปลาย</option>
            <option value="9" <? if($dbarr["emp_education"]=="9"){ ?> selected <? } ?>>มัธยมศึกษาตอนต้น</option>
            <option value="10" <? if($dbarr["emp_education"]=="10"){ ?> selected <? } ?>>ต่ำกว่ามัธยมศึกษา</option>                                   >
        </select>
     </div>
	 <div class="form-group">
    	<label>สาขาวิชา</label>
		<input class="form-control" name="emp_subjects" value="<?=$dbarr["emp_subjects"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>ปีที่จบ</label>
		<input class="form-control" name="emp_yearend" value="<?=$dbarr["emp_yearend"]?>" placeholder="" type="number">
     </div>
</div>

<div role="tabpanel" class="tab-pane" id="tab_work">
	 <div class="form-group">
    	<label>รหัสพนักงาน</label>
		<input class="form-control" name="emp_code" value="<?=$dbarr["emp_code"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>ระดับพนักงาน</label>
		<select class="form-control" name="emp_level">
			<option value="">เลือก</option>
			<option value="01" <? if($dbarr["emp_level"]=="01"){ ?> selected <? } ?>>พนักงาน</option>
			<option value="02" <? if($dbarr["emp_level"]=="02"){ ?> selected <? } ?>>ผู้จัดการแผนก</option>
			<option value="03" <? if($dbarr["emp_level"]=="03"){ ?> selected <? } ?>>ผู้จัดการฝ่าย</option>
			<option value="04" <? if($dbarr["emp_level"]=="04"){ ?> selected <? } ?>>ผู้บริหาร</option>
		</select>
     </div>
 	<div class="form-group">
    	<label>ฝ่าย</label>
		<select class="form-control" name="emp_party">
			<option value="">เลือก</option> 
<?
$sql = "SELECT * FROM  master_party ORDER BY party_name";
$query = mysql_query($sql);
while($party_array = mysql_fetch_array($query)){
?>      
		<option value="<?=$party_array["party_id"]?>" <? if($party_array["party_id"]==$dbarr["emp_party"]){ ?> selected <? } ?>><?=$party_array["party_name"]?></option> 
<? } ?>                  
        </select>
     </div>
	<div class="form-group">
    	<label>แผนก</label>
		<select class="form-control" name="emp_department" id="emp_department">
			<option value="">เลือก</option>
<?
if($dbarr['emp_party']!=''){
	$party_id = $dbarr["emp_party"];
	$sql = "SELECT * FROM master_department WHERE party_id='".$party_id."' ORDER BY department_name";
	echo $sql;
	$query = mysql_query($sql);
	while($dbarr_p = mysql_fetch_array($query)){
		$s = "";
		if($dbarr_p["department_id"]==$dbarr["emp_department"]){
			$s = "selected";
		}
		echo "<option value='".$dbarr_p["department_id"]."' ".$s.">".$dbarr_p["department_name"]."</option>";
	}
}
?>
        </select>
     </div>
	 <div class="form-group">
    	<label>ตำแหน่ง</label>
		<select class="form-control" name="emp_office">
			<option value="">เลือก</option> 
<?
$sql = "SELECT * FROM  master_office ORDER BY office_name ";
$query = mysql_query($sql);
while($office_array = mysql_fetch_array($query)){
?>      
		<option value="<?=$office_array["office_id"]?>"  <? if($office_array["office_id"]==$dbarr["emp_office"]){ ?> selected <? } ?> ><?=$office_array["office_name"]?></option> 
<? } ?>                  
        </select>
     </div>
	 <div class="form-group">
    	<label>เงินเดือน</label>
		<input class="form-control" name="emp_salary" value="<?=$dbarr["emp_salary"]?>" placeholder="" type="number">
     </div>
	 <div class="form-group">
    	<label>วันที่เข้าทำงาน</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
        	</div>
        	<input class="form-control datepicker" name="emp_jobstart" value="<?=conver_dateSQL($dbarr["emp_jobstart"])?>"  type="text">
		</div>
     </div>
	 <div class="form-group">
    	<label>สถานะพนักงาน</label>
		<select class="form-control" name="status">
			<option value="">เลือก</option>
			<option value="1" <? if($dbarr["status"]=='1'){ ?> selected <? } ?>>พนักงาน</option>
            <option value="2" <? if($dbarr["status"]=='2'){ ?> selected <? } ?>>ลาออก</option>                                 
        </select>
     </div>
</div>

<div role="tabpanel" class="tab-pane" id="tab_address1">	
	 <div class="form-group">
    	<label>ที่อยู่</label>
		<input class="form-control" name="emp_address1" value="<?=$dbarr["emp_address1"]?>" placeholder="" type="text" >
     </div>
	 <div class="form-group">
    	<label>ตำบล</label>
		<input class="form-control" name="emp_sub_district1" value="<?=$dbarr["emp_sub_district1"]?>" placeholder="" type="text" >
     </div>
	<div class="form-group">
    	<label>อำเภอ</label>
		<input class="form-control" name="emp_district1" value="<?=$dbarr["emp_district1"]?>" placeholder="" type="text" >
     </div>
	 <div class="form-group">
    	<label>จังหวัด</label>
		<input class="form-control" name="emp_province1" value="<?=$dbarr["emp_province1"]?>" placeholder="" type="text" >
     </div>
	 <div class="form-group">
    	<label>รหัสไปรษณีย์</label>
		<input class="form-control" name="emp_zipcod1" value="<?=$dbarr["emp_zipcod1"]?>" placeholder="" type="text" >
     </div>
</div>

<div role="tabpanel" class="tab-pane" id="tab_address2">	
	 <div class="form-group">
    	<label>ที่อยู่</label>
		<input class="form-control" name="emp_address2" value="<?=$dbarr["emp_address2"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>ตำบล</label>
		<input class="form-control" name="emp_sub_district2" value="<?=$dbarr["emp_sub_district2"]?>" placeholder="" type="text" >
     </div>
	<div class="form-group">
    	<label>อำเภอ</label>
		<input class="form-control" name="emp_district2" value="<?=$dbarr["emp_district2"]?>" placeholder="" type="text">
     </div>
	 <div class="form-group">
    	<label>จังหวัด</label>
		<input class="form-control" name="emp_province2" value="<?=$dbarr["emp_province2"]?>" placeholder="" type="text" >
     </div>
	 <div class="form-group">
    	<label>รหัสไปรษณีย์</label>
		<input class="form-control" name="emp_zipcod2" value="<?=$dbarr["emp_zipcod2"]?>" placeholder="" type="text">
     </div>
</div>

<!---- ---->
</div>
</div>
<!---- ---->
<!------------------------------------------------------------------------------------>
	<button type="submit" class="btn btn-primary">บันทึก</button>
	</form>
  	</div>
</div><!-- /.box -->
<script>
$(function() {	
	$('.datepicker').datepicker({
    	format: 'dd-mm-yyyy',
		language: "th"
	});
	
	$("select[name=emp_party]").change(function(){
		GetDep($(this).val());
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