<? 
//print $_SESSION["login"]["type"];
if($_SESSION["login"]["type"]==1){
?>
<div class="menu">
	<ul>
		<li <? if($m=="master"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=master">ข้อมูลมาตราฐาน</a></li>
        <li <? if($m=="user"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=user">ผู้ใช้งาน</a></li>
        <li <? if($m=="employees"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=employees">ข้อมูลพนักงาน</a></li>
        <li <? if($m=="memo"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=memo">บันทึกการทำงาน</a></li>
        <li <? if($m=="leave"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=leave">คำร้องขอลาหยุด</a></li>
        <li <? if($m=="salary"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=salary">เงินเดือน</a></li>
        <li <? if($m=="user_report"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=user_report">รายงาน</a></li>
        <li <? if($m=="survey"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=survey">แบบสำรวจ</a></li>
        <li <? if($m=="logout"){  ?> id="menu_select"  <? } ?>><a href="logout.php">ออกจากระบบ</a></li>
    </ul>
</div>

<? }
else{
?>

<div class="menu">
	<ul>
        <li <? if($m=="memo"){  ?> id="menu_select"  <? } ?>><a href="index.php?m=memo">บันทึกการทำงาน</a></li>
        <li <? if($m=="logout"){  ?> id="menu_select"  <? } ?>><a href="logout.php">ออกจากระบบ</a></li>
    </ul>
</div>

<? } ?>