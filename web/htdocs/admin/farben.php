<?
/*
    copyright            : (C) 2002-2003 by Jonas Genannt
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
$seite="farben.php";
include("../conf.inc.php");
include("header.inc.php");
include("./check_it.php");
?>
<br>
<center>
<h3>Farben anpassen</h2>
</center>
<br>

<center>
<?
if (isset($_POST[wechseln])) //Style waechseln:
 {
//  echo "$farbeW";
   mysql_connect($host,$dbuser, $dbpasswd);
    mysql_select_db($db);
	$result=mysql_query("SELECT id FROM farben WHERE name='$_POST[farbeW]'");
	$row=mysql_fetch_array($result);
//	echo "---ID:$row[0]:";
    $result2=mysql_query("UPDATE farben SET std='$row[0]' WHERE id='1'");
	 if ($result2==1)
	  {
	   echo "<center><font color=\"red\"><b>Style erflogreich geändert!<br></center></font></b>";
	  }
	 else
	  {
        echo "<center><font color=\"red\"><b>Style NICHT erflogreich geändert!<br></center></font></b>";
	  }
   mysql_close();
 }

if (isset($_POST[eigene]))
 {
  mysql_connect($host, $dbuser, $dbpasswd);
  mysql_select_db($db);
  $result=mysql_query("DELETE FROM farben WHERE id='2'");
   if($result==1)
    {
	echo "<center><font color=\"red\"><b>Erflogreich eingetragen!<br></center></font></b>";
	}
	else
	{
	echo "<center><font color=\"red\"><b>NICHT Erflogreich gelöscht!<br></center></font></b>";
	}
  $result2=mysql_query("INSERT INTO farben VALUES ('2','Eigene Farbwahl','','$_POST[f_link]','$_POST[f_hover]', '$_POST[f_hinter_seite]', '$_POST[f_zeile_ueber]', '$_POST[f_schrift]','$_POST[f_hinter_link]','$_POST[f_hinter_main]', '$_POST[f_border_link]','$_POST[f_border_main]', '$_POST[f_hinter_haupt]', '$_POST[f_hinter_zeile1]', '$_POST[f_hinter_zeile2]')");
  mysql_close();
 }

?>
<form action="farben.php" method="post">
<table border="1">
<tr><td>
  <select name="farbeW" size="6">
   <?
    mysql_connect($host,$dbuser, $dbpasswd);
	mysql_select_db($db);
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
   mysql_close();
   ?>
</select></td>
<td><input type="submit" name="wechseln" value="Wählen"></td>
</tr>
</table>
</form>
<br><br>
<form action="farben.php" method="post">
Eigene Farbwahl:
<?
mysql_connect($host, $dbuser, $dbpasswd);
mysql_select_db($db);
$result=mysql_query("SELECT * FROM farben WHERE id=2");
$daten=mysql_fetch_row($result);
mysql_close();
echo "
<table border=\"1\">
 <tr>
  <td>Link-Farbe:</td>
  <td><input type=\"text\" name=\"f_link\" value=\"$daten[3]\"></td>
 </tr>
 <tr>
  <td>Hover-Farbe:</td>
  <td><input type=\"text\" name=\"f_hover\" value=\"$daten[4]\"></td>
 </tr>
 <tr>
  <td>Hintergrundfarbe der Seite:</td>
  <td><input type=\"text\" name=\"f_hinter_seite\" value=\"$daten[5]\"></td>
 </tr>
 <tr>
  <td>Zeile mit Überschrift:</td>
  <td><input type=\"text\" name=\"f_zeile_ueber\" value=\"$daten[6]\"></td>
 </tr>
 <tr>
  <td>Schriftfarbe:</td>
  <td><input type=\"text\" name=\"f_schrift\" value=\"$daten[7]\"></td>
 </tr>
 <tr>
  <td>Hintergrundfarbe der Link-Liste:</td>
  <td><input type=\"text\" name=\"f_hinter_link\" value=\"$daten[8]\"></td>
 </tr>
 <tr>
  <td>Hintergrundfarbe des Hauptrahmens:</td>
  <td><input type=\"text\" name=\"f_hinter_main\" value=\"$daten[9]\"></td>
 </tr>
 <tr>
  <td>Rahmenfarbe der Link-Liste:</td>
  <td><input type=\"text\" name=\"f_border_link\" value=\"$daten[10]\"></td>
 </tr>
 <tr>
  <td>Rahmenfarbe der Hauptrahmens:</td>
  <td><input type=\"text\" name=\"f_border_main\" value=\"$daten[11]\"></td>
 </tr>
 <tr>
  <td>Hintergrundgfarbe der Haupttabelle:</td>
  <td><input type=\"text\" name=\"f_hinter_haupt\" value=\"$daten[12]\"></td>
 </tr>
 <tr>
  <td>Hintergrundfarbe für Zeile 1 in Statistik:</td>
  <td><input type=\"text\" name=\"f_hinter_zeile1\" value=\"$daten[13]\"</td>
 </tr>
  <tr>
  <td>Hintergrundfarbe für Zeile 2 in Statistik:</td>
  <td><input type=\"text\" name=\"f_hinter_zeile2\" value=\"$daten[14]\"</td>
 </tr>
</table>";
?>
<input type="submit" name="eigene" value="Speichern">
</form>
</center>



<?
include("footer.inc.php");
?>

