<?php
	require_once "configuration.php";
	require_once "sef.php";
	Configuration::Connect();

	if (mysqli_connect_errno()) {
		echo "Unable to connect to the database. Error: ".mysqli_connect_error();
		die();
	}

	if (isset($_REQUEST['error'])) {
		$errNo = $_REQUEST['errNo'];
		$errMsg = $_REQUEST['errMsg'];
		$errorMsg = "Error #".$errNo." - Error Message: ".$errMsg;
		$specialMsg .= $errorMsg;
	}

	// check user credentials (in cookies)
	if (!isset($_REQUEST['error']))
		require_once "checkUser.php";

	// determine what content was requested
	if (!isset($_REQUEST['error'])) {
		switch ($SEFdata[2]) {
			case "post":$SEFdata[2] .= "/".$SEFdata[3]."/".$SEFdata[4]."/".$SEFdata[5]."/".$SEFdata[6];
						Configuration::$content = new Post($SEFdata[2]);
						Configuration::$contentType = "post";
						break;
			case "mod": $contentType = "module";
						break;
			default: 	Configuration::$content = new AdminPage($SEFdata[2]);
						Configuration::$contentType = "page";
		}
	}
	else {
        Configuration::$content = new AdminPage(0);
		Configuration::$contentType = "page";
	}

	if (isset($_REQUEST['specialMsg']))
		Configuration::$specialMsg .= $_REQUEST['specialMsg']."<br><br>";
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="application/javascript"></script>
	<?php
	include Configuration::php_function_dir."bbcode.php";
	replaceBBcode(Configuration::$content);
	Configuration::SetTpl();
	if (Configuration::$tpl->Error())
	    echo Configuration::$tpl->Error();
	else
		Configuration::$tpl->UseTpl();
	//print_r(Configuration::$content);

	Configuration::GetLink()->close();
?>