-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 10.6.166.92
-- Generation Time: Oct 09, 2013 at 03:02 PM
-- Server version: 5.0.96
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `jbogle`
--

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_adminLocations`
--

CREATE TABLE `jlb1_adminLocations` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(32) NOT NULL,
  `ordering` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jlb1_adminLocations`
--

INSERT INTO `jlb1_adminLocations` VALUES(1, 'top bar', 'menu:1');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_adminMenus`
--

CREATE TABLE `jlb1_adminMenus` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(64) NOT NULL,
  `showTitle` tinyint(1) NOT NULL default '0',
  `location` int(11) NOT NULL default '1',
  `type` enum('horizontal','vertical') NOT NULL,
  `parentID` int(11) NOT NULL default '0',
  `parentType` enum('page','post','mod') NOT NULL default 'page',
  `parentMenuItem` int(11) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  `securelevel` int(11) NOT NULL default '0',
  `items` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jlb1_adminMenus`
--

INSERT INTO `jlb1_adminMenus` VALUES(1, 'Main Menu', 0, 1, 'horizontal', 0, 'page', 0, 1, 2, '1,2,3,4,5');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_adminMenu_items`
--

CREATE TABLE `jlb1_adminMenu_items` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '0',
  `type` enum('page','blog','custom') NOT NULL default 'page',
  `menu` int(11) NOT NULL default '0',
  `title` text NOT NULL,
  `url` varchar(32) NOT NULL,
  `order` int(11) NOT NULL default '0',
  `securelevel` int(11) NOT NULL default '2',
  `status` tinyint(1) NOT NULL default '1',
  `subMenu` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jlb1_adminMenu_items`
--

