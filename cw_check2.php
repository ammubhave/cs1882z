<?php 
session_start();
include('db.php');
//$_GET['ans'] = str_replace(' ', '', $_GET['ans']);
//$_GET['ans'] = preg_replace('/\s*/m', '', $_GET['ans']);
$q_id = mysql_real_escape_string($_GET['id']);
$q = $db->GetRow("SELECT * FROM cw_seqques2 WHERE id='" . $q_id . "'");

$graded = 1;
if(time() - strtotime($q['due']) > 0)
{
	//echo 'Due';
//	$graded = 0;
}

$aans = $_GET['ans'];
if($q['type'] == 6)
{
	preg_match_all('/\((.*?)\)=(.*?)\|/', $q['answer'], $res, PREG_SET_ORDER);
	//print_r($res);
	foreach($res as $r)
	{//print_r ($r);
		$aans = str_replace($r[1], $r[2], $aans);
		if($r[1] == 'answer')
			$q['answer'] = $r[2];	
	}
	//print $aans;
	$q['type'] = 0;
}

if($q['type'] == 0)
{
	
	$correct = false;
	$evalu = json_decode(file_get_contents('https://6002x.mitx.mit.edu/calculate?equation=' . str_replace('%20', '%2B', rawurlencode($aans))));
	if ($evalu->{'result'} == 'Invalid syntax')
	{
		?><span style="color:yellow; font-weight: 900;"?>!</span><script>$("#answer<?=$q_id?>").css("border", "thin gold solid");</script><?php
		exit();
	}

	$ans = floatval($evalu->{'result'});
	$cans = floatval($q['answer']);

	if(abs($cans-$ans) < 0.001)
	{
		$correct = true;
		?><span style="color:lime; font-weight: 900;">&#x2714;</span><script>$("#answer<?=$q_id?>").css("border", "thin lime solid");</script>
		<?php
	}
	else
	{ 
		$correct = false;
		?><span style="color:red; font-weight: 900;">X</span><script>$("#answer<?=$q_id?>").css("border", "thin red solid");</script><?php
	}
	
	$res = $db->Execute("SELECT * FROM cw_submissions WHERE ques=? AND user=?", array($q['id'], $_SESSION['uid']));
	//print_r($res);
	if ($res->EOF)
	{
		echo '<span style="font-size: x-small; color: lightgrey;">1</span>';
		$db->Execute("INSERT INTO cw_submissions (ques, user, answer, status, datetimesub, graded) VALUES (?, ?, ?, ?, NOW(), ?)", array($q['id'], $_SESSION['uid'], $_GET['ans'], $correct, $graded));
	}
	else
	{
		echo '<span style="font-size: x-small; color: lightgrey;">' .(intval($res->fields['count']) + 2) . '</span>';
		$db->Execute("UPDATE cw_submissions SET status=?, answer=?, count=?, datetimesub=NOW(),graded=? WHERE ques=? AND user=?", array($correct, $_GET['ans'], intval($res->fields['count']) + 1, $graded, $q['id'], $_SESSION['uid']));
	}
	
}
else if ($q['type'] == 1)
{ 
	$ans = $aans;
	$cans = $q['answer'];
	if(strcmp($ans, $cans) == 0)
	{$correct = true;
		?><span style="color:lime; font-weight: 900;">&#x2714;</span><script>$("#answer<?=$q_id?>").css("border", "thin lime solid");</script>
	<?php
	}
	else
	{ $correct = false;
		?><span style="color:red; font-weight: 900;">X</span><script>$("#answer<?=$q_id?>").css("border", "thin red solid");</script>
	<?
	} 
	
		$res = $db->Execute("SELECT * FROM cw_submissions WHERE ques=? AND user=?", array($q['id'], $_SESSION['uid']));
	//print_r($res);
	if ($res->EOF)
	{
		echo '<span style="font-size: x-small; color: lightgrey;">1</span>';
		$db->Execute("INSERT INTO cw_submissions (ques, user, answer, status, datetimesub, graded) VALUES (?, ?, ?, ?, NOW(), ?)", array($q['id'], $_SESSION['uid'], $_GET['ans'], $correct, $graded));
	}
	else
	{
		echo '<span style="font-size: x-small; color: lightgrey;">' .(intval($res->fields['count']) + 2) . '</span>';
		$db->Execute("UPDATE cw_submissions SET status=?, answer=?, count=?, datetimesub=NOW(),graded=? WHERE ques=? AND user=?", array($correct, $_GET['ans'], intval($res->fields['count']) + 1, $graded, $q['id'], $_SESSION['uid']));
	}

}
else if ($q['type'] == 3)
{ 
	echo $q['answer'];
	
	?><script>MathJax.Hub.Queue(["Typeset",MathJax.Hub]);</script>
	<?php
}
else if ($q['type'] == 5)
{
	$qa = preg_split( '/\r\n|\r|\n/', $q['answer']);
	$aa = preg_split( '/\r\n|\r|\n/', $_GET['ans']);

	$cnt = 0;
	$correct = false;
	for($i = 0; $i < count($aa); $i++)
	{
		if(abs(floatval($qa[$i]) - floatval($aa[$i])) > 0.5)
			break;
		$cnt++;
	}
	if ($cnt == count($aa))
	{?><span style="color:lime; font-weight: 900;">&#x2714;</span><script>$("#answer<?=$q_id?>").css("border", "thin lime solid");</script><?php
		$correct = true;
	} else {?><span style="color:red; font-weight: 900;">X</span><script>$("#answer<?=$q_id?>").css("border", "thin red solid");</script><?php
		$correct = false;
	}
	
		
	$res = $db->Execute("SELECT * FROM cw_submissions WHERE ques=? AND user=?", array($q['id'], $_SESSION['uid']));
//print_r($res);
	if ($res->EOF)
	{
		//echo '<span style="font-size: x-small;">1</span>';
		$db->Execute("INSERT INTO cw_submissions (ques, user, answer, status, datetimesub, graded) VALUES (?, ?, ?, ?, NOW(), ?)", array($q['id'], $_SESSION['uid'], $_GET['ans'], $correct, $graded));
	}
else
	{
		//echo '<span style="font-size: x-small;">' .(intval($res->fields['count']) + 2) . '</span>';
		$db->Execute("UPDATE cw_submissions SET status=?, answer=?, count=?, datetimesub=NOW(), graded=? WHERE ques=? AND user=?", array($correct, $_GET['ans'], intval($res->fields['count']) + 1, $graded, $q['id'], $_SESSION['uid']));
	}
}


?>