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

<title>Novartis RMD - Add Location</title>
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
      <font size=6><i>Add New Location</i></font>
      <?php if($_POST["name"] && $_POST["city"] && $_POST["stateSelect"]) {
           add_location();
         }
      ?>
      <br>
      <table width="100%">
        <tr>
          <td width="200px">Location Name <font color="red">*</font></td>
          <td><input id="name" type="text" name="name" size="30" /></td>
        </tr>
        <tr>
          <td>Address</td>
          <td><input type="text" name="address" size="30" /></td>
        </tr>
        <tr>
          <td>City <font color="red">*</font></td>
          <td><input type="text" id="city" name="city" size="30" /></td>
        </tr>
        <tr>
          <td>State <font color="red">*</font></td>
          <td><?php print_states_list_select(); ?>
        </tr>
        <tr>
          <td>Zip Code</td>
          <td><input type="text" name="zip" size="10" /></td>
        </tr>
	<tr>
          <td>Notes</td>
          <td><input type="text" name="notes" size="30" /></td>
        </tr>
      </table>
      <br><br>
      <input id="locationsubmit" type="submit" value="Add Location" />
    </form>
  </div>
  <br>
</div>
</body>
</html>
