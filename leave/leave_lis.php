<fieldset class="title">
	<legend>รายการคำร้องขอลาหยุด</legend>
    
   <center>
    <table border="1">
    	<tr class="head_table">
        	<td>ลำดับ</td>
            <td width="500">ชื่อ-นามสกุล</td>
            <td width="150">วันที่ยื่นใบลา</td>
            <td width="100">สถานะ</td>
        </tr>	
<?

$n=$_GET["n"];
$show=20;
if($n==""){
	$n=1;
}

$sql="SELECT COUNT(*) FROM ".DB_NAME.".leave";
//print $sql;
$query=mysql_query($sql);
$count=mysql_result($query,0);

$num_page=ceil($count/$show);
$start=($n*$show)-$show;

$sql="SELECT DISTINCT ".DB_NAME.".leave.leave_id , ".DB_NAME.".leave.leave_status , ".DB_NAME.".leave.leave_open , ".DB_NAME.".leave.create_date  , employees.employees_name , employees.employees_last_name , employees.employees_id FROM ".DB_NAME.".leave , employees WHERE ".DB_NAME.".leave.employees_id=employees.employees_id  ORDER BY ".DB_NAME.".leave.create_date DESC LIMIT $start , $show";
//print $sql;
$query=mysql_query($sql);
$i=$n-1;
while($dbarr=mysql_fetch_array($query)){
	$i++;
	
	if($dbarr["leave_open"]==0){
		$text="<font color='red'>ยังไม่ได้อ่าน</font>";
	}
	else{
		$text="";
	}
?>
		<tr class="head_table2">
        	<td align="center"><?=$i?></td>
            <td><a href="index.php?m=leave&page=leave_lis&ac=viwe&id=<?=$dbarr["leave_id"]?>"><?=$dbarr["employees_name"]?> <?=$dbarr["employees_last_name"]?></a> <?=$text?></td>
            <td align="center"><?=conver_datetime($dbarr["create_date"])?></td>
            <td align="center"><?=leave_status($dbarr["leave_status"])?></td>
        </tr>	
<? } ?>

<? if($num_page>1){ ?>
		<tr class="head_table2">
        	<td colspan="4">
            หน้า 
            <?
				for($i=1;$i<=$num_page;$i++){
					if($i==$n){
						print "<a href='index.php?m=leave&page=leave_lis&n=".$i."'><u>".$i."</u></a> ";
					}
					else{
						print "<a href='index.php?m=leave&page=leave_lis&n=".$i."'>".$i."</a> ";
					}
				}
			?>
            </td>
        </tr>	
<? } ?>
	</table>
    </center>
    
</fieldset>

<? 
if($_GET["ac"]=="viwe"){ 

mysql_query("UPDATE ".DB_NAME.".leave SET leave_open='1' WHERE leave_id='".$_GET["id"]."'");

$sql="SELECT * FROM ".DB_NAME.".leave WHERE leave_id='".$_GET["id"]."'";
$query=mysql_query($sql);
$dbarr=mysql_fetch_array($query);
$employees=employees($dbarr["employees_id"]);

	if($dbarr["leave_startday"]!=$dbarr["leave_endday"]){
		$day=conver_dateSQL($dbarr["leave_startday"])." ถึง ".conver_dateSQL($dbarr["leave_endday"]);
	}
	else{
		$day=conver_dateSQL($dbarr["leave_startday"]);
	}

?>
<fieldset class="title">
	<legend>รายการคำร้องขอลาหยุด</legend>
    <div id="ie_none"> 
    <form method="post" action="index.php?m=leave&page=leave_update_status"> 
    <table style="margin-left:30px;">
    	<tr>
        	<td align="right">สถานะ :</td>
            <td><? if($dbarr["leave_status"]=="0"){ ?>
            	<select name="status">
                	<option value="0" <? if($dbarr["leave_status"]=="0"){ ?> selected="selected" <? } ?>>รอการพิจารณา</option>
                    <option value="1" <? if($dbarr["leave_status"]=="1"){ ?> selected="selected" <? } ?>>อนุมัติ</option>
                    <option value="2" <? if($dbarr["leave_status"]=="2"){ ?> selected="selected" <? } ?>>ไม่อนุมัติ</option>
                    <option value="3" <? if($dbarr["leave_status"]=="3"){ ?> selected="selected" <? } ?>>ยกเลิก</option>
                </select>
                <input type="submit" value="เปลี่ยนสถานะ" />
                <? } else{ print leave_status($dbarr["leave_status"]); } ?>
            </td>
        </tr>
    	<tr>
        	<td align="right">ชื่อ :</td>
            <td><?=$employees["employees_name"]?> <?=$employees["employees_last_name"]?></td>
        </tr>
        <tr>
        	<td align="right">ลา :</td>
            <td><?=leave_type($dbarr["leave_type"])?></td>
        </tr>
         <tr>
        	<td align="right">วันที่ :</td>
            <td><?=$day?></td>
        </tr>
        <tr>
        	<td align="right">เวลา :</td>
            <td><?=substr($dbarr["leave_starttime"],0,5)?> - <?=substr($dbarr["leave_endtime"],0,5)?> น.</td>
        </tr>
         <tr valign="top">
        	<td align="right">ข้อความ :</td>
            <td><?=$dbarr["leave_comment"]?></td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?=$_GET["id"]?>" />
    </form>
    </div>
</fieldset>
<? } ?>
