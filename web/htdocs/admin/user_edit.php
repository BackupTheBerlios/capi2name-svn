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
include("./check_it.php");
include("./header.inc.php");


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
echo "<div class=\"ueberschrift_seite\">Change settings for user $username with ID $id</div>";


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
$result=mysql_query("SELECT * FROM users WHERE id='$id'");
$daten=mysql_fetch_assoc($result);
$zugriff_mysql->close_mysql();
if ($daten[show_config]==0) $option[show_config]="selected";
if ($daten[show_callback]==0) $option[show_callback]="selected";
if ($daten[show_prefix]==0) $option[show_prefix]="selected";
if ($daten[show_msn]==0) $option[show_msn]="selected";
if ($daten[show_type]==0) $option[show_type]="selected";
if ($daten[allow_delete]==0) $option[allow_delete]="selected";
?>

<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
   <td style="text-align:left;">
   <span style="font-weight:bold;">
   [<a href="./doc.html#1" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;username:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="hidden" value="<?=$daten[username]?>" maxlength="8" name="username"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">
   <span style="font-weight:bold;">
   [<a href="./doc.html#2" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;first name:
  </td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" value="<?=$daten[name_first]?>" name="first_name" maxlength="15" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#3" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;last name:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="last_name" value="<?=$daten[name_last]?>" maxlength="15" /></td>
 </tr>
 <tr>
  <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#4" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show configpage:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <select name="show_config"><option value="1">Yes</option>
  			    <option <?=$option[show_config]?> value="0">No</option>
			    </select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#5" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show callback function:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><select name="show_callback">
  <option value="1">Yes</option>
  <option <?=$option[show_callback]?> value="0">No</option></select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#6" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show the following MSNs in the call stat:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="msns_listen" value="<?=$daten[msn_listen]?>" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#7" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;set how many rows are display in the stat:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="show_lines" value="<?=$daten[show_lines]?>"/></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#8" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show prefix col in the stat:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="show_prefix"><option value="1">Yes</option>
    <option <?=$option[show_prefix]?> value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#9" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show on witch MSN is the call comming:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="show_msn"><option value="1">Yes</option>
    <option <?=$option[show_msn]?> value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#10" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show call type:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;"><select name="show_type">
    <option value="1">Yes</option>
    <option <?=$option[show_type]?> value="0">No</option></select></td>
   </tr>
   <tr>
     <td style="text-align:left;">
     <span style="font-weight:bold;">[<a href="./doc.html#11" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;allow delete entries:</td>
     <td style="width:5px;"></td>
     <td style="text-align:right;"><select name="allow_delete">
     <option value="1">Yes</option>
     <option <?=$option[allow_delete]?> value="0">No</option></select></td>
   </tr>
   <tr>
      <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#12" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;new password:</td>
      <td style="width:5px;"></td>
      <td style="text-align:right;"><input type="password" name="passwd"/></td>
   </tr>
</table>
<br/>
<input type="submit" name="edit" value="save user"/>
<br/>
<?
include("footer.inc.php");
?>

