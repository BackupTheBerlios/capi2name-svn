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
$seite=base64_encode("showstatnew7days.php");
include("./login_check.inc.php");
include("./header.inc.php");

for ($e=0;$e<=7;$e++)
 {
 $tstamp  = mktime(0, 0, 0, date("m"), date("d")-$e, date("Y"));
 $datum[$e]=date("d.m.Y",$tstamp);
 $tag[$e]=date("D",$tstamp );
 }
$template->set_filenames(array('overall_body' => './templates/'.$_SESSION['template'].'/show_call_stat7.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata['days7_7tage_uebersicht']));



if (isset($_GET['unbekannt']))
 {
  $template->assign_block_vars('change_name_from_unkown', array(
  	'DATA_ID_FROM_DB' => $_GET['einid'],
	'L_SUBMIT_ENTRY' => $textdata['addadress_eintrag_aufnehmen']));
 }


if (isset($_POST['eintragen']))
  {
   $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $query=sprintf("UPDATE angerufene SET name=%s WHERE id=%s",
		$dataB->sql_check($_POST['newname']),
		$dataB->sql_checkn($_POST['newid']));
   $dataB->sql_query($query);
   $dataB->sql_close();
  }

for ($es=0;$es<=7;$es++)
{
switch ($tag[$es])
   {
    case 'Mon':
     $tag[$es]=$textdata['days7_montag'];
    break;
    case 'Tue':
     $tag[$es]=$textdata['days7_dienstag'];
    break;
    case 'Wed':
     $tag[$es]=$textdata['days7_mittwoch'];
    break;
    case 'Thu':
     $tag[$es]=$textdata['days7_donnerstag'];
    break;
    case 'Fri':
     $tag[$es]=$textdata['days7_freitag'];
    break;
    case 'Sat':
     $tag[$es]=$textdata['days7_samstag'];
    break;
    case 'Sun':
     $tag[$es]=$textdata['days7_sonntag'];
    break;
   }

$template->assign_block_vars('tab0',array(
		'L_DATE_P' => $datum[$es],
		'L_DAY_P' => $tag[$es],
  		'L_DATE' => $textdata['stat_anrufer_datum'],
		'L_CLOCK' => $textdata['stat_anrufer_uhrzeit'],
		'L_CALL_NUMBER' => $textdata['stat_anrufer_rufnummer'],
		'L_CALLERS_NAME' =>$textdata['showstatnew_name'],
		'L_COPY_TO_ADDR' => $textdata['showstatnew_ins_addr']));
if (isset($_SESSION['show_type']) && $_SESSION['show_type'])
 {
  $template->assign_block_vars('tab0.userconfig_show_typ',array('L_CALLERS_TYP' => $textdata['showstatnew_anrufertyp']));
 }
if (isset($_SESSION['show_prefix']) && $_SESSION['show_prefix'])
 {
  $template->assign_block_vars('tab0.userconfig_show_prefix',array('L_FROM_CITY' => $textdata['showstatnew_aus_ort']));
 }
if (isset($_SESSION['show_msn']) && $_SESSION['show_msn'])
 {
  $template->assign_block_vars('tab0.userconfig_show_msn',array('L_CALL_TO_MSN' => $textdata['stat_anrufer_MSN']));
 }
if (isset($_SESSION['show_callback']) && $_SESSION['show_callback'])
 {
 
  $template->assign_block_vars('tab0.userconfig_show_call_back',array('L_SHOW_CALL_BACK' => $textdata['showstatnew_zurueckrufen']));
 }
if (isset($_SESSION['allow_delete']) && $_SESSION['allow_delete']) 
 {
  $template->assign_block_vars('tab0.userconfig_show_delete',array('L_DELETE_ENTRY_TITLE' => $textdata['showstatnew_loeschen']));
 }
 

 
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$tmp=$dataB->sql_check(datum_mysql($datum[$es]));
$sql_query="SELECT  t1.id,t1.rufnummer,t1.datum,t1.uhrzeit,t1.name,t1.dienst,
		t5.name AS vorwahl,t1.msn,
		t3.name_first, t3.name_last,t3.id AS ADDR_ID,t2.areacode,
		t4.name AS msn_name
		FROM angerufene AS t1
		LEFT JOIN phonenumbers AS t2 ON t1.rufnummer=t2.number
		LEFT JOIN addressbook AS t3 ON t2.addr_id=t3.id
		LEFT JOIN msnzuname AS t4 ON t1.msn=t4.msn
		LEFT JOIN vorwahl AS t5 ON t1.vorwahl=t5.id
		WHERE t1.datum=$tmp AND t1.aktive='1' ORDER BY t1.id DESC ";


$result_angerufene=$dataB->sql_query($sql_query);
$dataB->sql_close();
$i=0;
while($daten=$dataB->sql_fetch_assoc($result_angerufene))
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
   if ($daten['rufnummer']=="unbekannt" && $daten['name']=="unbekannt")
    {
     $anz_name="<a href=\"./showstatnew7days.php?unbekannt=yes&#038;einid=$daten[id]\">unbekannt</a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten['rufnummer']!="unbekannt" && $daten['name_last']==NULL)
    {
     $anz_name=$daten['name'];
     $wertaddaddr=handynr_vorhanden($daten['rufnummer']);
     $anz_insaddr="<a href=\"./addressbook_add.php?$wertaddaddr\"><img src=\"./images/1rightarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\" /></a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten['rufnummer']=="unbekannt" && $daten['name']!="unbekannt")
    {
     $anz_name=$daten['name'];
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   else
    {
     $anz_name='<a href="./addressbook.php?id=' . $daten['ADDR_ID'] . '#find">' . $daten['name_first'].' '.$daten['name_last'] . '</a>';
     $anz_statistik='<a href="./statistic_person.php?id='.$daten['ADDR_ID'].'" title="'.$textdata['showstatnew_zeige_anrufstat'].' '.$daten['name_first'].' '. $daten['name_last'].'"><img  src="./images/data.png" style="border-width:0px;vertical-align:middle;" alt="" /></a>';
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
    $anz_datum=anzeige_datum(mysql_datum($daten['datum']));
    //ermittle Dienstkennung:
    $anz_dienst=ermittle_typ_anruf($daten['dienst']); 

if ($show_entry_msns) 
{  
  if($i%2==0)
   { $color=$row_color_1; }
  else
   { $color=$row_color_2; }
  $template->assign_block_vars('tab0.tab1', array(
  'DATA_ROW_COLOR' => $color,
  'DATA_SHOW_SINGEL_STAT' => $anz_statistik,
  'DATA_SHOW_DATE' => $anz_datum,
  'DATA_SHOW_CLOCK' => $daten['uhrzeit'],
  'DATA_SHOW_NUMBER' => $daten['rufnummer'],
  'DATA_SHOW_CALLERS_NAME' => $anz_name,
  'DATA_TO_ADDR' => $anz_insaddr));

if (isset($_SESSION['show_type']) && $_SESSION['show_type'])
 {
  $template->assign_block_vars('tab0.tab1.show_typ', array('DATA_CALLERS' =>$anz_dienst));
 }
if (isset($_SESSION['show_prefix']) && $_SESSION['show_prefix'])
 {
  $template->assign_block_vars('tab0.tab1.show_prefix', array('DATA_SHOW_PREFIX' => $anz_vorwahl));
 }
if (isset($_SESSION['show_msn']) && $_SESSION['show_msn']) 
 {
  $template->assign_block_vars('tab0.tab1.show_msn', array('DATA_SHOW_MSN' => $anz_msn));
 }
if (isset($_SESSION['show_callback']) && $_SESSION['show_callback']) 
 {
  $template->assign_block_vars('tab0.tab1.show_call_back',array('DATA_SHOW_CALL_BACK' =>$anz_rueckruf ));
 }
if (isset($_SESSION['allow_delete']) && $_SESSION['allow_delete'])
 {
  $template->assign_block_vars('tab0.tab1.show_delete_func', array(
  	'DATA_LINK_DELETE_FUNC' => $daten['id'],
	'L_DELETE_ENTRY_FROM_DB' => $textdata['showstatnew_loesche_db']));
 }
 $i++;
 }//show entry msn 
} //WHILE ende     

}//ende FOR schleife

$template->pparse('overall_body');
include("./footer.inc.php");
?>
