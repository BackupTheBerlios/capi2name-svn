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

$seite=base64_encode("stat_gesamt.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/stat_gesamt.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[stat_gesamt_stat_alle_anrufe]));
   

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );

$sql_query="SELECT COUNT(*) AS anzahl,
	addressbook.id,addressbook.name_last,
	addressbook.name_first, MAX(angerufene.datum) AS datum
	FROM angerufene LEFT 
	JOIN phonenumbers ON angerufene.rufnummer=phonenumbers.number 
	LEFT JOIN addressbook ON phonenumbers.addr_id=addressbook.id 
	WHERE NOT(phonenumbers.typ='null')
	GROUP BY addressbook.id 
	ORDER by anzahl DESC";
$result_data=$zugriff_mysql->sql_abfrage($sql_query);

$ges_anzahl=mysql_num_rows($result_data);
  if (!$ges_anzahl)
    {
     $template->assign_block_vars('no_entry_found',array(
     		'L_MSG_NOT_FOUND' => $textdata[stat_gesamt_keine_stat]));
     $zugriff_mysql->close_mysql();
     $template->pparse('overall_body');  
     include("./footer.inc.php");
     die();
    }
 
 

$template->assign_vars(array(
	'DATA_ORDER_OPTION' =>$option_order,
	'L_SORT_OPTION' => $textdata[stat_gesamt_sortierung],
	'L_ADDR_LAST_NAME' =>  $textdata[addadress_nachname],
	'L_ADDR_FIRST_NAME' => $textdata[addadress_vorname],
	'L_ALL_CALLS' => $textdata[stat_gesamt_anrufe],
	'L_LAST_CALL' => $textdata[stat_anrufer_letzter_anruf]));
$i=1;
while($data=mysql_fetch_assoc($result_data)) 
 {
  if($i%2==0)
   {
     $color=$row_color_1;
   }
  else
   {
     $color=$row_color_2;
    }
  $template->assign_block_vars('tab1',array(
  	'DATA_COLOR' => $color,
	'DATA_INDEX' => $i,
	'DATA_ID' => $data[id],
	'DATA_LAST_NAME' => $data[name_last],
	'DATA_FIRST_NAME' => $data[name_first],
	'DATA_COUNT' => $data[anzahl],
	'DATA_LAST_CALL' => mysql_datum($data[datum])));
  $i++;
 }



$zugriff_mysql->close_mysql();
$template->pparse('overall_body');  
include("./footer.inc.php");
?>
