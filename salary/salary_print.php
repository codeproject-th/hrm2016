<?php
//พิมพ์สลีปเงินเดือน ใช้ libs html2pdf
error_reporting ( E_ALL & ~ E_NOTICE );
include_once("./html2pdf/tcpdf.php");

$sql = "SELECT * FROM salary WHERE salary_id='".$_GET['id']."'";
$query = mysql_query($sql);
$salary_data = mysql_fetch_array($query);

$sql = "SELECT s.* , m.list_name FROM salary_detail s LEFT JOIN master_list m ON s.list_id = m.list_id WHERE s.salary_id='".$_GET['id']."' and s.salary_type='1'";//ดึงข้อมูลรายละเอียดเงินเดือน
$query = mysql_query($sql);
$tb1 = '<table border="0" cellspacing="0" cellpadding="3">';
$in = 0;
while($dbarr=mysql_fetch_array($query)){
	$tb1 .= '<tr>';
	$tb1 .= '<td width="192">'.$dbarr['list_name'].'</td>';
	$tb1 .= '<td width="68" align="right">'.number_format($dbarr['money'],2).'</td>';
	$tb1 .= '</tr>';
	$in = $in+$dbarr['money'];
}
$tb1 .= '</table>';

$tb3 = '<table border="0" cellspacing="0" cellpadding="3">';
$tb3 .= '<tr>';
$tb3 .= '<td width="192">'.$dbarr['list_name'].'</td>';
$tb3 .= '<td width="68" align="right">'.number_format($in,2).'</td>';
$tb3 .= '</tr>';
$tb3 .= '</table>';
//////////////////
$sql = "SELECT s.* , m.list_name FROM salary_detail s LEFT JOIN master_list m ON s.list_id = m.list_id WHERE s.salary_id='".$_GET['id']."' and s.salary_type='2'";
$query = mysql_query($sql);
$tb2 = '<table border="0" cellspacing="0" cellpadding="3">';
$de = 0;
while($dbarr=mysql_fetch_array($query)){
	$tb2 .= '<tr>';
	$tb2 .= '<td width="197">'.$dbarr['list_name'].'</td>';
	$tb2 .= '<td width="68" align="right">'.number_format($dbarr['money'],2).'</td>';
	$tb2 .= '</tr>';
	$de = $de+$dbarr['money'];
}
$tb2 .= '</table>';

$tb4 = '<table border="0" cellspacing="0" cellpadding="3">';
$tb4 .= '<tr>';
$tb4 .= '<td width="197">'.$dbarr['list_name'].'</td>';
$tb4 .= '<td width="68" align="right">'.number_format($de,2).'</td>';
$tb4 .= '</tr>';
$tb4 .= '</table>';
//////////////////
$sql = "SELECT * FROM employees WHERE emp_id='".$salary_data['employees_id']."'";
$query = mysql_query($sql);
$emp_data = mysql_fetch_array($query);

$sql = "SELECT * FROM master_office WHERE office_id='".$emp_data['emp_office']."'";
$query = mysql_query($sql);
$office_data = mysql_fetch_array($query);

$sql = "SELECT * FROM master_party WHERE party_id='".$emp_data['emp_party']."'";
$query = mysql_query($sql);
$party_data = mysql_fetch_array($query);



$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//สร้าobj
$pdf->SetPrintHeader(false);//set ให้ำม่มีไตเติล
$pdf->SetPrintFooter(true);//set footer
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage();//เพิ่มหน้า
$pdf->SetFont('angsanaupc', '', 12);

$html = '<table border="1" cellspacing="0" cellpadding="3">
					<tr>
						<td width="540" align="center" bgcolor="#efefef">
							<b>ใบแจ้งเงินเดือน</b>
						</td>
					</tr>
				</table>
				';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<table border="0" cellspacing="0" cellpadding="3">
					<tr>
						<td width="270" align="left">
							รหัสพนักงาน : '.$emp_data['emp_code'].'
						</td>
						<td width="270" align="left">
							ตำแหน่ง : '.$office_data['office_name'].'
						</td>
					</tr>
					<tr>
						<td width="270" align="left">
							ชื่อ : '.$emp_data['emp_name'].' '.$emp_data['emp_last_name'].'
						</td>
						<td width="270" align="left">
							ประจำงวด : '.monthThai(number_format($salary_data['salary_month'])).' '.($salary_data['salary_year']+543).'
						</td>
					</tr>
					<tr>
						<td width="500" align="left">
							สังกัด : '.$party_data['party_name'].'
						</td>
					</tr>
				</table>
				';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<table border="1" cellspacing="0" cellpadding="3">
					<tr>
						<td width="195" align="center" bgcolor="#efefef">
							รายการรับ
						</td>
						<td width="70" align="center" bgcolor="#efefef">
							จำนวนเงิน
						</td>
						<td width="200" align="center" bgcolor="#efefef">
							รายการหัก
						</td>
						<td width="70" align="center" bgcolor="#efefef">
							จำนวนเงิน
						</td>
					</tr>
					<tr>
						<td width="265">
							'.$tb1.'
						</td>
						<td width="270">
							'.$tb2.'
						</td>
					</tr>
					<tr>
						<td width="265">
							'.$tb3.'
						</td>
						<td width="270">
							'.$tb4.'
						</td>
					</tr>
				</table>
				';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<table border="0" cellspacing="0" cellpadding="3">';
$html .= '<tr>';
$html .= '<td></td>';
$html .= '<td align="right">รายได้สุทธิ '.number_format($salary_data['salary_money'],2).' บาท</td>';
$html .= '</tr>';
$html .= '</table>';
$pdf->setY($pdf->getY()-5);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('slip.pdf', 'F');//สร่างไฟล์ pdf
?>

<iframe src="slip.pdf" width="100%" height="600"></iframe> 
