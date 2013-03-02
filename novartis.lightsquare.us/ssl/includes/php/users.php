<?php

function print_user_rows() {
	$query = "SELECT Users.Username, Users.FirstName, Users.LastName, Users.Email, " .
		"Users.Disabled, Groups.GroupName, Users.UserID FROM Users, Groups WHERE " .
		"Users.GroupID = Groups.GroupID ORDER BY Users.Username";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) == 0) {
		# add code to display no users in database
	}

	print("<table class=\"userloc\" width=\"100%\">\n" .
		"<tr class=\"tableheader\">\n" .
		"<td width=\"30px\"></td>\n" .
		"<td>Username</td>\n" .
		"<td>Name</td>\n" .
		"<td>Email</td>\n" .
		"<td>Role</td>\n" .
		"</tr>\n");

	while($row = mysql_fetch_row($result)) {
		$odd = !$odd;

		$class = $odd ? "oddTR" : "evenTR";

		printf("<tr class=\"%s top-align toggleHidden\" onmouseout=\"this.className='%s top-align'\" " .
			"onmouseover=\"this.className='rowOver top-align'\">\n", $class, $class);

		printf("<td><img src=\"/images/user.png\"></td>\n" .
			"<td>\n" .
			"<a href=\"/edit_user.php?userid=%s\">%s</a><br>\n" .
			"<a class=\"hidden-options\" href=\"/edit_user.php?userid=%s\">Edit</a> \n" .
			"<a class=\"hidden-options delete_user\" href=\"/delete_user.php?userid=%s\"><font color=\"red\">Delete</font></a>\n" .
			"</td>\n" .
			"<td>%s %s</td>\n" .
			"<td>%s</td>\n" .
			"<td>%s</td>\n" .
			"</tr>\n",
			$row[6],          # UserID
			$row[0],          # Username
			$row[6],          # UserID
			$row[6],          # UserID
			$row[1], $row[2], # First and last name
			$row[3],          # Email
			$row[5]);         # Role
	}

	print("</table>\n");
}

function print_role_select($current_role) {
	$query = "SELECT GroupName, GroupID FROM Groups";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	print("<select name=\"role\">\n");

	while($row = mysql_fetch_row($result)) {
		printf("<option value=\"%d\" %s>%s</option>\n", $row[1],
			$row[1] == $current_role ? "selected" : "", $row[0]);
	}

	print("</select>\n");
}

function edit_user($username) {
	$varnames = array("username", "email", "role");

	foreach($varnames as $var) {
		if($_POST[$var] == "") {
			print_error("Error: Missing Data");
			log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Attempted to add a user with missing $var");
			return(1);
		}
	}

	if($_POST["password"]) {
		$query = sprintf("UPDATE Users SET GroupID = '%d', Password = ENCRYPT('%s'), FirstName = '%s', LastName = '%s', " .
				"Email = '%s' WHERE Username = '%s'",
				$_POST["role"],
				$_POST["password"],
				$_POST["firstname"],
				$_POST["lastname"],
				$_POST["email"],
				$_POST["username"]);
	}
	else {
		$query = sprintf("UPDATE Users SET GroupID = '%d', FirstName = '%s', LastName = '%s', " .
				"Email = '%s' WHERE Username = '%s'",
				$_POST["role"],
				$_POST["firstname"],
				$_POST["lastname"],
				$_POST["email"],
				$_POST["username"]);
	}


	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	printf("<div class=\"hidden-options\" id=\"gritter\" name=\"gritter\">%s was modified successfully</div>\n", $_POST["username"]);
	log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], sprintf("Edited username %s", $_POST["username"]));
	return(0);
}

function add_user() {
	$varnames = array("username", "email", "password", "role");

	foreach($varnames as $var) {
		if($_POST[$var] == "") {
			print_error("Error: Missing Data");
			log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Attempted to add a user with missing $var");
			return(1);
		}
	}

	$query = sprintf("SELECT Username FROM Users WHERE Username = '%s' LIMIT 1", $_POST["username"]);

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) > 0) {
		print_error("That Username is already in use");
		return(1);
	}

	$query = sprintf("INSERT INTO Users(GroupID, Username, Password, FirstName, LastName, Email) " .
			"VALUES('%d', '%s', ENCRYPT('%s'), '%s', '%s', '%s')",
			$_POST["role"],
			$_POST["username"],
			$_POST["password"],
			$_POST["firstname"],
			$_POST["lastname"],
			$_POST["email"]);

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	printf("<div class=\"hidden-options\" id=\"gritter\" name=\"gritter\">%s was added successfully</div>\n", $_POST["username"]);
	log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Added user " . $_POST["username"]);

	return(0);
}

function delete_user($str) {
	if($str == $_SESSION['userinfo'][1]) {
		print_error("You cannot delete your own account!");
		return(1);
	}

	$query = sprintf("SELECT Username FROM Users WHERE UserID = '%d' LIMIT 1", $str);
	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) == 0) {
		log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], "Tried to delete non-existant UserID ($str)");
		return(1);
	}

	$row = mysql_fetch_array($result);

	$query = sprintf("DELETE FROM Users WHERE userid = '%s' LIMIT 1", $str);

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	printf("<font color=\"blue\">%s was successfully deleted</font>\n", $row[0]);
	printf("<div class=\"hidden-options\" id=\"gritter\" name=\"gritter\">%s was deleted successfully</div>\n", $row[0]);
	log_action($_SESSION['userinfo'][1], $_SERVER['REMOTE_ADDR'], sprintf("User account %s (%d) was deleted", $row[0], $str));
	return(0);
}

?>
