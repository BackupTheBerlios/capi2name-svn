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
$seite=base64_encode("statistic_all_calls.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/statistic_all_calls.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata['stat_gesamt_stat_alle_anrufe']));
   
if (isset($_GET['order']) && $_GET['order']=="firstname")
 {
  $oderby="name_first";
 }
elseif (isset($_GET['order']) && $_GET['order']=="lastname")
 {
  $oderby="name_last";
 }
elseif (isset($_GET['order']) && $_GET['order']=="date")
 {
  $oderby="datum";
 }
 else
 {
  $oderby="anzahl";
 }
if (isset($_GET['sortby']) && $_GET['sortby']=="up")
 {
  $sortby="ASC";
 }
else
 {
  $sortby="DESC";
 }

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$sql_query="SELECT COUNT(*) AS anzahl,
	addressbook.id,addressbook.name_last,
	addressbook.name_first, MAX(angerufene.datum) AS datum
	FROM angerufene LEFT 
	JOIN phonenumbers ON angerufene.rufnummer=phonenumbers.number 
	LEFT JOIN addressbook ON phonenumbers.addr_id=addressbook.id 
	WHERE NOT(phonenumbers.typ='null')
	GROUP BY addressbook.id,addressbook.name_last,addressbook.name_first 
	ORDER by $oderby $sortby";
$result_data=$dataB->sql_query($sql_query);
//mysql_num_rows
$ges_anzahl=$dataB->sql_num_rows($result_data);
  if (!$ges_anzahl)
    {
     $template->assign_block_vars('no_entry_found',array(
     		'L_MSG_NOT_FOUND' => $textdata['stat_gesamt_keine_stat']));
     $dataB->sql_close();
     $template->pparse('overall_body');  
     include("./footer.inc.php");
     exit();
    }
 
 

$template->assign_block_vars('tab0',array(
	'L_SORT_OPTION' => $textdata['stat_gesamt_sortierung'],
	'L_ADDR_LAST_NAME' =>  $textdata['addadress_nachname'],
	'L_ADDR_FIRST_NAME' => $textdata['addadress_vorname'],
	'L_ALL_CALLS' => $textdata['stat_gesamt_anrufe'],
	'L_LAST_CALL' => $textdata['stat_anrufer_letzter_anruf']));
$i=1;
while($data=$dataB->sql_fetch_assoc($result_data)) 
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
	'DATA_ID' => $data['id'],
	'DATA_LAST_NAME' => $data['name_last'],
	'DATA_FIRST_NAME' => $data['name_first'],
	'DATA_COUNT' => $data['anzahl'],
	'DATA_LAST_CALL' => mysql_datum($data['datum']),
	'L_SEARCH_ENTRY' => $textdata['search_calls_from']. $data['name_first'].' '. $data['name_last']));
  $i++;
 }

$dataB->sql_close();
$template->pparse('overall_body');  
include("./footer.inc.php");
?>
