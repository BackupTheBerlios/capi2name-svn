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
include("./check_it.php");
include("./header.inc.php");

?>
<br>
<center><h3>
<?
if (isset($_POST[speichern]))
 {
  $username=$_POST[username];
  $id=$_POST[id];
 }
 else
 {
  $username=$_GET[username];
  $id=$_GET[id];
 }
echo "Ändern der Daten für den Benutzer $username mit ID $id";
?>
</h3></center>
<br>

<?
//------------------- Daten in DB schreiben: ---------------------------------
if (isset($_POST[speichern]))
 {
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   //Namen setzen:
    $res=mysql_query("UPDATE userliste SET name='$_POST[b_name]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Namen setzen: OK</center>";
	else echo "<center><font color=\"red\">Name setzen: Failed</font></center>";

	//KonfigMenü setzen
	$res=mysql_query("UPDATE userliste SET showconfig='$_POST[b_konfig]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option Konfigmenü setzen: OK</center>";
	else echo "<center><font color=\"red\">Option Konfigmenü setzen: Failed</font></center>";

	//Rueckruf setzen
	$res=mysql_query("UPDATE userliste SET showrueckruf='$_POST[b_rueckruf]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option Rückrufmenü setzen: OK</center>";
	else echo "<center><font color=\"red\">Option Rückrufmenü setzen: Failed</font></center>";

	//Notiz setzen
	$res=mysql_query("UPDATE userliste SET shownotiz='$_POST[b_notiz]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option Notizmenü setzen: OK</center>";
	else echo "<center><font color=\"red\">Option Notizmenü setzen: Failed</font></center>";

	//MSNS setzen
	$res=mysql_query("UPDATE userliste SET msns='$_POST[b_msns]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>MSNs setzen: OK</center>";
	else echo "<center><font color=\"red\">MSNs setzen: Failed</font></center>";

	//Anzahl setzen
	$res=mysql_query("UPDATE userliste SET anzahl='$_POST[b_anzahl]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Anzahl setzen: OK</center>";
	else echo "<center><font color=\"red\">Anzahl setzen: Failed</font></center>";

	//Vorwahl setzen
	$res=mysql_query("UPDATE userliste SET showvorwahl='$_POST[b_vorwahl]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option Vorwahl setzen: OK</center>";
	else echo "<center><font color=\"red\">Option Vorwahl setzen: Failed</font></center>";

	//Auf welcher MSN setzen
	$res=mysql_query("UPDATE userliste SET showmsn='$_POST[b_showmsn]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option MSN anzeigen setzen: OK</center>";
	else echo "<center><font color=\"red\">Option MSN anzeigen setzen: Failed</font></center>";

	//Zeige Typen die angerufen haben
	$res=mysql_query("UPDATE userliste SET showtyp='$_POST[b_showtyp]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option Typ anzeigen setzen: OK</center>";
	else echo "<center><font color=\"red\">Option Typ anzeigen setzen: Failed</font></center>";

	//Zeige Typen die angerufen haben
	$res=mysql_query("UPDATE userliste SET loeschen='$_POST[b_showloeschen]' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Option Loeschen anzeigen setzen: OK</center>";
	else echo "<center><font color=\"red\">Option Loeschen anzeigen setzen: Failed</font></center>";

	//Passwort neu setzen:
	if ($_POST[b_passwd]!="")
	 {
	 $passwd_ver=md5($_POST[b_passwd]);
	$res=mysql_query("UPDATE userliste SET passwd='$passwd_ver' WHERE id='$_POST[id]'");
    if ($res==1) echo "<center>Passwort setzen: OK</center>";
	else echo "<center><font color=\"red\">Passwort setzen: Failed</font></center>";
	 }




$zugriff_mysql->close_mysql();
 }
//---------------------Daten in DB schreiben ENDE---------------------------


//--------------------------------------------- Daten aus DB auslesen-------------------------------
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=mysql_query("SELECT * FROM userliste WHERE id='$id'");
$daten=mysql_fetch_array($result);
$zugriff_mysql->close_mysql();
if ($daten[showrueckruf]=="")    $option[rueckruf]="selected";
if ($daten[shownotiz]=="")       $option[notiz]="selected";
if ($daten[showvorwahl]=="")     $option[vorwahl]="selected";
if ($daten[showmsn]=="")    $option[showmsn]="selected";
if ($daten[showconfig]=="") $option[konfig]="selected";
if ($daten[showtyp]=="") $option[typ]="selected";
if ($daten[loeschen]=="") $option[loeschen]="selected";



echo "
<center>
<form action=\"bearbeiten.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"$daten[id]\">
<input type=\"hidden\" name=\"username\" value=\"$daten[username]\">
 <table border=\"1\">
   <tr>
      <td><b>[<a href=\"./doc.html#1\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Username:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td>$daten[username]</td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#2\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Name:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_name\" value=\"$daten[name]\"</td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#3\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Menüpunkt Konfigmenü</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_konfig\"><option value=\"checked\">Yes</option><option $option[konfig] value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#4\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Menüpunkt Rückruf:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_rueckruf\"><option value=\"checked\">Yes</option><option $option[rueckruf] value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#5\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Menüpunkt Notiz:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_notiz\"><option value=\"checked\">Yes</option><option $option[notiz] value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#6\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige nur folgende MSNs:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_msns\" value=\"$daten[msns]\"></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#7\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Anzahl der Zeilen in der Statistik:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_anzahl\" value=\"$daten[anzahl]\"></td>
   </tr>
   <tr>
   	  <td><b>[<a href=\"./doc.html#8\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Vorwahlbereich in Statistik:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_vorwahl\"><option value=\"checked\">Yes</option><option $option[vorwahl] value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#9\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige auf welcher MSN angerufen wurde:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_showmsn\"><option value=\"checked\">Yes</option><option $option[showmsn] value=\"\">No</option></select></td>
   </tr>
     <tr>
	  <td><b>[<a href=\"./doc.html#10\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige den Typ des Anrufes:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_showtyp\"><option value=\"checked\">Yes</option><option $option[typ] value=\"\">No</option></select></td>
   </tr>
    <tr>
	  <td><b>[<a href=\"./doc.html#11\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Einträge loeschen erlaubt:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_showloeschen\"><option value=\"checked\">Yes</option><option $option[loeschen] value=\"\">No</option></select></td>
   </tr>


   <tr>
      <td><b>[<a href=\"./doc.html#12\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Neues Passwort:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"password\" name=\"b_passwd\"></td>
   </tr>
 </table><br>
 <input type=\"submit\" name=\"speichern\" value=\"Speichern\">
</form>
</center>";
//------------------------ Daten aus DB auslesen: ENDE---------------------------------------

?>





<?
include("footer.inc.php");
?>

