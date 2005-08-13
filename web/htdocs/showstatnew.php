<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                :  jonas.genannt@capi2name.de
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                  		   *
 *                                                                         *
 ***************************************************************************/
if (isset($_GET['datum']))
  { 
   if ($_GET['datum']=="heute")
     {
      $seite=base64_encode("showstatnew.php?datum=heute");
     }
   else
    {
     $seite=base64_encode("showstatnew.php?datum=gestern");
    }
  }
elseif (isset($_GET['sdatum']))
  {
   $seite=base64_encode("showstatnew.php?sdatum=".$_GET['sdatum']);
  }
else
{
$seite=base64_encode("showstatnew.php");
}
include("./login_check.inc.php");
include("./header.inc.php");
//pages berechung:
$cur_page="";
$maxlist=NULL;
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_angerufene=$dataB->sql_query("SELECT COUNT(*) AS all_calls FROM angerufene");
$daten_angerufene=$dataB->sql_fetch_assoc($result_angerufene);
$all_calls=$daten_angerufene['all_calls'];
$pages_num=(int)($daten_angerufene['all_calls']/100)+1;

$checkdate=false;
if (!isset($_GET['page'])) //zeige alle eintraege an
{
	$maxlist=$_SESSION['show_lines'];
}
else
{
	$cur_page=$_GET['page'];
}
$loeschen_seiten="";
if (isset($_GET['datum']))
{
	$maxlist=NULL; 
	$checkdate=true;
	if ($_GET['datum']=="gestern")
	{
		$anz_title=$textdata['showstatnew_gestrige_anrufe'];
		$tstamp  = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
		$datum = date("d.m.Y", $tstamp);
		$sql_datum=date("d.m.Y", $tstamp);
		$loeschen_seiten="&amp;datum=gestern";
	}
	elseif ($_GET['datum']=="heute")
	{
		$anz_title=$textdata['showstatnew_heutige_anrufe'];
		$datum = date("d.m.Y");
		$sql_datum=date("d.m.Y");
		$loeschen_seiten="&amp;datum=heute";
	}
}
elseif (isset($_GET['sdatum']))
{
	$checkdate=true;
	$maxlist=NULL;
	$anz_title=$textdata['header_inc_anrufstatistik'] . " " . $textdata['showstatnew_vom'] . " " . $_GET['sdatum'];
	$sql_datum=$_GET['sdatum'];
	$loeschen_seiten="&amp;sdatum=".$_GET['sdatum'];
}
else
{
	$anz_title=$textdata['header_inc_anrufstatistik'];
}
$template->set_filenames(array('overall_body' => './templates/'.$_SESSION['template'].'/show_call_stat.tpl'));
$template->assign_vars(array('L_CALL_STAT_TITLE' => $anz_title));
// buttons left and right with datum calc
if ($checkdate)
{
	$ex_datum=explode(".",$sql_datum);
	$tstamp1=mktime(0,0,0,$ex_datum[1],$ex_datum[0]-1,$ex_datum[2]);
	$tstamp2=mktime(0,0,0,$ex_datum[1],$ex_datum[0]+1,$ex_datum[2]);
}
else
{
	$tstamp1  = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
	$tstamp2  = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
}
if (date("d.m.Y", $tstamp1)==date("d.m.Y",mktime(0,0,0,date("m"), date("d")-1, date("Y"))))
{
	$template->assign_vars(array('date_back' => "datum=gestern"));
}
elseif(date("d.m.Y", $tstamp1)==date("d.m.Y",mktime(0,0,0,date("m"), date("d"), date("Y"))))
{
	$template->assign_vars(array('date_back' => "datum=heute"));
}
else
{
	$template->assign_vars(array('date_back' => "sdatum=".date("d.m.Y", $tstamp1)));
}
if (date("d.m.Y",$tstamp2)==date("d.m.Y"))
{
	$template->assign_vars(array('date_for' => "datum=heute"));
}
elseif(date("d.m.Y",$tstamp2)==date("d.m.Y",mktime(0,0,0,date("m"), date("d")-1, date("Y"))))
{
	$template->assign_vars(array('date_for' => "datum=gestern"));
}
else
{
	$template->assign_vars(array('date_for' => "sdatum=".date("d.m.Y", $tstamp2)));
}
$template->assign_vars(array('day_left' =>$textdata['day_left']));
if ($tstamp2 < time())
{
	$template->assign_block_vars('b_right',array());
}
if ($checkdate)
{
	$ex_datum=explode(".",$sql_datum);
	$ck_date=mktime(0,0,0,$ex_datum[1],$ex_datum[0],$ex_datum[2]);
	if ($ck_date>time())
	{
		$template->assign_block_vars('in_future',array(
			'warning' => $textdata['warning'],
			'L_DATA' => $textdata['date_in_future']));
	}
}
// END buttons left and right datum calc


