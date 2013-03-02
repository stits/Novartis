<?php

include("includes/php/general.php");

if($_GET['id']) {
	$query = sprintf("SELECT DeviceIP, Description, Path FROM Devices WHERE DeviceID = '%s' LIMIT 1", $_GET['id']);
	$result = mysql_query($query) or
		die("Error: " . mysql_error());

	$row = mysql_fetch_array($result);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="includes/css/default.css" />
    <title>Novartis RMD - <?php print($row[1]); ?></title>
  </head>
  <body>
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
        <center>
        <iframe src="http://<?php printf("24.120.213.203:500/%s/", $row[2]); ?>" width="800" height="600" frameborder=0>
          <p>Your browser does not support iframes.</p>
        </iframe>
        </center>
      </div>
    </div>
  </body>
</html>
