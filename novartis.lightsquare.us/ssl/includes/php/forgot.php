<?php

require_once("Mail.php");

function reset_password($email) {
	$query = sprintf("SELECT UserID, Email, FirstName FROM Users WHERE Email = '%s' LIMIT 1", $user);

	$result = mysql_query($query) or
		die("Could not execure query: " . mysql_error());

	$num = mysql_num_rows($result);

	$row = mysql_fetch_array($result);

	if($num > 0) {
		$newpass = substr(md5(uniqid(rand())), 0, 8);

		$host = "localhost";
		$from = "Novartis Support <support@example.com>";
		$to = sprintf("%s <%s>", $row[2], $row[1]);
		$reply_to = "Novartis Dashboard Admin <support@example.com>";
		$subject = "Novartis Dashboard Password Reset";
		$headers = array('From'     => $from,
				 'To'       => $to,
				 'Reply-To' => $reply_to,
				 'Subject'  => $subject);

		$mesg = sprintf("Your Novartis Dashboard password has been recently reset by someone at '%s'\r\n" .
			"The new details are as follows:\r\n\r\n" .
			"Username: %s\r\n" .
			"Temporary Password: %s\r\n\r\n" .
			"**Note: This temporary password will be valid for only 24 hours.\r\n" .
			"Please log in to: https://novartis.lightsquare.us and navigate to the 'My Account' section " .
			"to change your password.\r\n\r\n" .
			"If you have received this email in error.  Please contact your administrator immediately.\r\n",
			$_SERVER['REMOTE_ADDR'], $user, $newpass);

		$smtp = Mail::factory('smtp', array('host' => $host));

		$mail = $smtp->send($to, $headers, $mesg);

		if(PEAR::isError($mail)) {
			print_error($mail->getMessage());
		}

		$tomorrow = time() + (24*60*60);
		$mysqldate = date('Y-m-d H:i:s', $tomorrow);

		$query = sprintf("UPDATE Users SET TempPassword = ENCRYPT('%s'), TempUntil = '%s' WHERE UserID = '%d'",
				$newpass, $mysqldate, $row[0]);

		mysql_query($query) or
			die("Could not execute query: " . mysql_error());
	}
}

?>
