<?php

// connect to database
$link = mysql_connect($db_address, $db_username, $db_password);
if (!$link) {
  die('Could not connect: ' . mysql_error());
}
mysql_select_db($db_name);

// set email and password variables from form
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

// Cookie info
$loginCookiePath = $cookiePath;
$loginCookieURL = $cookieURL;

if (!isset($_COOKIE[$sitePrefix."l"]) || !isset($_COOKIE[$sitePrefix."e"]) || !isset($_COOKIE[$sitePrefix."p"])) {
  if ($_REQUEST['action'] == "checkLogin") {
    $query = "SELECT name, password, securitylevel FROM ".$sitePrefix."users WHERE email='".$email."'";
    $result = mysql_query($query);
    if (!$result) {
      DBError(mysql_error());
    }
    else {
      if (mysql_num_rows($result) == 0) {
        $errMsg = "The email you tried to login with is not in our databse. Please Register or login with another email.";
        LoginError($errMsg);
      }
      else {
        $row = mysql_fetch_array($result);
        if (md5($password) != $row['password']) {
          $errMsg = "Incorrect password. Try again.";
          LoginError($errMsg, $email);
        }
        else { // create appropriate cookies
          if (isset($_REQUEST['remember']))
            $rememberMe = 1;
          else
            $rememberMe = -1;
          $status = $row['securitylevel']; // member status
          if ($rememberMe == 1) { // last a month
            setcookie($sitePrefix."l", md5("loggedin"), time()+60*60*24*30);
            setcookie($sitePrefix."e", $email, time()+60*60*24*30);
            setcookie($sitePrefix."p", sha1(md5($password)), time()+60*60*24*30);
            setcookie($sitePrefix."s", $status, time()+60*60*24*30);
            setcookie($sitePrefix."r", md5($rememberMe), time()+60*60*24*30);
          }
          else { // delete cookies at end of session
            setcookie($sitePrefix."l", md5("loggedin"), 0);
            setcookie($sitePrefix."e", $email, 0);
            setcookie($sitePrefix."p", sha1(md5($password)), 0);
            setcookie($sitePrefix."s", $status, 0);
            setcookie($sitePrefix."r", $rememberMe, 0);
          }
          $specialMsg = "You are now logged in as ".$row['name'];
          header("Location: index.php?specialMsg=$specialMsg");
          die();
        }
      }
    }
  }
}
?>