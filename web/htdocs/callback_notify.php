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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
include("./includes/conf.inc.php");
include("./includes/functions.php");
include("./includes/template.php");
$template = new Template("./templates/blueingrey");
$template->set_filenames(array('overall_body' => 'templates/blueingrey/callback_notify.tpl'));
session_start(); 
if ($_SESSION['show_callback_notify'])
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $result_callback=$zugriff_mysql->sql_abfrage("SELECT t1.*,t2.name_first,t2.name_last,t3.number AS RUFNR
  FROM callback AS t1 LEFT JOIN addressbook AS t2 ON t1.addr_id=t2.id LEFT JOIN phonenumbers AS t3 ON t3.addr_id=t2.id WHERE t1.user_id=".$_SESSION['user_id']  ." AND t1.notify=1 GROUP BY t1.id");
  $zugriff_mysql->sql_abfrage("UPDATE callback SET notify=0 WHERE user_id=".$_SESSION['user_id']);
  $_SESSION['show_callback_notify']=false;
  while($daten_callback=mysql_fetch_assoc($result_callback))
   {
   if ($daten_callback[addr_id]==-1)
     {
      $number=$daten_callback[number];
     }
    else
     {
      $number=$daten_callback[RUFNR];
     }
    switch ($daten_callback[callback_time])
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
   if ($daten_callback[addr_id]==-1)
   {
    $full_name=$daten_callback[full_name];
   }
  else
   {
   $full_name="$daten_callback[name_first] $daten_callback[name_last]";
   }
    $template->assign_block_vars('tab1',array(
    		'L_DATA_NAME' => $full_name,
		'L_DATA_NUMBER' => $number,
		'L_DATA_CREATED_ON' => $daten_callback[en_time]." / ". mysql_datum($daten_callback[en_date]),
		'L_DATA_CALLBACK_TIME' => $callback_time,
		'L_DATA_MESSAGE' => $daten_callback[message]));
   }
  $zugriff_mysql->close_mysql();
 }
else
 {
  $template->assign_block_vars('not_found',array('L_MSG_NOT_FOUND' => 'Nicht erlebt/keine Callback entries found'));

 }
$template->pparse('overall_body');
?>