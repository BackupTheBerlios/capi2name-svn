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
$seite=base64_encode("configpage.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/'.$userconfig['template'].'/configpage.tpl'));
//ob er die Page anschauen darf:
 if (!$userconfig['showconfig'])
  {
   $template->assign_block_vars('userconfig_show_configpage', array(
   	'L_NOT_SHOW_THIS_PAGE' => $textdata[configpage_nicht_berechtigt]));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   exit();
  }
$template->assign_vars(array('L_TITLE_OF_CONFIG_PAGE' => $textdata[configpage_konfiguration]));

// Einstellungen speichern ANFANG
if ($_POST[save_data])
{
$array=array(show_callback,show_prefix,show_msn,show_type);
for ($i=0;$i<=3;$i++)
 {
  if ($_POST[$array[$i]]=="on")
   {
    $_POST[$array[$i]]=1;
   }
 }
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (!empty($_POST[old_passwd]))
 {
  $result_users=$zugriff_mysql->sql_abfrage("SELECT passwd,id FROM users WHERE id='$_POST[id]'");
  $daten_users=mysql_fetch_assoc($result_users);
  if ($daten_users[passwd]==(md5($_POST[old_passwd])))
   {
    if ($_POST[password1]==$_POST[password2] && !empty($_POST[password1]))
     {
      $passwd=md5($_POST[password1]);
      $result=$zugriff_mysql->sql_abfrage("UPDATE users SET passwd='$passwd' WHERE id='$_POST[id]'");
      if (!$result) 
       {
        echo "<div class=\"rot_mittig\">Updating passwd in database failed!!</div>";
       }
     }
     else
     {
      echo "<div class=\"rot_mittig\">The new passwords are not the same or empty new password field</div>";
     }
   }
   else
   {
   echo "<div class=\"rot_mittig\">Old Password is not the same like in the Database</div>";
   }
 }
$result_config=$zugriff_mysql->sql_abfrage("SELECT * FROM config WHERE conf='template'"); 
$daten_config=mysql_fetch_assoc($result_config);
if ($daten_config[value]==NULL)
 {
  $result=$zugriff_mysql->sql_abfrage("UPDATE users SET template='$_POST[template]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating template in database failed!!</div>";
   }
 } 
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET name_first='$_POST[name_first]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating first name in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET name_last='$_POST[name_last]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating last name in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET show_callback='$_POST[show_callback]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating show callback in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET msn_listen='$_POST[msn_listen]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating msn listen in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET show_lines='$_POST[show_lines]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating show lines in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET show_prefix='$_POST[show_prefix]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating show prefix in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET show_msn='$_POST[show_msn]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating show msn in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET show_type='$_POST[show_type]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating show type in database failed!!</div>";
   }
$result=$zugriff_mysql->sql_abfrage("UPDATE users SET allow_delete='$_POST[allow_delete]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating allow delete in database failed!!</div>";
   }
$zugriff_mysql->close_mysql();
echo "<div class=\"blau_mittig\">data saved to database...</div>";
}// Einstellungen speichern ENDE


$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM users WHERE username='".$_SESSION['username']."'");
$daten=mysql_fetch_assoc($result);
$result_config=$zugriff_mysql->sql_abfrage("SELECT * FROM config WHERE conf='template'"); 
$daten_config=mysql_fetch_assoc($result_config); 
$zugriff_mysql->close_mysql();
//Xhtml konform das checkboxen gechecked sind.
$array=array(show_callback,show_prefix,show_msn,show_type);
for ($i=0;$i<=3;$i++)
 {
  if ($daten[$array[$i]])
   {
    $daten[$array[$i]]="checked=\"checked\"";
   }
 }

$template->assign_block_vars('tab1', array(
	'L_USER_NAME' => $textdata[configpage_username],
	'DATA_USER_NAME' => $daten[username],
	'L_CHANGE_PASSWD' => $textdata[configpage_passwort_aendern],
	'L_OLD_PASSWD' => $textdata[configpage_altes_passwd],
	'L_NEW_PASSWD' => $textdata[configpage_neues_passwd],
	'L_NEW_PASSWD_CONFIRM' => $textdata[configpage_wiederholen],
	'L_FIRST_NAME' => 'Vorname',
	'L_LAST_NAME' => 'Nachname',
	'DATA_FIRST_NAME' => $daten[name_first],
	'DATA_LAST_NAME' => $daten[name_last],
	'L_SHOW_NUMBERS_OF_CALLS_IN_STAT' => $textdata[configpage_zeige_letzte_anrufe],
	'DATA_NUMBERS' => $daten[show_lines],
	'L_SHOW_CALL_BACK_FUNC' => $textdata[configpage_zeige_rueckruf],
	'DATA_CALL_BACK_FUNC' => $daten[show_callback],
	'L_SHOW_PREFIX_FUNC' => $text[option_splate_vorwahl],
	'DATA_PREFIX_FUNC' => $daten[show_prefix],
	'L_SHOW_TYP_FROM_CALL' => $text[zeige_typ],
	'DATA_SHOW_TYP_FROM_CALL' => $daten[show_type],
	'L_SHOW_MSN' => $text[option_splate_msn],
	'DATA_SHOW_MSN' => $daten[show_msn],
	'L_SHOW_MSN_FUNC' => $text[zeige_msns],
	'DATA_SHOW_MSN_FUNC' => $daten[msn_listen],
	'L_WARNING_FOR_MSN_FUNC' => $text[warnung_msns],
	'DATA_ID_FROM_DB' => $daten[id],
	'L_SAVE_DATA_TO_DB' => $text[speichern])); 

if ($daten_config[value]==NULL)
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
    if ($value==$daten[template])
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
