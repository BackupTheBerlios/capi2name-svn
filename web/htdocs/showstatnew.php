<?
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
 *   any later version.                                   *
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
if ($_GET[maxlist] == "alle") { $maxlist="1000000"; }
if (!isset($_GET[maxlist])) { $maxlist=$userconfig['anzahl']; }
if ($_GET[showallmsns]=="yes") { $userconfig['msns']=""; }

if (isset($_GET[datum]))
 {
if ($_GET[datum]=="gestern")
 {
  $anz_title=$textdata[showstatnew_gestrige_anrufe];
  $tstamp  = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
  $datum = date("d.m.Y", $tstamp);
  $loeschen_seiten="&amp;datum=gestern";
 }
 elseif ($_GET[datum]=="heute")
 {
 $anz_title=$textdata[showstatnew_heutige_anrufe];
 $datum = date("d.m.Y");
 $loeschen_seiten="&amp;datum=heute";
 }
 }
elseif (isset($_GET[sdatum]))
 {
   $anz_title=$textdata[header_inc_anrufstatistik] . " " . $textdata[showstatnew_vom] . " " . $_GET[sdatum];
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
  $template->assign_block_vars('change_name_from_unkown', array(
  	'DATA_ID_FROM_DB' => $_GET[einid],
	'L_SUBMIT_ENTRY' => $textdata[addadress_eintrag_aufnehmen]));
 }
if (isset($_POST[eintragen]))
  {
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $zugriff_mysql->sql_abfrage("UPDATE angerufene SET name='$_POST[newname]' WHERE id=$_POST[newid]");
   $zugriff_mysql->close_mysql();
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

 
 $i=0;
 $up=0;
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 if (isset($_GET[datum]))
  {
  $tmp=datum_mysql($datum);
  $sqlabfrage="SELECT * FROM angerufene WHERE datum='$tmp' ORDER BY 'id'  DESC";
  }
  else if (isset($_GET[sdatum]))
  {
   $tmp=datum_mysql($_GET[sdatum]);
   $sqlabfrage="SELECT * FROM angerufene WHERE datum='$tmp' ORDER BY 'id'  DESC";
  }
  else
  {
  $sqlabfrage="SELECT * FROM angerufene ORDER BY 'id'  DESC";
  }

  $tab_angerufene=$zugriff_mysql->sql_abfrage($sqlabfrage);
   
  while($data=mysql_fetch_row($tab_angerufene))
   {
 if ($maxlist > $up)
  { // maxlist up if-schleife
    //alles zurücksetzten:
    $data[2]=mysql_datum($data[2]);
    $anz_name="";
    $anz_reuckruf="";
    $anz_vorwahl="";
    $anz_insaddr="";
    $anz_statistik="";

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
     $anz_name=$textdata[showstatnew_unbekannt];
     
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
     $anz_name="<a href=\"./addressbook.php?id=$adress_data[0]#find\">$full_name</a>";
     $anz_statistik="<a href=\"./stat_anrufer.php?id=$adress_data[0]\" title=\"$textdata[showstatnew_zeige_anrufstat] $adress_data[1] $adress_data[2]\">
      <img  src=\"./bilder/data.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    } // else ende adresse in DB gefunden
   $d_name=base64_encode($anz_name1_d);
   $d_uhrzeit=base64_encode($data[3]);
   $d_datum=base64_encode($data[2]);
   $anz_rueckruf="<a href=\"./callback.php?add=yes&amp;addname=$d_name&amp;addrufnummer=$data[1]&amp;zuhrzeit=$d_uhrzeit&amp;zdatum=$d_datum\">
   <img src=\"./bilder/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";


//MSN zu Name
$anz_msn=msnzuname($data[6]);

// Anruftyp bzw Dienstkennung erkennen:
$anz_dienst=ermittle_typ_anruf($data[8]);

//Datum umwandeln wenn heute oder gestern, dann schreibe heute/gestern
$anz_datum=anzeige_datum($data[2]);


//BEGIN WRITE DATA TO TABLE
if ($show_entry_msns)
 {  
  $template->assign_block_vars('tab1', array(
  'DATA_ROW_COLOR' => $color,
  'DATA_SHOW_SINGEL_STAT' => $anz_statistik,
  'DATA_SHOW_DATE' => $anz_datum,
  'DATA_SHOW_CLOCK' => $data[3],
  'DATA_SHOW_NUMBER' => $data[1],
  'DATA_SHOW_CALLERS_NAME' => $anz_name,
  'DATA_TO_ADDR' => $anz_insaddr));

if ($userconfig['showtyp'])
 {
  $template->assign_block_vars('tab1.show_call_typ', array('DATA_CALLERS_TYP' =>$anz_dienst));
 }
if ($userconfig['showvorwahl'])
 {
  $template->assign_block_vars('tab1.show_prefix', array('DATA_SHOW_PREFIX' => $data[7]));
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
  	'DATA_LINK_DELETE_FUNC' => $data[0].$loeschen_seiten,
	'L_DELETE_ENTRY_FROM_DB' => $textdata[showstatnew_loesche_db]));
 }
//END WRITE DATA TO TABLE
  $i++;
}

$up++;
} // maxlist ende
} // while zu ende
$zugriff_mysql->close_mysql();


$template->assign_vars(array('L_SHOW_ALL_CALLS_FROM_AB' => $textdata[showstatnew_alle_eintraege]));
$template->pparse('overall_body');
include("./footer.inc.php");
?>
