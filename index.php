<?
session_start();
error_reporting ( E_ALL & ~ E_NOTICE );
include("./includes/config.inc.php");
include("./includes/conn.php");
include("./includes/function.php");

if($_SESSION["login"]==""){
	include("login.php");
	exit;
}

if($_GET["m"]!=""){
	$m=$_GET["m"];
}

if($m=="master" and $_SESSION["login"]["type"]!="1"){
	exit;
}

if($m=="employees" and ($_SESSION["login"]["type"]!="1" and $_SESSION["login"]["type"]!="2")){
	//print_r($_SESSION);
	exit;
}


$sql = "SELECT * FROM employees WHERE emp_id='".$_SESSION["login"]['emp_id']."'";
$query = mysql_query($sql);
$UserData = mysql_fetch_array($query );
if($UserData ["emp_img"]!=""){
	$Emp_Img = "./employees_img/".$UserData ["emp_img"];
}else{
	$Emp_Img = "./employees_img/anonymous.png";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Leave System</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="./AdminLTE/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./AdminLTE/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="./AdminLTE/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./AdminLTE/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="./AdminLTE/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="./AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="./AdminLTE/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="./AdminLTE/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="./AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="./AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="./AdminLTE/plugins/fullcalendar/fullcalendar.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	 <!-- jQuery 2.1.4 -->
    <script src="./AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="./AdminLTE/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="./AdminLTE/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="./AdminLTE/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="./AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="./AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="./AdminLTE/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="./AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="./AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="./AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="./AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="./AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="./AdminLTE/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./AdminLTE/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="./AdminLTE/dist/js/pages/dashboard.js"></script>-->
    <!-- AdminLTE for demo purposes -->
    <script src="./AdminLTE/dist/js/demo.js"></script>
	<!-- bootstrap time picker -->
	<script src="./AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- Fullcalendar -->
	<script src="./AdminLTE/plugins/fullcalendar/fullcalendar.js"></script>
	<script src="./AdminLTE/plugins/fullcalendar/lang-all.js"></script>
	<!-- Chartjs -->
	<script src="./AdminLTE/plugins/chartjs/Chart.js"></script>
  </head>
	<body class="skin-blue fixed">
    	<div class="wrapper">
    		<header class="main-header">
    			 <!-- Logo -->
        		<a href="index.php" class="logo">
          			Online Leave System
        		</a>
        		<nav class="navbar navbar-static-top" role="navigation">
          			<!-- Sidebar toggle button-->
          			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          				<span class="sr-only">Toggle navigation</span>
          			</a>
          			<div class="navbar-custom-menu">
            			<ul class="nav navbar-nav">
              			<!-- Messages: style can be found in dropdown.less-->
              				
                		</ul>
                	</div>
                </nav>
    		</header>
    		<aside class="main-sidebar">
    			 <section class="sidebar">
    			 	<ul class="sidebar-menu">
						<div class="user-panel">
        					<div class="pull-left image">
          						<img src="<?=$Emp_Img?>" class="img-circle" alt="User Image">
        					</div>
        					<div class="pull-left info">
          						<p><?=$UserData["emp_name"]?> <?=$UserData["emp_last_name"]?></p>
          						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        					</div>
							<br><br>
      					</div>
            			<li class="header">MAIN NAVIGATION</li>
            			<? if($_SESSION["login"]["type"]==1){ ?>
            				<li class=" <? if($m=="master"){  ?>active<? } ?> treeview">
            					<a href="index.php?m=master">
            						<i class="fa fa-database"></i> <span>ข้อมูลมาตราฐาน</span> <i class="fa fa-angle-left pull-right"></i>
            					</a>
            					<ul class="treeview-menu">
									<li><a href="index.php?m=master&p=party"><i class="fa fa-circle-o"></i> ฝ่าย</a></li>
                					<li><a href="index.php?m=master&p=department"><i class="fa fa-circle-o"></i> แผนก</a></li>
									<li><a href="index.php?m=master&p=office"><i class="fa fa-circle-o"></i> ตำแหน่ง</a></li>
    								<li><a href="index.php?m=master&p=list"><i class="fa fa-circle-o"></i> รายการเงินเดือน</a></li>
    								<li><a href="index.php?m=master&p=weekend"><i class="fa fa-circle-o"></i> เวลาทำการบริษัท</a></li>
    								<li><a href="index.php?m=master&p=holiday"><i class="fa fa-circle-o"></i> วันหยุดนักขัตฤกษ์</a></li>
									<li><a href="index.php?m=master&p=leave_type"><i class="fa fa-circle-o"></i> ประเภทการลา</a></li>
									<li><a href="index.php?m=master&p=setting_salary"><i class="fa fa-circle-o"></i> OT และประกันสังคม</a></li>
              					</ul>
            				</li>
        					<li class="<? if($m=="user"){  ?> active <? } ?> treeview">
        						<a href="index.php?m=user">
        							<i class="fa fa-user"></i> <span>ผู้ใช้งาน</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
        						<ul class="treeview-menu">
        							<li><a href="index.php?m=user&p=user"><i class="fa fa-circle-o"></i> ข้อมูลผู้ใช้งาน</a></li>
        						</ul>
        					</li>
        					<li  class="<? if($m=="employees"){  ?> active <? } ?> treeview">
        						<a href="index.php?m=employees">
        							<i class="fa fa-group"></i> <span>พนักงาน</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
        						<ul class="treeview-menu">
        							<li><a href="index.php?m=employees&p=employees"><i class="fa fa-circle-o"></i> ข้อมูลพนักงาน</a></li>
        						</ul>
        					</li>
        					<li  class="<? if($m=="leave"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=leave">
        							<i class="fa fa-hand-stop-o"></i> <span>การลา</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
								<ul class="treeview-menu">
									<li><a href="index.php?m=leave&p=endorser"><i class="fa fa-circle-o"></i> สิทธิ์การอนุมัติ</a></li>
									<li><a href="index.php?m=leave&p=leave"><i class="fa fa-circle-o"></i> ข้อมูลการลา</a></li>
              					</ul>
        					</li>
							<li  class="<? if($m=="time_attendance"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=time_attendance">
        							<i class="fa fa-clock-o"></i> <span>เข้า-ออกงาน</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
								<ul class="treeview-menu">
									<li><a href="index.php?m=time_attendance&p=import"><i class="fa fa-circle-o"></i> นำเข้าข้อมูลเวลา</a></li>
									<li><a href="index.php?m=time_attendance&p=cal"><i class="fa fa-circle-o"></i> คำนวณเวลา</a></li>
									<li><a href="index.php?m=time_attendance&p=time_emp"><i class="fa fa-circle-o"></i> ข้อมูลเวลา</a></li>
              					</ul>
        					</li>
        					<li class="<? if($m=="salary"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=salary">
        							<i class="fa fa-money"></i> <span>เงินเดือน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=salary&p=salary_add&act=add"><i class="fa fa-circle-o"></i> บันทึกจ่ายเงินเดือน</a></li>
										<li><a href="index.php?m=salary&p=salary"><i class="fa fa-circle-o"></i> รายการเงินเดือน</a></li>
									</ul>
        						</a>
        					</li>
        					<li class="<? if($m=="report"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=user_report">
        							<i class="fa fa-bar-chart"></i> <span>รายงาน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=report&p=report_1"><i class="fa fa-circle-o"></i> รายงานการลา</a></li>
									</ul>
        						</a>
        					</li>
							<? if($_SESSION["login"]["type"]!=''){ ?>
							<li class="<? if($m=="user_calendar"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=user_calendar">
        							<i class="fa fa-calendar"></i> <span>ปฏิทิน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=user_calendar&p=user_work_calendar"><i class="fa fa-circle-o"></i> ปฏิทินการทำงาน</a></li>
										<li><a href="index.php?m=user_calendar&p=user_calendar"><i class="fa fa-circle-o"></i> ปฏิทินการลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_statistic_calendar"><i class="fa fa-circle-o"></i> สถิติการลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_leave_add&act=add"><i class="fa fa-circle-o"></i> ขอลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_leave_approve"><i class="fa fa-circle-o"></i> การอนุมัติ</a></li>
              						</ul>
        						</a>
        					</li>
							<? } ?>
        					<li class="<? if($m=="logout"){  ?> active  <? } ?> treevie">
        						<a href="logout.php">
        							<i class="fa fa-sign-out"></i> <span>ออกจากระบบ</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
        					</li>  			
            			<? } ?>
						<!-------- Type2 ----------->
						<? if($_SESSION["login"]["type"]==2){ ?>
        					<li  class="<? if($m=="employees"){  ?> active <? } ?> treeview">
        						<a href="index.php?m=employees">
        							<i class="fa fa-group"></i> <span>พนักงาน</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
        						<ul class="treeview-menu">
        							<li><a href="index.php?m=employees&p=employees"><i class="fa fa-circle-o"></i> ข้อมูลพนักงาน</a></li>
        						</ul>
        					</li>
        					<li class="<? if($m=="report"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=user_report">
        							<i class="fa fa-bar-chart"></i> <span>รายงาน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=report&p=report_1"><i class="fa fa-circle-o"></i> รายงาน</a></li>
									</ul>
        						</a>
        					</li>
							<? if($_SESSION["login"]["type"]!=''){ ?>
							<li class="<? if($m=="user_calendar"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=user_calendar">
        							<i class="fa fa-calendar"></i> <span>ปฏิทิน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=user_calendar&p=user_work_calendar"><i class="fa fa-circle-o"></i> ปฏิทินการทำงาน</a></li>
										<li><a href="index.php?m=user_calendar&p=user_calendar"><i class="fa fa-circle-o"></i> ปฏิทินการลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_statistic_calendar"><i class="fa fa-circle-o"></i> สถิติการลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_leave_add&act=add"><i class="fa fa-circle-o"></i> ขอลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_leave_approve"><i class="fa fa-circle-o"></i> การอนุมัติ</a></li>
              						</ul>
        						</a>
        					</li>
							<? } ?>
							<li class="<? if($m=="logout"){  ?> active  <? } ?> treevie">
        						<a href="logout.php">
        							<i class="fa fa-sign-out"></i> <span>ออกจากระบบ</span> <i class="fa fa-angle-left pull-right"></i>
        						</a>
        					</li>  	
						<? } ?>
						<!-------- Type2 ----------->
						<? if($_SESSION["login"]["type"]==3){ ?>
							<li class="<? if($m=="user_calendar"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=user_calendar">
        							<i class="fa fa-calendar"></i> <span>ปฏิทิน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=user_calendar&p=user_work_calendar"><i class="fa fa-circle-o"></i> ปฏิทินการทำงาน</a></li>
										<li><a href="index.php?m=user_calendar&p=user_calendar"><i class="fa fa-circle-o"></i> ปฏิทินการลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_statistic_calendar"><i class="fa fa-circle-o"></i> สถิติการลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_leave_add&act=add"><i class="fa fa-circle-o"></i> ขอลา</a></li>
										<li><a href="index.php?m=user_calendar&p=user_leave_approve"><i class="fa fa-circle-o"></i> การอนุมัติ</a></li>
              						</ul>
        						</a>
        					</li>
							
							<? if($UserData["emp_level"]!="01"){ ?>
							<li class="<? if($m=="report"){  ?> active  <? } ?> treeview">
        						<a href="index.php?m=user_report">
        							<i class="fa fa-bar-chart"></i> <span>รายงาน</span> <i class="fa fa-angle-left pull-right"></i>
									<ul class="treeview-menu">
										<li><a href="index.php?m=report&p=report_1"><i class="fa fa-circle-o"></i> รายงาน</a></li>
									</ul>
        						</a>
        					</li>
							<? } ?>
							
							<li class="treevie">
        						<a href="index.php?m=&p=chg_pass">
        							<i class="fa fa-lock"></i> <span>เปลี่ยนรหัสผ่าน</span>
        						</a>
        					</li> 
							<li class="<? if($m=="logout"){  ?> active  <? } ?> treevie">
        						<a href="logout.php">
        							<i class="fa fa-sign-out"></i> <span>ออกจากระบบ</span>
        						</a>
        					</li> 
						<? } ?>
            		</ul>
    			 </section>
    		</aside>
    		<div class="content-wrapper">
    			 <div class="content body">
    			 	<div class="row">
    			 		<div class="col-sm-12">
    			 		
    			 		<!---------->
    			 		<? if($_GET["p"]!="")
    			 		{ 
							include("./".$m."/".$_GET["p"].".php");
						 } 
						?>
    			 		<!---------->
    			 		</div>
    			 	</div>
    			 </div>
    		</div>
    	</div>
	</body>
</html>
