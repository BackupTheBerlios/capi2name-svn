<?php
include("./includes/conf.inc.php");
include("./language/".$config['language'].".inc.php");
include("./includes/functions.php");
session_start();
$login_ok=0;
$login_cockie=0;
if ($_SESSION['remember_login'])
{
	setcookie("ck_userid",$_SESSION['userid'], time()+172800000 );  
	setcookie("ck_passwd",$_SESSION['password'], time()+172800000 );  
	$_SESSION['remember_login']=false;
}

if ($_SESSION['userid']==NULL || $_SESSION['password']==NULL)
{
	$user_id=$_COOKIE['ck_userid'];
	$password=$_COOKIE['ck_passwd'];
	$login_cockie=1;
} 
elseif ($_SESSION['userid']!="" && $_SESSION['password']!="")
{
	$user_id=$_SESSION['userid'];
	$password=$_SESSION['password'];
}
else
{
	$user_id="-1";
}
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$query=sprintf("SELECT passwd FROM users WHERE id=%s", $dataB->sql_checkn($user_id));
$result_userlist=$dataB->sql_query($query);
if ($result_userlist && $password!="")
{
	$row_userlist=$dataB->sql_fetch_assoc($result_userlist);
	if ($password==$row_userlist['passwd'])
	{
	// echo "PASSWD Richtig...";
	//DB-Version auslesen:
	$result_db_version=$dataB->sql_query("SELECT value FROM config WHERE conf='db_version'");
	$db_version=$dataB->sql_fetch_assoc($result_db_version);
	$login_ok=1;
	if ($login_cockie==1)
	{
		$query=sprintf("SELECT * FROM users WHERE id=%s", $dataB->sql_checkn($user_id));
		$result_userlist=$dataB->sql_query($query);
		fill_sessions($dataB->sql_fetch_assoc($result_userlist));
		//template suchen und schauen wegen global oder nicht ;)
		$result_config=$dataB->sql_query("SELECT * FROM config WHERE conf='template'");
		$daten_config=$dataB->sql_fetch_assoc($result_config);
		$result_config1=$dataB->sql_query("SELECT * FROM config WHERE conf='default_template'");
		$daten_config1=$dataB->sql_fetch_assoc($result_config1);
		fill_template_session($daten_config,$daten_config1);

	}
	//update lastlogin_d and lastlogin_t
	//UPDATE capi_version SET version='0.6.7.2' WHERE id='1'
	$datum=$dataB->sql_fetch_assoc($dataB->sql_query("SELECT lastlogin_d FROM users WHERE username='$username'"));
	if ($datum[lastlogin_d]!=date("Y-m-d"))
	{
		$dataB->sql_query("UPDATE users SET lastlogin_t=NOW(),lastlogin_d=NOW() WHERE username='$username'");
	}
	$result_callback=$dataB->sql_query("SELECT user_id,notify FROM callback WHERE user_id='$row_userlist[id]' AND notify='1'");
	$daten_callback=$dataB->sql_fetch_assoc($result_callback);
	if ($daten_callback)
	{
		$_SESSION['show_callback_notify']=true;
	}
	}//if passwd OK
	else
	{
		$login_ok=0;
	}
}//if username es gibt
else
{
	$login_ok=0;
}
$dataB->sql_close();
if ($login_ok == 0)
{
	$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$result=$dataB->sql_query("SELECT conf,value FROM config WHERE conf='default_template'");
	$daten=$dataB->sql_fetch_assoc($result); 
	$dataB->sql_close();
	$_SESSION['template']=$daten[value];
	include("./header.inc.php");
	$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/login_site.tpl'));
	$template->assign_vars(array(
		'L_USERNAME' => $textdata[configpage_username],
		'L_PASSWD' => $textdata[passwd],
		'DATA_TO_SITE' => $seite,
		'L_STAY_LOGIN' => $textdata[stay_login],
		'L_LOGIN' => $textdata[login]));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	exit();
}
?>