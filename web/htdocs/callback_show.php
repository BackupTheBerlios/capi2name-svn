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
$seite=base64_encode("callback_show.php");
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
$result=$zugriff_mysql->sql_abfrage("
SELECT t1.*,t2.nachname,t2.vorname,t2.tele1,t2.handy FROM callback AS t1 LEFT JOIN adressbuch AS t2 ON t1.addr_id=t2.id WHERE t1.user_id=".$_SESSION['user_id']." AND t1.id=$_GET[anz]");
$zugriff_mysql->close_mysql();
$daten=mysql_fetch_assoc($result);
if ($daten==false)
 {
  $template->assign_block_vars('entry_not_found',array(
  	'L_NOT_FOUND' =>$text[eintragmit_id]." ".$_GET[anz]." ".$text[anadmin_wenden] ));
  $template->pparse('overall_body');
  include("footer.inc.php");
  die();
 }

   if ($daten[tele1]=="99")
     {
      $number=$daten[handy];
     }
    else
     {
      $number=$daten[tele1];
     }
   switch ($daten[callback_time])
     {
      case 0:
      	$callback_time="So bald wie moeglich";
	break;
      case 1:
      	$callback_time="Morgens";
	break;
      case 2:
      	$callback_time="Mittags";
	break;
      case 3:
      	$callback_time="Abends";
	break;
     
     }; 


$template->assign_vars(array('L_SITE_TITLE' =>$text[detail]." ".$text[zurueckrufen]));

$template->assign_block_vars('tab1',array(
	'L_DATE' => $text[datum],
	'L_CALLBACK_TIME' => $text[zurueck_zeit],
	'DATA_CALLBACK_TIME' => $callback_time,
	'DATA_DATE' => mysql_datum($daten[en_date]),
	'L_NAME' =>  'Name',
	'DATA_NAME' => $daten[vorname]. " ".$daten[nachname],
	'DATA_ADDR_ID' => $daten[addr_id],
	'L_TIME' => $text[uhrzeit],
	'DATA_TIME' => $daten[en_time],
	'L_NUMBER' => $text[rufnummer],
	'DATA_NUMBER' => $number,
	'DATA_REASON' => $daten[message],
	'L_REASON' => $text[grund]));

$template->pparse('overall_body');
include("./footer.inc.php");
?>
