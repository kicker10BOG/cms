<!DOCTYPEHTML html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="date" content="Jun 2013">
		<meta name="author" content="Jason L. Bogle">
		<meta name="title" content="<?php echo Configuration::$content->title(); ?>">
		<meta name="copyright" content="copyright 2012 Jason L. Bogle">
		<meta name="description" content="<?php echo Configuration::$content->description(); ?>">
		<meta name="keywords" content="<?php echo Configuration::$content->tags(); ?>">
		<meta name="tags" content="<?php echo Configuration::$content->tags(); ?>">
		<title><?php echo Configuration::$windowtitle.Configuration::$content->title(); ?></title>
		<script type="application/javascript" src="/templates/JasonBogleDefault/js/style.js"></script>
		<script type="application/javascript">
			$(document).ready(function(){
				$.fn.SetMargins();
				$(".dropdown").hover(function() {
					console.log("hover");
					$(this).find(".submenu").removeClass("submenu").addClass("hover");
				}, function() {
			    	$(this).find(".hover").removeClass("hover").addClass("submenu");
				});
			});
		</script>
		<link rel="stylesheet" type="text/css" href="/templates/JasonBogleDefault/css/index.css">
		<link rel="stylesheet" type="text/css" href="/templates/JasonBogleDefault/css/roll2.css">
		<!-- Author: Jason L. Bogle -->
	</head>
	<body>
	<div id="container">
		<div id="container2">
		    <header>
				<div id="banner">
					<a href="/">
						<img src="<?php echo $this->banner; ?>">
					</a>
					<div id="rightheader">
					    <?php //InsertLocation(4, "horizontal"); ?>
					</div>
				</div>
			</header>
			<div id="mainsection">
				<nav id="topbar">
					<?php IncludeLocation(1, "horizontal"); ?>
				</nav>
				<nav id="leftbar">
					<?php //InsertLocation(2, "vertical"); ?>
				</nav>
				<nav id="rightbar">
					<?php //InsertLocation(3, "vertical"); ?>
				</nav>
				<div id="maincontent">
				    <?php DisplayContent(); ?>
				</div>
			</div>
		<footer>
			<div id="footspacer"></div><div id="foot">
				Created by: Jason L. Bogle</div></footer>
			</div>
		</footer>
	</div>
	</body>
</html>