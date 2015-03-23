<?php
	$SEFdata = substr($_SERVER['REQUEST_URI'],strlen($_SERVER['SCRIPT_NAME']));
	$SEFdata = explode('/',$_SERVER['REQUEST_URI']);
	$SEFhomeCount = count($SEFdata) - 1;
	$SEFdataFiltered = array_filter($SEFdata,"filter");
	$SEFvars = array();
	foreach($SEFdataFiltered as $SEFvalue){
		$SEFvar = explode('_',$SEFvalue);
		$SEFvar[0] = urldecode($SEFvar[0]);
		$SEFvar[1] = urldecode($SEFvar[1]);
		if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/',$SEFvar[0])){
			$HTTP_GET_VARS[$var[0]]=$SEFvar[1];
			$_GET[$SEFvar[0]]=$SEFvar[1];
			$SEFvars[$SEFvar[0]]=$SEFvar[1];
		}
	}
	if (ini_get('register_globals')){
		extract($SEFvars);
	}

	function filter($SEFvar){
		return preg_match('/^[^_]+?_[^_]*$/',$SEFvar);
	}
?>