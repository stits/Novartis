<?php
$crowd_app_name = 'novartis';
$crowd_app_password = 'be3Anuvafr';
$crowd_url = 'https://hello.lightsquare.us:8443/crowd/services/SecurityServer?wsdl';

require_once('Services/Atlassian/Crowd.php');

$username = NULL;

$crowd = new Services_Atlassian_Crowd(array(
	'app_name' => $crowd_app_name,
	'app_credential' => $crowd_app_password,
	'service_url' => $crowd_url,
));

$crowd->authenticateApplication();

$is_authenticated = FALSE;

if (!empty($_COOKIE['crowd_token_key'])) {
	$is_authenticated = $crowd->isValidPrincipalToken(
		$_COOKIE['crowd_token_key'],
		$_SERVER['HTTP_USER_AGENT'],
		$_SERVER['REMOTE_ADDR']
	);

}

if (!$is_authenticated) {
	if (isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="Crowd Login"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Forbidden.';
		exit;
	}

	try {
		$_COOKIE['crowd_token_key'] = $crowd->authenticatePrincipal(
			"jwoosley@gmail.com",
			"jackw!",
#			$_SERVER['PHP_AUTH_USER'],
#			$_SERVER['PHP_AUTH_PW'],
			$_SERVER['HTTP_USER_AGENT'],
			$_SERVER['REMOTE_ADDR']
		);

		setcookie('crowd_token_key', $_COOKIE['crowd_token_key'], time() + 3600);

		$is_authenticated = TRUE;
	}

	catch (Services_Atlassian_Crowd_Exception $e) {
		if ($e->getMessage() == $_SERVER['PHP_AUTH_USER']) {
		}

		throw $e;
	}
}

if ($is_authenticated) {
	$principal = $crowd->findPrincipalByToken($_COOKIE['crowd_token_key']);
	$username = $principal->name;
}

if (empty($username)) {
	header('HTTP/1.0 401 Unauthorized');
	echo 'Forbidden.';
	exit;
}

echo "Welcome $username, you do have access to this application.";
echo "<pre>";
var_dump($principal);
echo "</pre>";

?>
