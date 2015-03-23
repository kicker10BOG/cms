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
		$specialMsg = $errorMsg;
	}

	// check user credentials (in cookies)
	if (!(isset($_REQUEST['error'])))
		include("./checkUser.php");

	// determine what content was requested
	switch ($SEFdata[1]) {
		case "post":$SEFdata[1] .= "/".$SEFdata[2]."/".$SEFdata[3]."/".$SEFdata[4]."/".$SEFdata[5];
					Configuration::$content = new Post($SEFdata[1]);
					Configuration::$contentType = "post";
					break;
		case "category":$SEFdata[1] .= "/".$SEFdata[2];
					if (isset($SEFdata[3]) && isset($SEFdata[4]))
						Configuration::$content = new Category($SEFdata[1], $SEFdata[3], $SEFdata[4]);
					else
						Configuration::$content = new Category($SEFdata[1]);
					Configuration::$contentType = "category"; 
					break;
		case "mod": Configuration::$contentType = "module"; 
					break;
		default: 	Configuration::$content = new Page($SEFdata[1]);
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

	Configuration::GetLink()->close();
?> 