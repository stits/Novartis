<?php

function reset_password() {
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $oldpw = $_POST['opassword'];

        if($_POST['opassword'] == "" || $_POST['rpassword'] == "") {
                print_error("Missing password");
                log_action($_SESSION['userinfo'][1], $remoteip, "Password was missing for reset");
                return(FALSE);
        }

        $query = sprintf("SELECT Password, TempPassword, Attempts FROM Users WHERE UserID = '%d'",
                $_SESSION['userinfo'][1]);

        $result = mysql_query($query) or
                die("Could not execute query: " . mysql_error());

        $row = mysql_fetch_array($result);

        if($row[2] >= 10) {
                print_error("Too password many failures.  Your account has been disabled");
                log_action($_SESSION['userinfo'][1], $remoteip, "Too password many failures.  Account disabled");
                session_destroy();
                return(FALSE);
        }

        if((crypt($oldpw, $row[0]) != $row[0]) && (crypt($oldpw, $row[1]) != $row[1])) {
                print_error("Invalid current / temporary password");
                log_action($_SESSION['userinfo'][1], $remoteip,
                        "Failed password change.  Invalid current / temp password");

                $query = sprintf("UPDATE Users SET Attempts = '%d' WHERE UserID = '%d'",
                        ($row[2] + 1), $_SESSION['userinfo'][1]);

                mysql_query($query) or
                        die("Could not execute query: " . mysql_error());

                if($row[2] + 1 >= 20) {
                        log_action($_SESSION['userinfo'][1], $remoteip, "Account disabled");
                        $query = sprintf("UPDATE Users SET Disabled = 'Y' WHERE UserID = '%d'",
                                $_SESSION['userinfo'][1]);

                        mysql_query($query) or
                                die("Could not execute query: " . mysql_error());
                }

                return(FALSE);
        }

        $query = sprintf("UPDATE Users SET Password = ENCRYPT('%s'), TempPassword = '', " .
                "TempUntil = '0000-00-00 00:00:00', Attempts = '0' WHERE UserID = '%d'",
                $_POST['rpassword'], $_SESSION['userinfo'][1]);

        mysql_query($query) or
                die("Could not execute query: " . mysql_error());

        log_action($_SESSION['userinfo'][1], $remoteip, "Changed password");

        return(TRUE);
}

?>
