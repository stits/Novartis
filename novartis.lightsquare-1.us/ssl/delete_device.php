<?php
include("includes/php/general.php");
include("includes/php/devices.php");

$remoteip = $_SERVER['REMOTE_ADDR'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/css/default.css" />
<link rel="stylesheet" type="text/css" href="/includes/css/menu_styles.css">
<script type="text/javascript" src="includes/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="includes/js/devices.js"></script>
<title>Novartis RMD - Delete Device</title>
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
<?php delete_device($_GET["deviceid"]); ?>
  </div>
  <br>
</div>
</body>
</html>
