<?php session_start();
include('db.php');

$seq_id = mysql_real_escape_string($_GET['id']);

$seq = $db->GetRow("SELECT * FROM cw_sequences WHERE id=?", array($_GET['id']));
$sseq = $db->GetRow("SELECT * FROM cw_subsequences WHERE sequence=? AND id=?", array($_GET['id'], $_GET['sid']));



?>
<div>
	<!-- Navigation -->
	<div>
		<?php
		
		$res = $db->Execute("SELECT * FROM cw_subsequences WHERE sequence=? ORDER BY oindex", array($_GET['id']));
		foreach($res as $sseq2)
		{
				
		?>
			<a href="#" id="sseq<?=$sseq2['id']?>" style="width: <?=(100/$res->RecordCount())-1?>%; padding: 0; margin: 0;" title="<?=$sseq2['name']?>" onclick="$('#content').load('cw_content.php?id=<?=$_GET['id']?>&sid=<?=$sseq2['id']?>');">
			<?php 
			$icon = 'ui-icon-video';
			if ($sseq2['type'] == 1)
				echo "Video";
			else if($sseq2['type'] == 2)
			{	echo "Exercise"; $icon = 'ui-icon-document'; }
			else if($sseq2['type'] == 4)
			{	echo "Text"; $icon = 'ui-icon-comment';}
		 ?></a>
		 <script type="text/javascript">
		 	$('#sseq<?=$sseq2['id']?>').button({ icons: {primary: '<?=$icon?>'}, text: false});		 	
		 </script>
			<?php } ?>
	</div>
	
	
	<h3><?=$sseq['name']?></h3>
	
		<?php if ($sseq['type'] == 1) {		
			$video = $db->GetRow("SELECT * FROM cw_seqlectures WHERE subsequence='" . $sseq['id'] . "'");
			
		?>
		<div>
		<script>
		
		
		
		</script>
				
				<script type="text/javascript">
					function updateHTML(elmId, value) {
				        document.getElementById(elmId).innerHTML = value;
				      }
				      
				      // This function is called when an error is thrown by the player
				      function onPlayerError(errorCode) {
				        alert("An error occured of type:" + errorCode);
				      }
				      
				      // This function is called when the player changes state
				      function onPlayerStateChange(newState) {
				      //  updateHTML("playerState", newState);
				      	if (newState == 1)
				      	{
				      		$('#btnPlay').hide();
				      		$('#btnPause').show();	
				      	}
				      	else if(newState == 2 || newState == 0)
				      	{
				      		$('#btnPlay').show();
				      		$('#btnPause').hide();
				      	}
				      }
      
					function updatePlayerInfo() {
				        // Also check that at least one function exists since when IE unloads the
				        // page, it will destroy the SWF before clearing the interval.
				        if(ytplayer && ytplayer.getDuration) {
				   
				          //updateHTML("videoDuration", ytplayer.getDuration());
				          currTime = ytplayer.getCurrentTime() - <?=$video['start_time']?>;
				           $('#slider').slider( { 'value':currTime } );
				          
				          mins = Math.floor(currTime / 60);
				          mins = mins.toString();
				          secs = Math.floor(currTime % 60);
				          if (secs < 10) {
				          	secs = "0" + secs.toString();
				          } else {
				          	secs = secs.toString();
				          }
				          updateHTML("videoCurrentTime", mins + ":" + secs );
				          
				         
				          //updateHTML("bytesTotal", ytplayer.getVideoBytesTotal());
				          //updateHTML("startBytes", ytplayer.getVideoStartBytes());
				          //updateHTML("bytesLoaded", ytplayer.getVideoBytesLoaded());
				          //updateHTML("volume", ytplayer.getVolume());
				        }
				      }
				        // Allow the user to set the volume from 0-100
				      function setVideoVolume() {
				        var volume = parseInt(document.getElementById("volumeSetting").value);
				        if(isNaN(volume) || volume < 0 || volume > 100) {
				          alert("Please enter a valid volume between 0 and 100.");
				        }
				        else if(ytplayer){
				          ytplayer.setVolume(volume);
				        }
				      }
				      
				      function playVideo() {
				        if (ytplayer) {
				          ytplayer.playVideo();
				        }
				      }
				      
				      function pauseVideo() {
				        if (ytplayer) {
				          ytplayer.pauseVideo();
				        }
				      }
				      
				      function muteVideo() {
				        if(ytplayer) {
				          ytplayer.mute();
				        }
				      }
				      
				      function unMuteVideo() {
				        if(ytplayer) {
				          ytplayer.unMute();
				        }
				      }
				      
					function onYouTubePlayerReady(playerId) {
				        ytplayer = document.getElementById("ytPlayer");
				        // This causes the updatePlayerInfo function to be called every 250ms to
				        // get fresh data from the player
				        setInterval(updatePlayerInfo, 1000);
				     //   updatePlayerInfo();
				        ytplayer.addEventListener("onStateChange", "onPlayerStateChange");
				        ytplayer.addEventListener("onError", "onPlayerError");
				        //Load an initial video into the player
				        //ytplayer.cueVideoById("NKv_XFmCxiE");
				        ytplayer.cueVideoById({'videoId': '<?=$video['video_code']?>', 'startSeconds': <?=$video['start_time']?>, 'endSeconds': <?=$video['end_time']?>, 'suggestedQuality': 'default'});
				        $('#volslider').slider({'value': ytplayer.getVolume()});				        
				    
				      }
				      
				</script>
				
				<object data="http://www.youtube.com/apiplayer?version=3&amp;enablejsapi=1&amp;playerapiid=player1" id="ytPlayer" 
				type="application/x-shockwave-flash" height="487" width="795"><param value="always" name="allowScriptAccess"></object>
				<div id="controls" style="background-color: lightgray;">
				<button id="btnPlay">Play</button><button id="btnPause">Pause</button>&nbsp;&nbsp;&nbsp;
				<div style="width: 650px; display: inline-block;" id="slider"></div>&nbsp;&nbsp;
				<span id="videoCurrentTime" style="font-size: 25px;"></span>&nbsp;&nbsp;&nbsp;&nbsp;<div style="width: 50px; display: inline-block;" id="volslider"></div>
				</div>
				<script>
				
					$( function () {
				 	ytplayer = document.getElementById("ytPlayer");
				 	$('#ytPlayer').width($('#controls').width() - 20);
				 	$('#ytPlayer').height(($('#controls').width() - 20) * 325 / 530);				 		   
			        $("#slider").width($('#controls').width() - 250);
				 	});
				 	$('#btnPlay').button({
			            icons: {
			                primary: "ui-icon-play"
			            },
			            text: false
			        }).click(function () { playVideo(); });
			        $('#btnPause').hide();
			        $('#btnPause').button({
			            icons: {
			                primary: "ui-icon-pause"
			            },
			            text: false
			        }).click(function () { pauseVideo(); });		
				    $( "#slider" ).slider( {
				     	min: 0,
				        max: <?php echo $video['end_time'] - $video['start_time'] ?>,
				        step: 1,
				        slide: function(event, ui) { 
//				        	 ytplayer = document.getElementById("ytPlayer");
				        	 ytplayer.seekTo(ui.value, false);
				        },
				        stop: function(event, ui) {
				        //	ytplayer.seekTo(<?=$video['start_time']?> + ui.value, true);
				        }
				    } );
				     $( "#volslider" ).slider( {
				     	min: 0,
				        max: 100,
				        step: 1,
				        slide: function(event, ui) { 
//				        	 ytplayer = document.getElementById("ytPlayer");
				        	 ytplayer.setVolume(ui.value);				        }
				    } );

				    
				 </script>
				 
				 

				<!--<embed src="http://ocw.mit.edu/jw-player-free/player.swf"
				 flashvars="file=<?=$video['url']?>?wmode=transparent"
				 allowfullscreen=true allowscriptaccess=always id=player1 name=player1 height=325 width="100%" wmode="Opaque"></embed>
				 <script>
				 	$('#player1').height($('#player1').width() * 325 / 530);
				 </script>-->
		</div>	
		<div>
			<?=$sseq['details']?>			
		</div>
		
		<?php } else if ($sseq['type'] == 2) { //excercises
		
		$quescount = $db->Execute("SELECT COUNT(DISTINCT qno) FROM cw_seqques2 WHERE subsequence=?", array($sseq['id']));
		$quescount = $quescount->FetchRow();
		$quescount = intval($quescount[0]);
		
		for ($qno = 1; $qno <= $quescount; $qno++)
		{
			$res = $db->Execute("SELECT * FROM cw_seqques2 WHERE subsequence=? AND qno=? ORDER BY oindex ASC", array($sseq['id'], $qno));
			?>			
			<div>
			   	<?=$sseq['details']?>
			   	<br />
				<?php
				$qids = array();
				foreach ($res as $q) {
				?>
					<?php if ($q['name']!='') { ?><h3><?=$q['name']?></h3><?php }
					
					$text = $q['text'];
					
					$border_style = 'thin blue solid';
					if($q['type'] != 4) 
					{
						array_push($qids, $q['id']);
						$sub = $db->GetRow("SELECT * FROM cw_submissions WHERE ques=? AND user=?", array($q['id'], $_SESSION['uid']));
						$check_text = '<span id="check' . $q['id'] . '" style="font-size: large">';
			 			if($sub['id'] != 0)
			 			{
							if ($sub['status'] == 1)
							{ 
								$check_text .= '<span style="color:lime; font-weight: 900;">&#x2714;</span>';
								$border_style = 'thin lime solid';
					     	} else {
					     		$check_text .= '<span style="color:red; font-weight: 900;">X</span>';
					     		$border_style = 'thin red solid';
							}
							//$check_text .= '<span style="font-size: x-small;">' . ($sub['count']+1) . '</span>';
						}					
						$check_text .= '</span>';
						$text = str_replace('###SUBMISSION_BOX###', $check_text, $text);
					}
					
					if($q['type'] == 0 || $q['type'] == 1 || $q['type'] == 6) 
					{
					
						
						$input_box = '<input type="text" style="border: ' . $border_style . '; font-size: larger" name="answer' . $q['id'] . '" id="answer' . $q['id'] . '" value="' . $sub["answer"] .'" />';
						$text = str_replace('###TEXT_BOX###', $input_box, $text);
						
						//						<input type="text" style="border: thin blue solid; font-size: larger" name="answer<?=$q['id']" id="answer<?=$q['id']" value="<?=$sub['answer']" /> 
			 
						//<script type="text/javascript">$('#submit<?=$q['id']').button();</script>
						
					}
					else if ($q['type'] == 3) { ?>
						<input id="show<?=$q['id']?>" type="button" onclick="$(this).hide(); $('#check<?=$q['id']?>').load('/cw_check.php?id=<?=$q['id']?>'); $('#hide<?=$q['id']?>').show() " value="Show Answer" />
						<input id="hide<?=$q['id']?>" type="button" onclick="$(this).hide(); $('#check<?=$q['id']?>').html(''); $('#show<?=$q['id']?>').show()" value="Hide Answer" />
					<?php
					}					
					
					echo $text;					
				} 
				
				?>
				<br />
				<input type="button" style="font-size: small" id="submit<?=$qno?>" onclick="<?php				
				
				foreach ($qids as $qid)
				{
					echo "$('#check" . $qid . "').html('<img src=\'/media/images/loading.gif\' />');";
					echo "$('#check" , $qid . "').load('cw_check2.php?id=" . $qid . "&ans=' + encodeURIComponent($('#answer" . $qid . "').val()));";
				}
				
				?>" value="Check" />
				<script type="text/javascript">				
				$('#submit<?=$qno?>').button();				
				</script>				
			</div>
	<?php }
		

		 } else if ($sseq['type'] == 4) { ?>
		<div style="overflow:hidden">
		<?=$sseq['details']?>
		</div>
		<?php } ?>
		
</div>
					<script>
		 		   

					MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
					</script>
