<?php
  $query = sprintf("SELECT * FROM ".$sitePrefix."users WHERE email='%s'", $_COOKIE[manbizdire]);
  $result = mysql_query($query);
  $row = '';
  if ($result) {
	$row = mysql_fetch_assoc($result);
  }
  $passwordValue = '';
  $passwordVValue = '';
  $emailValue = $row['email'];
  $nameValue = $row['name'];
  if (isset($_REQUEST['checkEditInfo'])) {
	include($php_function_dir."checkEdit.php");
  }
  echo "
  <table style=\"margin-left:auto; margin-right:auto; width:280px\">
    <form method=\"post\" action=\"./userCP.php?action=checkEdit\" name=\"editInfoForm\">
    <thead>
      <tr><td colspan=2 style=\"text-align:center\"><h3>Edit User Info</h3></td></tr>
    </thead>
    <tbody>
      <tr><td>E-mail:</td><td>
          <input name=\"email\" required=reqiured type=\"text\" value=\"".$emailValue."\"></td>
      </tr>
      <tr><td>Full Name (or Business):</td><td>
          <input name=\"fullName\" type=\"text\" required=reqiured value=\"".$nameValue."\"></td>
      </tr>
      <tr><td>Password:</td><td>
          <input name=\"password\" type=\"password\" value=\"".$passwordValue."\"></td>
      </tr>
      <tr><td>Verify Password:</td><td>
          <input name=\"passwordV\" type=\"password\" value=\"".$passwordVValue."\"></td>
      </tr>
      <tr>
        <td colspan=2 style=\"text-align: right;\">
          <input type=\"submit\" name=\"checkEditInfo\" value=\"Submit\"></td>
      </tr>
    </tbody>
    </form>
  </table>";
?>