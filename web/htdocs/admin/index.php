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

?>
<div class="ueberschrift_seite">Capi2Name Users</div>



<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td style="width:150px;">username</td>
  <td>password</td>
  <td style="width:200px;">last login</td>
  <td style="width:70px;">edit</td>
  <td style="width:70px;">delete</td>
 </tr>

<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT id,username,passwd,lastlogin_d,lastlogin_t FROM users");
$zugriff_mysql->close_mysql();
 while($daten =mysql_fetch_assoc($result))
  {
  if ($daten[id]!=1)
  {
   echo "
    <tr>
     <td>$daten[username]</td>
     <td>$daten[passwd]</td>
     <td>$daten[lastlogin_d] / $daten[lastlogin_t]</td>
     
     <td style=\"text-align:center;\">
     <a href=\"./bearbeiten.php?id=$daten[id]&username=$daten[username]\">
     <img src=\"../bilder/edit.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
     <td><a href=\"./loeschen.php?id=$daten[id]&username=$daten[username]\">
     <img src=\"../bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
    </tr>
   ";
 }
  }


?>
</table>





<?
include("footer.inc.php");
?>
