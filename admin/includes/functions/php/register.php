<?php
if ($loggedIn)
  echo "<p class=\"cent\">You already logged in.</p>";
else
  echo "
  <table style=\"margin-left:auto; margin-right:auto; width:280px\">
    <form method=\"post\" action=\"./index.php?pid=2&checkRegister=true\" name=\"registerForm\">
    <thead>
      <tr><td colspan=2 style=\"text-align:center\"><h3>Register</h3></td></tr>
    </thead>
    <tbody>
      <tr><td>E-mail:</td><td>
          <input name=\"email\" type=\"text\" value=\"".$emailValue."\"></td>
      </tr>
      <tr><td>Full Name:</td><td>
          <input name=\"fullName\" type=\"text\" value=\"".$nameValue."\"></td>
      </tr>
      <tr><td>Password:</td><td>
          <input name=\"password\" type=\"password\" value=\"".$passwordValue."\"></td>
      </tr>
      <tr><td>Verify Password:</td><td>
          <input name=\"passwordV\" type=\"password\" value=\"".$passwordVValue."\"></td>
      </tr>
      <tr>
        <td colspan=2 style=\"text-align: right;\">
          <input type=\"submit\" name=\"checkRegister\" value=\"Register\"></td>
      </tr>
      <tr>
        <td colspan=2 style=\"text-align: center;\">All fields required.
          <br>Passwords must be at least 7 characters long.
          </p></td>
      </tr>
    </tbody>
    </form>
  </table>";
?>