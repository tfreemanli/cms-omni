<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Omnitech Stock Management System</title>
	<link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="./css/jquery.tabs.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<style type="text/css">@import url(./scripts/jscalendar/skins/aqua/theme.css);</style>
	<script type="text/javascript" src="./scripts/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="./scripts/jscalendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="./scripts/jscalendar/calendar-setup.js"></script>
	
	<script src="./scripts/jquery-1.2.6.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="./scripts/jquery.tabs.pack.js" type="text/javascript" charset="utf-8"></script>
	
	<script src="./scripts/common.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="top">
				<img id="earth" src="./images/earth.jpg" />
				<img id="logo" src="./images/logo.jpg" />
				<ul id="help_link">
					<li><a href="../repair/fb_list.php">help</a></li>
					<li><a href="../repair/fb_list.php">contact us</a></li>				
				</ul>
			</div>
			<div id="top_bar">
				<img class="right" src="./images/bar_r.jpg" />
				<?php if (isset($_SESSION['uid']) && isset($_SESSION['name'])): ?>
				<div id="userCtrl" class="right">
					Login: <?php echo $_SESSION['name']; ?> | <a href="<?php echo url('index', 'logout'); ?>">Logout</a>
				</div>	
				<?php endif ?>		
				<img src="./images/bar_l.jpg" />
				
			</div>
		</div>
		
		
		
		