<?php
	// the autoload fnction for php classes
	function __autoload($className) {
		include Configuration::php_class_dir.$className.".php";
	}

	class GLB { // globals class
		// set a global variable
		static public function set($name, $value){
			$GLOBALS[$name] = $value;
		}
		// get a global variable
		static public function get($name){
			return $GLOBALS[$name];
		}
	}
	
	date_default_timezone_set("America/Chicago");
	
	class Configuration {
		// site info should be private and immutable
		// DB info
		const db_address = '';
		const db_name = "";
		const db_username = "";
		const db_password = "";
		
		private static $link = null; // the link will be set when a connection is made
		
		// FTP info
		const ftp_address = "";
		const ftp_username = "";
		const ftp_password = "";
		
		// Cookie info
		const cookiURL = "";
		const cookiePath = "/";
		
		// content
		public static $specialMsg;
		public static $content;
		public static $contentType;
		public static $tpl;
		
		// Misc. site info
		const sitePrefix = "jlb1_";
		const siteURL = "http://dev.jasonlbogle.com/";
		const fullHomDir = "http://dev.jasonlbogle.com/";
		const home_dir = "/";
		public static $windowtitle = "Jason L Bogle || ";
		// Include location folder info
		const include_dir = "includes/";
		const function_dir = "includes/functions/";
		const php_function_dir = "includes/functions/php/";
		const js_function_dir = "includes/functions/js/";
		const class_dir = "includes/classes/";
		const php_class_dir = "includes/classes/php/";
		const content_dir = "content/";
		
		// the link should be accessible but not mutable by clients 
		public static function GetLink() {
			return Configuration::$link;
		}
		
		// the method to connect to the database
		public static function Connect() {
			Configuration::$link = new mysqli(Configuration::db_address, Configuration::db_username, Configuration::db_password, Configuration::db_name);
			return $link;
		}
		
		public static function Query($query) {
			return Configuration::$link->query($query);
		}
		
		public static function MultiQuery($query) {
			return Configuration::$link->multi_query($query);
		}
		
		public static function SetTpl() {
			Configuration::$tpl = new Template(Configuration::$content->template());
		}
	}
	
	function IncludeLocation($loc, $orientation) {
		$loc = new Location($loc);
		$loc->Display($orientation);
	}

	// function to display main content
	function DisplayContent() {
		echo Configuration::$specialMsg;
		Configuration::$content->Display();
	}

	// functions to help handle errors
	function SendError($errNo = 0, $errMsg = "Unknown error has occurred", $pid = 0){
		if (isset($_REQUEST['pid']))
		  $pid = $_REQUEST['pid'];
		$url = "/?error=true&errNo=".$errNo."&errMsg=".$errMsg."&pid=".$pid;
		header("Location: $url");
		die();
	}

	function LoginError($errMsg = "Error logging in.", $email ="", $pid = 0) {
		$errNo = 1; // login error
		SendError($errNo, $errMsg, $pid);
	}

	function DBError($errMsg = "Error accessing database.", $pid = 0) {
		$errNo = 2; // database error
		SendError($errNo, $errMsg, $pid);
	}

	function CookieError($errMsg = "Login data is invalid.", $pid = 0) {
		$errNo = 3; // cookie error
		$errMsg .= "<br><a href=./index.php?action=logout>Reset cookies associated with this site.";
		SendError($errNo, $errMsg, $pid);
	}
?>