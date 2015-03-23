<?php
  if (isset($_REQUEST['checkEditInfo'])) {
	include("./configuration.php");
	$link = mysql_connect($db_address, $db_username, $db_password);
	if (!$link) {
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db_name);
	include($php_function_dir."userCP.php");
  }
?>