if (isset($_GET['unbekannt']))
{
	if (isset($_GET['datum'])) $submit_date="?datum=".$_GET['datum'];
	else if (isset($_GET['sdatum'])) $submit_date="?datum=".$_GET['sdatum'];
	else  $submit_date="";
	$template->assign_block_vars('change_name_from_unkown', array(
		'DATA_ID_FROM_DB' => $_GET['einid'],
		'L_SUBMIT_ENTRY' => $textdata['addadress_eintrag_aufnehmen'],
		'DATE' => $submit_date));
}
if (isset($_POST['eintragen']))
{
	$query=sprintf("UPDATE angerufene SET name=%s WHERE id=%s",
		$dataB->sql_check($_POST['newname']),
		$dataB->sql_checkn($_POST['newid']));
	$dataB->sql_query($query);
}
$template->assign_vars(array(
		'L_DATE' => $textdata['stat_anrufer_datum'],
		'L_CLOCK' => $textdata['stat_anrufer_uhrzeit'],
		'L_CALL_NUMBER' => $textdata['stat_anrufer_rufnummer'],
		'L_CALLERS_NAME' =>$textdata['showstatnew_name'],
		'L_COPY_TO_ADDR' => $textdata['showstatnew_ins_addr']));
if ($_SESSION['show_type'])
{
	$template->assign_block_vars('userconfig_show_typ', array());
	$template->assign_vars(array('L_CALLERS_TYP' => $textdata['showstatnew_anrufertyp']));
}
if ($_SESSION['show_prefix'])
{
	$template->assign_block_vars('userconfig_show_prefix', array());
	$template->assign_vars(array('L_FROM_CITY' => $textdata['showstatnew_aus_ort']));
}
if ($_SESSION['show_msn'])
{
	$template->assign_block_vars('userconfig_show_msn', array());
	$template->assign_vars(array('L_CALL_TO_MSN' => $textdata['stat_anrufer_MSN']));
}
if ($_SESSION['show_callback'])
{
	$template->assign_block_vars('userconfig_show_call_back', array());
	$template->assign_vars(array('L_SHOW_CALL_BACK' => $textdata['showstatnew_zurueckrufen']));
}
if ($_SESSION['allow_delete']) 
{
	$template->assign_block_vars('userconfig_show_delete', array());
	$template->assign_vars(array('L_DELETE_ENTRY_TITLE' => $textdata['showstatnew_loeschen']));
}
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$sql_query_1="SELECT  t1.id,t1.rufnummer,t1.datum,t1.uhrzeit,t1.name,t1.dienst,
		t5.name AS vorwahl,t1.msn,t5.vorwahlnr,
		t3.name_first, t3.name_last,t3.id AS ADDR_ID,t2.areacode,
		t4.name AS msn_name
		FROM angerufene AS t1
		LEFT JOIN phonenumbers AS t2 ON t1.rufnummer=t2.number
		LEFT JOIN addressbook AS t3 ON t2.addr_id=t3.id
		LEFT JOIN msnzuname AS t4 ON t1.msn=t4.msn
		LEFT JOIN vorwahl AS t5 ON t1.vorwahl=t5.id";
