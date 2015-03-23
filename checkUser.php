<?php

  if (isset($_COOKIE[$sitePrefix."l"])) {
	if ($_REQUEST['action'] == "logout") {
		setcookie($sitePrefix."l", "", time()-7200);
		setcookie($sitePrefix."e", "", time()-7200);
		setcookie($sitePrefix."p", "", time()-7200);
		setcookie($sitePrefix."s", "", time()-7200);
		setcookie($sitePrefix."r", "", time()-7200);
		header("Location: ./");
		die();
    }
    if ($_COOKIE[$sitePrefix."l"] == md5("loggedin")) {
      if (isset($_COOKIE[$sitePrefix."e"])) {
        if (!empty($_COOKIE[$sitePrefix."e"])) {
          $email = $_COOKIE[$sitePrefix."e"];
          $query = "SELECT password, securitylevel FROM ".$sitePrefix."users WHERE email='".$email."'";
          $result = mysql_query($query);
          if ($result) {
            if (mysql_num_rows == 0) {
              if (isset($_COOKIE[$sitePrefix."p"])) {
                if (!empty($_COOKIE[$sitePrefix."p"])) {
                  $row = mysql_fetch_array($result);
                  $password = $_COOKIE[$sitePrefix."p"];
                  if ($password == sha1($row['password'])) {
                    if (isset($_COOKIE[$sitePrefix."s"])) {
                      if (!empty($_COOKIE[$sitePrefix."s"])) {
                        $status = $_COOKIE[$sitePrefix."s"];
                        if ($status == $row['securitylevel']) {
						  if (isset($_COOKIE[$sitePrefix."r"])) {
							if (!empty($_COOKIE[$sitePrefix."r"])) {
							  $loggedin = "yes";
							  $userStatus = $status;
							  if ($_COOKIE[$sitePrefix."r"] == 1){ // reset expiration time
								setcookie($sitePrefix."l", md5("loggedin"), time()+60*60*24*30);
								setcookie($sitePrefix."e", $email, time()+60*60*24*30);
								setcookie($sitePrefix."p", sha1(md5($password)), time()+60*60*24*30);
								setcookie($sitePrefix."s", $status, time()+60*60*24*30);
								setcookie($sitePrefix."r", md5($rememberMe), time()+60*60*24*30);
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
                    CookieError("passwrd cookie incorrect");
                }
                else // password cookie empty
                  CookieError("password cookie empty");
              }
              else // password cookie not set
                CookieError("password cookie not set");
            }
            else // email not in database
              CookieError("email not in database");
          }
          else // error while checking database database
            DBErroror("error while checking database database");
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
  if ($loggedin != "yes") {
    $loggedin = "no";
    $userStatus = 0;
	$userType = "";
  }
?>
