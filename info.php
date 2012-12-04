<?php $login_req = false; $_title = 'Course Updates'; $_page = 'info'; $_subpage = 'updates'; require_once('header.php'); include('main_left_nav.php'); ?>
		<hr class="noscreen" />
		
	<!-- Content (Right Column) -->
		<div id="content" class="box">	
			<h1 id="page-title">Course Updates</h1>
			<br /><?php if ($_SESSION['isAuthenticated'] == false) { ?>
<a href="login.php" id="loginreglink">Login / Register</a>
<script type="text/javascript">
	$('#loginreglink').button();
</script>
<?php } ?>
<br />
			<?php
			
			$res = $db->Execute('SELECT * FROM info_updates ORDER BY dtposted DESC');
			
			foreach ($res as $post)
			{
			$dt = new DateTime($post['dtposted']);
			
			?>
			
				<div style="font-size: large; text-transform: capitalize; font-weight: bolder; width: 20%; float: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date_format($dt, 'F d'); ?></div>
				<div style="font-size: 18px; float: right; width: 80%;"><?=$post['text']?></div>
				
				<div style="clear: both;"><br /><hr /><br /></div>
			
			<?php } ?>
			
			<div class="content-right">
			<div style="text-align: center;">
				<div style="margin: 10px"><!-- Place this tag where you want the +1 button to render -->
			<div class="g-plusone" data-size="tall" data-annotation="inline" data-width="200" data-href="http://cs1882z.amolbhave.in"></div>
			
			<!-- Place this render call where appropriate -->
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script></div>
			
			<div style="text-align: center">
			</div>
			</div>
			
			<br style="clear:both;"/>

		</div>
<?php require_once('footer.php'); ?>
