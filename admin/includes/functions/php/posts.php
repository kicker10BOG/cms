<?php
if ($_REQUEST['action'] == "delete") {
	if (!isset($_REQUEST['postid'])) {
		$_REQUEST['postid'] = intval($_REQUEST['postid']);
		$query = "SELECT id, title, description FROM ".Configuration::sitePrefix."posts WHERE id=".$_REQUEST['postid'];
		$result = Configuration::Query($query);
		if (!$result)
		    Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$postid = $row['id'];
			$ptitle = $row['title'];
			$pdescription = $row['description'];
			echo "<p class=cent>Are you sure you want to delete the post %s with ID %d and description: %s?<br><a href=\"?action=deleteConfirmed&ptitle=%s&postid=%d&pdescription=%s\">Yes</a> or <a href=\"./\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "deleteConfirmed") {
	$query = sprintf("DELETE FROM ".Configuration::sitePrefix."posts WHERE id=%d", $_REQUEST['postid']);
	$result = mysql_query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The post, ".$_REQUEST['ptitle'].", was deleted</p>";
}

elseif ($_REQUEST['action'] == "unpublish") {
	if (isset($_REQUEST['postid'])) {
		$_REQUEST['postid'] = intval($_REQUEST['postid']);
		$query = "SELECT id, title, description FROM ".Configuration::sitePrefix."posts WHERE id=".$_REQUEST['postid'];
		$result = Configuration::Query($query);
		if (!$result)
		    Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$postid = $row['id'];
			$ptitle = $row['title'];
			$pdescription = $row['description'];
			echo "<p class=cent>Are you sure you want to unpublish the post $ptitle with ID $postid and description: $pdescription?<br><a href=\"?action=unpublishConfirmed&ptitle=$ptitle&postid=$postid&pdescription=$pdescription\">Yes</a> or <a href=\"./\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "unpublishConfirmed") {
	$query = "UPDATE ".Configuration::sitePrefix."posts SET status=0 WHERE id=".$_REQUEST['postid'];
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The post, ".$_REQUEST['ptitle'].", is now unpublished</p>";
}

elseif ($_REQUEST['action'] == "publish") {
	if (isset($_REQUEST['postid'])) {
		$_REQUEST['postid'] = intval($_REQUEST['postid']);
		$query = "SELECT id, title, description FROM ".Configuration::sitePrefix."posts WHERE id=".$_REQUEST['postid'];
		$result = Configuration::Query($query);
		if (!$result)
		    Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$postid = $row['id'];
			$ptitle = $row['title'];
			$pdescription = $row['description'];
			echo "<p class=cent>Are you sure you want to publish the post $ptitle with ID $postid and description: $pdescription?<br><a href=\"?action=publishConfirmed&ptitle=$ptitle&postid=$postid&pdescription=$pdescription\">Yes</a> or <a href=\"./\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "publishConfirmed") {
	$query = sprintf("UPDATE ".Configuration::sitePrefix."posts SET status=1 WHERE id=%d", $_REQUEST['postid']);
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The post, ".$_REQUEST['ptitle'].", is now published</p>";
}

else if ($_REQUEST['action'] == "edit" || $_REQUEST['action'] == "addNewPost") {
?>
	<script type="text/javascript" src="/admin/<?php echo Configuration::include_dir; ?>tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
			tinymce.init({
				selector: "textarea#contentEdit",
				height: "400",
				document_base_url: "<?php echo Configuration::siteURL; ?>",
				relative_urls: false,
			    plugins: [
			        "advlist autolink link image charmap print preview",
			        "code fullscreen",
			        "table contextmenu paste"
			    ],
			    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview | code",
				menu: {
					edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},
					insert: {title: 'Insert', items: 'link image | table'},
					view: {title: 'View', items: 'preview fullscreen visualaid'},
					format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
					table: {title: 'Table'},
					tools: {title: 'Tools', items: 'code'}
				}
			});
	</script>
<?php
	if (isset($_REQUEST['savePost'])) 
	    include "postSave.php";
	if (isset($_REQUEST['postid'])) {
		$_REQUEST['postid'] = intval($_REQUEST['postid']);
		$post = new Post($_REQUEST['postid']);
	}
	else {
		$arr = array("id" => NULL);
		$post = new Post($arr);
		//print_r($post);
	}
	$categories = Category::GetAll();
	$_REQUEST['currPostCategories'] = $post->categories();
	include "postForm.php";
}

else {
	$posts = Post::GetAll();
	if (is_array($posts)) {
		echo "<table style=\"margin-left:auto; margin-right:auto;\" rules=\"rows\">\n";
		echo "<tr style=\"border:0;\">\n<td colspan=5 style=\"text-align: left; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-posts/?action=addNewPost\">Add New Post</a></strong></td></tr>\n";
		echo "<tr>\n<td style=\"text-align: right; padding: 0px 10px 0px 10px;\">ID</td>\n<td style=\"padding: 0px 10px 0px 10px\";>Post Title</td>\n<td></td><td></td><td></td><td></td></tr>\n";
		$i = 0;
		$color = array("#AAAAAA", "#CCCCCC");
		foreach ($posts as $post) {
		    $trow = sprintf( "<tr style=\"background:%s; text-align: right;\">\n<td style=\"padding: 0px 10px 0px 10px;\">%d</td>\n<td style=\"text-align: left; padding: 0px 10px 0px 10px;\">%s</td>\n<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-posts/?action=delete&postid=%d&ptitle=%s\">Delete</a></strong></td>\n", $color[$i], $post->id, $post->title, $post->id, $post->title);

			if (!$post->status)
				$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-posts/?action=publish&postid=%d&ptitle=%s\">Publish</a></strong></td>\n", $post->id, $post->title);
			else
				$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-posts/?action=unpublish&postid=%d&ptitle=%s\">Unpublish</a></strong></td>\n", $post->id, $post->title);

			$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-posts/?action=edit&postid=%d&ptitle=%s\">Edit</a></strong></td>\n", $post->id, $post->title);

		  echo $trow."</tr>\n";

			$i = ($i + 1) % 2;
		}
		echo "</table>";
	}
	else
	    echo $posts;
}
?>