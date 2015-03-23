<?php

	//echo "checkuser! --- ";

	if (isset($_COOKIE[Configuration::sitePrefix."l"])) {
		//echo "login cookie! - ";
		if ($_REQUEST['action'] == "logout") {
			setcookie(Configuration::sitePrefix."l", "", time()-7200);
			setcookie(Configuration::sitePrefix."e", "", time()-7200);
			setcookie(Configuration::sitePrefix."p", "", time()-7200);
			setcookie(Configuration::sitePrefix."s", "", time()-7200);
			setcookie(Configuration::sitePrefix."r", "", time()-7200);
			header("Location: ./");
			die();
	    }
		if ($_COOKIE[Configuration::sitePrefix."l"] == md5("loggedin")) {
			if (isset($_COOKIE[Configuration::sitePrefix."e"])) {
				if (!empty($_COOKIE[Configuration::sitePrefix."e"])) {
					$email = $_COOKIE[Configuration::sitePrefix."e"];
					$query = "SELECT password, securitylevel FROM ".Configuration::sitePrefix."users WHERE email='".$email."'";
					$result = Configuration::Query($query);
					if ($result) {
						if (Configuration::GetLink()->affected_rows != 0) {
							if (isset($_COOKIE[Configuration::sitePrefix."p"])) {
								if (!empty($_COOKIE[Configuration::sitePrefix."p"])) {
									$row = $result->fetch_array(MYSQLI_ASSOC);
									$password = $_COOKIE[Configuration::sitePrefix."p"];
									if ($password == sha1($row['password'])) {
										if (isset($_COOKIE[Configuration::sitePrefix."s"])) {
											if (!empty($_COOKIE[Configuration::sitePrefix."s"])) {
												$status = $_COOKIE[Configuration::sitePrefix."s"];
												if ($status == $row['securitylevel']) {
													if (isset($_COOKIE[Configuration::sitePrefix."r"])) {
														if (!empty($_COOKIE[Configuration::sitePrefix."r"])) {
															GLB::SET('loggedin', "yes");
															GLB::SET('userStatus', $status);
															if ($_COOKIE[Configuration::sitePrefix."r"] == md5(1)){ // reset expiration time
																setcookie(Configuration::sitePrefix."l", md5("loggedin"), time()+60*60*24*30);
																setcookie(Configuration::sitePrefix."e", $email, time()+60*60*24*30);
																setcookie(Configuration::sitePrefix."p", $password, time()+60*60*24*30);
																setcookie(Configuration::sitePrefix."s", $status, time()+60*60*24*30);
																setcookie(Configuration::sitePrefix."r", md5($rememberMe), time()+60*60*24*30);
															}
															else { // reset expiration time
																setcookie(Configuration::sitePrefix."l", md5("loggedin"), 0);
																setcookie(Configuration::sitePrefix."e", $email, 0);
																setcookie(Configuration::sitePrefix."p", $password, 0);
																setcookie(Configuration::sitePrefix."s", $status, 0);
																setcookie(Configuration::sitePrefix."r", md5($rememberMe), 0);
															}
														}
														else // rememberMe cookie empty
															CookieError("r cookie empty");
													}
													else // rememberMe cookie not set
														CookieError("r cookie not set");
												}
												else // status cookie data invalid
													CookieError("status cookie data invalid");
											}
											else // status cookie set to 0
												CookieError("Please check your email and click the verifiction link.");
										}
										else // status cookie not set
											CookieError("status cookie not set");
									}
									else // passwrd cookie incorrect
										echo("passwrd cookie incorrect");
								}
								else // password cookie empty
									CookieError("password cookie empty");
							}
							else // password cookie not set
								CookieError("password cookie not set");
						}
						else // email not in database
							echo("email not in database $query");
					}
					else // error while checking database database
						echo("error while checking database database");
				}
				else // login cookie set, but empty
					CookieError("login cookie set, but empty");
			}
			else // email cookie not set
				CookieError("email cookie not set");
		}
		else // login cookie invalid
			CookieError("login cookie invalid");
	}
	else { // login cookie not set
		if (isset($_REQUEST['checkRegister']) || isset($_REQUEST['vcode']))
			include($php_function_dir."checkRegister.php");
	}
	if (GLB::GET('loggedin') != "yes") {
		GLB::SET('loggedin', "no");
		$userStatus = 0;
		$userType = "";
	}

?>
