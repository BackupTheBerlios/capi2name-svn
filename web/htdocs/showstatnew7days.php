<?
/*
    copyright            : (C) 2002-2004 by Jonas Genannt
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
 ?>
<?

$seite=base64_encode("showstatnew7days.php");

include("./login_check.inc.php");
include("./header.inc.php");
?>

<?
$datum[0]=date("d.m.Y");
$tag[0]=date("D");

for ($e=1;$e<=6;$e++)
 {
 $tstamp  = mktime(0, 0, 0, date("m"), date("d")-$e, date("Y"));
 $datum[$e]=date("d.m.Y",$tstamp);
 $tag[$e]=date("D",$tstamp );
 }
echo "<div class=\"ueberschrift_seite\">$textdata[days7_7tage_uebersicht]</div>";


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

echo "<p style=\"text-align:left; margin-bottom:0px; font-weight:bold\">
       $datum[$es] - $tag[$es]</p><br />";

echo "
<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\" style=\"margin-right:auto;margin-left:auto;\">
 <tr>
 <td></td>
  <td style=\"text-align:center\">$textdata[stat_anrufer_datum]</td>
  <td style=\"text-align:center\">$textdata[stat_anrufer_uhrzeit]</td>
  <td style=\"width:110px; text-align:center\">$textdata[stat_anrufer_rufnummer]</td>";
  if ($userconfig['showtyp']) 
   { echo "<td style=\"text-align:center\">$textdata[showstatnew_anrufertyp]</td>"; } 
  if ($userconfig['showvorwahl'])
   { echo "<td style=\"text-align:center\">$textdata[showstatnew_aus_ort]</td>"; } 
  if ($userconfig['showmsn'])
  { echo "<td style=\"text-align:center\">$textdata[stat_anrufer_MSN]</td>"; } 
  echo "<td style=\"text-align:center\">$textdata[showstatnew_name]</td>";
  if ($userconfig['showrueckruf'])
    { echo "<td style=\"text-align:center\">$textdata[showstatnew_zurueckrufen]</td>"; } 
  echo "<td style=\"text-align:center\">$textdata[showstatnew_ins_addr]</td>";
  if ($userconfig['loeschen'])
    { echo "<td>$textdata[showstatnew_loeschen]</td>"; } 
echo "</tr>";
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
      { $color="$c_color[11]"; }
    else
      { $color="$c_color[12]"; }

    //MSNS überprüfen:
    $show_entry_msns=msns_ueberpruefen($userconfig['msns'],$data[6]);
     
     
   
   $tab_adressbuch =$zugriff_mysql->sql_abfrage("SELECT id,vorname,nachname,tele1,tele2,tele3,handy FROM adressbuch WHERE tele1='$data[1]' OR tele2='$data[1]' OR tele3='$data[1]' OR handy='$data[1]'");
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
      $anz_insaddr="<a href=\"./addadress.php?$wertaddaddr\"><img src=\"./bilder/1rightarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
      }
    $anz_name1=$anz_name;
    } // if adresse gefunden in DB ENDE
    else
    {
      if ($adress_data[6]==$data[1])
       {
        $full_name="$adress_data[1] $adress_data[2] $textdata[showstatnew_handy]";
       }
      else
       {
       $full_name="$adress_data[1] $adress_data[2]";
       }
     $anz_name1_d=$full_name;
     $anz_name="<a href=\"./adressbuch.php?findnr=$data[1]#find\">$full_name</a>";
$anz_statistik="<a href=\"./stat_anrufer.php?id=$adress_data[0]\" title=\"$textdata[showstatnew_zeige_anrufstat] $adress_data[1] $adress_data[2]\">
      <img  src=\"./bilder/data.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    } // else ende adresse in DB gefunden
   $d_name=base64_encode($anz_name1_d);
   $d_uhrzeit=base64_encode($data[3]);
   $d_datum=base64_encode($data[2]);
   $anz_rueckruf="<a href=\"./zurueckruf.php?add=yes&amp;addname=$d_name&amp;addrufnummer=$data[1]&amp;zuhrzeit=$d_uhrzeit&amp;zdatum=$d_datum\">
   <img src=\"./bilder/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
   
//show_vorwahl
if ($userconfig['showvorwahl'])
  {
   $anz_vorwahl=$data[7];
  }
  
//MSN zu Name
$anz_msn=msnzuname($data[6]);
// Anruftyp bzw Dienstkennung erkennen:
$anz_typ=ermittle_typ_anruf($data[8]);

//Datum umwandeln wenn heute oder gestern, dann schreibe heute/gestern
$anz_datum=anzeige_datum($data[2]);

// SCHREIBE DATEN in TABELLE:
//datenblock in eine Variable schreiben:
$vorwahl_data="";
$msn_data="";
$rueckruf_data="";
$anruftyp="";
$anruf_loeschen="";
 if ($userconfig['showvorwahl']) 
     { $vorwahl_data="<td style=\"text-align:center\">$anz_vorwahl</td>";  }
 if ($userconfig['showmsn']) 
     { $msn_data="<td>$anz_msn</td>";  }
 if ($userconfig['showrueckruf']) 
     { $rueckruf_data="<td style=\"text-align:center\">$anz_rueckruf</td>";  }
 if ($userconfig['showtyp'])
     { $anruftyp="<td style=\"text-align:center\">$anz_dienst</td>"; }
 if ($userconfig['loeschen'])
     { $anruf_loeschen="<td style=\"text-align:center\"><a href=\"./stat_loeschen.php?id=$data[0]$loeschen_seiten\" title=\"$textdata[showstatnew_loesche_db]\">
 <img  src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>"; }
 
 
 $ALL="<tr style=\"background-color:$color\">
       <td>$anz_statistik</td>
       <td style=\"text-align:center\">$anz_datum</td>
       <td style=\"text-align:center\">$data[3]</td>
       <td style=\"text-align:center\">$data[1]</td>
       $anruftyp
       $vorwahl_data
       $msn_data
       <td style=\"text-align:center\">$anz_name</td>
       $rueckruf_data
       <td style=\"text-align:center\">$anz_insaddr</td>
       $anruf_loeschen
       </tr>";
   

if ($show_entry_msns=="true") {  echo "$ALL"; $i++;   }
  
     
} // while zu ende
$zugriff_mysql->close_mysql(); 
echo " </table>";
echo "<br /><br /><br />";
}//ende FOR schleife


include("./footer.inc.php");
?>
