<?php
if ($_REQUEST['action'] == "delete") {
	if (isset($_REQUEST['pageid'])) {
		$_REQUEST['pageid'] = intval($_REQUEST['pageid']);
		$query = "SELECT id, title, description FROM ".Configuration::sitePrefix."pages WHERE id=".$_REQUEST['pageid'];
		$result = Configuration::Query($query);
		if (!$result)
			Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$pageid = $row['id'];
			$ptitle = $row['title'];
			$pdescription = $row['description'];
			echo "<p class=cent>Are you sure you want to delete the page $ptitle with ID $pageid and description: $pdescription?<br><a href=\"?action=deleteConfirmed&ptitle=$ptitle&pageid=$pageid&pdescription=$pdescription\">Yes</a> or <a href=\"./\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "deleteConfirmed") {
	$query = sprintf("DELETE FROM ".Configuration::sitePrefix."pages WHERE id=%d", $_REQUEST['pageid']);
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The page, ".$_REQUEST['ptitle'].", was deleted</p>";
}

elseif ($_REQUEST['action'] == "unpublish") {
	if (isset($_REQUEST['pageid'])) {
		$_REQUEST['pageid'] = intval($_REQUEST['pageid']);
		$query = "SELECT id, title, description FROM ".Configuration::sitePrefix."pages WHERE id=".$_REQUEST['pageid'];
		$result = Configuration::Query($query);
		if (!$result)
			Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$pageid = $row['id'];
			$ptitle = $row['title'];
			$pdescription = $row['description'];
			echo "<p class=cent>Are you sure you want to unpublish the page $ptitle with ID $pageid and description: $pdescription?<br><a href=\"?action=unpublishConfirmed&ptitle=$ptitle&pageid=$pageid&pdescription=$pdescription\">Yes</a> or <a href=\"../\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "unpublishConfirmed") {
	$query = "UPDATE ".Configuration::sitePrefix."pages SET status=0 WHERE id=".$_REQUEST['pageid'];
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The page, ".$_REQUEST['ptitle'].", is now unpublished</p>";
}

elseif ($_REQUEST['action'] == "publish") {
	if (isset($_REQUEST['pageid'])) {
		$_REQUEST['pageid'] = intval($_REQUEST['pageid']);
		$query = "SELECT id, title, description FROM ".Configuration::sitePrefix."pages WHERE id=".$_REQUEST['pageid'];
		$result = Configuration::Query($query);
		if (!$result)
			Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$pageid = $row['id'];
			$ptitle = $row['title'];
			$pdescription = $row['description'];
			echo "<p class=cent>Are you sure you want to publish the page $ptitle with ID $pageid and description: $pdescription?<br><a href=\"?action=publishConfirmed&ptitle=$ptitle&pageid=$pageid&pdescription=$pdescription\">Yes</a> or <a href=\"?pid=3\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "publishConfirmed") {
	$query = sprintf("UPDATE ".Configuration::sitePrefix."pages SET status=1 WHERE id=%d", $_REQUEST['pageid']);
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The page, ".$_REQUEST['ptitle'].", is now published</p>";
}

else if ($_REQUEST['action'] == "edit" || $_REQUEST['action'] == "addNewPage") {
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
	if (isset($_REQUEST['savePage'])) {
	    include "pageSave.php";
	}
	if (isset($_REQUEST['pageid'])) {
		$_REQUEST['pageid'] = intval($_REQUEST['pageid']);
		$page = new Page($_REQUEST['pageid']);
	}
	else {
		$arr = array("id" => NULL);
		$page = new Page($arr);
		//print_r($page);
	}
	include "pageForm.php";
}

else {
	$pages = Page::GetAll();
	if (is_array($pages)) {
		echo "<table style=\"margin-left:auto; margin-right:auto;\" rules=\"rows\">\n";
		echo "<tr style=\"border:0;\">\n<td colspan=5 style=\"text-align: left; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-pages/?action=addNewPage\">Add New Page</a></strong></td></tr>\n";
		echo "<tr>\n<td style=\"text-align: right; padding: 0px 10px 0px 10px;\">ID</td>\n<td style=\"padding: 0px 10px 0px 10px\";>Page Title</td>\n<td></td><td></td><td></td><td></td></tr>\n";
		$i = 0;
		$color = array("#AAAAAA", "#CCCCCC");
		foreach ($pages as $page) {
		$trow = sprintf( "<tr style=\"background:%s; text-align: right;\">\n<td style=\"padding: 0px 10px 0px 10px;\">%d</td>\n<td style=\"text-align: left; padding: 0px 10px 0px 10px;\">%s</td>\n<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-pages/?action=delete&pageid=%d&ptitle=%s\">Delete</a></strong></td>\n", $color[$i], $page->id, $page->title, $page->id, $page->title);

			if ($page->status == 0)
				$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-pages/?action=publish&pageid=%d&ptitle=%s\">Publish</a></strong></td>\n", $page->id, $page->title);
			else
				$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-pages/?action=unpublish&pageid=%d&ptitle=%s\">Unpublish</a></strong></td>\n", $page->id, $page->title);

			$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-pages/?action=edit&pageid=%d&ptitle=%s\">Edit</a></strong></td>\n", $page->id, $page->title);

			if ($page->isHome)
			    $trow .= "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\">Home</td>\n";
			else
			    $trow .= "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"></td>\n";

			echo $trow."</tr>\n";

			$i = ($i + 1) % 2;
		}
		echo "</table>";
	}
	else
	echo $pages;
}
?>