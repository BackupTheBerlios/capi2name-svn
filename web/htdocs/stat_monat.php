<?
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
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

<img src="./stat.png.php" border="0"/>
<br/>
<table border="0">
 <tr>
  <td style="width:50px;">
  <img src="./bilder/balken_rot.jpg" border="0" width="30" height="10"/></td>
  <td style="text-align:left">Alle Anrufe</td>
 </tr>
 <tr>
  <td style="width:50px;">
  <img src="./bilder/balken_blau.jpg" border="0" width="30" height="10"/></td>
  <td style="text-align:left">Bekannte Anrufe</td>
 </tr>
 <tr>
  <td style="width:50px;">
  <img src="./bilder/balken_gruen.jpg" border="0" width="30" height="10"/></td>
   <td style="text-align:left">Unbekannte Anrufe</td>
 </tr>
</table>



<br /><br />

<?
include("./footer.inc.php");
?>
