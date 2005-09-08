<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonasge@gmx.net
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
include("./includes/conf.inc.php");
include("./language/".$config['language'].".inc.php");
include("./includes/functions.php");
session_start(); 
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$dataB->sql_query("SELECT conf,value FROM config WHERE conf='default_template'");
$daten=$dataB->sql_fetch_assoc($result); 
$_SESSION['template']=$daten['value'];
$loginok=0;
if (isset($_POST['absenden']) OR isset($_SESSION['L_id']) OR isset($_SESSION['L_pw']))
{
if (isset($_POST['absenden']) && $_POST['login_name']!="" && $_POST['login_passwd']!="")
{
	$sql_query=sprintf("SELECT * FROM users WHERE username=%s",
		$dataB->sql_check($_POST['login_name']));
	$ck_passwd=md5($_POST['login_passwd']);
}
else
{
	$sql_query=sprintf("SELECT * FROM users WHERE id=%s",
		$dataB->sql_checkn($_SESSION['L_id']));
	$ck_passwd=$_SESSION['L_pw'];
	$_SESSION['L_pw']=NULL;
}
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$dataB->sql_query($sql_query);
echo mysql_error();
if ($result_userlist)
{
	//$passwd_ggg=md5($_POST['login_passwd']);
	$row_userlist=$dataB->sql_fetch_assoc($result_userlist);
	if ($ck_passwd==$row_userlist['passwd'])
	{
		$seite=base64_decode($_POST['seite']);
		if ($_POST['remember_login']=="on")
		{
			$_SESSION['remember_login']=true;
		}
		fill_sessions($row_userlist);
		//template suchen und schauen wegen global oder nicht ;)
		$result_config=$dataB->sql_query("SELECT conf,value FROM config WHERE conf='template'");
		$result_config1=$dataB->sql_query("SELECT conf,value FROM config WHERE conf='default_template'");
		$daten_config1=$dataB->sql_fetch_assoc($result_config1);
		$daten_config=$dataB->sql_fetch_assoc($result_config);
		fill_template_session($daten_config,$daten_config1,$row_userlist['template']);
		$loginok=1;
		include("./header.inc.php");
		$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/login.tpl'));
		$template->assign_block_vars('tab1',array(
			'L_PASSWD_OK' => $textdata['login_OK_forward'],
			'DATA_SITE_FORWARD' => $seite));
		$template->pparse('overall_body');
		include("./footer.inc.php");
	}
	else
	{
		
		$loginok=0;
	}
}
else
{
	$loginok=0;
}
$dataB->sql_close();

} //isset ende
else
{
	include("./header.inc.php");
	$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/login.tpl'));
	$template->assign_block_vars('tab2', array('L_MSG_ERROR' => 'Bad syntax for open login.php'));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	exit();
}
if ($loginok==0)
{
	include("./header.inc.php");
	$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/login.tpl'));
	$template->assign_block_vars('tab3',array(
		'L_LOGIN_FAILED' => 'Login failed, username or password wrong. Please go back!',
		'L_BACK' => 'go back'));
	$template->pparse('overall_body');
	include("./footer.inc.php");
}
?>