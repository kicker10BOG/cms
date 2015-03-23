<?php

if ($pid != 0) {
	$row = mysql_fetch_array($result);
	if ($row['status'] == "published") {
		$title = $row['title'];
		$description = $row['description'];
		$tags = $row['tags'];
		$windowtitle .= $title;
		if ($userStatus >= $row['securelevel'] && ($row['type'] == "" || $userType == $row['type'] || $userType == "admin"))
			$content = stripslashes($row['content']);
		else
			$content = "<p>Sorry. You are not cleared to view this page.</p>";
	}
	else {
		$title = "Unpublished Page";
		$description = "Unpublished page";
		$windowtitle .= $title;
		$content = "<h3>This page is currently unavailable.</h3>";
	}
}

?>
