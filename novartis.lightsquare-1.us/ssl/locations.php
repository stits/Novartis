<?php
include("includes/php/general.php");
include("includes/php/locations.php");

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
<script type="text/javascript" src="includes/js/locations.js"></script>
<title>Novartis RMD - Locations</title>
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
     <font size=6><i>Locations</i></font>&nbsp; &nbsp;<a href="add_location.php"><img src="/images/location.png"> Add Location</a>
    <br>
<?php print_location_rows(); ?>
  </div>
  <br>
</div>
<?php
if($_GET["location_add"]) {
	$name = get_location_by_id($_GET["location_add"]);
	printf("<div class=\"hidden-options\" id=\"gritter\" name=\"gritter\">Location %s was added successfully</div>\n", $name);
}

elseif($_GET["location_edit"]) {
	$name = get_location_by_id($_GET["location_edit"]);
	printf("<div class=\"hidden-options\" id=\"gritter\" name=\"gritter\">Location %s was modified successfully</div>\n", $name);
}
elseif($_GET["location_delete"]) {
	print("<div class=\"hidden-options\" id=\"gritter\" name=\"gritter\">Location was deleted successfully</div>\n");
}
?>
</body>
</html>
