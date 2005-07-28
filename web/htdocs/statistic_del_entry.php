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
$seite=base64_encode("statistic_del_entry.php");
include("./login_check.inc.php");
include("./header.inc.php");


$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/statistic_del_entry.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[stat_loeschen]));

//ob er die Page anschauen darf:
 if (!$userconfig['loeschen'])
  {
   $template->assign_block_vars('not_allowed_view', array(
   		'L_MSG_NOT_ALLOWED' => $textdata[nichtberechtigt]));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   die();
  }
if (isset($_POST[btn_loeschen]))
  {
   //Eintrag löschen:
   $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"]);
   $sql=sprintf("UPDATE angerufene SET aktive='0' WHERE id=%s",$_POST[id]);
   $res=$dataB->sql_query($sql);
   $dataB->sql_close();
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
  	'L_MSG_SUCCESS' => $textdata[del_OK_forward],
	'DATA_DATE' => $datum));
    }
  }

if (isset($_GET[id]))
  {
    $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
    $sql=sprintf("SELECT * FROM angerufene WHERE id=%s", $dataB->sql_checkn($_GET[id]));
    $result=$dataB->sql_query($sql);
    $dataB->sql_close();
    $daten=$dataB->sql_fetch_assoc($result);
    $datum1=mysql_datum($daten[datum]);
    $template->assign_block_vars('check_if_del',array(
    	'L_MSG_CHECK_TO_DEL' => $textdata[stat_del_1].$_GET[id]. $textdata[stat_del_2],
	'L_ID' => $textdata[id],
	'L_DATE' => $textdata[stat_anrufer_datum],
	'L_TIME' => $textdata[stat_anrufer_uhrzeit],
	'L_NUMBER' => $textdata[stat_anrufer_rufnummer],
	'DATA_ID' => $daten[id],
	'DATA_DATE' => $datum1,
	'DATA_TIME' => $daten[uhrzeit],
	'DATA_NUMBER' => $daten[rufnummer],
	'DATA_FROM_GET' => $_GET[datum],
	'L_DELETE' => $textdata[delet]));
    

  }
$template->pparse('overall_body');  
include("./footer.inc.php");
?>
