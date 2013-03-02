<?php
include("includes/php/general.php");
include("includes/php/forgot.php");

$remoteip = $_SERVER['REMOTE_ADDR'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/css/default.css" />
<title>Novartis RMD - Password Reset</title>
</head>
<body onLoad="document.login.username.focus();">
<div id="outer">
  <table width="100%">
    <tr>
      <td>
  <a href="/index.php"><img src="images/logo.jpg"></a>
      </td>
      <td align="right"><img src="images/Yotta-logo-medium.jpg"></td>
    </tr>
  </table>
  <ul class="topnav">
  </ul>
  <div id="content">
    <form method="post" name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php
if(isset($_POST['emailAddress'])) {
	print("<h3>A temporary password has been sent to your email address.</h3>\n");
	reset_password($_POST['emailAddress']);
	log_action(0, $remoteip, sprintf("Password reset requested for %s", $_POST['emailAddress']));
}
else {
?>
    <h3>Reset Password</h3>
    <table class="content_table">
	<td>Email Address</td>
	<td><input type="text" name="emailAddress" size="20"></td>
	<td><input name="submit" type="submit" value="Submit"></td>
      </tr>
    </table>
<?php
}
?>
  </div>
  <br>
</div>
</body>
</html>
