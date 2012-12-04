<?php
//error_reporting(-1);
session_start();
include('db.php');

if(!isset($login_req)) $login_req = false;
if(!isset($_SESSION['isAuthenticated'])) $_SESSION['isAuthenticated'] = false;
if($login_req == true && $_SESSION['isAuthenticated'] == false)
{
	header('Location: login.php');
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" /> <!-- RESET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" /> <!-- MAIN STYLE SHEET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" /> <!-- GRAPHIC THEME -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/switcher.js"></script>
	<script type="text/javascript" src="js/toggle.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.tabs.js"></script>
	<script src="js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
	<link href="css/excite-bike/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
	<script type="text/javascript">
	$(document).ready(function(){
		$(".tabs > ul").tabs();
	});
	(function () {
	  var head = document.getElementsByTagName("head")[0], script;
	  script = document.createElement("script");
	  script.type = "text/x-mathjax-config";
	  script[(window.opera ? "innerHTML" : "text")] =
	    "MathJax.Hub.Config({\n" +
	    "  tex2jax:  {  inlineMath: [['$','$'], ['\\\\(','\\\\)']] }\n" +
	    "});"
	  head.appendChild(script);
	  script = document.createElement("script");
	  script.type = "text/javascript";
	  script.src  = "http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML";
	  head.appendChild(script);  
	})();
	</script>
	<title><?php if(isset($_title)) echo $_title . " - "; ?>CS188.2z: Artificial Intelligence</title>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6614345-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body>

<div id="main">
	<!-- Tray -->
	<div id="tray" class="box">
		<p class="f-left box">
			<!-- Switcher -->
			<!--<span class="f-left" id="switcher">
				<a href="#" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="design/switcher-1col.gif" alt="1 Column" /></a>
				<a href="#" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="design/switcher-2col.gif" alt="2 Columns" /></a>
			</span>-->
			<strong>CS188.2z: Artificial Intelligence</strong>
		</p>
		<p class="f-right">
			<?php if ($_SESSION['isAuthenticated']) { ?>
				User: <strong><a href="progress.php"><?=$_SESSION['email']?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="logout.php" id="logout">Log out</a></strong>
			<?php } else { ?>
				<strong><a href="login.php" id="logout">Log in</a></strong>
			<?php } ?>
		</p>
	</div> <!--  /tray -->

	<hr class="noscreen" />

	<!-- Menu -->
	<div id="menu" class="box">

		<ul class="box">
			<li <?php if ($_page == 'courseware') { ?>id="menu-active"<?php } ?>><a href="courseware.php"><span>Courseware</span></a></li> <!-- Active -->
			<li <?php if ($_page == 'info') { ?>id="menu-active"<?php } ?>><a href="info.php"><span>Updates and Info</span></a></li>
			<li <?php if ($_page == 'discussion') { ?>id="menu-active"<?php } ?>><a href="discussion.php"><span>Discussion</span></a></li>
			<li <?php if ($_page == 'progress') { ?>id="menu-active"<?php } ?>><a href="progress.php"><span>Progress</span></a></li>
		</ul>

	</div> <!-- /header -->
	
	<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">
