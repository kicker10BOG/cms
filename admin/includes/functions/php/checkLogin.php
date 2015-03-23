<?php

	//echo "hi";
	require_once "configuration.php";
	// connect to database
	Configuration::Connect();

	// set email and password variables from form
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];

	// Cookie info
	$loginCookiePath = $cookiePath;
	$loginCookieURL = $cookieURL;

	if (!isset($_COOKIE[Configuration::sitePrefix."l"]) || !isset($_COOKIE[Configuration::sitePrefix."e"]) || !isset($_COOKIE[Configuration::sitePrefix."p"])) {
	    //echo " - hello -";
		if ($_REQUEST['action'] == "checkLogin") {
			$query = "SELECT name, password, securitylevel FROM ".Configuration::sitePrefix."users WHERE email='".$email."'";
			$result = Configuration::Query($query);
			if (!$result) {
				DBError(Configuration::GetLink()->error);
			}
			else {
				if (Configuration::GetLink()->affected_rows == 0) {
					$errMsg = "The email you tried to login with is not in our databse. Please Register or login with another email.";
					LoginError($errMsg);
				}
				else {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					if (md5($password) != $row['password']) {
						$errMsg = "Incorrect password. Try again.";
						LoginError($errMsg, $email);
					}
					else { // create appropriate cookies
					    //echo "cookies!";
						if (isset($_REQUEST['remember']))
							$rememberMe = 1;
						else
							$rememberMe = -1;
						$status = $row['securitylevel']; // member status
						if ($rememberMe == 1) { // last a month
							setcookie(Configuration::sitePrefix."l", md5("loggedin"), time()+60*60*24*30);
							setcookie(Configuration::sitePrefix."e", $email, time()+60*60*24*30);
							setcookie(Configuration::sitePrefix."p", sha1(md5($password)), time()+60*60*24*30);
							setcookie(Configuration::sitePrefix."s", $status, time()+60*60*24*30);
							setcookie(Configuration::sitePrefix."r", md5($rememberMe), time()+60*60*24*30);
						}
						else { // delete cookies at end of session
							setcookie(Configuration::sitePrefix."l", md5("loggedin"), 0);
							setcookie(Configuration::sitePrefix."e", $email, 0);
							setcookie(Configuration::sitePrefix."p", sha1(md5($password)), 0);
							setcookie(Configuration::sitePrefix."s", $status, 0);
							setcookie(Configuration::sitePrefix."r", $rememberMe, 0);
						}
						$specialMsg = "You are now logged in as ".$row['name'];
						header("Location: ".Configuration::home_dir."control-panel/?specialMsg=$specialMsg");
						die();
					}
				}
			}
		}
	}

?>