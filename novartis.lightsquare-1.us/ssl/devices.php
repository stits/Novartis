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
<title>Novartis RMD - Configure Devices</title>
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
    <form method="post" name="devices" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <font size=6><i>Devices</i></font>&nbsp; &nbsp;<a href="edit_device.php"><img src="/images/add-device.png"> Add Device</a>
    <br><br>
    <table>
      <tr>
        <td >Location:</td>
        <td>
          <?php print_location_select(); ?>
        </td>
        <td><input type="submit" value="Show Devices" />
      </tr>
    </table>
    <table width="100%"><tr><td><?php print_edit_device_list(); ?></td></tr></table>
    </form>
  </div>
  <br>
</div>
</body>
</html>
