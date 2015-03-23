		<script>
			$(document).ready(function(){
				$(".updateNotification").delay(5000).fadeOut(5000);
			});
		</script>
		<?php
		$allowedTags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><img><figcaption>';
		$allowedTags .= '<li><ol><ul><span><div><br><ins><del><dfn><code><samp><a>';
		$allowedTags .= '<kbd><var><abbr><big><cite><caption><dl><dt><q><figure><hr>';
        $allowedTags .= '<form><input>';
		$pageTitle = trim($_REQUEST['newTitle']);
		$pageDescription = $_REQUEST['newDescription'];
		$pageTags = $_REQUEST['newTags'];
		$pageContent = Configuration::GetLink()->real_escape_string(strip_tags(trim($_REQUEST['contentEdit']), $allowedTags));
		$pageCategories = $_REQUEST['pageCategories'];
		if (in_array("all", $pageCategories))
		    $pageCategories = "all";
		else
		    $pageCategories = implode(",", $pageCategories);
		$pageNumPosts = $_REQUEST['numPosts'];
		$pageType = $_REQUEST['pageType'];
		$pageStatus = $_REQUEST['pageStatus'];
		$pageIsHome = $_REQUEST['makeHome'];
		if ($pageIsHome) {
			$query = "UPDATE ".Configuration::sitePrefix."pages SET isHome=0 WHERE isHome=1";
			$result = Configuration::Query($query);
		}
		if ($_REQUEST['pageid'] == "") {
			$pageAlias = str_replace(" ", "-", strtolower($pageTitle));
			$query = "SELECT id FROM ".Configuration::sitePrefix."pages WHERE alias='$pageAlias'";
			$result = Configuration::Query($query);
			$i = 1;
			while (Configuration::GetLink()->affected_rows > 0) {
				$pageAlias = str_replace(" ", "-", strtolower($pageTitle))."-$i";
				$query = "SELECT id FROM ".Configuration::sitePrefix."pages WHERE alias='$pageAlias'";
				$result = Configuration::Query($query);
				$i = $i+1;
			}
			$query = "INSERT INTO ".Configuration::sitePrefix."pages (title, description, tags, alias, content, categories, numPosts, type, status, isHome) VALUES ('$pageTitle', '$pageDescription', '$pageTags', '$pageAlias', '$pageContent', '$pageCategories', $pageNumPosts, '$pageType', '$pageStatus', $pageIsHome)";
			$result = Configuration::Query($query);
			$query = "SELECT id FROM ".Configuration::sitePrefix."pages WHERE alias='$pageAlias'";
			$result = Configuration::Query($query);
			if (!$result)
				die(mysql_error());
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$_REQUEST['pageid'] = $row['id'];
		}
		else {
			$query = "UPDATE ".Configuration::sitePrefix."pages SET title='$pageTitle', description='$pageDescription', tags='$pageTags', content='$pageContent', categories='$pageCategories', numPosts='$pageNumPosts', type='$pageType', status='$pageStatus', isHome='$pageIsHome' WHERE id=".$_REQUEST['pageid'];
			$result = Configuration::Query($query);
		}
		if ($result)
			echo "<p class=\"updateNotification\" style=\"width:100%; line-height:40px; text-align:center; vertical-align: center; background:green;\">The page, ".$_REQUEST['newTitle'].", has been saved!</p>";
		else
			echo "<p class=\"updateNotification\" style=\"width:100%; line-height:40px; text-align:center; vertical-align: middle; background:red; color:white;\">The page, ".$_REQUEST['newTitle'].", was not saved! There appears to have been an error accessing the database.</p>";

?>
