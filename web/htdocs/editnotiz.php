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
$seite=base64_encode("editnotiz.php");
include("./login_check.inc.php");
include("./header.inc.php");
if ($_GET[edit] == "yes") { $ueberschrift="$textdata[editnotiz_bearbeiten]"; }
if ($_GET[show] == "yes") { $ueberschrift="$textdata[editnotiz_anzeigen]"; }
if ($_GET[loeschen] == "yes") { $ueberschrift="$textdata[editnotiz_loeschen]"; }
if (isset($_POST[aendern])) { $ueberschrift="$textdata[editnotiz_bearbeitetet_anzeigen]"; }
?>

<? echo "<div class=\"ueberschrift_seite\">$ueberschrift</div>"; ?>

<?
//ob er die Page anschauen darf:
 if ($shownotiz=="no")
  {
   echo "<div class=\"rot_mittig\">$textdata[configpage_nicht_berechtigt]</div>";
   include("./footer.inc.php");
   die();
  }
?>


<?
// aendere Eintrag: Anfang
if (isset($_POST[aendern]))
{
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("DELETE FROM notiz WHERE id=$_POST[bid]");
$bschreiber=$_POST[bschreiber];
$btopic=$_POST[btopic];
$btext=$_POST[btext];
if (!$bschreiber) { echo "<font color=red>$text[notiz1]</font>"; die(); }
if (!$btopic) { echo "<font color=red>$text[notiz2]</font>"; die(); }
if (!$btext) { echo "<font color=red>$text[notiz3]</font>"; die(); }
$btext =  strip_tags($btext);
$btext =  nl2br($btext);
$bdatum = date("d.m.Y");
$buhrzeit = date("G:i");
$result=$zugriff_mysql->sql_abfrage("INSERT INTO notiz VALUES('$_POST[bid]', '$bdatum', '$buhrzeit', '$btopic', '$bschreiber', '$btext')");
if ($result==1) {
   echo "<div class=\"rot_mittig\">$textdata[editadress_eintrag_veraendert]</div>";
    echo "<meta http-equiv=\"refresh\" content=\"1; URL=./editnotiz.php?show=yes&amp;sid=$_POST[bid]\">";
   }
$zugriff_mysql->close_mysql();
$show="yes";
$sid=$bid;
}//if isset ENde
// aendere Eintrag: ENDE

// show notiz  Anfang
if (isset($_GET[show]))
 {
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM notiz WHERE id=$_GET[sid]");
$daten=mysql_fetch_row($result);
$zugriff_mysql->close_mysql();
if ($daten==false)
 {
  $ge_id=$_GET[sid];
  echo "<div class=\"rot_mittig\">$textdata[editnotiz_eintrag_mit_nicht_gefunden]</div>";
 }

     echo "
<div align=\"center\">
<table border=\"0\">
 <tr>
  <td><center>
<table border=\"0\">
 <tr>
  <td>$textdata[editnotiz_schreiber]:</td>
  <td>$daten[4]</td>
 </tr>
 <tr>
  <td>$textdata[editnotiz_topic]:</td>
  <td>$daten[3]</td>
 </tr>
</table>
  </center></td>
 </tr>
 <tr>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>$daten[5]</td>
 </tr>

</table>
</div>

";


}//if ende
// show notiz ENDE ENDE
/*
======================================================
*/
// edit  notiz  Anfang
if (isset($_GET[edit]))
 {
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM notiz WHERE id='$_GET[eid]'");
$zugriff_mysql->close_mysql();
$daten=mysql_fetch_row($result);
if ($daten==false)
 {
  $ge_id=$_GET[eid];
  echo "<div class=\"rot_mittig\">$textdata[editnotiz_eintrag_mit_nicht_gefunden]</div>";
 }
 $textnotiz =  strip_tags($daten[5]);
     echo "
<form action=\"$PHP_SELF\" method=\"post\">
<div align=\"center\">
<TABLE BORDER=\"0\">
 <TR>
  <TD><center>
<table border=\"0\">
 <TR>
  <TD>$textdata[editnotiz_schreiber]:</TD>
  <TD><input name=\"bschreiber\" value=\"$daten[4]\"><input name=\"bid\" type=\"hidden\" value=\"$_GET[eid]\"></TD>
 </TR>
 <TR>
  <TD>$textdata[editnotiz_topic]</TD>
  <TD><input name=\"btopic\" value=\"$daten[3]\"></TD>
 </TR>
</table>
  </center></TD>
 </TR>
 <TR>
  <TD>&nbsp;</TD>
 </TR>
 <TR>
  <TD><textarea rows=\"10\" cols=\"40\" name=\"btext\">$textnotiz</textarea></TD>
 </TR>
 <TR>
  <TD><center><input name=\"aendern\" type=\"submit\" value=\"$textdata[editadress_eintrag_aendern]\"><input name=\"reset\" type=\"reset\" value=\"$textdata[editadress_abbrechen]\"></center></TD>
 </TR>
</TABLE>
</div>
</form>
";


}
// edit notiz ENDE ENDE
/*
======================================================
*/
// loeschen anfang
if (isset($_GET[loeschen]))
{
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("DELETE FROM notiz WHERE id=$_GET[lid]");
 $zugriff_mysql->close_mysql();
 echo "<BR /><div class=\"blau_mittig\">$textdata[editadress_eintrag_geloescht]</div>";
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./notiz.php?edit=OK\">";
} // if isset ende
// loeschen ENDE
?>

<?
include("./footer.inc.php");
?>
