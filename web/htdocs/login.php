<?
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
include("./includes/functions.php");
session_start(); 
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT conf,value FROM config WHERE conf='default_template'");
$daten=mysql_fetch_assoc($result); 
$zugriff_mysql->close_mysql();
$userconfig['template']=$daten[value];
include("./header.inc.php");
$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/login.tpl'));
$loginok=0;

if (isset($_POST['absenden']))
{

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$zugriff_mysql->sql_abfrage("SELECT id,username,passwd,name_first,name_last FROM users WHERE username='".$_POST['login_name']."'");
 if ($result_userlist && $_POST['login_name']!="" && $_POST['login_passwd']!="")
  {
  $row_userlist=mysql_fetch_assoc($result_userlist);
    if (md5($_POST['login_passwd'])==$row_userlist['passwd'])
    {
     $seite=base64_decode($_POST['seite']);
     if ($_POST['remember_login']=="on")
      {
       $_SESSION['remember_login']=true;
      }
     $_SESSION['realname']=$row_userlist['name_first']." ".$row_userlist['name_last'];
     $_SESSION['username']=$_POST['login_name'];
     $_SESSION['password']=$row_userlist['passwd'];
     $loginok=1;
     $template->assign_block_vars('tab1',array(
     		'L_PASSWD_OK' => 'PASSWD Richtig... Sie werden weitergeleitet...',
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
$zugriff_mysql->close_mysql();

}
else
 {
  $template->assign_block_vars('tab2', array('L_MSG_ERROR' => 'Bad syntax for open login.php'));
  $template->pparse('overall_body');
  include("./footer.inc.php");
  exit();
 }
if ($loginok==0)
 {
  $template->assign_block_vars('tab3',array(
  	'L_LOGIN_FAILED' => 'Login failed, username or password wrong. Please go back!',
	'L_BACK' => 'go back'));
  $template->pparse('overall_body');
  include("./footer.inc.php");
 }
 
 
 

?>
