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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("configpage.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/'.$_SESSION['template'].'/configpage.tpl'));
//ob er die Page anschauen darf:
 if (!$_SESSION['show_config'])
  {
   $template->assign_block_vars('userconfig_show_configpage', array(
   	'L_NOT_SHOW_THIS_PAGE' => $textdata[configpage_nicht_berechtigt]));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   exit();
  }
$template->assign_vars(array('L_TITLE_OF_CONFIG_PAGE' => $textdata['configpage_konfiguration']));

// Einstellungen speichern ANFANG
if (isset($_POST['save_data']))
{
$array=array('show_callback','show_prefix','show_msn','show_type');
for ($i=0;$i<=3;$i++)
 {
  if ($_POST[$array[$i]]=="on")
   {
    $_POST[$array[$i]]=1;
   }
 }
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (!empty($_POST['old_passwd']))
{
	$sqlquery=sprintf("SELECT passwd,id, FROM users WHERE id=%s",
		$dataB->sql_checkn($_POST['id']));
	$result_users=$dataB->sql_query($sqlquery);
  $daten_users=mysql_fetch_assoc($result_users);
  if ($daten_users['passwd']==(md5($_POST['old_passwd'])))
   {
    if ($_POST['password1']==$_POST['password2'] && !empty($_POST['password1']))
     {
      $passwd=md5($_POST['password1']);
      $sqlquery=sprintf("UPDATE users SET passwd=%s WHERE id=%s",
      		$dataB->sql_check($passwd),
      		$dataB->sql_checkn($_POST['id']));
      $result=$dataB->sql_query($sqlquery);
      if (!$result) 
       {
        $template->assign_block_vars('update_passwd_failed',array(
			'L_MSG_PASSWD_FAILED' => 'Updating passwd in database failed!!'));
       }
     }
     else
     {
      $template->assign_block_vars('update_empty_passwd',array(
      	'L_MSG_NEW_PASSWD' => 'The new passwords are not the same or empty new password field'));
     }
   }
   else
   {
   $template->assign_block_vars('update_old_passwd',array(
   		'L_MSG_OLD_PASSWD' => 'Old Password is not the same like in the Database'));
   }
 }
 /*********************************/
$result_config=$dataB->sql_query("SELECT * FROM config WHERE conf='template'"); 
$daten_config=$dataB->sql_fetch_assoc($result_config);
if ($daten_config[value]==NULL)
 {
  $result=$dataB->sql_query("UPDATE users SET template='$_POST[template]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_tempalte',array(
    		'L_MSG_TEMPLATE_FAILED' => 'Updating template in database failed!!'));
   }
 } 
$result=$dataB->sql_query("UPDATE users SET name_first='$_POST[name_first]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_first_name',array(
    			'L_MSG_FIRST_NAME' => 'Updating first name in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET name_last='$_POST[name_last]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_last_name',array(
    			'L_MSG_LAST_NAME' => 'Updating last name in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET show_callback='$_POST[show_callback]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_callback', array(
    		'L_MSG_SHOW_CALLBACK' => 'Updating show callback in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET msn_listen='$_POST[msn_listen]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_msn_listen', array(
    			'L_MSG_MSN_LISTEN' => 'Updating msn listen in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET show_lines='$_POST[show_lines]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_show_lines',array(
    			'L_MSG_SHOW_LINES' => 'Updating show lines in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET show_prefix='$_POST[show_prefix]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_show_prefix',array(
    		'L_MSG_SHOW_PREFIX' => 'Updating show prefix in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET show_msn='$_POST[show_msn]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_show_msn',array(
    			'L_MSG_SHOW_MSN' => 'Updating show msn in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET show_type='$_POST[show_type]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_show_type',array(
    		'L_MSG_SHOW_TYPE' => 'Updating show type in database failed!!'));
   }
$result=$dataB->sql_query("UPDATE users SET cs_audio='$_POST[cs_audio]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    $template->assign_block_vars('db_update_cs_audio',array(
    		'L_MSG_CS_AUDIO' => 'Updating cs_audio in database failed!!'));
   }   

$dataB->sql_close();
$template->assign_block_vars('db_update',array(
			'L_MSG_SAVED' => 'data saved to database...'));
}// Einstellungen speichern ENDE


$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$sqlquery=sprintf("SELECT * FROM users WHERE id=%s",
	$dataB->sql_checkn($_SESSION['userid']));
