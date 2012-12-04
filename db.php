<?php global $db;
include("lib/adodb5/adodb-exceptions.inc.php");
require_once('lib/adodb5/adodb.inc.php');
$db = NewADOConnection('mysql');
$db->autoRollback = true; # default is false
$db->PConnect('<DB SERVER>', '<USERNAME>', '<PASSWORD>', '<DB NAME>'); // Information hidden
?>
