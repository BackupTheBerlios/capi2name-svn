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
<h3>Übersicht über die Benutzer von Capi2Name</h2>
</center>
<br>


<center>
<table border="1">
 <tr>
  <td>Benutername</td>
  <td><center>Passwort</center></td>
  <td>Datum des letzten Logins</td>
  <td>Uhrzeit des letzten Logins</td>
  <td>Bearbeiten</td>
  <td>Löschen</td>
 </tr>

<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT id,username,passwd,lastlogin_d,lastlogin_t FROM userliste");
$zugriff_mysql->close_mysql();
 while($daten =mysql_fetch_array($result))
  {
  if ($daten[id]!=1)
  {
   echo "
    <tr>
     <td><center>$daten[username]</center></td>
     <td><center>$daten[passwd]</center></td>
     <td><center>$daten[lastlogin_d]</center></td>
     <td><center>$daten[lastlogin_t]</center></td>
     <td><center><a href=\"./bearbeiten.php?id=$daten[id]&username=$daten[username]\">OK</a></center></td>
     <td><center><a href=\"./loeschen.php?id=$daten[id]&username=$daten[username]\">OK</a></center></td>
    </tr>
   ";
 }
  }


?>
</table>
</center>
<br><br>




<?
include("footer.inc.php");
?>
