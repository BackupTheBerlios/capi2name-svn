<?
exit();
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
$dataB->sql_coennect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
?>


<br>
<center>
<h3>Vorwahlbereiche Anpassen</h3>
</center>
<br>
Hier kann man die Vorwahlbereiche festlegen, das hei�t, z.B. wenn jemand aus dem Vorwahlbereich 089 anruft, steht in der Anrufstatistik  M�nchen.
<br>
<br>
Dies kann hier festlegen.

<center>

<?
if (isset($_POST[eintragen]))
 {
// echo "<br><br>Vorwahl: $einvorwahl<br>Name: $einname<br>";
 $res=$dataB->sql_query("INSERT INTO vorwahl VALUES( '', '$_POST[einvorwahl]', '$_POST[einname]')");
 if (!$res)
  { echo "Capi2Name meldet Fehler in der DB ansteuerung<br> Mysql Says:".mysql_error();  }

 }


if(isset($_GET[neuereintrag]))
 {
  echo "Neuer Eintrag in Tabelle vorwahl:<br/>";
  echo "<form action=\"./vorwahl.php\" method=\"post\"><table border=\"0\">
  <tr>
   <td>Vorwahl:</td>
   <td width=\"10\"> </td>
   <td><input name=\"einvorwahl\"/></td>
  </tr>
  <tr>
  <td>Name:</td>
   <td width=\"10\"> </td>
   <td><input name=\"einname\"/></td>
  </tr>

  </table><input name=\"eintragen\" value=\"Eintragen\" type=\"submit\"/></form><br/><br/>
  ";
 }
?>


<table border="1">
 <tr>
  <td>ID</td>
  <td>Vorwahl Nr</td>
  <td>Name</td>
  <td>Edit</td>
  <td>Loschen</td>
 </tr>
<?
  $result=$dataB->sql_query("SELECT * FROM vorwahl");
  while($daten=$dataB->sql_fetch_assoc($result))
   {
     echo "
     <tr>
      <td>$daten[id]</td>
      <td>$daten[vorwahlnr]</td>
      <td>$daten[name]</td>
      <td><center><a href=\"./vorwahlb.php?edit=yes&editid=$daten[id]\">X</a></center></td>
      <td><center><a href=\"./vorwahlb.php?loschen=yes&loeschid=$daten[id]\">X</a></center></td>
     </tr>

    " ; // ende echo
   } //ende while


?>
</table>
<br><br>
<a href="./vorwahl.php?neuereintrag=yes">Neuer Eintrag</a>
<br>
</center>
<?
$dataB->sql_close();
include("./footer.inc.php");
?>