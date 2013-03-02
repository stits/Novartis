<?php
include("includes/php/access.php");
include("includes/php/general.php");
include("includes/php/search.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/css/default.css" />
<link rel="stylesheet" type="text/css" href="/includes/css/menu_styles.css">
<link rel="stylesheet" type="text/css" href="/includes/css/jquery.gritter.css">
<script type="text/javascript" src="includes/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="includes/js/jquery.zclip.min.js"></script>
<script type="text/javascript" src="includes/js/jquery.gritter.min.js"></script>
<script type="text/javascript" src="includes/js/search.js"></script>
<title>Novartis RMD - Search</title>
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
    <form method="post" name="search" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="blockbody formcontrols">
      <h3 class="blocksubhead">Search Options</h3>
      <div class="section">
	<div class="blockrow">
	  <label>Search By:</label>
	  <table>
	    <tr>
	      <td>
		<table>
		  <tr>
		    <td><input type="radio" id="searchRadioCity" name="searchRadio" value="City" checked /></td>
		    <td>City</td>
		    <td><?php print_city_select(); ?></td>
		  </tr>
		  <tr>
		    <td><input type="radio" id="searchRadioState" name="searchRadio" value="State" /></td>
		    <td>State</td>
		    <td><?php print_state_select(); ?></td>
		  </tr>
                  <tr>
                    <td><input type="radio" id="searchRadioLocation" name="searchRadio" value="LocationID" / ></td>
                    <td>Location</td>
                    <td><?php print_location_select(); ?></td>
                  </tr>
		</table>
	      </td>
	      <td>
		<table>
		  <tr>
		    <td><?php print_computers_checkbox(); ?></td>
		    <td>Computers</td>
		  </tr>
		  <tr>
		    <td><?php print_webcam_checkbox(); ?></td>
		    <td>Cameras</td>
		  </tr>
		</table>
	      </td>
	    </tr>
	      </td>
	    </tr>
	  </table>
	</div>
      </div>
      <div class="blockfoot actionbuttons">
	<div class="group">
	  <input class="button" type="submit" value="Search Now" name="dosearch">
	</div>
      </div>
    </div>
    </form>
  </div>
  <br>
    <div class="blockbody formcontrols">
<?php
  if($_POST['searchRadio']) {
	print_device_list();
  }
?>
  </div>
</body>
</html>
