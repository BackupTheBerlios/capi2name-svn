<?php
//error_reporting(E_ALL);
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonasge@gmx.net
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                  		   *
 *                                                                         *
 ***************************************************************************/
if (isset($_GET[datum]))
  { 
   if ($_GET[datum]=="heute")
     {
      $seite=base64_encode("showstatnew.php?datum=heute");
     }
   else
    {
     $seite=base64_encode("showstatnew.php?datum=gestern");
    }
  }
elseif (isset($_GET[sdatum]))
  {
   $seite=base64_encode("showstatnew.php?sdatum=$_GET[sdatum]");
  }
else
{
$seite=base64_encode("showstatnew.php");
}
include("./login_check.inc.php");
include("./header.inc.php");
if ($_GET[maxlist] == "alle") { $maxlist=NULL; }
if (!isset($_GET[maxlist])) { $maxlist=$userconfig['anzahl']; }
if ($_GET[showallmsns]=="yes") { $userconfig['msns']=""; }

if (isset($_GET[datum]))
 {
$maxlist=NULL; 
if ($_GET[datum]=="gestern")
 {
  $anz_title=$textdata[showstatnew_gestrige_anrufe];
  $tstamp  = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
  $datum = date("d.m.Y", $tstamp);
  $sql_datum=date("d.m.Y", $tstamp);
  $loeschen_seiten="&amp;datum=gestern";
 }
 elseif ($_GET[datum]=="heute")
 {
 $anz_title=$textdata[showstatnew_heutige_anrufe];
 $datum = date("d.m.Y");
 $sql_datum=date("d.m.Y");
 $loeschen_seiten="&amp;datum=heute";
 }
 }
elseif (isset($_GET[sdatum]))
 {
   $maxlist=NULL;
   $anz_title=$textdata[header_inc_anrufstatistik] . " " . $textdata[showstatnew_vom] . " " . $_GET[sdatum];
   $sql_datum=$_GET[sdatum];
   $loeschen_seiten="&amp;sdatum=$_GET[sdatum]";
 }
else
  {
  $anz_title=$textdata[header_inc_anrufstatistik];
  }

$template->set_filenames(array('overall_body' => './templates/'.$userconfig['template'].'/show_call_stat.tpl'));
$template->assign_vars(array('L_CALL_STAT_TITLE' => $anz_title));


if (isset($_GET[unbekannt]))
 {
  if (isset($_GET[datum])) $submit_date="?datum=$_GET[datum]";
  else if (isset($_GET[sdatum])) $submit_date="?datum=$_GET[sdatum]";
  else  $submit_date="";
  $template->assign_block_vars('change_name_from_unkown', array(
  	'DATA_ID_FROM_DB' => $_GET[einid],
	'L_SUBMIT_ENTRY' => $textdata[addadress_eintrag_aufnehmen],
	'DATE' => $submit_date));
 }
if (isset($_POST[eintragen]))
  {
   $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $query=sprintf("UPDATE angerufene SET name=%s WHERE id=%s",
   		$dataB->sql_check($_POST[newname]),
		$dataB->sql_checkn($_POST[newid]));
   $dataB->sql_query($query);
   $dataB->sql_close();
  }

$template->assign_vars(array(
  		'L_DATE' => $textdata[stat_anrufer_datum],
		'L_CLOCK' => $textdata[stat_anrufer_uhrzeit],
		'L_CALL_NUMBER' => $textdata[stat_anrufer_rufnummer],
		'L_CALLERS_NAME' =>$textdata[showstatnew_name],
		'L_COPY_TO_ADDR' => $textdata[showstatnew_ins_addr]));
if ($userconfig['showtyp'])
 {
  $template->assign_block_vars('userconfig_show_typ', array());
  $template->assign_vars(array('L_CALLERS_TYP' => $textdata[showstatnew_anrufertyp]));
 }
if ($userconfig['showvorwahl'])
 {
  $template->assign_block_vars('userconfig_show_prefix', array());
  $template->assign_vars(array('L_FROM_CITY' => $textdata[showstatnew_aus_ort]));
 }
if ($userconfig['showmsn'])
 {
  $template->assign_block_vars('userconfig_show_msn', array());
  $template->assign_vars(array('L_CALL_TO_MSN' => $textdata[stat_anrufer_MSN]));
 }
if ($userconfig['showrueckruf'])
 {
  
  $template->assign_block_vars('userconfig_show_call_back', array());
  $template->assign_vars(array('L_SHOW_CALL_BACK' => $textdata[showstatnew_zurueckrufen]));
 }
if ($userconfig['loeschen']) 
 {
  $template->assign_block_vars('userconfig_show_delete', array());
  $template->assign_vars(array('L_DELETE_ENTRY_TITLE' => $textdata[showstatnew_loeschen]));
 }
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$sql_query_1="SELECT  t1.id,t1.rufnummer,t1.datum,t1.uhrzeit,t1.name,t1.dienst,t1.vorwahl,t1.msn,
		t3.name_first, t3.name_last,t3.id AS ADDR_ID,t2.areacode,
		t4.name AS msn_name
		FROM angerufene AS t1
		LEFT JOIN phonenumbers AS t2 ON t1.rufnummer=t2.number
		LEFT JOIN addressbook AS t3 ON t2.addr_id=t3.id
		LEFT JOIN msnzuname AS t4 ON t1.msn=t4.msn";
