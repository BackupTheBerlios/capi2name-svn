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


$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$dataB->sql_query("
SELECT t1.*,t2.name_last,t2.name_first,t3.number AS RUFNR FROM callback AS t1 LEFT JOIN addressbook AS t2 ON t1.addr_id=t2.id LEFT JOIN phonenumbers AS t3 ON t3.addr_id=t2.id WHERE t1.user_id=".$_SESSION['user_id']." AND t1.id=$_GET[anz] AND t3.typ=1 GROUP BY t1.id");
$dataB->sql_close();
$daten=mysql_fetch_assoc($result);
if ($daten==false)
 {
  $template->assign_block_vars('entry_not_found',array(
  	'L_NOT_FOUND' =>$text[eintragmit_id]." ".$_GET[anz]." ".$text[anadmin_wenden] ));
  $template->pparse('overall_body');
  include("footer.inc.php");
  die();
 }

   if ($daten[addr_id]==-1)
     {
      $number=$daten[number];
     }
   else
     {
      $number=$daten[RUFNR];
     }
   switch ($daten[callback_time])
     {
      case 0:
      	$callback_time=$textdata[callback_soon_as_posible];
	break;
      case 1:
      	$callback_time=$textdata[callback_morning];
	break;
      case 2:
      	$callback_time=$textdata[callback_midday];
	break;
      case 3:
      	$callback_time=$textdata[callback_evening];
	break;
     
     }; 
  if ($daten[addr_id]==-1)
   {
    $full_name=$daten[full_name];
   }
  else
   {
   $full_name="<a href=\"./addressbook.php?id=$daten[addr_id]#find\">$daten[name_first] $daten[name_last]</a>";
   }

$template->assign_vars(array('L_SITE_TITLE' =>$text[detail]." ".$text[zurueckrufen]));

$template->assign_block_vars('tab1',array(
	'L_DATE' => $text[datum],
	'L_CALLBACK_TIME' => $text[zurueck_zeit],
	'DATA_CALLBACK_TIME' => $callback_time,
	'DATA_DATE' => mysql_datum($daten[en_date]),
	'L_NAME' =>  'Name',
	'DATA_NAME' => $full_name,
	'L_TIME' => $text[uhrzeit],
	'DATA_TIME' => $daten[en_time],
	'L_NUMBER' => $text[rufnummer],
	'DATA_NUMBER' => $number,
	'DATA_REASON' => $daten[message],
	'L_REASON' => $text[grund]));

$template->pparse('overall_body');
include("./footer.inc.php");
?>
