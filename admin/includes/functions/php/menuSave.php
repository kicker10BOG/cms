		<script>
			$(document).ready(function(){
				$(".updateNotification").delay(5000).fadeOut(5000);
			});
		</script>
		<?php
		$menuTitle = trim($_REQUEST['newTitle']);
		$menuStatus = $_REQUEST['menuStatus'];
		$menuParentType = $_REQUEST['menuPType'];
		$menuID = intval($_REQUEST['menuid']);
        $menuParentID = 0;
		if ($menuParentType == "page")
			$menuParentID = $_REQUEST['parentPageID'];

		if ($menuIsHome) {
			$query = "UPDATE ".Configuration::sitePrefix."menus SET isHome=0 WHERE isHome=1";
			$result = Configuration::Query($query);
		}
		if ($_REQUEST['menuid'] == 0) {
			$menuAlias = str_replace(" ", "-", strtolower($menuTitle));
			$query = "SELECT id FROM ".Configuration::sitePrefix."menus WHERE alias='$menuAlias'";
			$result = Configuration::Query($query);
			$i = 1;
			while (Configuration::GetLink()->affected_rows > 0) {
				$menuAlias = str_replace(" ", "-", strtolower($menuTitle))."-$i";
				$query = "SELECT id FROM ".Configuration::sitePrefix."menus WHERE alias='$menuAlias'";
				$result = Configuration::Query($query);
				$i = $i+1;
			}
			$query = "INSERT INTO ".Configuration::sitePrefix."menus (title=, alias, status) VALUES ('$menuTitle', '$menuAlias', '$menuStatus')";
			$result = Configuration::Query($query);
			$query = "SELECT id FROM ".Configuration::sitePrefix."menus WHERE alias='$menuAlias'";
			$result = Configuration::Query($query);
			if (!$result)
				die(mysql_error());
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$menuID = $row['id'];
		}
		else {
			$menu = new Menu($menuID);
			$menu->title($menuTitle);
			$menu->status($menuStatus);
			$menu->parentType($menuParentType);
            $menu->parentID($menuParentID);
			$result = $menu->update();
			if ($result) {
				for ($i = 0; $i < count($_REQUEST['itemID']) && $result; $i+=1) {
					//print("\n".$_REQUEST['itemID'][$i]."<br>");
					if ($_REQUEST['itemNew'][$i] == "true") {
						print("\n<br>new Item<br>\n");
						if ($_REQUEST['typeEdit'][$i] == "page") {
							$query = "SELECT alias FROM ".Configuration::sitePrefix."pages WHERE id=".$_REQUEST['pageSelect'][$i];
							$result = Configuration::Query($query);
							$row = $result->fetch_array(MYSQL_ASSOC);
							$_REQUEST['typeExternalEdit'][$i] = "/".$row['alias'];
						}
						$query = "INSERT INTO ".Configuration::sitePrefix."menu_items (title, pmenu, iorder, pid, type, url, status) VALUES ('".$_REQUEST['titleEdit'][$i]."', $menuID, $i, ".$_REQUEST['pageSelect'][$i].", '".$_REQUEST['typeEdit'][$i]."', '".$_REQUEST['typeExternalEdit'][$i]."', ".$_REQUEST['itemPub'][$i].")";
						print("<p>".$query."</p>");
						$result = Configuration::Query($query);
					}
					else {
						print("\n<br>Test 1<br>");
						$mItem = new MenuItem(intval($_REQUEST['itemID'][$i]));
						$mItem->status($_REQUEST['itemPub'][$i]);
						$mItem->type($_REQUEST['typeEdit'][$i]);
						$mItem->url($_REQUEST['typeExternalEdit'][$i]);
						$mItem->pid($_REQUEST['pageSelect'][$i]);
						$mItem->order($i);
						$mItem->title($_REQUEST['titleEdit'][$i]);
						print_r($mItem);
						$result = $mItem->update();
					}
				}
			}
		}
		if ($result)
			echo "<p class=\"updateNotification\" style=\"width:100%; line-height:40px; text-align:center; vertical-align: center; background:green;\">The menu, ".$_REQUEST['newTitle'].", has been saved!</p>";
		else
			echo "<p class=\"updateNotification\" style=\"width:100%; line-height:40px; text-align:center; vertical-align: middle; background:red; color:white;\">The menu, ".$_REQUEST['newTitle'].", was not saved! There appears to have been an error accessing the database.</p>"."<p>".Configuration::GetLink()->error."</p>";
		
		print_r($_POST);
		print_r($menu);

?>
