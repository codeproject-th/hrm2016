<?php
//บันทึกเงินเดือน
function getList($id){
	$sql = "SELECT * FROM master_list WHERE list_id='".$id."'";
	$query = mysql_query($sql);
	$dbarr = mysql_fetch_array($query);
	return $dbarr;
}

if($_POST){
	if($_GET["act"]=="add"){
		$sql = "SELECT COUNT(*) AS N FROM salary WHERE 
				employees_id='".$_POST['employees_id']."' 
				AND salary_month='".$_POST["salary_month"]."' 
				AND salary_year='".$_POST["salary_year"]."'
				";//นับก่อนว่าเคยinsertข้อมูลยัง
		$query = mysql_query($sql);
		$query_row = mysql_fetch_array($query);
		if($query_row["N"]=='0'){
			$money = 0;
			$i = 0;
			if(count($_POST['list'])>0){
				foreach($_POST['list'] as $key => $val){
					$getList = getList($key);
					if($getList["list_type"]=="1"){
						//$money = $money+$_POST['list_value'][$key];
						$money = $money+$val;
					}else if($getList["list_type"]=="2"){
						//$money = $money-$_POST['list_value'][$key];
						$money = $money-$val;
					}
					
					$sql_arr[$i]['list_id'] = $key;
					$sql_arr[$i]['salary_type'] = $getList["list_type"];
					//$sql_arr[$i]['money'] = $_POST['list_value'][$key];
					$sql_arr[$i]['money'] = $val;
					$i++;
				}
			}
			
			$sql = "INSERT INTO salary(
					employees_id,
					salary_month,
					salary_year,
					salary_money
				) VALUES(
					'".$_POST['employees_id']."',
					'".$_POST["salary_month"]."',
					'".$_POST["salary_year"]."',
					'".$money."'
				)";
				
			$query = mysql_query($sql);
			$insert_id = mysql_insert_id();
			if(count($sql_arr)>0){
				foreach($sql_arr as $key => $val){
					$sql = "INSERT INTO salary_detail(
								salary_id,
								list_id,
								salary_type,
								money
							) VALUES(
								'".$insert_id."',
								'".$val['list_id']."',
								'".$val['salary_type']."',
								'".$val['money']."'
							)";
					mysql_query($sql);
				}
			}
			$save = true;
		}
	}else if($_GET["act"]=="edit"){
		$sql = "DELETE FROM salary_detail WHERE salary_id='".$_POST['salary_id']."'";
		mysql_query($sql);
		$money = 0;
		if(count($_POST['list'])>0){
				$i = 0;
				foreach($_POST['list'] as $key => $val){
					$getList = getList($key);
					if($getList["list_type"]=="1"){
						//$money = $money+$_POST['list_value'][$key];
						$money = $money+$val;
					}else if($getList["list_type"]=="2"){
						//$money = $money-$_POST['list_value'][$key];
						$money = $money-$val;
					}
					
					$sql_arr[$i]['list_id'] = $key;
					$sql_arr[$i]['salary_type'] = $getList["list_type"];
					//$sql_arr[$i]['money'] = $_POST['list_value'][$key];
					$sql_arr[$i]['money'] = $val;
					$i++;
				}
			}
		}
		
		$sql = "UPDATE salary SET 
					employees_id = '".$_POST['employees_id']."',
					salary_month = '".$_POST["salary_month"]."',
					salary_year = '".$_POST["salary_year"]."',
					salary_money = '".$money."'
				WHERE salary_id='".$_POST['salary_id']."'";
		
		mysql_query($sql);
		if(count($sql_arr)>0){
				foreach($sql_arr as $key => $val){
					$sql = "INSERT INTO salary_detail(
								salary_id,
								list_id,
								salary_type,
								money
							) VALUES(
								'".$_POST['salary_id']."',
								'".$val['list_id']."',
								'".$val['salary_type']."',
								'".$val['money']."'
							)";
					mysql_query($sql);
				}
		}
		$sql = "DELETE FROM salary_detail WHERE salary_id='0'";
		mysql_query($sql);
		$save = true;
	
}

?>

<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="window.location='index.php?m=salary&p=salary';">×</button>
    <h4><i class="icon fa fa-check"></i> Alert!</h4>
    บันทึกข้อมูลเรียบร้อย
</div>