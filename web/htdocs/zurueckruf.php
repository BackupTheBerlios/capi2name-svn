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
 mysql_connect($host, $dbuser,$dbpasswd);
 $result=mysql_db_query($db, "DELETE FROM zurueckrufen WHERE id=$_GET[loeschen]");
 if ($result != "true") {echo "Fehler-Nr. " . mysql_errno()." - " .mysql_error(); die();}
 mysql_close();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./zurueckruf.php\">";
 }

if(isset($_POST[eintragen]))
 {
 if (!$_POST[addname]) {echo "<font color=red><BR /><center>Bitte Name eingeben.</center><BR /></font>"; die(); }
 if (!$_POST[addrufnummer]) {echo "<font color=red><BR /><center>Bitte Rufnummer eingeben.</center><BR /></font>"; die(); }
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
 mysql_connect($host, $dbuser,$dbpasswd);
 $result=mysql_db_query($db, "INSERT INTO zurueckrufen VALUES(NULL, '$_POST[addname]', '$_POST[addrufnummer]', '$adddatum', '$addzeit', '$grund','$_POST[addzurueckzeit]')");
 mysql_close();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./zurueckruf.php?show=yes\">";

 }
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
<div align="center"><h2><? echo $text[zurueckrufen] ?></h2></div>
<div align="center">
<TABLE BORDER="0">
 <TR>
  <TD width="150"><b><? echo $text[name1] ?></b></TD>
  <TD width="150"><div align="center"><b><? echo $text[rufnummer] ?></b></div></TD>
  <TD><div align="center"><b><? echo $text[anruf_zeit] ?></b></div></TD>
  <TD width="150"><div align="center"><b><? echo $text[zurueck_zeit] ?></b></div></TD>
  <TD></TD>
 </TR>
<?
mysql_connect($host, $dbuser,$dbpasswd);
$result=mysql_db_query($db, "SELECT * FROM zurueckrufen");
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

 $anzname="<A HREF=\"./adressbuch.php?find=yes&amp;findnr=$nummer#find\">$name</A>";
  echo "
  <TR>
   <TD width=\"150\">$anzname</TD>
   <TD width=\"150\"><div align=\"center\"><a href=\"./szurueckruf.php?anz=$id\" title=\"Grund anzeigen.\">$nummer</a></div></TD>
   <TD><div align=\"center\">$uhrzeit - $datum</div></TD>
   <TD width=\"150\"><div align=\"center\">$zurueckzeit</div></TD>
   <TD><center><A HREF=\"./zurueckruf.php?loeschen=$id\" title=\"Loeschen\"><img src=\"./bilder/edittrash.png\" align=\"middle\" border=0></A></center></TD>
  </TR>
  ";
 }
mysql_close();
?>
</TABLE>
</div>

<?
if ($_GET[add]== "yes")
 {
 if ($_GET[no] == "yes")
  {
   $anzeige="<INPUT TYPE=\"HIDDEN\" name=\"datumno\" value=\"yes\">";
  }
 $addname= base64_decode($_GET[addname]);
 $uhrzeit=base64_decode($_GET[zuhrzeit]);
 $datum=base64_decode($_GET[zdatum]);
 echo "
<BR /><BR /><HR>
<div align=\"center\"><h2>Neuer Eintrag</h2></div>
<div align=\"center\">
<FORM action=\"$PHP_SELF\" method=\"post\">
<TABLE BORDER=\"0\">
 <TR>
  <TD>$text[name1]:</TD>
  <TD><INPUT NAME=\"addname\" VALUE=\"$addname\" type=\"text\">
   <INPUT TYPE=\"HIDDEN\" name=\"addzeit\" value=\"$uhrzeit\">
  <INPUT TYPE=\"HIDDEN\" name=\"adddatum\" value=\"$datum\">
  </TD>
 </TR>
 <TR>
  <TD>$text[rufnummer]:</TD>
  <TD><INPUT NAME=\"addrufnummer\" VALUE=\"$_GET[addrufnummer]\" type=\"text\"</TD>
 </TR>
 <TR>
  <TD>$text[zurueck_zeit]:</TD>
  <TD>
   <select name=\"addzurueckzeit\">
   <option value=\"Morgens\" >Morgens</option>
   <option value=\"Mittags\" >Mittags</option>
   <option value=\"Abends\"  >Abends</option>
   <option value=\"So bald wie moeglich\" >So bald wie moeglich</option>
   </select></TD>
   </tr>
   <tr>
   <TD>$text[grund]</TD>
    <TD>$anzeige
     <textarea rows=\"10\" cols=\"30\" name=\"grund\"></textarea>
    </TD>
 </TR>
</TABLE><BR />
<INPUT name=\"eintragen\" value=\"$text[speichern]\" type=\"submit\">
</FORM>
</div>
 ";
 }
?>
<BR /><BR />

<?
include("./footer.inc.php");
?>

