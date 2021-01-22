<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>เข้าสู่ระบบ</title>

<link href="./css/login.css" rel="stylesheet" type="text/css" />
</head>

<body>

<form action="chk_login.php" method="post">

<div style="padding: 100px 0 0 0;" align="center">

<div id="login-box">

<H2>เข้าสู่ระบบ</H2>

<br />
<br />
<div id="login-box-name" style="margin-top:20px;">
	Username:
</div>

<div id="login-box-field" style="margin-top:20px;">
	<input name="username" class="form-login" title="Username" value="" size="30" maxlength="2048" />
</div>

<div id="login-box-name">Password:</div>

<div id="login-box-field">
	<input name="password" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" />
</div>


	
<input type="image" name="submit" src="images/login-btn.png" width="103" height="42">

</div>
</div>

</form>

</body>
</html>
