<?
$menu_spacer = "<img src=\"".$home_dir."templates/default/images/menu/tmenu2.png\" class=\"tMenuSepersator\">"; //"<div class=\"tMenuSeperator\"></div>";

$query = "SELECT parent FROM ".$sitePrefix."topMenu WHERE pid=".$pid;
$result = mysql_query($query);
$parentId = $row['parent'];
if ($parentId == 0)
	$parentId = -1;
$smenu = false;

$query2 = "SELECT pid, title, pub, securelevel, parent, url FROM ".$sitePrefix."topMenu ORDER BY `order` ASC";
$result2 = mysql_query($query2);
if (!$result2 || mysql_num_rows($result2) == 0)
  echo "Unable to load top menu.";
else {
	while ($row = mysql_fetch_assoc($result2)) {
		if ($row['parent'] == 0 && $row['pub'] == 1 && $userStatus >= $row['securelevel']) {
			echo $menu_spacer;
			echo "<a href=\"".$home_dir.$row['url']."\" ";
			if ($pid == $row['pid'] || $parentId == $row['parent']){
				echo " id=\"current\"";
			}
			echo " target=\"_parent\">";
			echo $row['title'];
			echo "</a>";
			echo $menu_spacer;
		}
	}
}
?>