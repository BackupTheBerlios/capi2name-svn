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
$seite=base64_encode("callback_show.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/callback_show.tpl'));
//ob er die Page anschauen darf:
if (!$_SESSION['show_callback'])
{
	$template->assign_block_vars('not_allowed_show',array(
		'L_MSG_NOT_ALLOWED' => $textdata['nichtberechtigt']));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	die();
}

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$query=sprintf("SELECT t1.*,t2.name_last,t2.name_first,t3.number AS RUFNR FROM callback AS t1 LEFT JOIN addressbook AS t2 ON t1.addr_id=t2.id LEFT JOIN phonenumbers AS t3 ON t3.addr_id=t2.id WHERE t1.user_id=%s AND t1.id=%s GROUP BY t1.id",
	$dataB->sql_checkn($_SESSION['userid']),
	$dataB->sql_checkn($_GET['id']));
$result=$dataB->sql_query($query);
$daten=mysql_fetch_assoc($result);
$dataB->sql_close();
if (!$daten)
 {
  $template->assign_block_vars('entry_not_found',array(
  	'L_NOT_FOUND' =>$textdata['showaddress_eintrag_nicht']." ".$_GET['id']." ".$textdata['showaddress_admin_wenden']));
  $template->pparse('overall_body');
  include("footer.inc.php");
  die();
 }

   if ($daten['addr_id']==-1)
     {
      $number=$daten['number'];
     }
   else
     {
      $number=$daten['RUFNR'];
     }
   switch ($daten['callback_time'])
     {
      case 0:
      	$callback_time=$textdata['callback_soon_as_posible'];
	break;
      case 1:
      	$callback_time=$textdata['callback_morning'];
	break;
      case 2:
      	$callback_time=$textdata['callback_midday'];
	break;
      case 3:
      	$callback_time=$textdata['callback_evening'];
	break;
     
     }; 
  if ($daten['addr_id']==-1)
   {
    $full_name=$daten['full_name'];
   }
  else
   {
   $full_name="<a href=\"./addressbook.php?id=$daten[addr_id]#find\">$daten[name_first] $daten[name_last]</a>";
   }

$template->assign_vars(array('L_SITE_TITLE' =>$textdata['showaddress_deteilansicht']." ".$textdata['callback_detail_title']));

$template->assign_block_vars('tab1',array(
	'L_DATE' => $textdata['stat_anrufer_datum'],
	'L_CALLBACK_TIME' => $textdata['callback_time'],
	'DATA_CALLBACK_TIME' => $callback_time,
	'DATA_DATE' => mysql_datum($daten['en_date']),
	'L_NAME' =>  $textdata['showstatnew_name'],
	'DATA_NAME' => $full_name,
	'L_TIME' => $textdata['stat_anrufer_uhrzeit'],
	'DATA_TIME' => $daten['en_time'],
	'L_NUMBER' => $textdata['stat_anrufer_rufnummer'],
	'DATA_NUMBER' => $number,
	'DATA_REASON' => $daten['message'],
	'L_REASON' => $textdata['reason']));

$template->pparse('overall_body');
include("./footer.inc.php");
?>
