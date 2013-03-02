<?php

function print_edit_device_list() {
	$search_by = $_POST['searchRadio'];
	$extra_filter = "";

	switch($search_by) {
		case "City":
			$search_value = $_POST["citySelect"];
			break;
		case "State":
			$search_value = $_POST["stateSelect"];
			break;
		default:
			$search_value = $_POST["locationSelect"];
			$search_by = "LocationID";
	}

	$query = sprintf("SELECT Devices.Description, Devices.DeviceIP, Locations.Name, " .
			"Locations.City, Locations.State, Devices.PhyLocation, " .
			"ConnectionTypes.TypeName, Devices.DeviceName, Devices.Path, Devices.DeviceID " .
			"FROM Devices, Locations, ConnectionTypes WHERE Locations.%s = '%s' AND Devices.LocationID = " .
			"Locations.LocationID AND Devices.ConnectionType = ConnectionTypes.TypeID %s" .
			"ORDER BY Locations.City, Locations.State, Locations.Name, Devices.DeviceType",
			$search_by, $search_value, $extra_filter);

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	if(mysql_num_rows($result) > 0) {

		print("<table class=\"userloc\" width=\"100%\">\n" .
			"<tr class=\"tableHeader\">\n" .
			"<td width=30px></td>\n" .
			"<td width=120px>Device Name</td>\n" .
			"<td width=150px>Location Name</td>\n" .
			"<td width=60px>IP</td>\n" .
			"<td width=80px>City</td>\n" .
			"<td width=30px>State</td>\n" .
			"<td width=150px>Physical Location</td>\n" .
			"<td>Description</td>\n" .
			"</tr>\n");

		while($row = mysql_fetch_array($result)) {
			$odd = !$odd;

			switch($row[6]) {
				case "http":
					$icon = "<img src=\"/images/webcam.png\">";
					break;

				case "https":
					$icon = "<img src=\"/images/webcam.png\">";
					break;

				case "rdp":
					$icon = "<img src=\"/images/rdp.png\">";
					break;

				case "smb":
					$icon = "<img src=\"/images/smb.png\">";
					break;

				case "vpn":
					$icon = "<img src=\"/images/vpn.png\">";
					break;

				default:
					$icon = "<img src=\"/images/www.png\">";
			}

			$class = $odd ? "oddTR" : "evenTR";

			printf("<tr valign=\"top\" class=\"%s toggleHidden\" onmouseout=\"this.className='%s'\" onmouseover=\"this.className='rowOver'\">\n",
				$class, $class);

			printf("<td>%s</td>" .
				"<td>%s<br>\n" .
				"<a class=\"hidden-options\" href=\"/edit_device.php?deviceid=%d\">Edit</a> " .
				"<a class=\"hidden-options delete_device\" href=\"/delete_device.php?deviceid=%d\"><font color=\"red\">Delete</font></a>" .
				"</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n" .
				"<td>%s</td>\n",
				$icon,
				$row[7],  # Device Name
				$row[9],  # Device ID
				$row[9],  # Device ID
				$row[2],  # Location Name
				$row[1],  # IP
				$row[3],  # City
				$row[4],  # State
				$row[5],  # Physical Location
				$row[0]); # Description

			print("</tr>\n");
		}
	}
}

function print_device_type_select($deviceid) {
	$query = "SELECT DeviceTypeID, Name FROM DeviceType";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	print("<select id=\"deviceTypeSelect\" name=\"deviceTypeSelect\">\n");
	print("<option></option>\n");

	while($row = mysql_fetch_array($result)) {
		printf("<option value=\"%s\"%s>%s</option>\n", $row[0], $row[0] == $deviceid ? " selected" : "", $row[1]);
	}
}

function print_connection_type_select($deviceid) {
	$query = "SELECT TypeID, TypeName FROM ConnectionTypes";

	$result = mysql_query($query) or
		die("Could not execute query: " . mysql_error());

	print("<select id=\"connectionTypeSelect\" name=\"connectionTypeSelect\">\n");
	print("<option></option>\n");

	while($row = mysql_fetch_array($result)) {
		printf("<option value=\"%s\"%s>%s</option>\n", $row[0], $row[0] == $deviceid ? " selected" : "", $row[1]);
	}
}

function delete_device($deviceid) {
	$query = sprintf("DELETE FROM Devices WHERE DeviceID = '%d' LIMIT 1", $deviceid);

	mysql_query($query) or
		die("Could not execute query: " . mysql_error());

#	Add logging

	print("<h1>Device deleted successfully</h1>\n");
}

?>
