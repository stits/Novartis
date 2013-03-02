<?php

function print_logs_rows() {
	# Need to add in pagination

	connect_db();

	$query = "SELECT Logs.EntryTime, Users.UserName, Logs.UserIP, Logs.Message FROM Users, Logs WHERE " .
		"Users.UserID = Logs.UserID ORDER BY Logs.EntryTime DESC";

        $result = mysql_query($query) or
                die("Could not execute query: " . mysql_error());

        print("<table class=\"userloc\" width=\"100%\">\n" .
                "<tr class=\"tableheader\">\n" .
                "<td width=\"160px\">Entry Time</td>\n" .
                "<td width=\"100px\">Username</td>\n" .
                "<td width=\"120px\">IP Address</td>\n" .
                "<td>Message</td>\n" .
                "</tr>\n");

        while($row = mysql_fetch_row($result)) {
                $odd = !$odd;

                $class = $odd ? "oddTR" : "evenTR";

#                printf("<tr class=\"%s top-align toggleHidden\" onmouseout=\"this.className='%s top-align'\" " .
 #                       "onmouseover=\"this.className='rowOver top-align'\">\n", $class, $class);

		printf("<tr>\n");

		printf("<td>%s</td>\n" .
			"<td>%s</td>\n" .
			"<td>%s</td>\n" .
			"<td>%s</td>\n",
			$row[0], # Entry Time
			$row[1], # Username
			$row[2], # IP Address
			$row[3]); # Log Message

		print("</tr>\n");
	}

	print("</table>\n");
}

?>
