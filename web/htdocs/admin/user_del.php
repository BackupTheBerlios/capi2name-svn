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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
include("./check_it.php");
include("./header.inc.php");
?>
<br>


<?
if ($_POST[id]==1)
 {
 echo "<span class=\"rot_mittig\">You can not delete the administator!!</span>";
 include("footer.inc.php");
 exit();
 }


if (isset($_POST[loeschen]))
 {
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $result=mysql_query("DELETE FROM users WHERE id=$_POST[id]");
  $zugriff_mysql->close_mysql();
 if ($result == 1)
  {
  echo "<span class=\"blau_mittig\">Eintrag mit $_POST[id] erfolgreich gelöscht, Sie werden in 2sec weitergeleitet.</span>";
  echo "<meta http-equiv=\"refresh\" content=\"2; URL=./index.php\">";
  }
 }

 
if (!isset($_POST[loeschen]))
{
echo "<h3>Löschen von Benutzer \"$_GET[username]\" mit ID $_GET[id]</h3><br/>";
echo "<form action=\"$PHP_SELF\" method=\"post\">";
echo "<input type=\"hidden\" name=\"id\" value=\"$_GET[id]\"/>";
echo "<input type=\"submit\" value=\"Löschen\" name=\"loeschen\"/>";
echo "</form>";
}
?>





<?
include("footer.inc.php");
?>
