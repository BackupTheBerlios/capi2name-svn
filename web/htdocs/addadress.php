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
$seite=base64_encode("addadress.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>
<? echo "<div class=\"ueberschrift_seite\">$textdata[addadress_neuer_adressbuch_eintrag]</div>"; ?>
<br />
<?
// Eintrag eintragen.
if (isset($_POST[eintragen]))
 {
   if ($_POST[bvorname]=="" or $_POST[bnachname]=="")
     {
     echo "<br /><span style=\"text-algin:center;color:red;\">$textdata[adddress_nicht_eingetragen]</span>
     <br /><span style=\"text-algin:center;\">- 
      <a href=\"javascript:history.back()\">$textdata[adddress_zurueck]</a> -</span>";
     include("footer.inc.php");
     exit();
     }

 if ($_POST[bhandy] =="")  { $bhandy="99"; } else { $bhandy=$_POST[bhandy]; }
 if ($_POST[btele1] =="")  { $btele1="99"; }   else { $btele1=$_POST[btele1]; }
 if ($_POST[btele2] =="")  { $btele2="99"; }  else { $btele2=$_POST[btele2]; }
 if ($_POST[btele3] =="")  { $btele3="99"; }   else { $btele3=$_POST[btele3]; }     
 
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$res_value=$zugriff_mysql->sql_abfrage("INSERT INTO adressbuch 
					VALUES(NULL,'$_POST[bvorname]',
					'$_POST[bnachname]', '$_POST[bstrasse]', '$_POST[bhausnr]', '$_POST[bplz]', '$_POST[bort]', '$btele1', '$btele2', '$btele3',  '$bhandy', '$_POST[bfax]', '$_POST[bemail]')");

$zugriff_mysql->close_mysql();

if($res_value)
 {
  echo "
 <span style=\"text-algin:center;color:blue;\">$textdata[addadress_eintrag_aufgenommen_weiterleitung]</span>";
  echo "<meta http-equiv=\"refresh\" content=\"2; URL=./adressbuch.php\">";

 }
else
 {
  echo "<span style=\"text-algin:center;color:red;\">Eintrag nicht aufgenommen - Fehler</span>";
 }


 }//ende if



echo "
<form action=\"$SELF_PHP\" method=\"post\" >
<table border=\"0\" cellpadding=\"3\" style=\"margin-right:auto;margin-left:auto;\">
 <tr>
  <td>$textdata[addadress_vorname]:</td>
  <td style=\"width:12px;\"></td>
  <td><input name=\"bvorname\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_nachname]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bnachname\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_strasse]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bstrasse\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_hausnummer]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bhausnr\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_plz]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bplz\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_ort]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bort\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer1]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"btele1\" type=\"text\" value=\"$_GET[rufnr]\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer2]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"btele2\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer3]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"btele3\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$textdata[addadress_handy]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bhandy\" type=\"text\" value=\"$_GET[handy]\"/></td>
 </tr>
  <tr>
  <td>$textdata[addadress_fax]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bfax\" type=\"text\"/></td>
 </tr>

 <tr>
  <td>$textdata[addadress_email]:</td>
  <td style=\"12px;\"></td>
  <td><input name=\"bemail\" type=\"text\"/></td>
 </tr>
</table>
<ins><br/><input type=\"submit\" name=\"eintragen\" value=\"$textdata[addadress_eintrag_aufnehmen]\"/></ins>
</form>";

?>


<?
include("./footer.inc.php");
?>
