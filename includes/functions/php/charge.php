<?php
$displayForm = true; 
if (isset($_REQUEST['memID'])) {
  $memID = intval(trim($_REQUEST['memID']));
  $serCode = intval(trim($_REQUEST['serCode']));
  $date = trim($_REQUEST['date']);
  $price = trim($_REQUEST['price']);
  if (isset($_REQUEST['comments']))
	$comments = trim($_REQUEST['comments']);
}

if ($_REQUEST['action'] == 'checkCharge' || $_REQUEST['action'] == 'confirmCharge') {
  $displayForm = false; 
  $query = "SELECT userid FROM members WHERE memberid=".trim($_REQUEST['memID']);
  $result = mysql_query($query) or die("databes error - ".mysql_error());
  $userID = mysql_fetch_row($result);
  $userID = $userID[0];
  $query = "SELECT name FROM users WHERE id=$userID";
  $result = mysql_query($query) or die("databes error - ".mysql_error());
  $userName = mysql_fetch_row($result);
  $userName = $userName[0];
  $query = "SELECT sername FROM services WHERE id=".trim($_REQUEST['serCode']);
  $result = mysql_query($query) or die("databes error - ".mysql_error());
  $serName = mysql_fetch_row($result);
  $serName = $serName[0];
  
  if ($_REQUEST['action'] == 'checkCharge') {
	function MyCheckDate($date) {
	  $date = str_replace('/', '-', $date);
	  $regex1 = '/[0-9]{2}-[0-9]{2}-[0-9]{4}/';
	  $regex2 = '/[0-9]{4}-[0-9]{2}-[0-9]{2}/';
	  if (preg_match($regex1, $date)) {
		//echo "date in proper format";
		return $date;
	  }
	  elseif (preg_match($regex2, $date)){
		$dateArr = explode('-', $date);
		$date = $dateArr[1].'-'.$dateArr[2].'-'.$dateArr[0];
		return $date;
	  }
	  return false;
	}
	
	if (MyCheckDate($date)) {
	  $date = MyCheckDate($date);
	  echo "<p class=\"cent\">Provide <strong>$serName</strong> service for <strong>$userName</strong>?<br><a href=\"./?pid=9&action=confirmCharge&memID=$memID&serCode=$serCode&price=$price&date=$date&comments=$comments\">Confirm</a> or <a href=\"./?pid=9\">Cancel</a></p>";
	}
	else {
	  echo "<p class=cent>The date format is incompatible, please use mm-dd-yyyy (or yyyy-mm-dd because it is forced by some tablets).</p>";
	  $displayForm = true; 
	}
  }
  else {
	$query = "SELECT id FROM users WHERE email='".$_COOKIE['manbizdire']."'";
	$result = mysql_query($query) or die("databass error - ".mysql_error());
	$puserId = mysql_fetch_row($result);
	$puserId = $puserId[0];
	$query = "SELECT providerid FROM providers WHERE userid=$puserId";
	$result = mysql_query($query) or die("databes error0 - ".mysql_error()." - $query");
	$provID = mysql_fetch_row($result);
	$provID = $provID[0];
	$date = str_replace('-', '/', $date);
	$query = sprintf("INSERT INTO servicesUsed (dateofservice, providernum, membernum, servicecode, price, datesubmitted, comments) VALUES (FROM_UNIXTIME(".strtotime($date)."), %d, %d, %d, $price, FROM_UNIXTIME(UNIX_TIMESTAMP(NOW())), '$comments')", $provID, $memID, $serCode, $comments);
	$result = mysql_query($query) or die("database error - ".mysql_error()." - $query");
  }
}
if ($displayForm == true)
  /*if (isset($_REQUEST['memID'])) {
	$memID = sprintf('%09d', trim($_REQUEST['memID']));
	$serCode = sprintf('%06d', trim($_REQUEST['serCode']));
  }*/
  echo "
	<table style=\"margin-left:auto; margin-right:auto; width: 280px;\">
	  <form name=\"chargeFom\" method=\"post\" action=\"./index.php?pid=9&action=checkCharge\">
	  <thead>
		<tr><td colspan=2 style=\"text-align:center\"><h3>Charge for a Service</h3></td></tr>
	  </thead>
	  <tbody>
		<tr><td>*Member # :</td><td><input type=\"int\" required=reqiured name=\"memID\" value=\"".$memID."\"></td></tr>
		<tr><td>*Service Code:</td><td><input type=\"int\" required=reqiured name=\"serCode\" value=\"".$serCode."\"></td></tr>
		<tr><td>*Date of Service (mm-dd-yyyy):</td><td><input type=\"date\" required=reqiured name=\"date\" value=\"".$date."\"></td></tr>
		<tr><td>*Price:</td><td><input type=\"float\" required=reqiured name=\"price\" min=0 max=999.99 value=\"".$price."\"></td></tr>
		<tr><td>Comments:</td><td><textarea name=\"comments\" cols=20 rows=5>".$comments."</textarea></td></tr>
		<tr><td colspan=2 style=\"text-align: right;\"><input type=\"submit\" name=\"checkCharge\" value=\"Charge\"></td></tr>
	  </tbody>
	  </form>
	</table>";
?>