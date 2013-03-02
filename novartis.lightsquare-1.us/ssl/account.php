<?php
include("includes/php/general.php");
include("includes/php/reset.php");

$remoteip = $_SERVER['REMOTE_ADDR'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/css/default.css" />
<link rel="stylesheet" type="text/css" href="/includes/css/menu_styles.css">
<title>Novartis RMD - My Account</title>
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
  <?php print_menu_list(); ?>
  <div id="content">
    <form method="post" name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php

if($_POST['rpassword']) {
	$result = reset_password(2);
}
if($result == TRUE) {
	print("Password changed successfully<br>\n");
	session_destroy();

}
else {
?>
      <h3>Change Password</h3>
      <table>
        <tr>
          <td>
            <table cellspacing="4" cellpadding="0">
              <tr>
                <td>Current / Temporary Password:</td>
                <td><input type="password" id="opassword" name="opassword" maxlength=20 /></td>
              </tr>
              <tr>
                <td>New Password:</td>
                <td><input type="password" id="rpassword" name="rpassword" maxlength=20 /></td>
              </tr>
              <tr>
                <td>Confirm Password:</td>
                <td><input type="password" id="passconfirm" name="passconfirm" maxlength=20 /></td>
              </tr>
            </table>
          </td>
          <td class="error"></td>
        </tr>
      </table>
      <br>
      <input type="submit" value="Submit" id="submit" name="submit" />
<?php
}
?>
  </div>
  <br>
</div>
</body>
</html>
