<?php
// admin index.php
include("./configuration.php");
// require password
if (!isset($_REQUEST['adminPass'])) {
  $adminLoggedIn = 0;
  $pid = 0;
  ob_start();
  include("login.php");
  $content = ob_get_contents();
  ob_end_clean();
}
else {
  if ($_REQUEST['adminPass'] != "Ad5kjg0G*3") {
    $adminLoggedIn = 0;
    $pid = 0;
    ob_start();
    include("login.php");
    $content = ob_get_contents();
    ob_end_clean();
  }
  else {
    $adminLoggedIn = 1;
    $pid = 0;
    ob_start();
    include($php_function_dir."addBusiness.php");
    $content = ob_get_contents();
    ob_end_clean();
    setcookie("adminPass", "true", 60*60);
  }
}
  // connect to database
  $link = mysql_connect($db_address, $db_username, $db_password);
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  mysql_select_db($db_name);
  
  // determine what page was requested
  $error = $_REQUEST['error'];
  if (isset($error)) { // if it's an error
    // handle the error
    switch ($error) {
      case 404:
        $content = "error 404: Page not found.";
        break;
    }
  }
  else {
    if (!isset($_REQUEST['pid']) && !isset($pid)) 
      $pid = 1;
    else
      $pid = $_REQUEST['pid'];
    
    // find the pid in the database and display content associated with it
    $query = "SELECT * FROM pages WHERE id='$pid'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) == 0) {
      if ($pid != 0) 
         header("Status: 404 Not Found");
    }
    else {
      if ($pid != 0) {
        $row = mysql_fetch_array($result);
        $title = $row['title'];
        $windowtitle .= $title;
        $content = $row['content'];
      }
    }
  }
  include("templates/default/index.php");
  
  mysql_close($link);
?> 