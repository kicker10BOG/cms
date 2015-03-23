<?php
	if ($loggedin == "yes") {
		echo "test3";
		if ($loggedinMsgSent != 1)
			echo "<p class=\"cent\">You are already logged in. ... <a href=\"./?action=logout\">logout</a></p>";
		}
	else if ($pid == 1 && (isset($_REQUEST['checkRegister']) || isset($_REQUEST['vcode'])))   {
		echo "test1";
		include("./includes/functions/php/checkRegister.php");
	}
	else {
		$passwordValue = "";
		$passwordVValue = "";
		$emailValue = "";
		$nameValue = "";

		include("./includes/functions/php/register.php");
	}
?>