<?php
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
<?php
$seite=base64_encode("showaddress.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>
<? echo "<div class=\"ueberschrift_seite\">$textdata[showaddress_deteilansicht]</div>"; ?>

<?php
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM adressbuch WHERE id='$_GET[show]'");
$row=mysql_fetch_row($result);
$zugriff_mysql->close_mysql();

if ($row==false)
 {
  echo "<div class=\"rot_mittig\">
  $textdata[showaddress_eintrag_nicht] $_GET[show] $textdata[showaddress_admin_wenden]</div>";
  
 }

if ($row[7] == "99") { $row[7]="";}
if ($row[8] == "99") { $row[8]="";}
if ($row[9] == "99") { $row[9]="";}
if ($row[10] == "99") { $row[10]="";}
echo "

<table border=\"0\"cellpadding=\"3\" style=\"margin-right:auto;margin-left:auto;text-align:left;\">
 <tr>
  <td>$textdata[addadress_vorname]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[1]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_nachname]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[2]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_strasse]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[3]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_hausnummer]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[4]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_plz]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[5]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_ort]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[6]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer1]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[7]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_telefonnummer2]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[8]</td>
 </tr>
  <tr>
  <td>$textdata[addadress_telefonnummer3]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[9]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_handy]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[10]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_fax]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[11]</td>
 </tr>
 <tr>
  <td>$textdata[addadress_email]:</td>
  <td style=\"width:12px;\"></td>
  <td>$row[12]</td>
 </tr>
</table><br /><a href=\"./editadress.php?bearbeiten=$row[0]\">$textdata[adressbuch_eintrag_bearbeiten]</a>

";
?>


<?php
include("./footer.inc.php");
?>
