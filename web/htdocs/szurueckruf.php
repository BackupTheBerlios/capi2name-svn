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
$seite=base64_encode("szurueckruf.php");
include("./login_check.inc.php");
include("./header.inc.php");
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM zurueckrufen WHERE id=$_GET[anz]");
$zugriff_mysql->close_mysql();
$daten=mysql_fetch_array($result);
if ($daten==false)
 {
  echo "<div class=\"rot_mittig\">$text[eintragmit_id] $_GET[anz] $text[anadmin_wenden]</div>";
 }
$name=$daten[name];
$nummer=$daten[nummer];
$uhrzeit=$daten[uhrzeit];
$datum=$daten[datum];
$zurueckzeit=$daten[rueckzeit];
$grund=$daten[grund];

?>
<?
//ob er die Page anschauen darf:
 if (!$userconfig['showrueckruf'])
  {
   echo "<div class=\"rot_mittig\">$text[nichtberechtigt]</div>";
   include("./footer.inc.php");
   die();
  }
echo "<div class=\"ueberschrift_seite\">$text[detail] $text[zurueckrufen]</div>"; 
?>
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
 <tr>
  <td style="height:30px;"><b><? echo "$text[datum]:"; ?></b></td>
  <td><? echo $datum; ?></td>
  <td style="width:100px;"></td>
  <td style="font-weight:bold;">Name:</td>
  <td><? echo "$name"; ?></td>
 </tr>
 <tr>
  <td style="height:30px;"><b><? echo "$text[uhrzeit]:"; ?></b></td>
  <td><? echo "$uhrzeit"; ?></td>
  <td  style="width:100px;"></td>
  <td style="font-weight:bold;"><? echo "$text[rufnummer]:"; ?></td>
  <td><? echo "$nummer"; ?></td>
 </tr>
 <tr>
  <td colspan="5" style="font-weight:bold;">
  <? echo $text[grund] ?><br />
   <? echo "$grund"; ?>

  </td>
 </tr>
</table>
<br /><br />
<?
include("./footer.inc.php");
?>
