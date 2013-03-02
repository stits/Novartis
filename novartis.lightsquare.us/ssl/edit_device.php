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
<link rel="stylesheet" type="text/css" href="/includes/css/jquery.gritter.css">
<script type="text/javascript" src="includes/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="includes/js/jquery.gritter.min.js"></script>
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
<?php
if($_POST) {
	if($_POST["deviceID"]) {
		$query = sprintf("REPLACE INTO Devices (DeviceID, LocationID, DeviceName, DeviceIP, DeviceType, PhyLocation, " .
				"Description, ConnectionType, Path) VALUES('%d', '%d', '%s', '%s', '%d', '%s', '%s', '%d', '%s')",
				$_POST["deviceID"], $_POST["locationSelect"], $_POST["deviceName"], $_POST["deviceIP"],
				$_POST["deviceTypeSelect"], $_POST["phyLocation"], $_POST["description"], $_POST["connectionTypeSelect"],
				$_POST["path"]);

		mysql_query($query) or
			die("Could not execute query: " . mysql_error());

		# Add logging
	}

	else {
		$query = sprintf("INSERT INTO Devices (DeviceID, LocationID, DeviceName, DeviceIP, DeviceType, PhyLocation, " .
				"Description, ConnectionType, Path) VALUES('%d', '%d', '%s', '%s', '%d', '%s', '%s', '%d', '%s')",
				$_POST["deviceID"], $_POST["locationSelect"], $_POST["deviceName"], $_POST["deviceIP"], $_POST["deviceTypeSelect"],
				$_POST["phyLocation"], $_POST["description"], $_POST["connectionTypeSelect"], $_POST["path"]);

		mysql_query($query) or
			die("Could not execute query: " . mysql_error());

		# Add logging
	}

	print("<input type=\"hidden\" name=\"inputSuccess\" id=\"inputSuccess\" value=\"Y\" />\n");
}

if($_GET["deviceid"] > 1) {
	$query = sprintf("SELECT LocationID, DeviceName, DeviceType, DeviceIP, PhyLocation, " .
			"Description, ConnectionType, Path FROM Devices WHERE DeviceID = '%d'",
			$_GET["deviceid"]);

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	$info = mysql_fetch_array($result);
}
?>
    <form method="post" name="edit_device" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1><?php printf("%s Device", $_GET["deviceid"] ? "Edit" : "Add New"); ?></h1>
    <table>
      <tr>
        <td width="150px">Location:</td>
        <td>
          <?php print_location_select($info["LocationID"]); ?>
        </td>
      </tr>
      <tr>
        <td>Device Name</td>
        <td><input type="text" size=30 name="deviceName" value="<?php if($_GET["deviceid"]) { print($info["DeviceName"]); } ?>"/></td>
      </tr>
      <tr>
        <td>Device Type</td>
        <td><?php print_device_type_select($info["DeviceType"]); ?></td>
      </tr>
      <tr>
        <td>Device IP</td>
        <td><input type="text" size=15 name="deviceIP" id="deviceIP" value="<?php if($_GET["deviceid"]) { print($info["DeviceIP"]); } ?>"/></td>
      </tr>
      <tr>
        <td>Physical Location</td>
        <td><input type="text" size=30 name="phyLocation" id="phyLocation" value="<?php if($_GET["deviceid"]) { print($info["PhyLocation"]); } ?>" /></td>
        <td><font color="gray"><i>Example: IDF closet 6</i></font></td>
      </tr>
      <tr>
        <td>Description</td>
        <td><input type="text" size=30 name="description" id="description" value="<?php if($_GET["deviceid"]) { print($info["Description"]); } ?>"/></td>
      </tr>
      <tr>
        <td>Connection Type</td>
        <td><?php print_connection_type_select($info["ConnectionType"]); ?></td>
      </tr>
      <tr>
        <td>Path</td>
        <td><input type="text" size=30 name="path" id="path" value="<?php if($_GET["deviceid"]) { print($info["Path"]); } ?>" /></td>
      </tr>
      <tr>
        <td><br><input type="submit" value="<?php printf("%s Device", $_GET["deviceid"] ? "Update" : "Create"); ?>" id="updateSubmit" /></td>
      </tr>
    </table>
<?php if($_GET["deviceid"]) { printf("<input type=\"hidden\" name=\"deviceID\" id=\"deviceID\" value=\"%d\" />\n", $_GET["deviceid"]); } ?>
    </form>
  </div>
  <br>
</div>
</body>
</html>
