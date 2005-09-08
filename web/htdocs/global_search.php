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
$seite=base64_encode("global_search.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/'.$_SESSION['template'].'/global_search.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata['site_search_title']));


$template->assign_block_vars('tab1',array(
	'L_SEARCH' => $textdata['search'],
	'L_NUMBER' => $textdata['stat_anrufer_rufnummer'],
	'L_SEARCH_MSN' => $textdata['search_on_msn'],
	'L_IN_CALL_STAT' => $textdata['in_call_stat'],
	'L_IN_ADDR' => $textdata['in_addr_book'],
	'L_SEARCH_BETWEEN' =>$textdata['search_between']
	));

for ($i=1;$i<=31;$i++)
{
	$template->assign_block_vars('tab1.first_d',array('NR' => $i));
	$template->assign_block_vars('tab1.last_d',array('NR' => $i));
}
for ($i=1;$i<=12;$i++)
{
	$template->assign_block_vars('tab1.first_m',array('NR' => $i));
	$template->assign_block_vars('tab1.last_m',array('NR' => $i));
}
for ($i=2001;$i<=2006;$i++)
{
	$template->assign_block_vars('tab1.first_j',array('NR' => $i));
	$template->assign_block_vars('tab1.last_y',array('NR' => $i));
}

if (isset($_POST['n_search']))
{
if (!empty($_POST['s_number']) && is_numeric($_POST['s_number']))
{
	$number="%".$_POST['s_number']."%";
	$number=sprintf("%s",$dataB->sql_check($number));
	if (isset($_POST['addr_calls']) && $_POST['addr_calls']=="addr" && isset($_POST['s_number']))
	{
		$sqlquery="SELECT t1.id,t1.name_first,t1.name_last,t2.number FROM phonenumbers AS t2 LEFT JOIN addressbook AS t1 ON t1.id=t2.addr_id WHERE t2.number LIKE $number";
	}
	elseif (isset($_POST['addr_calls']) && $_POST['addr_calls']=="call" && isset($_POST['s_number']))
	{	
		$sqlquery="SELECT  t1.id,t1.rufnummer,t1.datum,t1.uhrzeit,t1.name,t1.dienst,
		t5.name AS vorwahl,t1.msn,
		t3.name_first, t3.name_last,t3.id AS ADDR_ID,t2.areacode,
		t4.name AS msn_name
		FROM phonenumbers AS t2
		LEFT JOIN angerufene AS t1 ON t1.rufnummer=t2.number
		LEFT JOIN addressbook AS t3 ON t2.addr_id=t3.id
		LEFT JOIN msnzuname AS t4 ON t1.msn=t4.msn
		LEFT JOIN vorwahl AS t5 ON t1.vorwahl=t5.id WHERE t1.rufnummer LIKE $number";
		/*
		$sqlquery="SELECT t1.id ,t1.rufnummer,t1.uhrzeit,t5.name AS vorwahl,t1.datum,t1.dienst,t1.msn,t3.id AS ADDR_ID,t4.name AS msn_name,t3.name_first,t3.name_last FROM angerufene AS t1 LEFT JOIN phonenumbers AS t2 ON t2.number=t1.rufnummer LEFT JOIN addressbook As t3 ON t2.addr_id=t3.id LEFT JOIN vorwahl AS t5 ON t1.vorwahl=t5.id LEFT JOIN msnzuname AS t4 ON t1.msn=t4.msn WHERE t1.rufnummer LIKE $number";
		*/
	}
	if (!empty($_POST['s_msn']) && is_numeric($_POST['s_msn']))
	{
		$sqlquery=sprintf("%s AND t1.msn=%s",$sqlquery,
			$dataB->sql_checkn($_POST['s_msn']));
	}
	if (isset($_POST['be_dates'])&&$_POST['be_dates']=="on" && is_numeric($_POST['first_d']) &&
		is_numeric($_POST['first_m']) && is_numeric($_POST['first_j']) &&
		is_numeric($_POST['last_d']) && is_numeric($_POST['last_m']) &&
		is_numeric($_POST['last_y']))
	{
		$datum1=sprintf("%s-%s-%s",$_POST['first_j'],$_POST['first_m'],$_POST['first_d']);
		$datum2=sprintf("%s-%s-%s",$_POST['last_y'],$_POST['last_m'],$_POST['last_d']);
		$sqlquery=sprintf("%s AND UNIX_TIMESTAMP(t1.datum)>=UNIX_TIMESTAMP(%s) AND UNIX_TIMESTAMP(t1.datum)<=UNIX_TIMESTAMP(%s)", $sqlquery,$dataB->sql_check($datum1),$dataB->sql_check($datum2));
		
	}
	
}
else
{
	$template->assign_block_vars('tab2',array(
		'L_SEARCH_ERROR' => $textdata['error_onsearch']));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	die();
}
//AUSGABE AN BROWSER SUCHERGEBNIS:
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if ($_POST['addr_calls']=="addr")
{
	$i=0;
	$template->assign_block_vars('addr',array(
		'L_ADDR_LAST_NAME' => $textdata['addadress_nachname'],
		'L_ADDR_FIRST_NAME' => $textdata['addadress_vorname'],
		'L_ADDR_TELEPHON_NUMBER' => $textdata['adressbuch_telefonNR'],
		'L_ADDR_CELL_PHONE' => $textdata['addadress_handy']));
	$result_addr=$dataB->sql_query($sqlquery);
	if ($dataB->sql_num_rows($result_addr)<1)
	{
		$template->assign_block_vars('addr_not_found',array(
			'L_NOT_FOUND_ADDR' =>$textdata['addr_not_found']));
	}
	while($daten_addr=$dataB->sql_fetch_assoc($result_addr))
	{
		if($i%2==0)
		{
			$color=$row_color_1;
		}
		else
		{
			$color=$row_color_2;
		}
		$result_cell=$dataB->sql_query("SELECT number FROM phonenumbers WHERE typ='2' AND addr_id='$daten_addr[id]' LIMIT 1");
		$daten_cell=$dataB->sql_fetch_assoc($result_cell);
		$template->assign_block_vars('addr.data', array(
				'color' => $color,
				'addr_id' => $daten_addr['id'],
				'addr_last_name' => $daten_addr['name_last'],
				'addr_first_name' => $daten_addr['name_first'],
				'addr_tele_1' => $daten_addr['number'],
				'addr_cell_phone' => $daten_cell['number'],
				'addr_edit_entry' => $textdata['adressbuch_eintrag_bearbeiten'],
				'addr_delete_entry' => $textdata['adressbuch_eintrag_loeschen'],
				'addr_search_entry' => $textdata['adressbuch_suche_eintraege'],
				'addr_search_entry' =>  $textdata['adressbuch_suche_eintraege']
  				));
		
			  
		$i++;
	}
}//ADDR AUSGEBENE ENDE:
if ($_POST['addr_calls']=="call")
{
	$template->assign_block_vars('cell',array(
		'L_DATE' => $textdata['stat_anrufer_datum'],
		'L_CLOCK' => $textdata['stat_anrufer_uhrzeit'],
		'L_CALL_NUMBER' => $textdata['stat_anrufer_rufnummer'],
		'L_CALLERS_NAME' =>$textdata['showstatnew_name'],
		'L_COPY_TO_ADDR' => $textdata['showstatnew_ins_addr']));
	if ($_SESSION['show_type'])
	{
	$template->assign_block_vars('cell.userconfig_show_typ', array('L_CALLERS_TYP' => $textdata['showstatnew_anrufertyp']));
	}
	if ($_SESSION['show_prefix'])
	{
	$template->assign_block_vars('cell.userconfig_show_prefix', array('L_FROM_CITY' => $textdata['showstatnew_aus_ort']));
	}
	if ($_SESSION['show_msn'])
	{
	$template->assign_block_vars('cell.userconfig_show_msn', array('L_CALL_TO_MSN' => $textdata['stat_anrufer_MSN']));
	}
	if ($_SESSION['show_callback'])
	{
	$template->assign_block_vars('cell.userconfig_show_call_back', array('L_SHOW_CALL_BACK' => $textdata['showstatnew_zurueckrufen']));
	}
	if ($_SESSION['allow_delete']) 
	{
	$template->assign_block_vars('cell.userconfig_show_delete', array('L_DELETE_ENTRY_TITLE' => $textdata['showstatnew_loeschen']));
	}
	$i=0;
	$result_call=$dataB->sql_query($sqlquery);
	if ($dataB->sql_num_rows($result_call)<1)
	{
		$template->assign_block_vars('addr_not_found',array(
			'L_NOT_FOUND_ADDR' =>$textdata['addr_not_found']));
	}
	while($daten=$dataB->sql_fetch_assoc($result_call))
	{
 //resetten der vars:
 $anz_statistik="";
 $anz_name="";
 $anz_insaddr="";
 $anz_rueckruf="";
 $anz_msn="";
if ($daten['vorwahl']=="cell phone")
  {
   $anz_vorwahl=$textdata['cell_pone'];
  }
  else
  {
   $anz_vorwahl=$daten['vorwahl'];
  }
   if ($daten['rufnummer']=="unknown" && $daten['name']=="unknown")
    {
     if (isset($_GET['datum'])) $submit_date="&datum=".$_GET['datum'];
     else if (isset($_GET['sdatum'])) $submit_date="&datum=".$_GET['sdatum'];
     else $submit_date=""; 
     $anz_name="<a href=\"./showstatnew.php?unbekannt=yes&#038;einid=$daten[id]$submit_date\">unbekannt</a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten['rufnummer']!="unknown" && $daten['name_last']==NULL)
    {
     $anz_name=$daten['name'];
     $wertaddaddr=handynr_vorhanden($daten_cell['rufnummer']);
     $anz_insaddr="<a href=\"./addressbook_add.php?$wertaddaddr\"><img src=\"./images/1rightarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\" /></a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=&#038;nr=$daten[rufnummer]\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten['rufnummer']=="unknown" && $daten['name']!="unknown")
    {
     $anz_name=$daten['name'];
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   else
    {
     $anz_name="<a href=\"./addressbook.php?id=$daten[ADDR_ID]#find\">$daten[name_first] $daten[name_last]</a>";
     $anz_statistik="<a href=\"./statistic_person.php?id=$daten[ADDR_ID]\" title=\"$textdata[showstatnew_zeige_anrufstat] $daten[name_first] $daten[name_last]\"><img  src=\"./images/data.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\" /></a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addr=$daten[ADDR_ID]\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
    if ($daten['msn_name']==NULL)
     {
      $anz_msn=$daten['msn'];
     }
    else
     {
      $anz_msn=$daten['msn_name'];
     }
    //MSNS überprüfen:
    $show_entry_msns=msns_ueberpruefen($_SESSION['msn_listen'],$daten['msn']);
    //Datum umwandeln, und wegen Heute/Gestern funktion:
    $anz_datum=anzeige_datum(mysql_datum($daten['datum']),$textdata['today'],$textdata['yesterday']);
    //ermittle Dienstkennung:
    $anz_dienst=ermittle_typ_anruf($daten['dienst']);
    //TEMPLATE FUELLEN ANFANG:
    if ($show_entry_msns)
     {  
      if($i%2==0)
      { $color=$row_color_1; }
      else
      { $color=$row_color_2; }
      $template->assign_block_vars('cell.data', array(
	'DATA_ROW_COLOR' => $color,
	'DATA_SHOW_SINGEL_STAT' => $anz_statistik,
	'DATA_SHOW_DATE' => $anz_datum,
	'DATA_SHOW_CLOCK' => $daten['uhrzeit'],
	'DATA_SHOW_NUMBER' => $daten['rufnummer'],
	'DATA_SHOW_CALLERS_NAME' => $anz_name,
	'DATA_TO_ADDR' => $anz_insaddr));

if ($_SESSION['show_type'])
 {
  $template->assign_block_vars('cell.data.show_call_typ', array('DATA_CALLERS_TYP' =>$anz_dienst));
 }
if ($_SESSION['show_prefix'])
 {
  $template->assign_block_vars('cell.data.show_prefix', array('DATA_SHOW_PREFIX' => $anz_vorwahl));
 }
if ($_SESSION['show_msn']) 
 {
  $template->assign_block_vars('cell.data.show_msn', array('DATA_SHOW_MSN' => $anz_msn));
 }
if ($_SESSION['show_callback']) 
 {
  $template->assign_block_vars('cell.data.show_call_back',array('DATA_SHOW_CALL_BACK' =>$anz_rueckruf ));
 }
if ($_SESSION['allow_delete'])
 {
  $template->assign_block_vars('cell.data.show_delete_func', array(
  	'DATA_LINK_DELETE_FUNC' => $daten['id'],
	'L_DELETE_ENTRY_FROM_DB' => $textdata['showstatnew_loesche_db']));
 }
		
		
		$i++;
	}
	}
}//Statistik ausgeben ende



$dataB->sql_close();
}//isset search set!
$template->pparse('overall_body');
include("./footer.inc.php");
?>