$sql_query_2=" ORDER BY t1.id DESC";
if (!empty($sql_datum))
{
	$sql_query=$sql_query_1 . sprintf(" WHERE t1.datum=%s AND t1.aktive='1'",
		$dataB->sql_check(datum_mysql($sql_datum)));
}
else
{
	$sql_query=$sql_query_1. " WHERE t1.aktive='1'";
}
$sql_query=$sql_query.$sql_query_2;
if ($maxlist!=NULL)
{
	$sql_query=$sql_query. " LIMIT $maxlist";
	//$sql_query=$sql_query. sprintf(" LIMIT %s", $dataB->sql_check($maxlist));
}
elseif (isset($_GET['page']) && is_numeric($_GET['page']) )
{
	$tmp_start=$_GET['page']*100;
	$sql_query=$sql_query. " LIMIT $tmp_start, 100";
}
$result_angerufene=$dataB->sql_query($sql_query);
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
   $daten['rufnummer']=split_cellphone($daten['rufnummer']);
  }
  else
  {
   $daten['rufnummer']=split_number($daten['rufnummer'],$daten['vorwahlnr']);
   $anz_vorwahl=$daten['vorwahl'];
  }
   if ($daten['rufnummer']=="unknown" && $daten['name']=="unknown")
    {
     if (isset($_GET['datum'])) $submit_date="&datum=".$_GET['datum'];
     else if (isset($_GET['sdatum'])) $submit_date="&datum=".$_GET['sdatum'];
     else $submit_date=""; 
     $anz_name="<a href=\"./showstatnew.php?unbekannt=yes&#038;einid=$daten[id]$submit_date\">$textdata[unknown]</a>";
     $anz_rueckruf="<a href=\"./callback.php?add=yes&#038;addr=\">
   <img src=\"./images/1leftarrow.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    }
   elseif ($daten['rufnummer']!="unknown"  && $daten['name_last']==NULL)
    {
     $anz_name=$daten['name'];
     $wertaddaddr=handynr_vorhanden($daten['rufnummer']);
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
    $anz_datum=anzeige_datum(mysql_datum($daten['datum']));
    //ermittle Dienstkennung:
    $anz_dienst=ermittle_typ_anruf($daten['dienst']);
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
	'DATA_SHOW_CLOCK' => $daten['uhrzeit'],
	'DATA_SHOW_NUMBER' => $daten['rufnummer'],
	'DATA_SHOW_CALLERS_NAME' => $anz_name,
	'DATA_TO_ADDR' => $anz_insaddr));

if ($_SESSION['show_type'])
 {
  $template->assign_block_vars('tab1.show_call_typ', array('DATA_CALLERS_TYP' =>$anz_dienst));
 }
if ($_SESSION['show_prefix'])
 {
  $template->assign_block_vars('tab1.show_prefix', array('DATA_SHOW_PREFIX' => $anz_vorwahl));
 }
if ($_SESSION['show_msn']) 
 {
  $template->assign_block_vars('tab1.show_msn', array('DATA_SHOW_MSN' => $anz_msn));
 }
if ($_SESSION['show_callback']) 
 {
  $template->assign_block_vars('tab1.show_call_back',array('DATA_SHOW_CALL_BACK' =>$anz_rueckruf ));
 }
if ($_SESSION['allow_delete'])
 {
  $template->assign_block_vars('tab1.show_delete_func', array(
  	'DATA_LINK_DELETE_FUNC' => $daten['id'].$loeschen_seiten,
	'L_DELETE_ENTRY_FROM_DB' => $textdata['showstatnew_loesche_db']));
 }
 $i++;
 }//END SHOW MSN
    //TEMPLATE FUELLEN ENDE
 
   
}//END WHILE $result_angerufene

/*
for ($i=1;$i<=$pages_num;$i++)
{
	if ($i==$cur_page)
	{
		$template->assign_block_vars('show_pages',array(
			'D_PAGE'=> $i,
			'D_BOLD' => 'text-weidth:bold;'));
	}
	else
	{
		$template->assign_block_vars('show_pages',array(
			'D_PAGE'=> $i,
			'D_BOLD'  => ''));
	}
}
*/
$dataB->sql_close();
$template->pparse('overall_body');
include("./footer.inc.php");
?>
