<?
$menu_spacer = "<img src=\"./templates/default/images/menu/tmenu2.png\" class=\"tMenuSepersator\">"; //"<div class=\"tMenuSeperator\"></div>";

$query = "SELECT parent FROM ".$sitePrefix."adminTopMenu WHERE pid=".$pid;
$result = mysql_query($query);
$parentId = $row['parent'];
if ($parentId == 0)
	$parentId = -1;
$smenu = false;

$query2 = "SELECT * FROM ".$sitePrefix."adminTopMenu ORDER BY `order` ASC";
$result2 = mysql_query($query2);
if (!$result2 || mysql_num_rows($result2) == 0)
	echo "Unable to load top menu.";
else {
	while ($row = mysql_fetch_assoc($result2)) {
		if ($row['parent'] == 0 && $row['pub'] == 1 && $userStatus >= $row['securelevel']){
			echo $menu_spacer;
			echo "<a href=\"./index.php?pid=".$row['pid']."\" ";
			if ($pid == $row['pid'] || $parentId == $row['parent']){
				echo " id=\"current\"";
			}
			echo " target=\"_parent\">".$row['title']."</a>";
			echo $menu_spacer;
		}
	}
}
?>