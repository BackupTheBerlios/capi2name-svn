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
include("./check_it.php");
include("./header.inc.php");
?>
<div class="ueberschrift_seite">Colorsetup</div>


<?
if (isset($_POST[wechseln])) //Style waechseln:
 {
//  echo "$farbeW";
    $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$result=mysql_query("SELECT id FROM farben WHERE name='$_POST[farbeW]'");
	$row=mysql_fetch_array($result);
//	echo "---ID:$row[0]:";
    $result2=mysql_query("UPDATE farben SET std='$row[0]' WHERE id='1'");
	 if ($result2==1)
	  {
	   echo "<br/><span style=\"text-align:center;font-weight:bold;color:blue\">Style erflogreich ge�ndert!</span><br/><br/>";
	  }
	 else
	  {
        echo "<br/><span style=\"text-align:center;font-weight:bold;color:red\">Style NICHT erflogreich ge�ndert!</span><br/><br/>";
	  }
$zugriff_mysql->close_mysql();
 }

if (isset($_POST[eigene]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $result=mysql_query("DELETE FROM farben WHERE id='2'");
   if($result==1)
    {
	echo "<br/><span style=\"text-align:center;font-weight:bold;color:blue\">Erflogreich eingetragen!</span><br/><br/>";
	}
	else
	{
	echo "<br/><span style=\"text-align:center;font-weight:bold;color:red\">NICHT Erflogreich eingetragen!</span><br/><br/>";
	}
  $result2=mysql_query("INSERT INTO farben VALUES ('2','Eigene Farbwahl','','$_POST[f_link]','$_POST[f_hover]', '$_POST[f_hinter_seite]', '$_POST[f_zeile_ueber]', '$_POST[f_schrift]','$_POST[f_hinter_link]','$_POST[f_hinter_main]', '$_POST[f_border_link]','$_POST[f_border_main]', '$_POST[f_hinter_haupt]', '$_POST[f_hinter_zeile1]', '$_POST[f_hinter_zeile2]')");
$zugriff_mysql->close_mysql();
 }

?>
<form action="farben.php" method="post">
<table border="0"  style="margin-right:auto;margin-left:auto;">
<tr><td>
  <select name="farbeW" size="8">
   <?
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$result=mysql_query("SELECT * FROM farben");
	$result2=mysql_query("SELECT * FROM farben WHERE id='1'");
	$wert_default=mysql_fetch_array($result2);
	 while($row=mysql_fetch_array($result))
	  {
	   if ($row[0]!=1)
	    {
  			if($row[0]==$wert_default[2])  echo "<option selected>$row[1]</option>";
			else echo "<option>$row[1]</option>";
		}
	  }
  $zugriff_mysql->close_mysql();
   ?>
</select></td>
<td><input type="submit" name="wechseln" value="change"/></td>
</tr>
</table>
</form>
<br/><br />
<form action="farben.php" method="post">
Eigene Farbwahl:
<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=mysql_query("SELECT * FROM farben WHERE id=2");
$daten=mysql_fetch_row($result);
$zugriff_mysql->close_mysql();
echo "
<table border=\"0\" style=\"margin-right:auto;margin-left:auto;\">
 <tr>
  <td style=\"text-align:left;\">Link-Farbe:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_link\" value=\"$daten[3]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Hover-Farbe:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hover\" value=\"$daten[4]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Hintergrundfarbe der Seite:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hinter_seite\" value=\"$daten[5]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Zeile mit �berschrift:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_zeile_ueber\" value=\"$daten[6]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Schriftfarbe:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_schrift\" value=\"$daten[7]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Hintergrundfarbe der Link-Liste:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hinter_link\" value=\"$daten[8]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Hintergrundfarbe des Hauptrahmens:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hinter_main\" value=\"$daten[9]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Rahmenfarbe der Link-Liste:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_border_link\" value=\"$daten[10]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Rahmenfarbe der Hauptrahmens:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_border_main\" value=\"$daten[11]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Hintergrundgfarbe der Haupttabelle:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hinter_haupt\" value=\"$daten[12]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:left;\">Hintergrundfarbe f�r Zeile 1 in Statistik:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hinter_zeile1\" value=\"$daten[13]\"/></td>
 </tr>
  <tr>
  <td style=\"text-align:left;\">Hintergrundfarbe f�r Zeile 2 in Statistik:</td>
  <td style=\"width:10px\"></td>
  <td><input type=\"text\" name=\"f_hinter_zeile2\" value=\"$daten[14]\"/></td>
 </tr>
 <tr>
  <td style=\"text-align:center;\" colspan=\"3\"><input type=\"submit\" name=\"eigene\" value=\"save data\"/></td>
 </tr>
</table>";
?>

</form>




<?
include("footer.inc.php");
?>

