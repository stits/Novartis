<?php

function print_location_rows() {
	print("<table class=\"userloc height\" width=\"100%\">\n");

	$query = "SELECT Name, Address, City, State, Zip, Notes, LocationID FROM Locations ORDER BY Name";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) == 0) {
		print("<tr><td>No locations listed in database.  Go to \"Configure -> Add/Edit Locations\" " .
			"to add new locations.</td></tr>");
	}
	else {
		print("<tr class=\"tableHeader\">\n" .
			"<td width=\"200px\">Name</td>\n" .
			"<td>Address</td>\n" .
			"<td>City</td>\n" .
			"<td>State</td>\n" .
			"<td>Zip</td>\n" .
			"<td>Notes</td></tr>\n");
			
		while($row = mysql_fetch_array($result)) {
			$odd = !$odd;

			$class = $odd ? "oddTR" : "evenTR";

			printf("<tr class=\"%s top-align toggleHidden\" onmouseout=\"this.className='%s top-align'\" " .
				"onmouseover=\"this.className='rowOver top-align'\">\n", $class, $class);

			printf("<td>\n" .
				"<a href=\"/edit_location.php?locid=%d\">%s</a><br>\n" .
				"<a class=\"hidden-options\" href=\"/edit_location.php?locid=%d\">Edit</a> \n" .
				"<a class=\"hidden-options delete_location\" href=\"/delete_location.php?locid=%d\">" .
				"<font color=\"red\">Delete</font></a>\n" .
				"</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n",
				$row[6],  # LocationID
				$row[0],  # Name
				$row[6],  # LocationID
				$row[6],  # LocationID
				$row[1],  # Address
				$row[2],  # City
				$row[3],  # State
				$row[4],  # Zip
				$row[5]); # Notes
		}
	}

	print("</table>\n");
}

function delete_location($str) {
        if($str == "") {
                print_error("A blank LocationID was passed.  Action logged");
                log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Blank LocationID passed to delete_location.php");
                return(1);
        }

        $query = sprintf("DELETE FROM Locations WHERE LocationID = '%d' LIMIT 1", $str);

        mysql_query($query) or
                die("Could not execute query: " . mysql_error());

	$query = sprintf("DELETE FROM Devices WHERE LocationID = '%d'", $str);

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

        #printf("<font color=\"blue\">Location (%s) was successfully deleted</font>\n", $str);
	header(sprintf("location:locations.php?location_delete=1", $locid));
        log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Location ($str) was deleted");
}

function print_states_list_select($str) {
	$states = array("AL","AK","AZ","AR","CA","CO","CT","DE","FL","GA","HI","ID","IL","IN","IA","KS","KY",
			"LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND",
			"OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA","WV","WI","WY");

	print("<select id=\"stateSelect\" name=\"stateSelect\">\n");

	foreach($states as $state) {
		printf("<option value=\"%s\"%s>%s</option>\n", $state, $str == $state ? " selected" : "", $state);
	}

	print("</select>\n");
}

function edit_location($locid) {
	$varname = array("name", "city", "stateSelect");

	foreach($varnames as $var) {
		if($_POST[$var] == "") {
			print_error("Error: Missing Data");
			log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Attempted to add location with missing $var");
			return(1);
		}
	}

	$query = sprintf("REPLACE INTO Locations(LocationID, Name, Address, City, State, Zip, Notes) " .
			"VALUES('%d', '%s', '%s', '%s', '%s', '%s', '%s')",
			$locid,
			$_POST["name"],
			$_POST["address"],
			$_POST["city"],
			$_POST["stateSelect"],
			$_POST["zip"],
			$_POST["notes"]);

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Edited Location $locid");
	header(sprintf("location:locations.php?location_edit=%d", $locid));
}


function add_location() {
	$varname = array("name", "city", "stateSelect");

	foreach($varnames as $var) {
		if($_POST[$var] == "") {
			print_error("Error: Missing Data");
			log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Attempted to add location with missing $var");
			return(1);
		}
	}

	$query = sprintf("SELECT Name FROM Locations WHERE Name = '%s' LIMIT 1", $_POST["name"]);

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) > 0) {
		print_error("That location name is already in use");
		return(1);
	}

	$query = sprintf("INSERT INTO Locations(Name, Address, City, State, Zip, Notes) " .
			"VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
			$_POST["name"],
			$_POST["address"],
			$_POST["city"],
			$_POST["stateSelect"],
			$_POST["zip"],
			$_POST["notes"]);

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	$locid = mysql_insert_id();

	log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Added a new location ($locid)");
	header(sprintf("location:locations.php?location_add=%d", $locid));
#	printf("<font color=\"blue\">Location %s was added successfully</font>\n", $_POST["name"]);
}

function get_location_by_id($id) {
	$query = sprintf("SELECT Name FROM Locations WHERE LocationID = '%d' LIMIT 1", $id);

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	$row = mysql_fetch_array($result);

	return($row[0]);
}
?>
