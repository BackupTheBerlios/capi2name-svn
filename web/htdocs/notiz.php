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
if (isset($new))
 {
 $seite=base64_encode("notiz.php?new=yes");
 }
else {
$seite=base64_encode("notiz.php");
     }
include("./login_check.inc.php");
include("./header.inc.php");
?>

<? echo "<div class=\"ueberschrift_seite\">$textdata[notiz_notizen]</div>"; ?>
<br />

<?
//ob er die Page anschauen darf:
 if ($shownotiz=="no")
  {
   echo "<center><font color=\"red\">$textdata[configpage_nicht_berechtigt]</font></center>";
   include("./footer.inc.php");
   die();
  }
?>


<?
// neue Notiz eintagen
if (isset($_POST[absenden]))
{
$schreiber=$_POST[schreiber];
$topic=$_POST[topic];
$textn=$_POST[textn];
if (!$schreiber) { echo "<font color=red>$textdata[notiz_schreiber_angeben]</font>"; die(); }
if (!$topic) { echo "<font color=red>$textdata[notiz_topic_angeben]</font>"; die(); }
if (!$textn) { echo "<font color=red>$textdata[notiz_text_angeben]</font>"; die(); }
$textn =  strip_tags($textn);
$textn =  nl2br($textn);
$datum = date("d.m.Y");
$uhrzeit = date("G:i");
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("INSERT INTO notiz VALUES(NULL, '$datum', '$uhrzeit', '$topic', '$schreiber', '$textn')");
$zugriff_mysql->close_mysql();
echo "<meta http-equiv=\"refresh\" content=\"1; URL=./notiz.php?x=y\">";
}
// neue Notiz eintagen ENDE
?>
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left">
 <tr>
  <td style="width:130px; text-align:center; font-weight:bold;">
                 <? echo "$textdata[notiz_datum_uhrzeit]";?></td>
  <td style="width:250px; text-align:center; font-weight:bold;">
   <? echo "$textdata[notiz_topic]"; ?></td>
  <td style="width:130px; text-align:center; font-weight:bold;">
          <? echo "$textdata[notiz_schreiber]"; ?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
<?
//vorhandene notizen auslesen:
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM notiz");
$anzahl=mysql_numrows($result);
for ($i=$anzahl-1;$i>-1;$i--)
 {
  $id=mysql_result($result, $i, "id");
  $datum=mysql_result($result, $i, "datum");
  $uhrzeit=mysql_result($result, $i, "uhrzeit");
  $topic=mysql_result($result, $i, "topic");
  $schreiber=mysql_result($result, $i, "schreiber");

  echo "
  <tr>
   <td>$datum / $uhrzeit</td>
   <td><a href=\"./editnotiz.php?show=yes&amp;sid=$id\">$topic</a></td>
   <td style=\"text-align:center;\">$schreiber</td>
   <td style=\"text-align:center;\"><a href=\"./editnotiz.php?edit=yes&amp;eid=$id\" ><img src=\"./bilder/edit.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   <td style=\"text-align:center;\"><a href=\"./editnotiz.php?loeschen=yes&amp;lid=$id\" ><img src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
  </tr>
  ";

 }//for schleife ende
$zugriff_mysql->close_mysql();
// auslesen ende
?>
</table>
<?
if (isset($_GET['new']))
{
echo "
<br /><br /><hr />
<div class=\"ueberschrift_seite\">$textdata[notiz_neue_notiz]</div>
<form action=\"$PHP_SELF\" method=\"post\">
<table border=\"0\" style=\"margin-right:auto;margin-left:auto;\">
 <tr>
  <td>
<table border=\"0\" style=\"margin-right:auto;margin-left:auto;text-align:left\">
 <tr>
  <td>$textdata[notiz_schreiber]:</td>
  <td><input name=\"schreiber\" value=\"$_COOKIE[ck_name]\"/></td>
 </tr>
 <tr>
  <td>$textdata[notiz_topic]:</td>
  <td><input name=\"topic\"/></td>
 </tr>
</table>
  </td>
 </tr>
 <tr>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td><textarea rows=\"10\" cols=\"40\" name=\"textn\"></textarea></td>
 </tr>
 <tr>
  <td><input name=\"absenden\" type=\"submit\" value=\"$textdata[addadress_eintrag_aufnehmen]\"/><input name=\"reset\" type=\"reset\" value=\"$textdata[editadress_abbrechen]\"/></td>
 </tr>
</table>

</form>
";
}// if isset ende
?>
<br /><br />

<?
include("./footer.inc.php");
?>
