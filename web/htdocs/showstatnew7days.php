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
$seite=base64_encode("showstatnew7days.php");

include("./login_check.inc.php");
include("./header.inc.php");

$datum[0]=date("d.m.Y");
$tag[0]=date("D");

for ($e=1;$e<=6;$e++)
 {
 $tstamp  = mktime(0, 0, 0, date("m"), date("d")-$e, date("Y"));
 $datum[$e]=date("d.m.Y",$tstamp);
 $tag[$e]=date("D",$tstamp );
 }
$template->set_filenames(array('overall_body' => './templates/blueingrey/show_call_stat7.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[days7_7tage_uebersicht]));



if (isset($_GET[unbekannt]))
 {
 echo "<br /><form action=\"./showstatnew.php\" method=\"post\"><input type=\"hidden\" name=\"newid\" value=\"$_GET[einid]\">";
 echo "Name: <input name=\"newname\" type=\"text\"> <input type=\"submit\" name=\"eintragen\" value=\"$textdata[addadress_eintrag_aufnehmen]\">";
 echo "</form><br />";
 }
if (isset($_POST[eintragen]))
  {
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $zugriff_mysql->sql_abfrage("UPDATE angerufene SET name='$_POST[newname]' WHERE id=$_POST[newid]");
   $zugriff_mysql->close_mysql();
  }

echo "<br />";
for ($es=0;$es<=6;$es++)
{
switch ($tag[$es])
   {
    case 'Mon':
     $tag[$es]="$textdata[days7_montag]";
    break;
    case 'Tue':
     $tag[$es]="$textdata[days7_dienstag]";
    break;
    case 'Wed':
     $tag[$es]="$textdata[days7_mittwoch]";
    break;
    case 'Thu':
     $tag[$es]="$textdata[days7_donnerstag]";
    break;
    case 'Fri':
     $tag[$es]="$textdata[days7_freitag]";
    break;
    case 'Sat':
     $tag[$es]="$textdata[days7_samstag]";
    break;
    case 'Sun':
     $tag[$es]="$textdata[days7_sonntag]";
    break;
   }



$template->assign_block_vars('tab0',array(
		'L_DATE_P' => $datum[$es],
		'L_DAY_P' => $tag[$es],
  		'L_DATE' => $textdata[stat_anrufer_datum],
		'L_CLOCK' => $textdata[stat_anrufer_uhrzeit],
		'L_CALL_NUMBER' => $textdata[stat_anrufer_rufnummer],
		'L_CALLERS_NAME' =>$textdata[showstatnew_name],
		'L_COPY_TO_ADDR' => $textdata[showstatnew_ins_addr]));
if ($userconfig['showtyp'])
 {
  $template->assign_block_vars('tab0.userconfig_show_typ',array('L_CALLERS_TYP' => $textdata[showstatnew_anrufertyp]));
 }
if ($userconfig['showvorwahl'])
 {
  $template->assign_block_vars('tab0.userconfig_show_prefix',array('L_FROM_CITY' => $textdata[showstatnew_aus_ort]));
 }
if ($userconfig['showmsn'])
 {
  $template->assign_block_vars('tab0.userconfig_show_msn',array('L_CALL_TO_MSN' => $textdata[stat_anrufer_MSN]));
 }
if ($userconfig['showrueckruf'])
 {
  
  $template->assign_block_vars('tab0.userconfig_show_call_back',array('L_SHOW_CALL_BACK' => $textdata[showstatnew_zurueckrufen]));
 }
if ($userconfig['loeschen']) 
 {
  $template->assign_block_vars('tab0.userconfig_show_delete',array('L_DELETE_ENTRY_TITLE' => $textdata[showstatnew_loeschen]));
 }
 
$i=0;
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$tmp=datum_mysql($datum[$es]);
$tab_angerufene=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE datum='$tmp' ORDER BY 'id'  DESC");
  while($data=mysql_fetch_row($tab_angerufene))
   {
    //alles zurücksetzten:
    $data[2]=mysql_datum($data[2]);
    $anz_name="";
    $anz_reuckruf="";
    $anz_vorwahl="";
    $anz_insaddr="";
    $anz_statistik="";
    $anz_typ="";

    if($i%2==0)
      { $color=$row_color_1; }
    else
      { $color=$row_color_2; }

    //MSNS überprüfen:
    $show_entry_msns=msns_ueberpruefen($userconfig['msns'],$data[6]);
     
     
   
   $tab_adressbuch =$zugriff_mysql->sql_abfrage("SELECT id,vorname,nachname,tele1,tele2,tele3,handy,fax FROM adressbuch WHERE tele1='$data[1]' OR tele2='$data[1]' OR tele3='$data[1]' OR handy='$data[1]' OR fax='$data[1]'");
   $adress_data=mysql_fetch_row($tab_adressbuch);
   if ($adress_data==false)
    {
  
     if ($data[1]=="unbekannt")
      {
        if ($data[5]=="unbekannt")
         {
	$anz_name="<a href=\"./showstatnew.php?unbekannt=yes&amp;einid=$data[0]\">unbekannt</a>";
	$anz_name1_d="unbekannt";
	 }
	else
	 {
	  $anz_name="$data[5]";
	  $anz_name1_d="$data[5]";
	 } 
      } // if data[1]==unbekannt ebde
     else
      {
      //ins adressbuch anzeigen
      $anz_name="$textdata[showstatnew_unbekannt]";
      //erkenne handyNr oder Festnetznummer:
     $wertaddaddr=handynr_vorhanden($data[1]); 
     $anz_insaddr="<a href=\"./addressbook_add.php?$wertaddaddr\"><img src=\"./bilder/1rightarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
      }
    $anz_name1=$anz_name;
    } // if adresse gefunden in DB ENDE
    else
    {
      if ($adress_data[6]==$data[1])
       {
        $full_name="$adress_data[1] $adress_data[2] $textdata[showstatnew_handy]";
       }
      elseif ($adress_data[7]==$data[1])
       {
        $full_name="$adress_data[1] $adress_data[2] (FAX)";
       } 
      else
       {
       $full_name="$adress_data[1] $adress_data[2]";
       }
     $anz_name1_d=$full_name;
     $anz_name="<a href=\"./addressbook.php?findnr=$data[1]#find\">$full_name</a>";
     $anz_statistik="<a href=\"./stat_anrufer.php?id=$adress_data[0]\" title=\"$textdata[showstatnew_zeige_anrufstat] $adress_data[1] $adress_data[2]\">
      <img  src=\"./bilder/data.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    } // else ende adresse in DB gefunden
   $d_name=base64_encode($anz_name1_d);
   $d_uhrzeit=base64_encode($data[3]);
   $d_datum=base64_encode($data[2]);
   $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addname=$d_name&amp;addrufnummer=$data[1]&amp;zuhrzeit=$d_uhrzeit&amp;zdatum=$d_datum\">
   <img src=\"./bilder/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
   
//show_vorwahl
if ($userconfig['showvorwahl'])
  {
   $anz_vorwahl=$data[7];
  }
  
//MSN zu Name
$anz_msn=msnzuname($data[6]);
// Anruftyp bzw Dienstkennung erkennen:
$anz_dienst=ermittle_typ_anruf($data[8]);;

//Datum umwandeln wenn heute oder gestern, dann schreibe heute/gestern
$anz_datum=anzeige_datum($data[2]);

// SCHREIBE DATEN in TABELLE:
//datenblock in eine Variable schreiben:




if ($show_entry_msns) 
{  
  $template->assign_block_vars('tab0.tab1', array(
  'DATA_ROW_COLOR' => $color,
  'DATA_SHOW_SINGEL_STAT' => $anz_statistik,
  'DATA_SHOW_DATE' => $anz_datum,
  'DATA_SHOW_CLOCK' => $data[3],
  'DATA_SHOW_NUMBER' => $data[1],
  'DATA_SHOW_CALLERS_NAME' => $anz_name,
  'DATA_TO_ADDR' => $anz_insaddr));

if ($userconfig['showtyp'])
 {
  $template->assign_block_vars('tab0.tab1.show_typ', array('DATA_CALLERS' =>$anz_dienst));
 }
if ($userconfig['showvorwahl'])
 {
  $template->assign_block_vars('tab0.tab1.show_prefix', array('DATA_SHOW_PREFIX' => $data[7]));
 }
if ($userconfig['showmsn']) 
 {
  $template->assign_block_vars('tab0.tab1.show_msn', array('DATA_SHOW_MSN' => $anz_msn));
 }
if ($userconfig['showrueckruf']) 
 {
  $template->assign_block_vars('tab0.tab1.show_call_back',array('DATA_SHOW_CALL_BACK' =>$anz_rueckruf ));
 }
if ($userconfig['loeschen'])
 {
  $template->assign_block_vars('tab0.tab1.show_delete_func', array(
  	'DATA_LINK_DELETE_FUNC' => $data[0].$loeschen_seiten,
	'L_DELETE_ENTRY_FROM_DB' => $textdata[showstatnew_loesche_db]));
 }
//END WRITE DATA TO TABLE
  $i++;
}
  
     
} // while zu ende
$zugriff_mysql->close_mysql(); 
}//ende FOR schleife

$template->pparse('overall_body');
include("./footer.inc.php");
?>
