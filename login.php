<?php
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];
  if ($loggedin == "yes") {
	echo "<p class=\"cent\">You are already logged in. ... <a href=\"./?action=logout\">logout</a></p>";
    $loggedinMsgSent = 1;
  }
  else if ($_REQUEST['action'] == "checkLogin") {
    // include configuration file
    include("./configuration.php");
    include($php_function_dir."checkLogin.php");
  }
  else
    echo "
    <table style=\"margin-left:auto; margin-right:auto; width: 280px;\">
      <form name=\"loginFom\" method=\"post\" action=\"./login.php?pid=2&action=checkLogin\">
      <thead>
        <tr><td colspan=2 style=\"text-align:center\"><h3>login</h3></td></tr>
      </thead>
      <tbody>
        <tr><td>Email:</td><td><input type=\"text\" required=reqiured name=\"email\" value=\"".$email."\"></td></tr>
        <tr><td>Password:</td><td><input type=\"password\" required=reqiured name=\"password\" value=\"".$password."\"></td></tr>
        <tr><td>Remember Me:</td><td><input type=\"checkbox\" name=\"remember\" value=\"".$remember."\"></td></tr>
        <tr><td colspan=2 style=\"text-align: right;\"><input type=\"submit\" name=\"checkLogin\" value=\"Login\"></td></tr>
      </tbody>
      </form>
    </table>";
?>