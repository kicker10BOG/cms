<?php
include("templates/default/settings.php");
?>
<!DOCTYPEHTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="date" content="Jun 2013">
		<meta name="author" content="Jason L. Bogle">
		<meta name="title" content="<?php echo Configuration::$content->title; ?>">
		<meta name="copyright" content="copyright 2012 Jason L. Bogle">
		<meta name="description" content="<?php echo Configuration::$content->description; ?>">
		<meta name="keywords" content="<?php echo Configuration::$content->tags; ?>">
		<meta name="tags" content="<?php echo Configuration::$content->tags; ?>">
		<title><?php echo Configuration::$windowtitle.Configuration::$content->title; ?></title>
		<link rel="stylesheet" type="text/css" href="/templates/default/css/index.css">
		<link rel="stylesheet" type="text/css" href="/templates/default/css/roll.css">
		<!-- Author: Enterprise Technoligies -->
	</head>
	<body>
	<div id="container">
		<div id="container2">
		    <header>
				<div id="banner">
					<a href="/">
						<img src="<?php echo $tpl_bannerurl; ?>">
					</a>
				</div>
			</header>
			<div id="mainsection">
			<?php
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
				    DisplayContent(); ?>
				</div>
			</div>
		<footer>
			<div id="footspacer"></div><div id="foot">
				Created by: Jason L. Bogle</div></footer>
			</div>
		</footer>
	</body>
</html>