$sql_query_2=" ORDER BY t1.id DESC";
if (!empty($sql_datum))
{
 $sql_query=$sql_query_1 . sprintf(" WHERE t1.datum=%s",
 	 $dataB->sql_check(datum_mysql($sql_datum)));
}
else
{
 $sql_query=$sql_query_1;
}
$sql_query=$sql_query.$sql_query_2;
if ($maxlist!=NULL)
 {
  $sql_query=$sql_query. " LIMIT $maxlist";
  //$sql_query=$sql_query. sprintf(" LIMIT %s", $dataB->sql_checkn($maxlist));

 }
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
 //bugfix for daemon program:
 //we do not show what service the cell phone uses, we print out 'cell phone'
 //for the calls from cell phone.
 //because you can take your number from XX to XX service provider
 if ($daten[areacode]==2)
  {
   $anz_vorwahl=$textdata[cell_pone];
  }
  else
  {
   $anz_vorwahl=$daten[vorwahl];
  }
 
   if ($daten[rufnummer]=="unbekannt" && $daten[name]=="unbekannt")
    {
     if (isset($_GET[datum])) $submit_date="&datum=$_GET[datum]";
     else if (isset($_GET[sdatum])) $submit_date="&datum=$_GET[sdatum]";
     else $submit_date=""; 
     $anz_name="<a href=\"./showstatnew.php?unbekannt=yes&einid=$daten[id]$submit_date\">unbekannt</a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addr=\">
   <img src=\"./images/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten[rufnummer]!="unbekannt" && $daten[name_last]==NULL)
    {
     $anz_name=$daten[name];
     $wertaddaddr=handynr_vorhanden($daten[rufnummer]);
     $anz_insaddr="<a href=\"./addressbook_add.php?$wertaddaddr\"><img src=\"./images/1rightarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\" /></a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addr=&nr=$daten[rufnummer]\">
   <img src=\"./images/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten[rufnummer]=="unbekannt" && $daten[name]!="unbekannt")
    {
     $anz_name=$daten[name];
     $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addr=\">
   <img src=\"./images/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   else
    {
     $anz_name="<a href=\"./addressbook.php?id=$daten[ADDR_ID]#find\">$daten[name_first] $daten[name_last]</a>";
     $anz_statistik="<a href=\"./statistic_person.php?id=$daten[ADDR_ID]\" title=\"$textdata[showstatnew_zeige_anrufstat] $daten[name_first] $daten[name_last]\"><img  src=\"./images/data.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\" /></a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addr=$daten[ADDR_ID]\">
   <img src=\"./images/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
    if ($daten[msn_name]==NULL)
     {
      $anz_msn=$daten[msn];
     }
    else
     {
      $anz_msn=$daten[msn_name];
     }
    //MSNS überprüfen:
    $show_entry_msns=msns_ueberpruefen($userconfig['msns'],$daten[msn]);
    //Datum umwandeln, und wegen Heute/Gestern funktion:
    $anz_datum=anzeige_datum(mysql_datum($daten[datum]));
    //ermittle Dienstkennung:
    $anz_dienst=ermittle_typ_anruf($daten[dienst]);
    //TEMPLATE FUELLEN ANFANG:
    if ($show_entry_msns)
     {  
      if($i%2==0)
      { $color=$row_color_1; }
      else
      { $color=$row_color_2; }
      $template->assign_block_vars('tab1', array(
	'DATA_ROW_COLOR' => $color,
	'DATA_SHOW_SINGEL_STAT' => $anz_statistik,
	'DATA_SHOW_DATE' => $anz_datum,
	'DATA_SHOW_CLOCK' => $daten[uhrzeit],
	'DATA_SHOW_NUMBER' => $daten[rufnummer],
	'DATA_SHOW_CALLERS_NAME' => $anz_name,
	'DATA_TO_ADDR' => $anz_insaddr));

if ($userconfig['showtyp'])
 {
  $template->assign_block_vars('tab1.show_call_typ', array('DATA_CALLERS_TYP' =>$anz_dienst));
 }
if ($userconfig['showvorwahl'])
 {
  $template->assign_block_vars('tab1.show_prefix', array('DATA_SHOW_PREFIX' => $anz_vorwahl));
 }
if ($userconfig['showmsn']) 
 {
  $template->assign_block_vars('tab1.show_msn', array('DATA_SHOW_MSN' => $anz_msn));
 }
if ($userconfig['showrueckruf']) 
 {
  $template->assign_block_vars('tab1.show_call_back',array('DATA_SHOW_CALL_BACK' =>$anz_rueckruf ));
 }
if ($userconfig['loeschen'])
 {
  $template->assign_block_vars('tab1.show_delete_func', array(
  	'DATA_LINK_DELETE_FUNC' => $daten[id].$loeschen_seiten,
	'L_DELETE_ENTRY_FROM_DB' => $textdata[showstatnew_loesche_db]));
 }
 $i++;
 }//END SHOW MSN
    //TEMPLATE FUELLEN ENDE
    
    
    
    
    
 }//END WHILE $result_angerufene


$template->assign_vars(array('L_SHOW_ALL_CALLS_FROM_AB' => $textdata[showstatnew_alle_eintraege]));
$template->pparse('overall_body');
include("./footer.inc.php");
?>
