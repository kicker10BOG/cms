<?php
if ($_REQUEST['action'] == "delete") {
	if (isset($_REQUEST['menuid'])) {
		$_REQUEST['menuid'] = intval($_REQUEST['menuid']);
		$query = "SELECT id, title FROM ".Configuration::sitePrefix."menus WHERE id=".$_REQUEST['menuid'];
		$result = Configuration::Query($query);
		if (!$result)
			Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$menuid = $row['id'];
			$mtitle = $row['title'];
			echo "<p class=cent>Are you sure you want to delete the menu $mtitle with ID $menuid?<br><a href=\"?action=deleteConfirmed&mtitle=$mtitle&menuid=$menuid\">Yes</a> or <a href=\"./\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "deleteConfirmed") {
	$query = sprintf("DELETE FROM ".Configuration::sitePrefix."menus WHERE id=%d", $_REQUEST['menuid']);
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The menu, ".$_REQUEST['mtitle'].", was deleted</p>";
}

elseif ($_REQUEST['action'] == "unpublish") {
	if (isset($_REQUEST['menuid'])) {
		$_REQUEST['menuid'] = intval($_REQUEST['menuid']);
		$query = "SELECT id, title FROM ".Configuration::sitePrefix."menus WHERE id=".$_REQUEST['menuid'];
		$result = Configuration::Query($query);
		if (!$result)
			Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$menuid = $row['id'];
			$mtitle = $row['title'];
			echo "<p class=cent>Are you sure you want to unpublish the menu $mtitle with ID $menuid?<br><a href=\"?action=unpublishConfirmed&mtitle=$mtitle&menuid=$menuid\">Yes</a> or <a href=\"../\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "unpublishConfirmed") {
	$query = "UPDATE ".Configuration::sitePrefix."menus SET status=0 WHERE id=".$_REQUEST['menuid'];
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The menu, ".$_REQUEST['mtitle'].", is now unpublished</p>";
}

elseif ($_REQUEST['action'] == "publish") {
	if (isset($_REQUEST['menuid'])) {
		$_REQUEST['menuid'] = intval($_REQUEST['menuid']);
		$query = "SELECT id, title FROM ".Configuration::sitePrefix."menus WHERE id=".$_REQUEST['menuid'];
		$result = Configuration::Query($query);
		if (!$result)
			Configuration::GetLink()->error;
		else {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$menuid = $row['id'];
			$mtitle = $row['title'];
			echo "<p class=cent>Are you sure you want to publish the menu $mtitle with ID $menuid?<br><a href=\"?action=publishConfirmed&mtitle=$mtitle&menuid=$menuid\">Yes</a> or <a href=\"../\">No</a></p>";
		}
	}
}
elseif ($_REQUEST['action'] == "publishConfirmed") {
	$query = sprintf("UPDATE ".Configuration::sitePrefix."menus SET status=1 WHERE id=%d", $_REQUEST['menuid']);
	$result = Configuration::Query($query);
	if (!$result)
		Configuration::GetLink()->error;
	else
		echo "<p class=cent>The menu, ".$_REQUEST['mtitle'].", is now published</p>";
}

else if ($_REQUEST['action'] == "edit" || $_REQUEST['action'] == "addNewMenu") {
	if (isset($_REQUEST['saveMenu'])) {
	    include "menuSave.php";
	}
	if (isset($_REQUEST['menuid'])) {
		$_REQUEST['menuid'] = intval($_REQUEST['menuid']);
		$menu = new Menu($_REQUEST['menuid']);
	}
	else {
		$arr = array("id" => 0);
		$menu = new Menu($arr);
	}
	//print_r($menu);
	include "menuForm.php";
}

else {
	$menus = Menu::GetAll();
	if (is_array($menus)) {
		echo "<table style=\"margin-left:auto; margin-right:auto;\" rules=\"rows\">\n";
		echo "<tr style=\"border:0;\">\n<td colspan=5 style=\"text-align: left; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-menus/?action=addNewMenu\">Add New Menu</a></strong></td></tr>\n";
		echo "<tr>\n<td style=\"text-align: right; padding: 0px 10px 0px 10px;\">ID</td>\n<td style=\"padding: 0px 10px 0px 10px\";>Menu Title</td>\n<td></td><td></td><td></td><td></td></tr>\n";
		$i = 0;
		$color = array("#AAAAAA", "#CCCCCC");
		foreach ($menus as $menu) {
		$trow = sprintf( "<tr style=\"background:%s; text-align: right;\">\n<td style=\"padding: 0px 10px 0px 10px;\">%d</td>\n<td style=\"text-align: left; padding: 0px 10px 0px 10px;\">%s</td>\n<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-menus/?action=delete&menuid=%d&mtitle=%s\">Delete</a></strong></td>\n", $color[$i], $menu->id(), $menu->title(), $menu->id(), $menu->title());

			if ($menu->status() == 0)
				$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-menus/?action=publish&menuid=%d&mtitle=%s\">Publish</a></strong></td>\n", $menu->id(), $menu->title());
			else
				$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-menus/?action=unpublish&menuid=%d&mtitle=%s\">Unpublish</a></strong></td>\n", $menu->id(), $menu->title());

			$trow .= sprintf( "<td style=\"text-align: center; padding: 0px 10px 0px 10px;\"><strong><a href=\"/admin/manage-menus/?action=edit&menuid=%d&mtitle=%s\">Edit</a></strong></td>\n", $menu->id(), $menu->title());

			echo $trow."</tr>\n";

			$i = ($i + 1) % 2;
		}
		echo "</table>";
	}
	else
	echo $menus;
}
?>