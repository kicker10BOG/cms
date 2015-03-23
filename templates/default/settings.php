<?php
	$tpl_topMenu = 1;
	$tpl_leftMenu = 0;
	$tpl_rightMenu = 0;
	$tpl_bannerurl = $home_dir."/templates/default/images/banners/JasonLBogle-2.png";
	
	function InsertLocation($locID, $locName) {
		$sitePrefix = GLB::get('sitePrefix');
		$userStatus = GLB::get('userStatus');
		$pid = GLB::get('pid');
		$query = "SELECT * from ".Configuration::sitePrefix."menus WHERE publish=1 AND location=$locID ORDER BY `order` ASC";
		$result = Configuration::Query($query);
		if (!$result)
		    echo "DBError accessing location ... ".mysql_error();
		else if (Configuration::GetLink()->affected_rows == 0)
			echo "";
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			if ($userStatus >= $row['securelevel']) {
				$query2 = "SELECT * FROM ".Configuration::sitePrefix."menu_items WHERE menu=".$row['id']." ORDER BY `order` ASC";
				$result2 = Configuration::query($query2);
				if (!$result2 || Configuration::GetLink()->affected_rows == 0){
					echo "hello 2 $query2 ";
					echo mysql_error(); // do nothing
				}
				else {
				    if ($row['type'] == 'horizontal') {
				    	$menu_spacer = "<img src=\"/templates/default/images/menu/tmenu2.png\"class=\"tMenuSepersator\">";
						while ($row2 = $result2->fetch_array()) {
							if ($row2['publish'] == 1 && $userStatus >= $row2['securelevel']) { 
							    $query3 = "SELECT title, alias, status  FROM ".Configuration::sitePrefix."pages WHERE id=".$row2['pid'];
								$result3 = Configuration::query($query3);
								if (!$result3 || Configuration::GetLink()->affected_rows == 0)
									;//echo "hello 3 $query3 ".mysql_error(); // do nothing
								$row3 = $result3->fetch_array();
								if ($row['parent'] == 0 && $row3['status'] == "published") {
									echo $menu_spacer;
									echo "<a href=\"";
									if ($row2['url'] == "")
										echo Configuration::home_dir.$row3['alias'];
									else
										echo $row2['url'];
									echo "\" ";
									if ($row2['pid'] == Configuration::$content->id && Configuration::$contentType == "page"){
										echo " id=\"current\"";
									}
									echo " target=\"_parent\">";
									echo $row2['title'];
									echo "</a>";
									echo $menu_spacer;
								}
								else if ($row['parent'] == Configuration::$content->id && Configuration::$contentType == "page" && $row3['status'] == "published"){
									$submenu .= $menu_spacer;
									$submenu .= "<a href=\"";
									if ($row2['url'] == "")
										$submenu .= Configuration::home_dir.$row3['alias'];
									else
										$submenu .= $row2['url'];
									$submenu .= "\" ";
									$submenu .= " target=\"_parent\">";
									$submenu .= $row2['title'];
									$submenu .= "</a>";
									$submenu .= $menu_spacer;
								}
								$result3->free();
							}
						}
					}
					$result2->free();
					GLB::set('subMenu', $submenu);
				}
			}
		}
		$result->free();
	}
?>
