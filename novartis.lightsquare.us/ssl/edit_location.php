<?php
include("includes/php/general.php");
include("includes/php/locations.php");

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
<script type="text/javascript" src="includes/js/locations2.js"></script>

<title>Novartis RMD - Edit Location</title>
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
      <font size=6><i>Edit Location</i></font>
      <?php
	if($_GET["locid"]) {
		$query = sprintf("SELECT Name, Address, City, State, Zip, Notes FROM " .
				"Locations WHERE LocationID = '%d' LIMIT 1", $_GET["locid"]);

		$result = mysql_query($query) or
			die("Could not execute query: " . mysql_error());

		if(mysql_num_rows($result) == 0) {
			log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Invalid location was passed");
			header("location:locations.php");
		}

		$row = mysql_fetch_array($result);
	}

	else if($_POST["name"] && $_POST["city"] && $_POST["stateSelect"] && $_POST["locid"]) {
		edit_location($_POST["locid"]);
	}

	else {
		log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "No LocationID was passed");
		header("location:locations.php");
	}
      ?>
      <br>
      <table width="100%">
        <tr>
          <td width="200px">Location Name <font color="red">*</font></td>
          <td><input id="name" type="text" name="name" size="30" value="<?php print($row[0]); ?>" /></td>
        </tr>
        <tr>
          <td>Address</td>
          <td><input type="text" name="address" size="30" value="<?php print($row[1]); ?>" /></td>
        </tr>
        <tr>
          <td>City <font color="red">*</font></td>
          <td><input id="city" type="text" name="city" size="30" value="<?php print($row[2]); ?>" /></td>
        </tr>
        <tr>
          <td>State <font color="red">*</font></td>
          <td><?php print_states_list_select($row[3]); ?>
        </tr>
        <tr>
          <td>Zip Code</td>
          <td><input type="text" name="zip" size="10" value="<?php print($row[4]); ?>" /></td>
        </tr>
	<tr>
          <td>Notes</td>
          <td><input type="text" name="notes" size="30" value="<?php print($row[5]); ?>" /></td>
        </tr>
      </table>
      <br><br>
      <input id="locationsubmit" type="submit" value="Edit Location" />
      <input type="hidden" name="locid" value="<?php print($_GET["locid"]); ?>" />
    </form>
  </div>
  <br>
</div>
</body>
</html>
