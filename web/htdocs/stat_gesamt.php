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
$seite=base64_encode("stat_gesamt.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>

<? echo "<div class=\"ueberschrift_seite\">$textdata[stat_gesamt_stat_alle_anrufe]</div>"; ?>

<?
mysql_connect($host, $dbuser, $dbpasswd);
mysql_select_db($db);
   $result_adressbuch=mysql_query("SELECT * FROM adressbuch");
   $ges_anzahl=mysql_num_rows($result_adressbuch);
    if ($ges_anzahl==FALSE)
     {
     echo "<div class=\"rot_mittig\">$textdata[stat_gesamt_keine_stat]</div>";
     mysql_close();
     }
     else
     { // wenn ein eintrag besteht, sonst wird das hier nicht ausgefühert.
   $index_array=0;
   for ($i=0;$i<$ges_anzahl;$i++)
     {
       //SQL abfrage in Variable schreiben. (wegen übersicht)
       $sql_abfrage="SELECT * FROM angerufene WHERE rufnummer=". mysql_result($result_adressbuch, $i, "tele1") . " OR rufnummer=" . mysql_result($result_adressbuch, $i, "tele2") . " OR rufnummer=" . mysql_result($result_adressbuch, $i, "tele3") . " OR rufnummer=" . mysql_result($result_adressbuch, $i, "handy") . ";" ;
        $result_anrufe=mysql_query($sql_abfrage); //sql-abfrage ausführen
         
	 if ( $result_anrufe!=FALSE)
	  {
       $ges_anrufe=mysql_num_rows($result_anrufe);
       $id_letzer=$ges_anrufe -1;
        if ($ges_anrufe!=false ) {  $datum_letzer=mysql_datum(mysql_result($result_anrufe, $id_letzer, "datum"));   }  else {     $datum_letzer="-"; }
        }
	 else
	  {  $ges_anrufe=0; $datum_letzer="-";   }
     //  echo "Anrufe gesamt: ". mysql_result($result_adressbuch, $i, "vorname") . " " . mysql_result($result_adressbuch, $i, "nachname") . " $ges_anrufe<BR />";
       $id_name=mysql_result($result_adressbuch, $i, "id");
       $array[$index_array]= array("id" => mysql_result($result_adressbuch, $i, "id"), "rang" => $ges_anrufe, "letzter" => $datum_letzer );
       $index_array++;

     }
   

if ($_GET[order]=="false") 
  {
   $option_order="true";
   $index=$index_array;
   }
  else
  {
  $option_order="false";
  $index=1;
   }




function sortarray($a, $b) {
 if ($a['rang'] == $b['rang']) { return 0;  }
   
  if ($_GET[order]=="false") 
  {
   return ($a['rang'] < $b['rang']) ? -1 : 1;
   }
  else
  {
  return ($b['rang'] < $a['rang']) ? -1 : 1;
   }
  
  
}
usort ($array, "sortarray");

echo "
<table border=\"0\" cellpadding=\"1\" cellspacing=\"2\" align=\"center\">
 <tr>
    <td style=\"width:30px;text-align:center;\">
    <a href=\"./stat_gesamt.php?order=$option_order\" title=\"$textdata[stat_gesamt_sortierung]\">
    <img src=\"./bilder/rotate.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
    <td style=\"width:100px;\">$textdata[addadress_nachname]</td>
    <td style=\"width:100px;\">$textdata[addadress_vorname]</td>
    <td style=\"width:50px;text-align:center;\">$textdata[stat_gesamt_anrufe]</td>
    <td style=\"width:95px;text-align:center;\">$textdata[stat_anrufer_letzter_anruf]</td>
    <td style=\"width:10px;\"></td>
    <td></td>
 </tr>

";
$i=0;
while (list ($key, $value) = each ($array)) {
   if($i%2==0)
   { $color=$c_color[11]; }
    else
    { $color=$c_color[12]; }
  $id=$value["id"];
  $rang=$value["rang"];
  $letzer_anruf=$value["letzter"];
  
  $result_adressbuch=mysql_query("SELECT vorname,nachname FROM adressbuch where id=$id");
  $daten_adressbuch=mysql_fetch_array($result_adressbuch);
  echo "
  <tr style=\"background-color:$color\">
  <td style=\"width:30px;text-align:left;\">$index</td>
  <td><a href=\"./adressbuch.php?id=$id#find\">$daten_adressbuch[nachname]</a></td>
  <td><a  href=\"./adressbuch.php?id=$id#find\">$daten_adressbuch[vorname]</a></td>
  <td style=\"text-align:right;\">$rang</td>
  <td style=\"text-align:center;\">$letzer_anruf</td>
  <td style=\"width:10px;\"></td>";
  if ($letzer_anruf=="-")
    {
     echo "<td></td>";
    }
   else
   {
    echo "
     <td style=\"text-align:center;\">
     <a href=\"./stat_anrufer.php?id=$id\" title=\"$textdata[adressbuch_suche_eintraege]\">
     <img src=\"./bilder/search.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>";
   }
  echo "</tr>";
 
 if ($_GET[order]=="false") 
  {
  $index--;
   }
  else
  {
  $index++;
   }
 
  
$i++;  
}
mysql_close();




echo "</table>";

} // ENDE wenn kein eintrag besteht
?>



  <?
  include("./footer.inc.php");
  ?>
