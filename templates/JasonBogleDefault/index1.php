<?php
include("templates/default/settings.php");
echo "
<!DOCTYPEHTML>
<html>
	<head>
		<meta charset=\"UTF-8\">
		<meta name=\"date\" content=\"Jun 2013\">
		<meta name=\"author\" content=\"Jason L. Bogle\">
		<meta name=\"title\" content=\"".$title."\">
		<meta name=\"copyright\" content=\"copyright 2012 Jason L. Bogle\">
		<meta name=\"description\" content=\"".$description."\">
		<meta name=\"keywords\" content=\"keywords\">
		<title>".$windowtitle."</title>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"".$home_dir."templates/default/css/index.css\">
		<link rel=\"stylesheet\" type=\"text/css\" href=\"".$home_dir."templates/default/css/roll.css\">
		<!-- Author: Enterprise Technoligies -->
	</head>
	<body>
	<div id=\"container\">
		<div id=\"container2\">
		    <header>
				<a href=\"$home_dir\">
					<div id=\"banner\">
						<img src=\"".$tpl_bannerurl."\">
					</div>
				</a>
			</header>
			<div id=\"mainsection\">";
			if ($tpl_topMenu == 1) {
				echo "
				<nav id=\"topmenu\">";
					InsertLocation(1, "Top Menu");
				echo "
				</nav>";}
			if (GLB::get('subMenu') != "") {
				echo "<nav id=\"topsubmenu\">";
					echo GLB::get('subMenu');
				echo "
				</nav>";}
			if ($tpl_leftMenu == 1) {
				echo "
				<nav id=\"leftmenu\">";
					include("templates/default/left-menu.php");
				echo "
				</nav>";}
			if ($tpl_rightMenu == 1) {
				echo "
				<nav id=\"rightmenu\">";
					include("".$home_dir."templates/default/right-menu.php");
				echo "
				</nav>";}
			echo "
				<div id=\"maincontent\">";
				    DisplayContent();
			echo "
				</div>
			</div>
		<footer>
			<div id=\"footspacer\"></div><div id=\"foot\">
				Created by: Jason L. Bogle</div></footer>
			</div>
		</footer>
	</body>
</html>"; ?>