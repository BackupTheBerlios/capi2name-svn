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
<center>
<h3>Benutzer anlegen</h3>
</center>


<?
if (isset($_POST[speichern]))
 {
 $checked=2;
  if (isset($_POST[b_username]))
   {
  mysql_connect($host, $dbuser, $dbpasswd);
  mysql_select_db($db);

  //checke ob Usernamen schon gibt
    $ch_res=mysql_query("SELECT id,username FROM userliste");
    while ($row=mysql_fetch_array($ch_res))
	 {
	  if ($_POST[b_username]==$row[username])
	   {
	    echo "<br><center><font color=\"red\">Es gibt schon einen User $_POST[b_username]!!<br></center></font>";
		$checked=1;
	   }
	   
	 }

  //checke ob Usernamen schon gibt ENDE
if ($checked==2)
{
     $passwd=md5($_POST[b_passwd]);
        $res=mysql_query("INSERT INTO userliste VALUES('NULL',    '$_POST[b_username]','$passwd','NULL','NULL','$_POST[b_name]','$_POST[b_anzahl]','$_POST[b_rueckruf]','$_POST[b_notiz]','$_POST[b_msns]','$_POST[b_vorwahl]','$_POST[b_showmsn]','$_POST[b_konfig]', '$_POST[b_typ]', '$_POST[b_loeschen]')");
  if ($res==1) { echo "<center>Benutzer hinzufügen: OK</center>"; }
  else { echo "<center><font color=\"red\">Benutzer hinzufügen: Failed</font></center>"; }
}

  mysql_close();
  }
  else
  {
  echo "<center><font color=\"red\">Benutzer hinzufügen: Failed<br>Bitte Username setzen!!</font></center>";
  }
 }


echo "
<center>
<form action=\"neueruser.php\" method=\"post\">
 <table border=\"1\">
   <tr>
      <td><b>[<a href=\"./doc.html#1\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Username:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_username\"></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#2\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Name:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_name\"></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#3\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Menüpunkt Konfigmenü</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_konfig\"><option value=\"checked\">Yes</option><option  value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#4\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Menüpunkt Rückruf:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_rueckruf\"><option value=\"checked\">Yes</option><option  value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#5\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Menüpunkt Notiz:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_notiz\"><option value=\"checked\">Yes</option><option  value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#6\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige nur folgende MSNs:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_msns\" ></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#7\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Anzahl der Zeilen in der Statistik:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"text\" name=\"b_anzahl\" value=\"10\" ></td>
   </tr>
   <tr>
   	  <td><b>[<a href=\"./doc.html#8\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Vorwahlbereich in Statistik:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_vorwahl\"><option value=\"checked\">Yes</option><option  value=\"\">No</option></select></td>
   </tr>
      <tr>
   	  <td><b>[<a href=\"./doc.html#9\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige Anruftyp in Statistik:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_typ\"><option value=\"checked\">Yes</option><option  value=\"\">No</option></select></td>
   </tr>
   <tr>
	  <td><b>[<a href=\"./doc.html#10\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Zeige auf welcher MSN angerufen wurde:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_showmsn\"><option value=\"checked\">Yes</option><option  value=\"\">No</option></select></td>
   </tr>
      <tr>
	  <td><b>[<a href=\"./doc.html#11\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Einträge loeschen erlaubt:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><select name=\"b_loeschen\"><option value=\"checked\">Yes</option><option selected  value=\"\">No</option></select></td>
   </tr>

   <tr>
      <td><b>[<a href=\"./doc.html#12\" onClick=\"showDoc()\" target=\"showDoc\">i</a>]</b>&nbsp;Passwort:</td>
	  <td width=\"5\">&nbsp;</td>
	  <td><input type=\"password\" name=\"b_passwd\"></td>
   </tr>
 </table><br>
 <input type=\"submit\" name=\"speichern\" value=\"Anlegen\">
</form>
</center>";

?>



<?
include("footer.inc.php");
?>
