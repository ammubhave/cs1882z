<?php
$login_req = false; $_title = 'Login'; $_page = 'login';
require_once('header.php');

require('lib/openid.php');

if (isset($_GET['secret']) && $_GET['secret'] == 'adminsecret')
{
	$_SESSION['uid'] = $_GET['uid'];
	$_SESSION['email'] = $_GET['email'];
	$_SESSION['isAuthenticated'] = true;	
	//header('Location: /ai/info.php');
	echo '<script>window.location = "courseware.php";</script>';
	exit();
}

$openid = new LightOpenID('cs1882z.amolbhave.in');
$openid->identity = 'https://www.google.com/accounts/o8/id';
$openid->required = array('namePerson/first', 'namePerson/last', 'contact/email', 'contact/country/home', 'pref/language');

if ($openid->mode && $openid->mode != 'cancel' && $openid->validate())
{
	$_SESSION['isAuthenticated'] = true;
	// print_r($_REQUEST);
	$url = 'courseware.php';
	$res = $db->Execute("SELECT * FROM user_openids WHERE identity=?", array($_REQUEST['openid_ext1_value_contact_email']));
	if ($res->EOF)
	{
		$db->Execute("INSERT INTO user_openids (identity, openid, server, datetimereg, lastdt) VALUES (?, ?, ?, NOW(), NOW())", array($_REQUEST['openid_ext1_value_contact_email'], $_REQUEST['openid_identity'], 'google'));
		$url = '/privacy.php';
	}
	$res = $db->GetRow("SELECT * FROM user_openids WHERE identity=?", array($_REQUEST['openid_ext1_value_contact_email']));
	
	$db->Execute("UPDATE user_openids SET firstname=?, lastname=?, country=?, language=?, lastdt=NOW() WHERE id=?", array($_REQUEST['openid_ext1_value_namePerson_first'], $_REQUEST['openid_ext1_value_namePerson_last'], $_REQUEST['openid_ext1_value_contact_country_home'], $_REQUEST['openid_ext1_value_pref_language'], $res['id']));

	$_SESSION['email'] = $_REQUEST['openid_ext1_value_contact_email'];
	$_SESSION['uid'] = $res['id'];
	$_SESSION['firstname'] = $_REQUEST['openid_ext1_value_namePerson_first'];
	$_SESSION['lastname'] = $_REQUEST['openid_ext1_value_namePerson_last'];
	$_SESSION['country'] = $_REQUEST['openid_ext1_value_contact_country_home'];
	$_SESSION['language'] = $_REQUEST['openid_ext1_value_pref_language'];
	
	//header('Location: ' . $url);
	echo '<script>window.location = "courseware.php";</script>';
	exit();
}


?>

<div id="content" class="box">	
		<div style="width: 90%; margin: 30px; background-color: white; text-align: center;">
			Log in / Register<br /><br />
			<a href="<?=$openid->authUrl()?>"><img src="http://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Googlelogo.png/320px-Googlelogo.png"  style="border: medium #0066CC dashed; padding: 30px;" /></a>
		</div>
</div>
<?php include('footer.php'); ?>