INSERT INTO `jlb1_adminMenu_items` VALUES(1, 1, 'page', 1, 'Control Panel', '/admin/control-panel', 0, 3, 1, 0);
INSERT INTO `jlb1_adminMenu_items` VALUES(2, 2, 'page', 1, 'Users', '/admin/manage-users', 0, 2, 1, 0);
INSERT INTO `jlb1_adminMenu_items` VALUES(3, 3, 'page', 1, 'Pages', '/admin/manage-pages', 0, 2, 1, 0);
INSERT INTO `jlb1_adminMenu_items` VALUES(4, 4, 'page', 1, 'Posts', '/admin/manage-posts', 0, 2, 1, 0);
INSERT INTO `jlb1_adminMenu_items` VALUES(5, 5, 'page', 1, 'Logout', '/admin/loginlogout', 100, 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_adminPages`
--

CREATE TABLE `jlb1_adminPages` (
  `id` int(3) NOT NULL auto_increment,
  `title` text NOT NULL,
  `showTitle` tinyint(1) NOT NULL default '0',
  `alias` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `showDescription` tinyint(1) NOT NULL default '0',
  `tags` text NOT NULL,
  `showTags` tinyint(1) NOT NULL default '0',
  `template` varchar(11) NOT NULL default 'default',
  `dateUpdated` datetime NOT NULL,
  `showDate` tinyint(1) NOT NULL default '0',
  `securelevel` int(11) NOT NULL default '2',
  `type` enum('page','blog','custom') NOT NULL default 'page',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `jlb1_adminPages`
--

INSERT INTO `jlb1_adminPages` VALUES(1, 'Control Panel', 0, 'control-panel', '<p>Welcome to the admin control panel!</p>\r\n<p>Use the top menu to manage Members, Providers, or Services.</p>', 'Admin CP', 0, '', 0, 'default', '2012-04-07 17:46:59', 0, 2, 'page', 1);
INSERT INTO `jlb1_adminPages` VALUES(2, 'Manage Users', 0, 'manage-users', '<?php\r\ninclude(Configuration::php_function_dir."users.php");\r\n?>', '', 0, '', 0, 'default', '0000-00-00 00:00:00', 0, 2, 'custom', 1);
INSERT INTO `jlb1_adminPages` VALUES(3, 'Manage Pages', 0, 'manage-pages', '<?php\r\ninclude(Configuration::php_function_dir."pages.php");\r\n?>', '', 0, '', 0, 'default', '2012-04-07 23:42:16', 0, 2, 'custom', 1);
INSERT INTO `jlb1_adminPages` VALUES(4, 'Manage Posts', 0, 'manage-posts', '<?php \r\ninclude(Configuration::php_function_dir."posts.php"); \r\n?>', 'Manage Posts', 0, '', 0, 'default', '2012-04-08 00:23:59', 0, 2, 'custom', 1);
INSERT INTO `jlb1_adminPages` VALUES(5, 'Login/Logout', 0, 'loginlogout', '<?php \r\ninclude("login.php"); ?>', 'Login or Logout', 0, '', 0, 'default', '2012-04-08 00:09:03', 0, 0, 'custom', 1);
INSERT INTO `jlb1_adminPages` VALUES(6, 'User CP', 0, 'user-cp', '<?php\r\ninclude($php_function_dir."userCP.php");\r\n?>', 'User Control Panel', 0, '', 0, 'default', '2012-04-12 19:37:24', 0, 2, 'custom', 0);
INSERT INTO `jlb1_adminPages` VALUES(7, 'Sim Reports', 0, 'sim-reports', '<?php\r\ninclude($php_function_dir."reports.php");\r\n?>', 'Simulate reports', 0, '', 0, 'default', '2012-04-13 13:25:01', 0, 2, 'custom', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_adminTemplates`
--

CREATE TABLE `jlb1_adminTemplates` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(64) NOT NULL,
  `dir` varchar(128) NOT NULL,
  `isDefault` tinyint(1) NOT NULL default '0',
  `banner` varchar(128) NOT NULL,
  `horizSeperator` varchar(256) NOT NULL,
  `horizSeperator2` varchar(256) NOT NULL,
  `vertSeperator` varchar(256) NOT NULL,
  `creator` varchar(64) NOT NULL,
  `website` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jlb1_adminTemplates`
--

INSERT INTO `jlb1_adminTemplates` VALUES(1, 'Default', 'JasonBogleDefault/', 1, '/admin/templates/JasonBogleDefault/images/banners/JasonLBogle-2.png', '<span class="tMenuSeperator">&nbsp;</span>', '<span class="tMenuSeperator2">&nbsp;</span>', '', 'Jason Bogle', 'http://jasonlbogle.com', 'jason@jasonlbogle.com');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_categories`
--

CREATE TABLE `jlb1_categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `alias` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `jlb1_categories`
--

INSERT INTO `jlb1_categories` VALUES(0, 'Uncategorized', 'categories/Uncategorized');
INSERT INTO `jlb1_categories` VALUES(1, 'News', 'categories/News');
INSERT INTO `jlb1_categories` VALUES(2, 'Soccer', 'categories/Soccer');
INSERT INTO `jlb1_categories` VALUES(3, 'American Football', 'categories/American-Football');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_locations`
--

CREATE TABLE `jlb1_locations` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(32) NOT NULL,
  `ordering` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jlb1_locations`
--

INSERT INTO `jlb1_locations` VALUES(1, 'top bar', 'menu:1,menu:2,menu:3');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_menus`
--

CREATE TABLE `jlb1_menus` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(64) NOT NULL,
  `showTitle` tinyint(1) NOT NULL default '0',
  `location` int(11) NOT NULL default '1',
  `type` enum('horizontal','vertical') NOT NULL,
  `parentID` int(11) NOT NULL default '0',
  `parentType` enum('page','post','mod') NOT NULL default 'page',
  `parentMenuItem` int(11) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  `securelevel` int(11) NOT NULL default '0',
  `items` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jlb1_menus`
--

INSERT INTO `jlb1_menus` VALUES(1, 'Top Menu', 0, 1, 'horizontal', 0, 'page', 0, 1, 0, '1,2,3,4,5,6,7,8');
INSERT INTO `jlb1_menus` VALUES(2, 'About Menu', 0, 1, 'horizontal', 5, 'page', 6, 1, 0, '9,10,11,12,13,14');
INSERT INTO `jlb1_menus` VALUES(3, 'Resume Menu', 0, 1, 'horizontal', 6, 'page', 7, 1, 0, '15,16,17,18');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_menu_items`
--

CREATE TABLE `jlb1_menu_items` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL default '1',
  `type` enum('page','post','mod','external') NOT NULL default 'page',
  `title` varchar(64) NOT NULL,
  `url` varchar(32) NOT NULL,
  `target` enum('_parent','_blank') NOT NULL default '_parent',
  `securelevel` int(11) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  `subMenu` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `jlb1_menu_items`
--

INSERT INTO `jlb1_menu_items` VALUES(1, 1, 'page', 'Home', '/home', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(2, 2, 'page', 'Login/Register', '/loginregister', '_parent', 0, 0, 0);
INSERT INTO `jlb1_menu_items` VALUES(3, 2, 'page', 'Logout', '/logout', '_parent', 1, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(4, 3, 'external', 'Administrator', '/admin', '_blank', 3, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(5, 4, 'page', 'User CP', '/user-cp', '_parent', 1, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(6, 5, 'page', 'About', '/about', '_parent', 0, 1, 2);
INSERT INTO `jlb1_menu_items` VALUES(7, 6, 'page', 'Resume', '/resume', '_parent', 0, 1, 3);
INSERT INTO `jlb1_menu_items` VALUES(8, 7, 'page', 'Projects', '/projects', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(9, 5, 'external', 'The Fedora', '/about/#thefedora', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(10, 5, 'external', 'Beliefs', '/about/#beliefs', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(11, 5, 'external', 'The Cave', '/about/#thecave', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(12, 5, 'external', 'Education', '/about/#education', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(13, 5, 'external', 'Sports', '/about/#sports', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(14, 5, 'external', 'Clogging', '/about/#clogging', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(15, 6, 'external', 'Education', '/resume/#education', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(16, 6, 'external', 'Skills', '/resume/#skills', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(17, 6, 'external', 'Hobbies and Intterests', '/resume/#hobbies', '_parent', 0, 1, 0);
INSERT INTO `jlb1_menu_items` VALUES(18, 6, 'external', 'Contact Information', '/resume/#contact', '_parent', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_pages`
--

CREATE TABLE `jlb1_pages` (
  `id` int(4) NOT NULL auto_increment,
  `title` text NOT NULL,
  `alias` varchar(32) NOT NULL,
  `showTitle` tinyint(1) NOT NULL default '0',
  `content` text NOT NULL,
  `description` text NOT NULL,
  `showDescription` tinyint(1) NOT NULL default '0',
  `tags` text NOT NULL,
  `showTags` tinyint(1) NOT NULL default '0',
  `template` varchar(11) NOT NULL default 'default',
  `dateUpdated` datetime NOT NULL,
  `showDate` tinyint(1) NOT NULL default '0',
  `securelevel` int(11) NOT NULL default '0',
  `type` enum('page','blog','custom') NOT NULL default 'page',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `jlb1_pages`
--

INSERT INTO `jlb1_pages` VALUES(1, 'Home', 'home', 0, '<div>Welcome to my website!</div>\r\n<div>This is the home page, which divulges little insight into who I am. You can read the&nbsp;<a href=\\"/about\\">about</a>&nbsp;page to uncover a broader and more detailed picture of my life. The&nbsp;<a href=\\"/resume\\">resume</a>&nbsp;page will give you an idea of my professional skills. I also will upload personal&nbsp;<a href=\\"/projects\\">projects</a>&nbsp;to this website.</div>\r\n<div>So, basic info:\r\n<ul>\r\n<li>I am a Christian.</li>\r\n<li>I have a bachelor\\''s degree in computer scinence.</li>\r\n<li>I have Cerebral Palsy (CP).\r\n<ul>\r\n<li>My CP mainly affects my upper body.</li>\r\n<li>I write, type, play video games, and do just about everything else with my feet.</li>\r\n</ul>\r\n</li>\r\n<li>I love sports.</li>\r\n<li>My family is awesome. ... Be jealous.</li>\r\n</ul>\r\nAlso, you can checkout my other website,&nbsp;<a href=\\"http://thewordkeeper.com\\" target=\\"_blank\\">The Word Keeper</a>.<br /><a href=\\"http://thewordkeeper.com\\" target=\\"_blank\\"><img src=\\"/content/images/WK-banner-small.png\\" alt=\\"\\" /></a></div>', 'The home page of Jason Lee Bogle', 0, 'Jason Bogle, Jason L Bogle, Jason Lee Bogle, Cerebral Palsy, CP', 0, 'default', '2012-04-07 14:59:08', 0, 0, 'page', 1);
INSERT INTO `jlb1_pages` VALUES(2, 'Login or Register', 'loginregister', 0, '<?php \r\ninclude("login.php");\r\n\r\ninclude("register.php"); ?>', '', 0, '', 0, 'default', '2012-04-07 16:52:03', 0, 0, 'custom', 0);
INSERT INTO `jlb1_pages` VALUES(3, 'Admin Home', 'admin-home', 0, '<?php\r\nprint<<<scendx\r\n<script>\r\ntop.location = ''http://dev.jasonlbogle.com/admin/'';\r\n</script>\r\n<noscript>\r\n<p class="cent">You should have been redirected to the administrator control panel, but something went wrong. <a href="<?php echo $content_dir; ?>admin">Try again</a>.</p>\r\n</noscript>\r\nscendx\r\n;\r\nexit;\r\n?>', 'Admin Home link', 0, '', 0, 'default', '2012-04-07 00:00:00', 0, 2, 'custom', 0);
INSERT INTO `jlb1_pages` VALUES(4, 'User CP', 'user-cp', 0, '<?php\r\ninclude($php_function_dir."userCP.php");\r\n?>', 'User Control Panel', 0, '', 0, 'default', '2012-04-11 15:18:11', 0, 1, 'custom', 0);
INSERT INTO `jlb1_pages` VALUES(5, 'About', 'about', 0, '<div id=\\"thefedora\\" style=\\"clear: right;\\">\r\n<h3>The Fedora</h3>\r\n<img style=\\"float: left; margin: 10px;\\" src=\\"/content/images/me.png\\" alt=\\"\\" />\r\n<p>So, that\\''s me. Yes, I wear glasses and everything more than a foot away is blurry without them.</p>\r\n<p>My fedora is a little crooked in this picture. Speaking of the fedora, you\\''d be hardpressed to see me outside without one. That is, unless I\\''m playing soccer or clogging (you\\''ll learn about clogging further down the page) or doing some other physical activity. Why the fedora instead of a regular ball cap, you ask? I mainly like the fedora because it is easy to put on without the use of hands. I suppose a bowler hat would be too, but the fedora looks better.</p>\r\n<p>Why should it matter that the fedora is easy to put on without using hands? Well, my hands are ... troubled. I have Cerebral Palsy (CP). My CP affects mainly my upper body, so I do mostly everything with my feet. This website you are looking at was created by me typing with my feet. I also play video games and use remotes with my feet. (I\\''m pretty good at bowling on the Wii.) As to why I wear a hat: it\\''s to help shade my eyes and keep the rain off my glasses. Rain drops on glasses are annoying.</p>\r\n</div>\r\n<div id=\\"beliefs\\" style=\\"clear: left;\\">\r\n<h3>Beliefs</h3>\r\n<a href=\\"http://thewordkeeper.com\\"><img style=\\"float: right; margin: 10px;\\" src=\\"/content/images/wk.png\\" alt=\\"\\" /></a>\r\n<p>I am a Christian. I do believe that Jesus came to Earth and died for the sins of all. He is the Savior and Lord of my life. I was raised in a Southern Baptist church and I share many of the doctrinal beliefs of the traditional Southern Baptist.</p>\r\n<p>One of those beliefs is that everyone can be saved. Another is that we all have a role to play in the body of Christ. I contribute to this through church and my website, <a href=\\"http://thewordkeeper.com\\">The Word Keeper (WK)</a>. On WK, I post my notes from the morning sermon at my church. There are times when I neglect the website, but I intend to be more consistent in keeping it updated from now on.</p>\r\n</div>\r\n<div id=\\"thecave\\" style=\\"clear: right;\\">\r\n<h3>The Cave</h3>\r\n<img style=\\"float: left; margin: 10px;\\" src=\\"/content/images/thecave.png\\" alt=\\"\\" />\r\n<p>It\\''s hard to type with one\\''s feet at a regular desk. So I designed a custom desk using Google Sketchup and my dad constructed it for me. It was originally just a board, pretty much, that set on the end of a chase lounge. We have added a shelf to the back of it so I could use a second monitor. The shelf is also nice to have for putting other things on, like games or pens or whatever else. This corner of my room has been named \\"The Cave\\" by my family.</p>\r\n<p>You might notice the PS3 in the picture. I enjoy video games. My favorite games are sports games, racing games, and RPGs. I\\''m not too good at shooting games, but I do find them fun to play from time to time. Madden, Fifa, and Gran Turismo are my three favorites. I\\''m not the greatest at any of these games, but I can hang with most people, especially in Madden. Playing in an online league has improved my Madden skills this year for sure.</p>\r\n<p>I have another design in the works for a gaming and computer cabinet. I originally designed it to hold a PS3, but then the PS4 was announced and I need to check its dimensions so the cabinet can be made to accommodate one.</p>\r\n</div>\r\n<div id=\\"education\\" style=\\"clear: left;\\">\r\n<h3>Education</h3>\r\n<img style=\\"float: right; margin: 10px;\\" src=\\"/content/images/mtsuclip.png\\" alt=\\"\\" />\r\n<p>I graduated from Middle Tennesse State University (MTSU) in May 2013. My degree is a Bachelor of Science in Computer Science (CS). My final GPA was 3.769. Most of my non-A grades were in classes that weren\\''t CSclasses. The CS teachers at MTSU are awesome. The CS students were all pretty cool too. We had some fun times in most of my classes.</p>\r\n<p>Most people get a ring when they graduate. I don\\''t do good with rings. So I designed a clip. Well, I designed the printed part. I know it\\''s a money clip, but my intentions are to find a way to clip it to my fedora.</p>\r\n</div>\r\n<div id=\\"sports\\" style=\\"clear: right;\\">\r\n<h3>Sports</h3>\r\n<img style=\\"float: left; margin: 10px;\\" src=\\"/content/images/sports.png\\" alt=\\"\\" />\r\n<p>I love sports. I love competition and I love having fun. My favorite sport is soccer, which I started playing at a ripe of age of 4. I was pretty good in recreational leagues, but could never make it on a select team really. I know how to play and am not bad at the strategy portion or passing. I just never had the physical prowess to be really good. I still love it though. In fact, we have an alumni game coming up at my high school I plan to play in.</p>\r\n<p>I don\\''t really have a favorite club team. If I ever live somewhere that has a pro team, that team will likely become my favorite, I hope Tennessee gets one soon. My support goes to the U.S. National teams. I love rooting the men and women who represent our nation in soccer games. I also like seeing the progress that soccer has made in the U.S. over the years. Soccer has grown greatly in the last couple of decades and just continues to gain fans. Soccer needs to be aired on local networks more though, like NFL games are.</p>\r\n<p>Speaking of the NFL, I love football too. My favorite team is the Tennessee Titans of course, followed closely by the MTSU Blue Raiders and Tennessee Volunteers. I don\\''t really dislike any teams because I don\\''t see the point in it. I\\''m a fan of the sport and can enjoy any football game as long as there is good officiating. Bad officiating can ruin a game, and that goes for soccer too.</p>\r\n</div>\r\n<div id=\\"clogging\\" style=\\"clear: left;\\">\r\n<h3>Clogging</h3>\r\n<div style=\\"float: right; margin: 10px;\\">[youtube=http://www.youtube.com/watch?v=Wew8ZYx2LEQ&amp;w=420&amp;h=315]</div>\r\n<p>Clogging is similar to tap dancing. The taps on the shoes are different tap seems to use more hand movements, although clogging is beginning to use more hand movements as well. Clogging is also becoming more like hip-hop dancing if you watch some of the big competition groups.</p>\r\n<p>I\\''ve been clogging since I was about 10. I started because I hoped it would improve my soccer skills. The first group I danced with (and where I learned to clog) danced to country and bluegrass music but has since disbanded. Now I dance with the Heaven Bound Cloggers. We dance to mostly Christian music and our mission is to spread the love of God through dancing.</p>\r\n<p>The video to the side is our latest Smoky Mountain Encore performance. I\\''m the guy with the little solo.</p>\r\n</div>', 'Learn about Jason', 0, '', 0, 'default', '2012-04-07 19:33:54', 0, 0, 'page', 1);
INSERT INTO `jlb1_pages` VALUES(6, 'Resume', 'resume', 0, '<div><a href=\\"http://www.linkedin.com/pub/jason-bogle/74/a42/73a\\" target=\\"new\\"> <img src=\\"http://www.linkedin.com/img/webpromo/btn_viewmy_160x25.png\\" alt=\\"View Jason Bogle\\''s profile on LinkedIn\\" /></a> --<a href=\\"/content/JasonBogleLinkedIn.pdf\\" target=\\"new\\"> Download the PDF version</a>. <br /> <a href=\\"http://www.resume.com/Jason__Bogle/jason-bogles-resume\\" target=\\"new\\"> View resume on Resume.com</a> or <a href=\\"/content/JasonBogleResume.pdf\\" target=\\"new\\"> Download the PDF version</a></div>\r\n<div>\r\n<h2>General Resume</h2>\r\n<h3 id=\\"education\\">Education</h3>\r\n<p>Middle Tennessee State University<br /> Middle Tennessee State University, Murfreesboro, Tennessee<br /> Graduated: May 2013<br /> Final GPA: 3.769<br /> Degree Completed: Bachelor of Science<br /> Program: Computer Science - Professional<br /> <br /> Through my four years at MTSU, which uses C++ as the main language for teaching, I made the dean\\''s list in each of my last six semesters. I was awarded scholarships from the Computer Science Department each of my last three years. As a senior, I was inducted into the Upsilon Pi Epsilon organization. Some of the classes I took and excelled in include:</p>\r\n<ul>\r\n<li>Python</li>\r\n<li>Parallel Processing</li>\r\n<li>Artificial Intelligence</li>\r\n<li>Theory of Programming Languages</li>\r\n<li>Software Engineering</li>\r\n</ul>\r\n<p>These classes, as well as the other classes not listed, have prepared me for a job in the computer software field.</p>\r\n<h3 id=\\"skills\\">Skills</h3>\r\n<ul>\r\n<li>C/C++</li>\r\n<li>Python</li>\r\n<li>Ruby</li>\r\n<li>Parallel Programming</li>\r\n<li>PHP</li>\r\n<li>HTML</li>\r\n<li>CSS</li>\r\n<li>JavaScript</li>\r\n<li>Java</li>\r\n</ul>\r\n<h3 id=\\"hobbies\\">Hobbies and Interests</h3>\r\n<p>I enjoy sports of all kinds, especially soccer, football, and motor racing. I also dance with a christian clogging group and play some video games. You can learn more about me on the other pages of this website.</p>\r\n<h3 id=\\"contact\\">Contact Information</h3>\r\n<p>Email: jason@jasonlbogle.com<br /> <br /> Email really is the best way to contact me because my speech is somewhat impaired due to my Cerebral Palsy. If you need to call me, send me an email with the number you will be calling from first and I will send you my number.<br /> <br /> If you need references, let me know and I can send them to you.</p>\r\n</div>', 'Jason''s Resume', 0, '', 0, 'default', '2012-04-07 19:37:02', 0, 0, 'page', 1);
INSERT INTO `jlb1_pages` VALUES(7, 'Projects', 'projects', 0, '<h2>Dance Group Manager</h2>\r\n<p><img style=\\"float: left; margin: 10px;\\" src=\\"/content/projects/Dance Group Manager/icon.png\\" alt=\\"\\" /></p>\r\n<p>This desktop application is great for managing a dance group and deciding which routines to perform at the next show. Simply add all your dancers and songs then generate a show lineup based on which dancers are going and how long the show is supposed to last.</p>\r\n<h3>Download</h3>\r\n<h4>Version 0.1 (June 2013)</h4>\r\n<ul>\r\n<li style=\\"line-indent: 20px;\\">Windows 32-bit Installer: <a href=\\"/content/projects/Dance%20Group Manager/DanceGroupManagerSetup32-0_1.exe\\">Download</a></li>\r\n<li>Windows 64-bit Installer: <a href=\\"/content/projects/Dance%20Group Manager/DanceGroupManagerSetup64-0_1.exe\\">Download</a></li>\r\n</ul>\r\n<h2 style=\\"clear: both;\\">Unnamed Content Management System</h2>\r\n<p>I am currently developing a content management system (CMS), which this site uses. I am writing it in php/html5/css/js. It\\''s coming along nicely I think. I am aiming for a simple CMS that anyone can use easily, but am also attempting to make it where experienced web developers can use it for powerful applications. ... I need a name for it though. If you have any ideas, send them to me on twitter @JasonLBogle.&nbsp;</p>\r\n<p style=\\"clear: both;\\">I won\\''t stop you from supporting the development of free software. ;-)</p>\r\n<p><img src=\\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\\" alt=\\"\\" width=\\"1\\" height=\\"1\\" border=\\"0\\" /></p>', 'Jason''s Projects', 0, '', 0, 'default', '0000-00-00 00:00:00', 0, 0, 'page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_post-category-relationships`
--

CREATE TABLE `jlb1_post-category-relationships` (
  `id` int(11) NOT NULL auto_increment,
  `category` int(11) NOT NULL default '0',
  `post` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `jlb1_post-category-relationships`
--

INSERT INTO `jlb1_post-category-relationships` VALUES(13, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_posts`
--

CREATE TABLE `jlb1_posts` (
  `id` int(4) NOT NULL auto_increment,
  `title` text NOT NULL,
  `alias` varchar(32) NOT NULL,
  `showTitle` tinyint(1) NOT NULL default '0',
  `content` text NOT NULL,
  `description` text NOT NULL,
  `showDescription` tinyint(1) NOT NULL default '0',
  `tags` text NOT NULL,
  `showTags` tinyint(1) NOT NULL default '0',
  `template` varchar(11) NOT NULL default 'default',
  `dateUpdated` datetime NOT NULL,
  `showDate` tinyint(1) NOT NULL default '0',
  `securelevel` int(11) NOT NULL default '0',
  `type` text NOT NULL,
  `publish` tinyint(1) NOT NULL default '1',
  `status` enum('published','unpublished') NOT NULL default 'unpublished',
  `categories` varchar(128) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `jlb1_posts`
--

INSERT INTO `jlb1_posts` VALUES(1, 'Lorem Ipsum', 'post/07/22/13/test-post', 1, '<p>In facilisis scelerisque dui vel dignissim. Sed nunc orci, ultricies congue vehicula quis, facilisis a orci. In aliquet facilisis condimentum. Donec at orci orci, a dictum justo. Sed a nunc non lectus fringilla suscipit. Vivamus pretium sapien sit amet mauris aliquet eleifend vel vitae arcu. Fusce pharetra dignissim nisl egestas pretium.</p>\r\n<p>Etiam aliquam sem ac velit feugiat elementum. Nunc eu elit velit, nec vestibulum nibh. Curabitur ultrices, diam non ullamcorper blandit, nunc lacus ornare nisi, egestas rutrum magna est id nunc. Pellentesque imperdiet malesuada quam, et rhoncus eros auctor eu. Nullam vehicula metus ac lacus rutrum nec fermentum urna congue. Vestibulum et risus at mi ultricies sagittis quis nec ligula. Suspendisse dignissim dignissim luctus. Duis ac dictum nibh. Etiam id massa magna. Morbi molestie posuere posuere.</p>\r\n<p>Maecenas eu placerat ante. Fusce ut neque justo, et aliquet enim. In hac habitasse platea dictumst. Nullam commodo neque erat, vitae facilisis erat. Cras at mauris ut tortor vestibulum fringilla vel sed metus. Donec interdum purus a justo feugiat rutrum. Sed ac neque ut neque dictum accumsan. Cras lacinia rutrum risus, id viverra metus dictum sit amet. Fusce venenatis, urna eget cursus placerat, dui nisl fringilla purus, nec tincidunt sapien justo ut nisl. Curabitur lobortis semper neque et varius. Etiam eget lectus risus, a varius orci. Nam placerat mauris at dolor imperdiet at aliquet lectus ultricies. Duis tincidunt mi at quam condimentum lobortis.</p>\r\n<p>Proin suscipit luctus orci placerat fringilla. Donec hendrerit laoreet risus eget adipiscing. Suspendisse in urna ligula, a volutpat mauris. Sed enim mi, bibendum eu pulvinar vel, sodales vitae dui. Pellentesque sed sapien lorem, at lacinia urna. In hac habitasse platea dictumst. Vivamus vel justo in leo laoreet ullamcorper non vitae lorem. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin bibendum ullamcorper rutrum.</p>\r\n<div style=\\"display: none;\\"><a href=\\"http://slipsum.com\\">lorem ipsum</a></div>\r\n<p>&nbsp;</p>', 'Proin ut quam eros. Donec sed lobortis diam. Nulla nec odio lacus. Quisque porttitor egestas dolor in placerat. Nunc vehicula dapibus ipsum. Duis venenatis risus non nunc fermentum dapibus. Morbi lorem ante, malesuada in mollis nec, auctor nec massa. Aenean tempus dui eget felis blandit at fringilla urna ultrices. Suspendisse feugiat, ante et viverra lacinia, lectus sem lobortis dui, ultricies consectetur leo mauris at tortor. Nunc et tortor sit amet orci consequat semper. Nulla non fringilla diam. ', 0, '', 0, 'default', '2013-08-23 20:24:28', 0, 0, '', 1, 'published', '1');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_templates`
--

CREATE TABLE `jlb1_templates` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `dir` varchar(128) NOT NULL,
  `isDefault` tinyint(1) NOT NULL default '0',
  `banner` varchar(128) NOT NULL,
  `horizSeperator` varchar(256) NOT NULL,
  `horizSeperator2` varchar(256) NOT NULL,
  `vertSeperator` varchar(256) NOT NULL,
  `creator` varchar(64) NOT NULL,
  `website` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jlb1_templates`
--

INSERT INTO `jlb1_templates` VALUES(1, 'Default', 'JasonBogleDefault/', 1, '/templates/JasonBogleDefault/images/banners/JasonLBogle-2.png', '<span class="tMenuSeperator">&nbsp;</span>', '<span class="tMenuSeperator2">&nbsp;</span>', '', 'Jason Bogle', 'http://jasonlbogle.com', 'jason@jasonlbogle.com');

-- --------------------------------------------------------

--
-- Table structure for table `jlb1_users`
--

CREATE TABLE `jlb1_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `gender` set('male','female') NOT NULL,
  `location` varchar(256) NOT NULL,
  `password` varchar(32) NOT NULL,
  `verCode` varchar(96) NOT NULL,
  `securitylevel` tinyint(1) NOT NULL default '0',
  `usertype` set('member','moderator','administrator') NOT NULL default 'member',
  `suspended` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jlb1_users`
--

INSERT INTO `jlb1_users` VALUES(1, 'Jason Bogle', 'jason@jasonlbogle.com', '', '0000-00-00', '', '', '0c6b50eb2c0b5a4e5ce9af1090279f71', '3768997cbe09c0e4860826e39734fb83d41d8cd98f00b204e9800998ecf8427ed41d8cd98f00b204e9800998ecf8427e', 3, 'administrator', 0);
