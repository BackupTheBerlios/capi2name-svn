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
  echo "<FONT color=\"red\"><CENTER>$text[eintragmit_id] $_GET[anz] $text[anadmin_wenden]</FONT></CENTER>";
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
 if ($show_rueckruf=="no")
  {
   echo "<center><font color=\"red\">$text[nichtberechtigt]</font></center>";
   include("./footer.inc.php");
   die();
  }
?>
<div align="center"><h2><? echo "$text[detail] $text[zurueckrufen]"; ?></h2></div><BR />
<div align="center">
<table border="0">
 <tr>
  <td height="30"><b><? echo "$text[datum]:"; ?></b></td>
  <td><? echo $datum; ?></td>
  <td width="100"></td>
  <td ><b>Name:</b></td>
  <td><? echo "$name"; ?></td>
 </tr>
 <tr>
  <td height="30"><b><? echo "$text[uhrzeit]:"; ?></b></td>
  <td><? echo "$uhrzeit"; ?></td>
  <td width="100"></td>
  <td><b><? echo "$text[rufnummer]:"; ?></b></td>
  <td><? echo "$nummer"; ?></td>
 </tr>
 <tr>
  <td colspan="5">
  <b><? echo $text[grund] ?></b><BR />
   <? echo "$grund"; ?>

  </td>
 </tr>
</table>
</DIV>
<BR /><BR />
<?
include("./footer.inc.php");
?>
