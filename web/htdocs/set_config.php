<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonas.genannt@capi2name.de
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("configpage.php");
include("./login_check.inc.php");
if (isset($_POST['save_data']) && $_SESSION['show_config'])
{
	$array=array('show_callback','show_prefix','show_msn','show_type');
	for ($i=0;$i<=3;$i++)
	{
		if ($_POST[$array[$i]]=="on")
		{
			$_POST[$array[$i]]=1;
		}
	}
	$userid=$_SESSION['userid'];
	$password=$_SESSION['password'];
	$template=$_SESSION['template'];
	$cs_user=$_SESSION['cs_user'];
	$username=$_SESSION['username'];
	$show_config=$_SESSION['show_config'];
	$allow_delete=$_SESSION['allow_delete'];
	$_SESSION = array();
	//session_unset();
	//setcookie(session_name(), '', time()-42000, '/');
	//session_destroy();
	//session_start();
	$_SESSION['template']=$template;
	$_SESSION['L_id']=$userid;
	$_SESSION['L_pw']=$password;
	include("./header.inc.php");
	if (!empty($_POST['old_passwd'])&& !empty($_POST['password1'])&&!empty($_POST['password2']))
	{
		if (md5($_POST['old_passwd'])==$password)
		{
			if ($_POST['password1']==$_POST['password2'])
			{
				$password=md5($_POST['password1']);
			}
			else
			{
				echo "Neue passoerter stimmen nciht ueberein!";
			}
		}
		else
		{
			echo "Altes password stimmt nicht ueberein!";
		}
	}
	$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"]);
	$sql_query=sprintf("DELETE FROM users WHERE id=%s", $userid);
	$res_del=$dataB->sql_query($sql_query);
	$sql_query=sprintf("INSERT INTO users VALUES(%s,%s,%s,%s,NULL,NULL,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,NULL,%s,%s)",
	$dataB->sql_check($userid),
	$dataB->sql_check($username),
	$dataB->sql_check($cs_user),
	$dataB->sql_check($password), //NULL,NULL
	$dataB->sql_check($_POST['name_first']),
	$dataB->sql_check($_POST['name_last']),
	$dataB->sql_checkn($_POST['show_lines']),
	$dataB->sql_check($_POST['msn_listen']),
	$dataB->sql_checkn($_POST['show_callback']),
	$dataB->sql_checkn($_POST['show_prefix']),
	$dataB->sql_checkn($_POST['show_msn']),
	$dataB->sql_checkn($_POST['show_type']),
	$show_config,
	$allow_delete,
	$dataB->sql_checkn($_POST['cs_audio']),
	$dataB->sql_checkn($_POST['cs_fax']));
	$res_submit=$dataB->sql_query($sql_query);
	echo mysql_error();
	echo $sql_query;
	echo "ID:". $_SESSION['L_id']  . "</br>";
	echo "<meta http-equiv=\"refresh\" content=\"8; URL=./login.php\">";
	$dataB->sql_close();
	
}
include("./footer.inc.php");
?>