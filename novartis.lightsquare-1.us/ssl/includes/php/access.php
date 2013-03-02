<?php
session_set_cookie_params(28800);
session_start();

if(!$_SESSION['userinfo'][1]) {
	header("location:login.php");
}

?>