$result=$dataB->sql_query($sqlquery);
$daten=$dataB->sql_fetch_assoc($result);
$result_config=$dataB->sql_query("SELECT * FROM config WHERE conf='template'"); 
$daten_config=$dataB->sql_fetch_assoc($result_config); 
$dataB->sql_close();
//Xhtml konform das checkboxen gechecked sind.
$array=array('show_callback','show_prefix','show_msn','show_type');
for ($i=0;$i<=3;$i++)
 {
  if ($daten[$array[$i]])
   {
    $daten[$array[$i]]="checked=\"checked\"";
   }
 }
$template->assign_block_vars('tab1', array(
	'L_USER_NAME' => $textdata['configpage_username'],
	'DATA_USER_NAME' => $daten['username'],
	'L_CHANGE_PASSWD' => $textdata['configpage_passwort_aendern'],
	'L_OLD_PASSWD' => $textdata['configpage_altes_passwd'],
	'L_NEW_PASSWD' => $textdata['configpage_neues_passwd'],
	'L_NEW_PASSWD_CONFIRM' => $textdata['configpage_wiederholen'],
	'L_FIRST_NAME' => $textdata['addadress_vorname'],
	'L_LAST_NAME' => $textdata['addadress_nachname'],
	'DATA_FIRST_NAME' => $daten['name_first'],
	'DATA_LAST_NAME' => $daten['name_last'],
	'L_SHOW_NUMBERS_OF_CALLS_IN_STAT' => $textdata['configpage_zeige_letzte_anrufe'],
	'DATA_NUMBERS' => $daten['show_lines'],
	'L_SHOW_CALL_BACK_FUNC' => $textdata['configpage_zeige_rueckruf'],
	'DATA_CALL_BACK_FUNC' => $daten['show_callback'],
	'L_SHOW_PREFIX_FUNC' => $textdata['option_splate_vorwahl'],
	'DATA_PREFIX_FUNC' => $daten['show_prefix'],
	'L_SHOW_TYP_FROM_CALL' => $textdata['zeige_typ'],
	'DATA_SHOW_TYP_FROM_CALL' => $daten['show_type'],
	'L_SHOW_MSN' => $textdata['option_splate_msn'],
	'DATA_SHOW_MSN' => $daten['show_msn'],
	'L_SHOW_MSN_FUNC' => $textdata['zeige_msns'],
	'DATA_SHOW_MSN_FUNC' => $daten['msn_listen'],
	'L_WARNING_FOR_MSN_FUNC' => $textdata['warnung_msns'],
	'DATA_ID_FROM_DB' => $daten['id'],
	'L_SAVE_DATA_TO_DB' => $textdata['save'],
	'L_T_CS_AUDIO' =>$textdata['cs_type_cs_audio'])); 

//cs_audio selection:
for ($i=1;$i<=3;$i++)
{
	if ($daten['cs_audio']==$i)
	{
		$template->assign_block_vars('tab1.tab3',array(
			'DATA_NAME' => $textdata['cs_audio_'.$i],
			'DATA_ID' => $i,
			'DATA_SELECT' => 'selected="selected"'));
	}
	else
	{
		$template->assign_block_vars('tab1.tab3',array(
			'DATA_NAME' => $textdata['cs_audio_'.$i],
			'DATA_ID' => $i,
			'DATA_SELECT' => ''));
	}
}
if ($daten_config['value']==NULL)
 {
  $template->assign_block_vars('tab1.template_on',array(
  		'L_SET_TEMPLATE' => 'Template setzten'));
  $dir= "templates";
  $dh=opendir($dir);
  while (false!== ($filename=readdir($dh)))
   {
    if ($filename!="." AND $filename!=".." AND $filename!="index.html")
     {
      $files[] =$filename;
     }
   }
  foreach ($files as $value)  
   {
    if ($value==$daten['template'])
      {
       $template->assign_block_vars('tab1.template_on.tab2',array(
       		'DATA_TEMPLATE' => $value,
		'DATA_SELECT' => 'selected="selected"'));
      }
    else
      {
       $template->assign_block_vars('tab1.template_on.tab2',array('DATA_TEMPLATE' => $value));
      }
    
   }
  
 }//wenn user selber template setzten darf
 	
$template->pparse('overall_body');
include("./footer.inc.php");
?>
