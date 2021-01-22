<?
if($_SESSION["login"]["type"]!=1){
	print "
	<script>
		alert('เฉพาะผู้ดูแลระบบเท่านั้น');
	</script>
	";
	exit;
}
?>
<div class="menu_sub">
<ul>
	<li><a href="index.php?m=<?=$m?>&page=department">แผนก</a> </li>
	<li><a href="index.php?m=<?=$m?>&page=office">ตำแหน่ง</a></li>
    <li><a href="index.php?m=<?=$m?>&page=list">รายการ</a></li>
    <li><a href="index.php?m=<?=$m?>&page=weekend">เวลาทำการบริษัท</a></li>
    <li><a href="index.php?m=<?=$m?>&page=holiday">วันหยุดนักขัตฤกษ์</a></li>
</ul>
</div>