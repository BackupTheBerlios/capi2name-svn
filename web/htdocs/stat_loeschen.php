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
$seite=base64_encode("stat_loeschen.php");
include("./login_check.inc.php");
include("./header.inc.php");


$template->set_filenames(array('overall_body' => 'templates/blueingrey/stat_del_entry.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $text[stat_loeschen]));

//ob er die Page anschauen darf:
 if (!$userconfig['loeschen'])
  {
   $template->assign_block_vars('not_allowed_view', array(
   		'L_MSG_NOT_ALLOWED' => $text[nichtberechtigt]));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   die();
  }
if (isset($_POST[btn_loeschen]))
  {
   //Eintrag löschen:
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
   $res=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE id=$_POST[id]");
   $zugriff_mysql->close_mysql();
     if ($_POST[datum]!="")
      {
       $datum="?datum=$_POST[datum]";
      }
    else
      {
       $datum="";
      }
   if ($res == 1)
    {
     $template->assign_block_vars('del_entry_successfully', array(
  	'L_MSG_SUCCESS' => 'Eintrag erfolgreich gelöscht, Sie werden in 2sec weitergeleitet.',
	'DATA_DATE' => $datum));
    }
  }
?>



<?
if (isset($_GET[id]))
  {
    $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
    $result=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE id=$_GET[id]");
    $zugriff_mysql->close_mysql();
    $daten=mysql_fetch_assoc($result);
    $datum1=mysql_datum($daten[datum]);
    $template->assign_block_vars('check_if_del',array(
    	'L_MSG_CHECK_TO_DEL' => 'Soll dieser Eintrag mit ID '.$_GET[id]. ' gelöscht werden?&nbsp;-Zum Löschen einfach nochmal auf "Löschen" klicken!',
	'L_ID' => 'ID',
	'L_DATE' => 'Datum',
	'L_TIME' => 'Uhrzeit',
	'L_NUMBER' => 'Rufnummer',
	'DATA_ID' => $daten[id],
	'DATA_DATE' => $datum1,
	'DATA_TIME' => $daten[uhrzeit],
	'DATA_NUMBER' => $daten[rufnummer],
	'DATA_FROM_GET' => $_GET[datum],
	'L_DELETE' => 'Löschen'));
    

  }

$template->pparse('overall_body');  
include("./footer.inc.php");
?>
