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
if (isset($add))
 { $seite=base64_encode("zurueckruf.php?add=yes");
 }
else { $seite=base64_encode("zurueckruf.php"); }
include("./login_check.inc.php");
include("./header.inc.php");
?>

<?

if(isset($_GET[loeschen]))
 {
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("DELETE FROM zurueckrufen WHERE id=$_GET[loeschen]");
 if ($result != "true") {echo "Fehler-Nr. " . mysql_errno()." - " .mysql_error(); die();}
 $zugriff_mysql->close_mysql();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./zurueckruf.php\">";
 }

if(isset($_POST[eintragen]))
 {
 if (!$_POST[addname]) 
 	{echo "<br/><div class=\"rot_mittig\">Bitte Name eingeben.</div><br/>"; die(); }
 if (!$_POST[addrufnummer])
 	 {echo "<br/><div class=\"rot_mittig\">Bitte Rufnummer eingeben.</div><br/>"; die(); }
if ($_POST[datumno]=="yes")
 {
 $adddatum = date("d.m.Y");
 $addzeit= date("G:i:s");
}
else
{
$adddatum = $_POST[adddatum];
$addzeit= $_POST[addzeit];
}
 $grund =  strip_tags($_POST[grund]);
 $grund =  nl2br($grund);
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("INSERT INTO zurueckrufen VALUES(NULL, '$_POST[addname]', '$_POST[addrufnummer]', '$adddatum', '$addzeit', '$grund','$_POST[addzurueckzeit]')");
 $zugriff_mysql->close_mysql();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./zurueckruf.php?show=yes\">";

 }
?>
<?
//ob er die Page anschauen darf:
 if ($show_rueckruf=="no")
  {
   echo "<div class=\"rot_mittig\">$text[nichtberechtigt]</div>";
   include("./footer.inc.php");
   die();
  }
echo "<div class=\"ueberschrift_seite\">$text[zurueckrufen]</div>";
?>


<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
 <tr>
  <td style="width:150px;font-weight:bold;"><? echo $text[name1] ?></td>
  <td style="width:150px;text-align:center;font-weight:bold;"><? echo $text[rufnummer] ?></td>
  <td style="text-align:center;font-weight:bold;"><? echo $text[anruf_zeit] ?></td>
  <td style="width:150px; text-align:center;font-weight:bold;"><? echo $text[zurueck_zeit] ?></td>
  <td></td>
 </tr>
<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM zurueckrufen");
$anzahl=mysql_numrows($result);
 for ($i=$anzahl-1;$i>-1;$i--)
 {
 $id=mysql_result($result, $i, "id");
 $name=mysql_result($result, $i, "name");
 $nummer=mysql_result($result, $i, "nummer");
 $datum=mysql_result($result, $i, "datum");
 $uhrzeit=mysql_result($result, $i, "uhrzeit");
 $zurueckzeit=mysql_result($result, $i, "rueckzeit");
 $grund=mysql_result($result, $i, "grund");

 $anzname="<a href=\"./adressbuch.php?find=yes&amp;findnr=$nummer#find\">$name</a>";
  echo "
  <tr>
   <td style=\"width:150px;\">$anzname</td>
   <td style=\"width:150px; text-align:center;\">
   	<a href=\"./szurueckruf.php?anz=$id\" title=\"Grund anzeigen.\">$nummer</a></td>
   <td style=\"text-align:center;\">$uhrzeit - $datum</td>
   <td style=\"width:150px; text-align:center;\">$zurueckzeit</td>
   <td style=\"text-align:center;\">
   <a href=\"./zurueckruf.php?loeschen=$id\" title=\"Loeschen\">
   <img src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
  </tr>
  ";
 }
$zugriff_mysql->close_mysql();
?>
</table>


<?
if ($_GET[add]== "yes")
 {
 if ($_GET[no] == "yes")
  {
   $anzeige="<input type=\"hidden\" name=\"datumno\" value=\"yes\"/>";
  }
 $addname= base64_decode($_GET[addname]);
 $uhrzeit=base64_decode($_GET[zuhrzeit]);
 $datum=base64_decode($_GET[zdatum]);
 echo "
<br /><br /><hr/>
<div class=\"ueberschrift_seite\">Neuer Eintrag</div>
<form action=\"$PHP_SELF\" method=\"post\">
<table border=\"0\" style=\"margin-right:auto;margin-left:auto;text-align:left;\">
 <tr>
  <td>$text[name1]:</td>
  <td><input name=\"addname\" value=\"$addname\" type=\"text\"/>
   <input type=\"hidden\" name=\"addzeit\" value=\"$uhrzeit\"/>
   <input type=\"hidden\" name=\"adddatum\" value=\"$datum\"/>
  </td>
 </tr>
 <tr>
  <td>$text[rufnummer]:</td>
  <td><input name=\"addrufnummer\" value=\"$_GET[addrufnummer]\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$text[zurueck_zeit]:</td>
  <td>
   <select name=\"addzurueckzeit\">
   <option value=\"Morgens\" >Morgens</option>
   <option value=\"Mittags\" >Mittags</option>
   <option value=\"Abends\"  >Abends</option>
   <option value=\"So bald wie moeglich\" >So bald wie moeglich</option>
   </select></td>
   </tr>
   <tr>
   <td>$text[grund]</td>
    <td>$anzeige
     <textarea rows=\"10\" cols=\"30\" name=\"grund\"></textarea>
    </td>
 </tr>
</table>
<ins><br /><input name=\"eintragen\" value=\"$text[speichern]\" type=\"submit\"/></ins>
</form>
 ";
 }
?>
<br /><br />

<?
include("./footer.inc.php");
?>

