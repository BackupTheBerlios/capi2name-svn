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
$seite=base64_encode("editadress.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>

<? echo "<div class=\"ueberschrift_seite\">$textdata[editadress_adressbucheintrag_editieren]</div>"; ?>

<?
// Eintrag loeschen:
if (isset($_POST[wloeschen]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $result=$zugriff_mysql->sql_abfrage("DELETE FROM adressbuch WHERE id = $_POST[loeschenID]");
  $zugriff_mysql->close_mysql();
 echo "<div class=\"blau_mittig\">$textdata[editadress_eintrag_geloescht]</div>";
 echo "<meta http-equiv=\"refresh\" content=\"2; URL=./adressbuch.php\">";
 include("./footer.inc.php");
 exit;
 }

if (isset($_POST[loeschen]) or $_GET[loeschen]==1)
 {
 echo "<div class=\"rot_mittig\">$textdata[editadress_wirklich_loeschen]</div>";
 }

// Eintrag loeschen und neu mit gleicher ID reinschreiben.
if (isset($_POST[aendern]))
 {
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("DELETE FROM adressbuch WHERE id = $_POST[bid]");
 //eintragen:
 $bhandy=$_POST[bhandy];
 $btele1=$_POST[btele1];
 $btele2=$_POST[btele2];
 $btele3=$_POST[btele3];
 if ($bhandy =="")  { $bhandy="99"; }
 if ($btele1 =="")  { $btele1="99"; }
 if ($btele2 =="")  { $btele2="99"; }
 if ($btele3 =="")  { $btele3="99"; }
 $res=$zugriff_mysql->sql_abfrage("INSERT INTO adressbuch VALUES('$_POST[bid]','$_POST[bvorname]','$_POST[bnachname]', '$_POST[bstrasse]', '$_POST[bhausnr]', '$_POST[bplz]', '$_POST[bort]', '$btele1', '$btele2', '$btele3', '$bhandy', '$_POST[bfax]',  '$_POST[bemail]')");
 $zugriff_mysql->close_mysql();
 echo "<div class=\"blau_mittig\">$textdata[editadress_eintrag_veraendert]</div>";
 echo "<meta http-equiv=\"refresh\" content=\"2; URL=./adressbuch.php\">";
 }


// ======================================================================================
// =======================================================================================
// auslesen, baerbeiten = muss gesetzt sein.
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (isset($_POST[id]))
 {
  $eintrag=$_POST[id];
 }
 else
 {
  $eintrag=$_GET[bearbeiten];
 }
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM adressbuch WHERE id='$eintrag'");
$zugriff_mysql->close_mysql();
$row=mysql_fetch_row($result);
if ($row==false)
 {
 echo "<div class=\"rot_mittig\">$textdata[editadress_eintrag_mit_nicht_gefunden]</div>";
 }
 $id = $row[0];
 $vorname = $row[1];
 $nachname = $row[2];
 $strasse = $row[3];
 $hausnr = $row[4];
 $plz = $row[5];
 $ort = $row[6];
 $tele1 = $row[7];   if ($tele1 == "99") { $tele1="";}
 $tele2 = $row[8];   if ($tele2 == "99") { $tele2="";}
 $tele3 = $row[9];   if ($tele3 == "99") { $tele3="";}
 $handy = $row[10];   if ($handy == "99") { $handy="";}
 $fax = $row[11];
 $email = $row[12];
echo "
<form action=\"$PHP_SELF\" method=\"post\">
<table border=\"0\" cellpadding=\"3\" style=\"margin-right:auto;margin-left:auto;\">
 <tr>
  <td>$textdata[addadress_vorname]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bvorname\" type=\"text\" value=\"$vorname\"/><input name=\"bid\" value=\"$id\" type=\"hidden\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_nachname]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bnachname\" type=\"text\" value=\"$nachname\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_strasse]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bstrasse\" type=\"text\" value=\"$strasse\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_hausnummer]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bhausnr\" type=\"text\" value=\"$hausnr\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_plz]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bplz\" type=\"text\" value=\"$plz\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_ort]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bort\" type=\"text\" value=\"$ort\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer1]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"btele1\" type=\"text\" value=\"$tele1\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer2]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"btele2\" type=\"text\" value=\"$tele2\"/></td>
 </tr>
  <tr>
  <td>$textdata[addadress_telefonnummer3]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"btele3\" type=\"text\" value=\"$tele3\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_handy]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bhandy\" type=\"text\" value=\"$handy\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_fax]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bfax\" type=\"text\" value=\"$fax\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_email]:</td>
  <td style=\"width:12px\"></td>
  <td><input name=\"bemail\" type=\"text\" value=\"$email\"/></td>
 </tr>
</table>
<ins><br/><input name=\"id\" type=\"hidden\" value=\"$id\"/>
<input type=\"submit\" name=\"aendern\" value=\"$textdata[editadress_eintrag_aendern]\"/></ins><p></p>";
if (isset($_POST[loeschen_OK]) or $_GET[loeschen]==1)
 {
 echo "<ins><input type=\"hidden\" name=\"loeschenID\" value=\"$id\"/>";
 echo "<input type=\"submit\" name=\"wloeschen\" value=\"$textdata[adressbuch_eintrag_loeschen]\"/></ins>"; 
 }
else
 {
 
 echo "<ins><input type=\"hidden\" name=\"loeschen_OK\" value=\"$id\"/>";
  echo "<input type=\"submit\" name=\"loeschen\" value=\"$textdata[adressbuch_eintrag_loeschen]\"/></ins>";
 }  

echo "</form>";

?>


<span style="text-align:center">
  <form action="./adressbuch.php" method="post">
    <p><input type="submit" value="<? echo "$textdata[editadress_abbrechen]"; ?>"/></p>
</form>
</span>


<?
include("./footer.inc.php");
?>
