
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
	    $postTitle = trim($_REQUEST['newTitle']);
	    $postDescription = $_REQUEST['newDescription'];
	    $postTags = $_REQUEST['newTags'];
	    $postContent = Configuration::GetLink()->real_escape_string(strip_tags(trim($_REQUEST['contentEdit']), $allowedTags));
	    $postStatus = $_REQUEST['postStatus'];
	    $postCategories = $_REQUEST['postCategories'];
	    $oldPostCategories = $_REQUEST['currPostCategories'];
	    $result = false;
	    if ($_REQUEST['postid'] == "") {
	        $postAlias = str_replace(" ", "-", strtolower($postTitle));
	        $postAlias = "post/".date("m/d/Y/").$postAlias;
	        $query = "SELECT id FROM ".Configuration::sitePrefix."posts WHERE alias='$postAlias'";
	        $result = Configuration::Query($query);
			if (!$result)
				die(Configuration::GetLink()->error);
	        $i = 1;
	        while (Configuration::GetLink()->affected_rows > 0) {
		        $postAlias = str_replace(" ", "-", strtolower($postTitle))."-$i";
	        	$postAlias = "post/".date("m/d/Y/").$postAlias;
		        $query = "SELECT id FROM ".Configuration::sitePrefix."posts WHERE alias='$postAlias'";
		        $result = Configuration::Query($query);
		        $result->free();
			}
			$query = "INSERT INTO ".Configuration::sitePrefix."posts (title, description, dateUpdated, tags, alias, content, status) VALUES ('$postTitle', '$postDescription', UTC_TIMESTAMP(), '$postTags', '$postAlias', '$postContent', $postStatus)";
			$result = Configuration::Query($query);
			if (!$result)
				die(Configuration::GetLink()->error);
			$query = "SELECT id FROM ".Configuration::sitePrefix."posts WHERE alias='$postAlias'";
			$result = Configuration::Query($query);
			if (!$result)
				die(Configuration::GetLink()->error);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$_REQUEST['postid'] = $row['id'];
			//echo "hi ".Configuration::GetLink()->affected_rows;
		}
	    else {
	    	$query = "UPDATE ".Configuration::sitePrefix."posts SET title='$postTitle', description='$postDescription', tags='$postTags', content='$postContent', dateUpdated=UTC_TIMESTAMP(), status=$postStatus WHERE id=".$_REQUEST['postid'];
	    	$result = Configuration::Query($query);
    	}
		$post = new Post(intval($_REQUEST['postid']));
		$post->updateCategories($postCategories);
	    if (Configuration::GetLink()->affected_rows) {
			echo "<p class=\"updateNotification\" style=\"width:100%; line-height:40px; text-align:center; vertical-align: center; background:green;\">The post, ".$_REQUEST['newTitle'].", has been saved!</p>";
			//$result->free();
		}
		else
			echo "<p class=\"updateNotification\" style=\"width:100%; line-height:40px; text-align:center; vertical-align: middle; background:red; color:white;\">The post, ".$_REQUEST['newTitle'].", was not saved! There appears to have been an error accessing the database.</p>";

?>
