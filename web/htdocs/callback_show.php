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
$seite=base64_encode("szurueckruf.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/callback_show.tpl'));
//ob er die Page anschauen darf:
 if (!$userconfig['showrueckruf'])
  {
   $template->assign_block_vars('not_allowed_show',array(
   		'L_MSG_NOT_ALLOWED' => $text[nichtberechtigt]));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   die();
  }


$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM zurueckrufen WHERE id=$_GET[anz]");
$zugriff_mysql->close_mysql();
$daten=mysql_fetch_array($result);
if ($daten==false)
 {
  $template->assign_block_vars('entry_not_found',array(
  	'L_NOT_FOUND' =>$text[eintragmit_id]." ".$_GET[anz]." ".$text[anadmin_wenden] ));
  $template->pparse('overall_body');
  include("footer.inc.php");
  die();
 }



$template->assign_vars(array('L_SITE_TITLE' =>$text[detail]." ".$text[zurueckrufen]));

$template->assign_block_vars('tab1',array(
	'L_DATE' => $text[datum],
	'DATA_DATE' => $daten[datum],
	'L_NAME' =>  'Name',
	'DATA_NAME' => $daten[name],
	'L_TIME' => $text[uhrzeit],
	'DATA_TIME' => $daten[uhrzeit],
	'L_NUMBER' => $text[rufnummer],
	'DATA_NUMBER' => $daten[nummer],
	'DATA_REASON' => $daten[grund],
	'L_REASON' => $text[grund]));

$template->pparse('overall_body');
include("./footer.inc.php");
?>
