<?php
	include "configuration.php";
	Configuration::Connect();
	?><script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="application/javascript"></script>
	<?php $tpl = new Template(1);
	//print_r($tpl);
	//$tpl->UseTpl();
	$loc = new Location(1, "horizontal");
?>
