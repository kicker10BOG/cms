<?php
if ($loggedin == "yes")
  if (!isset($loggedinMsgSent))
    echo "<p class=\"cent\">You are already logged in. ... <a href=\"../?action=logout\">logout</a></p>";
else if ($_REQUEST['action'] == "checkLogin") {
  // include configuration file
  include("./configuration.php");
  include($php_function_dir."checkLogin.php");
}
else
  echo "
  <table style=\"margin-left:auto; margin-right:auto; width: 280px;\">
    <form name=\"loginFom\" method=\"post\" action=\"/login.php?action=checkLogin\">
    <thead>
      <tr><td colspan=2 style=\"text-align:center\"><h3>login</h3></td></tr>
    </thead>
    <tbody>
      <tr><td>Email:</td><td><input type=\"text\" name=\"email\" value=\"".$email."\"></td></tr>
      <tr><td>Password:</td><td><input type=\"password\" name=\"password\" value=\"".$password."\"></td></tr>
      <tr><td>Remember Me:</td><td><input type=\"checkbox\" name=\"remember\" value=\"".$remember."\"></td></tr>
      <tr><td colspan=2 style=\"text-align: right;\"><input type=\"submit\" name=\"checkLogin\" value=\"Login\"></td></tr>
    </tbody>
    </form>
  </table>";
?>