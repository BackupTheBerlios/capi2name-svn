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
$seite=base64_encode("stat_monat.php");
include("./login_check.inc.php");
include("./header.inc.php");
 
 
echo "<div class=\"ueberschrift_seite\">Monatsübersicht</div>";
?>
<?
$max_pixel_anzahl=400;

$datum_jahr[0]=date("Y");
$datum_monat[0]=date("m");

for ($e=1;$e<=2;$e++)
 {
 $tstamp  = mktime(0, 0, 0, date("m")-$e, date("d"), date("Y"));
 $datum_jahr[$e]=date("Y",$tstamp);
 $datum_monat[$e]=date("m", $tstamp);
 }

for ($i=0;$i<=2;$i++)
 {
  echo "<br>Datum_Jahr: $datum_monat[$i]/$datum_jahr[$i]";
 }
 

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
for ($e=0;$e<=2;$e++)
 {
  $result_alle=$zugriff_mysql->sql_abfrage("SELECT id,rufnummer FROM angerufene WHERE MONTH(datum)=$datum_monat[$e] AND YEAR(datum)=$datum_jahr[$e]");
$result_unbekannt=$zugriff_mysql->sql_abfrage("SELECT id,rufnummer FROM angerufene WHERE MONTH(datum)=$datum_monat[$e] AND YEAR(datum)=$datum_jahr[$e] AND rufnummer='unbekannt'");
$anzahl_monat_alle[$e]=mysql_num_rows($result_alle);
$anzahl_monat_unbekannt[$e]=mysql_num_rows($result_unbekannt);
$anzahl_monat_bekannt[$e]=$anzahl_monat_alle[$e]-$anzahl_monat_unbekannt[$e];
 }
$zugriff_mysql->close_mysql();

$max_anrufe=max($anzahl_monat_alle);
echo "<br/>Max-Anzhal: $max_anrufe<br/><br/>";


for ($i=0;$i<=2;$i++)
 {
  $pixel_alle=($max_pixel_anzahl/$max_anrufe)*$anzahl_monat_alle[$i];
  $pixel_unbekannt=($max_pixel_anzahl/$max_anrufe)*$anzahl_monat_unbekannt[$i];
  $pixel_bekannt=($max_pixel_anzahl/$max_anrufe)*$anzahl_monat_bekannt[$i];
  echo "
<div align=\"left\">
<img src=\"./bilder/balken_rot.jpg\" height=\"10\" width=\"$pixel_alle\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/>
Alle Anrufe $datum_monat[$i]/$datum_jahr[$i]: $anzahl_monat_alle[$i]<br/>
<img src=\"./bilder/balken_blau.jpg\" height=\"10\" width=\"$pixel_bekannt\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/>Bekannte Anrufe $datum_monat[$i]/$datum_jahr[$i]: $anzahl_monat_bekannt[$i]<br/>
<img src=\"./bilder/balken_gruen.jpg\" height=\"10\" width=\"$pixel_unbekannt\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/>Unbekannte Anrufe $datum_monat[$i]/$datum_jahr[$i]: $anzahl_monat_unbekannt[$i]<br/>
</div>
";
  
 }



?>
<br/>





<br /><br />

<?
include("./footer.inc.php");
?>
