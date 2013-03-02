<?php
include("includes/php/general.php");

$user = $_POST['username'];
$pass = $_POST['password'];
$remoteip = $_SERVER['REMOTE_ADDR'];
$max_attempts = 20;

if($user) {
	$query = sprintf("SELECT Password, UserID, GroupID, Attempts, Disabled, TempPassword, UNIX_TIMESTAMP(TempUntil) " .
			"FROM Users WHERE UserName = '%s'", $user);

	$result = mysql_query($query) or
		 die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) == 0) {
		$login_error = 1;
		log_action(0, $remoteip, "Invalid User: $user");
	}

	$row = mysql_fetch_array($result);

	if($row[4] == 'Y' && !$login_error) {
		$login_error = 2;
		log_action(0, $remoteip, "Disabled account login attempt: $user");
	}

	$curtime = time();


	if((crypt($_POST['password'], $row[0]) != $row[0]) && !((crypt($_POST['password'], $row[5]) == $row[5]) && ($curtime < $row[6]))) {
		if($row[3] >= $max_attempts) {
			$query = sprintf("UPDATE Users SET Disabled = 'Y' WHERE UserID = '%d'", $row[1]);

			 mysql_query($query) or
				die("Could not execute query: " . mysql_error());
		}

		$query = sprintf("UPDATE Users SET Attempts = '%d' WHERE UserID = '%d'", ($row[3] + 1), $row[1]);

		mysql_query($query) or
			die("Could not execute query: " . mysql_error());

		if(!$login_error) {
			log_action(0, $remoteip, "Invalid Password for user: $user");
			$login_error = 1;
		}
	}

	else {
		if(crypt($_POST['password'], $row[5]) == $row[5]) {
			$_SESSION['UsingTmpPW'] = 1;
			log_action($row[1], $remoteip, "$user logged in using temporary password");
		}

		if($row[3] > 0) {
			$query = sprintf("UPDATE Users SET Attempts = '0' WHERE UserID = '%d'",  $row[1]);

			mysql_query($query) or
				die("Could not execute query: " . mysql_error());
		}

		if(!$login_error) {
			# array(Username, UserID, GroupID)
			$_SESSION['userinfo'] = array($user, $row[1], $row[2]);

			header("location:index.php");
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes/css/default.css" />
<title>Novartis RMD - Login</title>
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
  <ul class="topnav">
    <?php #print_menu_list(); ?>
  </ul>
  <div id="content">
    <form method="post" name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table class="content_table">
      <tr>
	<td class="auth-hdr">Please Login</td>
      </tr>
      <tr>
	<td>&nbsp;</td>
      </tr>
      <tr>
	<td>Username:</td>
	<td><input type="text" name="username" size="12"></td>
<?php
	if($login_error > 0) {
		switch($login_error) {
			case 1:
				$error_mesg = "Login Invalid";
				break;
			case 2:
				$error_mesg = "Your account has been disabled";
				break;
		}
		printf("<td class=\"error\">%s</td>\n", $error_mesg);
	}
?>
      </tr>
      <tr>
	<td>Password:</td>
	<td><input type="password" name="password" size="12"></td>
	<td><a href="reset_password.php">Forgot your password?</a></td>
      </tr>
      <tr>
	<td><input type="submit" value="Submit"><BR></td>
      </tr>
    </table>
  </div>
</body>
</html>
