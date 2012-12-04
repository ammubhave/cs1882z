<?php $_title = 'Discussion'; $_page = 'discussion'; require_once('header.php'); ?>
<?php

if(isset($_GET['url'])) $href = $_GET['url'];
else $href = 'https://www.edx.org/courses/BerkeleyX/CS188.1x/2012_Fall/discussion/forum';

?>
<div id="content" class="box">

<style>
	.textbook-nav ul{
	height: 100%;
	display: inline-block;
	margin: 0;
	padding: 0;
	width: 100%;
}
.textbook-nav li {
	list-style: none;
	display: inline-block;
	background-color: white;
	height: 100%;
	margin: 0;
	line-height: 100%;
	width: 20%;
</style>

<div class="textbook-nav">

	If you see a 'Page not Found' page: <a id="login-mitx" style="display: inline-block; font-size: small; height: auto; width: auto" href="#">edX Login</a>

	<script type="text/javascript">
			$('#login-mitx').button();
			$('#login-mitx').click(function () {
				$('#dialog').dialog('open');
			});
	</script>
	<div id="dialog" title="Login to edX">
		If you see a 404 Error page below instead of the discussion forum, you have to login to edX website.<br /><br />
		You will redirected to edX main page where you have to login. After logging in, you can close the that window and refresh this page.
		<br /><br />
		<a id="login-mitx-sub" style="font-size: small; height: auto; width: auto" href="https://www.edx.org/" target="_blank">Goto edX main page to login.</a>
		<br /><br />
		<a id="refresh" style="font-size: small; height: auto; width: auto" href="/ai/discussion.php">Refresh this page</a> (click after you have logged in to edX and closed the window)
	</div>
	<script type="text/javascript">
		$('#dialog').dialog({ autoOpen: false, width: '500px' });
		$('#login-mitx-sub').button();
		$('#refresh').button();
	</script>

</div>
<div style="overflow: hidden; width: 100%; height: 1000px">
 <iframe name="textbook-frame" style="margin-top: -50px;" src="<?=$href?>" width="100%" height="100%" marginheight="0"></iframe>
</div>

</div>
<?php require_once('footer.php'); ?>