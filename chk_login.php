<?
session_start();
include("./includes/config.inc.php");
include("./includes/conn.php");
include("./includes/function.php");

/*



*/

$sql="SELECT * FROM user WHERE user_name='".$_POST["username"]."' AND user_pwd='".$_POST["password"]."'";
$query=mysql_query($sql);
$dbarr=mysql_fetch_array($query);

if($dbarr["user_name"]!="" and $dbarr["user_pwd"]!=""){
	$_SESSION["login"]["emp_id"]=$dbarr["employees_id"];
	$_SESSION["login"]["type"]=$dbarr["user_type"];
	//print $_SESSION["login"]["type"];
	print "
		<script>
			window.location='index.php';
		</script>
	";
}
else{
		print "
		<script>
			alert('ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
			window.location='index.php';
		</script>
	";
}

?>