<?php
session_start();
connect_db();
sanatize_variables();

function connect_db() {
	@mysql_connect('localhost', 'projx_user', 'ThasPEpuFreva7pu') or
		die("Could not open connection to the ProjectX database");

	mysql_select_db("ProjectX");
}

function sanatize($string) {
	$string = strip_tags($string, '<b><br>');
	$string = mysql_real_escape_string($string);

	return($string);
}

function sanatize_variables() {
	foreach($_GET as $key => $var) {
		$_GET[$key] = sanatize($var);
	}

	foreach($_POST as $key => $var) {
		$_POST[$key] = sanatize($var);
	}
}

function log_action($uid, $clientip, $desc) {
	$query = "INSERT INTO Logs VALUES(NULL, $uid, NOW(), '$clientip', '$desc')";

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());
}

function print_error($str) {
	printf("<font color=\"red\">%s</font>", $str);
}

function print_menu_list() {
	connect_db();

	$query = sprintf("SELECT GroupID FROM Users WHERE UserID = '%d' LIMIT 1", $_SESSION['userinfo'][1]);
	$result = mysql_query($query) or
		die("ERROR: " . mysql_error());

	$row = mysql_fetch_array($result);
?>
<div id='cssmenu'>
<ul>
   <li><a href='index.php'><span>Search</span></a></li>
<?php if($row[0] == 1) {
?>
   <li class='has-sub '><a href='#'><span>Configure</span></a>
      <ul>
         <li><a href='devices.php'><span>Devices</span></a></li>
         <li><a href='locations.php'><span>Locations</span></a></li>
      </ul>
   </li>
   <li class='has-sub '><a href='#'><span>Admin</span></a>
      <ul>
         <li><a href='users.php'><span>Users</span></a></li>
         <?php # <li><a href='roles.php'><span>Roles</span></a></li> ?>
         <li><a href='logs.php'><span>Logs</span></a></li>
      </ul>
   </li>
<?php }
?>
   <li><a href='account.php'><span>My Account</span></a></li>
   <li><a href='logout.php'><span>Logout</span></a></li>
</ul>
</div>
<?php
}

function print_city_select() {
	$query = "SELECT City FROM Locations GROUP BY City";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	print("<select id=\"citySelect\" name=\"citySelect\">\n");
	print("<option></option>\n");

	while($row = mysql_fetch_array($result)) {
		printf("<option value=\"%s\"%s>%s</option>\n", $row[0],
			$_POST["citySelect"] == $row[0] ? " selected" : "", $row[0]);
	}

	print("</select>\n");
}

function print_state_select() {
	$query = "SELECT State FROM Locations GROUP BY State";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	print("<select id=\"stateSelect\" name=\"stateSelect\">\n");
	print("<option></option>\n");

	while($row = mysql_fetch_array($result)) {
		printf("<option value=\"%s\"%s>%s</option>\n", $row[0],
			$_POST["stateSelect"] == $row[0] ? " selected" : "", $row[0]);
	}

	print("</select>\n");
}

function print_location_select($locid) {
	$query = "SELECT Name, LocationID FROM Locations ORDER BY Name";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	print("<select id=\"locationSelect\" name=\"locationSelect\">\n");
	print("<option></option>\n");

	while($row = mysql_fetch_array($result)) {
		printf("<option value=\"%s\"%s>%s</option>\n", $row[1],
			$_POST["locationSelect"] == $row[1] || $locid == $row[1] ? " selected" : "", $row[0]);
	}

	print("</select>\n");
}

function print_computers_checkbox() {
	printf("<input type=\"checkbox\" id=\"computersCheck\" name=\"computerCheck\" value=\"Y\"%s />\n",
		(count($_POST) && !isset($_POST["computerCheck"])) ? "" : " checked");
}

function print_webcam_checkbox() {
	printf("<input type=\"checkbox\" id=\"webcamCheck\" name=\"webcamCheck\" value=\"Y\"%s />\n",
		(count($_POST) && !isset($_POST["webcamCheck"])) ? "" : " checked");
}

?>
