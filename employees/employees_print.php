<?php

function dateThai($date=""){
	$m['01'] = "มกราคม";
	$m['02'] = "กุมภาพันธ์";
	$m['03'] = "มีนาคม";
	$m['04'] = "เมษายน";
	$m['05'] = "พฤษภาคม";
	$m['06'] = "มิถุนายน";
	$m['07'] = "กรกฎาคม";
	$m['08'] = "สิงหาคม";
	$m['09'] = "กันยายน";
	$m['10'] = "ตุลาคม";
	$m['11'] = "พฤศจิกายน";
	$m['12'] = "ธันวาคม";
	$date_ex = explode("-",$date);
	return $date_ex[2]." ".$m[$date_ex[1]]." ".($date_ex[0]+543);
}

$people_status['1'] = "โสด";
$people_status['2'] = "แต่งงาน";
$people_status['3'] = "อย่าร้าง";

$emp_edu['1'] = "ปริญญาเอก";
$emp_edu['2'] = "ปริญญาโท";
$emp_edu['3'] = "ปริญญาตรี";
$emp_edu['4'] = "อนุปริญญา";
$emp_edu['5'] = "ปวส.";
$emp_edu['6'] = "ปวท.";
$emp_edu['7'] = "ปวช.";
$emp_edu['8'] = "มัธยมศึกษาตอนปลาย";
$emp_edu['9'] = "มัธยมศึกษาตอนต้น";
$emp_edu['10'] = "ต่ำกว่ามัธยมศึกษา";


$sql = "SELECT e.* , o.office_name , p.party_name , d.department_name FROM employees e 
		LEFT JOIN master_office o ON e.emp_office=o.office_id
		LEFT JOIN master_party p ON e.emp_party=p.party_id
		LEFT JOIN master_department d ON e.emp_department=d.department_id
		WHERE e.emp_id='".$_GET["id"]."'";
$query = mysql_query($sql);
$dbarr = mysql_fetch_array($query);

include_once("./html2pdf/tcpdf.php");

$img = "./employees_img/".$dbarr['emp_img'];

$tb1 = '<table border="1" cellspacing="0" cellpadding="2">';
$tb1 .= '<tr>';
$tb1 .= '<td width="540" align="center" bgcolor="#f7d7a8"><center>ข้อมูลพนักงาน</center></td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="100" align="center"><img src="'.$img.'" width="94"  height="100" /></td>';
$tb1 .= '<td width="440">
			<b>รหัสพนักงาน :</b> '.$dbarr['emp_code'].' <br/> 
			<b>ชื่อ :</b> '.$dbarr['emp_name'].'         <b>นามสกุล :</b> '.$dbarr['emp_last_name'].'  <br/>
			<b>ตำแหน่ง :</b> '.$dbarr['office_name'].' <br/>
			<b>ฝ่าย :</b> '.$dbarr['party_name'].'         
			<b>แผนก :</b> '.$dbarr['department_name'].' <br/>
			<b>วันเริ่มงาน :</b> '.dateThai($dbarr['emp_jobstart']).' <br/>
			<b>เงินเดือน :</b> '.number_format($dbarr['emp_salary']).'
		</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">หมายเลขบัตรประชาชน</td>';
$tb1 .= '<td width="140" align="center">'.$dbarr['emp_idcard'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">วันเกิด</td>';
$tb1 .= '<td width="80" align="center">'.dateThai($dbarr['emp_birthday']).'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">สถานะภาพ</td>';
$tb1 .= '<td width="80" align="center">'.$people_status[$dbarr['emp_status_people']].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ศาสนา</td>';
$tb1 .= '<td width="100" align="center">'.$dbarr['emp_religion'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">สัญชาติ</td>';
$tb1 .= '<td width="100" align="center">'.$dbarr['emp_nationality'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">เชือชาติ</td>';
$tb1 .= '<td width="100" align="center">'.$dbarr['emp_nation'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ระดับการศึกษา</td>';
$tb1 .= '<td width="100" align="center">'.$emp_edu[$dbarr['emp_education']].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">สถานศึกษา</td>';
$tb1 .= '<td width="280" align="center">'.$dbarr['emp_academy'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">สาขาวิชา</td>';
$tb1 .= '<td width="280" align="center">'.$dbarr['emp_subjects'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ปีที่จบ</td>';
$tb1 .= '<td width="100" align="center">'.$dbarr['emp_yearend'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="540" align="center" bgcolor="#f7d7a8"><center>ที่อยู่ปัจจุบัน</center></td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ที่อยู่</td>';
$tb1 .= '<td width="460" align="center">'.$dbarr['emp_address1'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ตำบล</td>';
$tb1 .= '<td width="190" align="center">'.$dbarr['emp_sub_district1'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">อำเภอ</td>';
$tb1 .= '<td width="190" align="center">'.$dbarr['emp_district1'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">จังหวัด</td>';
$tb1 .= '<td width="300" align="center">'.$dbarr['emp_province1'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">รหัสไปรษณีย์</td>';
$tb1 .= '<td width="80" align="center">'.$dbarr['emp_zipcod1'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="540" align="center" bgcolor="#f7d7a8"><center>ที่อยู่ตามทะเบียนบ้าน</center></td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ที่อยู่</td>';
$tb1 .= '<td width="460" align="center">'.$dbarr['emp_address2'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">ตำบล</td>';
$tb1 .= '<td width="190" align="center">'.$dbarr['emp_sub_district2'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">อำเภอ</td>';
$tb1 .= '<td width="190" align="center">'.$dbarr['emp_district2'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '<tr>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">จังหวัด</td>';
$tb1 .= '<td width="300" align="center">'.$dbarr['emp_province2'].'</td>';
$tb1 .= '<td width="80" bgcolor="#e6e6e6">รหัสไปรษณีย์</td>';
$tb1 .= '<td width="80" align="center">'.$dbarr['emp_zipcod2'].'</td>';
$tb1 .= '</tr>';
$tb1 .= '</table>';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//สร้าobj
$pdf->SetPrintHeader(false);//set ให้ำม่มีไตเติล
$pdf->SetPrintFooter(true);//set footer
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage();//เพิ่มหน้า
$pdf->SetFont('angsanaupc', '', 12);
$pdf->writeHTML($tb1, true, false, true, false, '');
$pdf->Output('emp.pdf', 'F');
?>

<iframe src="emp.pdf" width="100%" height="600"></iframe>