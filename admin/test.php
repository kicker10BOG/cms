<?php
	include "configuration.php";
	Configuration::Connect();
	?><script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="application/javascript"></script>
	<?php $tpl = new AdminTemplate(1);
	print_r($tpl);
	$page = new AdminPage();
	$page->GetById(1);
	print_r($page);
	//$tpl->UseTpl();
	$loc = new Location(1, "horizontal");
?>
