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
<div class="ueberschrift_seite">create a new user</div>


<?
if (isset($_POST[speichern])) {
	$checked=2;
	if (isset($_POST[b_username])) {
		$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
		//checke ob Usernamen schon gibt
		$ch_res=mysql_query("SELECT id,username FROM userliste");
		while ($row=mysql_fetch_array($ch_res)) {
			if ($_POST[b_username]==$row[username]) {
				echo "<div style=\"color:red;text-align:center;\">Es gibt schon einen User $_POST[b_username]!!</div>";
				$checked=1;
			}
		}
		//checke ob Usernamen schon gibt ENDE
		if ($checked==2){
			$passwd=md5($_POST[b_passwd]);
			$sql = "INSERT INTO userliste VALUES('NULL', '$_POST[b_username]','$passwd','NULL','NULL','$_POST[b_name]','$_POST[b_anzahl]','$_POST[b_rueckruf]','$_POST[b_notiz]','$_POST[b_msns]','$_POST[b_vorwahl]','$_POST[b_showmsn]','$_POST[b_konfig]', '$_POST[b_typ]', '$_POST[b_loeschen]')";
			$res = mysql_query($sql);
			if ($res==1) echo "<div style=\"text-align:center;\">Benutzer hinzufügen: OK</div>";
			else echo "<div style=\"color:red;text-align:center;\">Benutzer hinzufügen: Failed</div>";
		}
		$zugriff_mysql->close_mysql();
	}
	else {
		echo "<div style=\"color:red;text-align:center;\">Benutzer hinzufügen: Failed<br>Bitte Username setzen!!</div>";
	}
}
?>

<form action="neueruser.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
   <td style="text-align:left;">
   <span style="font-weight:bold;">[<a href="./doc.html#1" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Username:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><input type="text" name="b_username"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#2" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Name:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="b_name" /></td>
 </tr>
 <tr>
  <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#3" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige Menüpunkt Konfigmenü</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <select name="b_konfig"><option value="checked">Yes</option>
  			    <option value="">No</option>
			    </select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#4" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige Menüpunkt Rückruf:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><select name="b_rueckruf">
  <option value="checked">Yes</option>
  <option  value="">No</option></select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#5" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige Menüpunkt Notiz:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <select name="b_notiz"><option value="checked">Yes</option>
  <option  value="">No</option></select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#6" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige nur folgende MSNs:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="b_msns" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#7" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Anzahl der Zeilen in der Statistik:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><input type="text" name="b_anzahl" value="10"/></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#8" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige Vorwahlbereich in Statistik:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="b_vorwahl"><option value="checked">Yes</option>
    <option  value="">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#9" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige auf welcher MSN angerufen wurde:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="b_showmsn"><option value="checked">Yes</option>
    <option value="">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#10" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Zeige den Typ des Anrufes:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;"><select name="b_showtyp">
    <option value="checked">Yes</option>
    <option value="">No</option></select></td>
   </tr>
   <tr>
     <td style="text-align:left;">
     <span style="font-weight:bold;">[<a href="./doc.html#11" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Einträge loeschen erlaubt:</td>
     <td style="width:5px;"></td>
     <td style="text-align:right;"><select name="b_loeschen">
     <option value="checked">Yes</option>
     <option selected value="">No</option></select></td>
   </tr>
   <tr>
      <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#12" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;Neues Passwort:</td>
      <td style="width:5px;"></td>
      <td style="text-align:right;"><input type="password" name="b_passwd"/></td>
   </tr>
 </table><br/>
 <input type="submit" name="speichern" value="add new user"/>
</form>



















<?php
	include("footer.inc.php");
?>
