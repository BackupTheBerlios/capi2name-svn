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

<?
if ($id==1)
 {
 echo "ADMIN KANN NICHT GELÖSCHT WERDEN!!!!!!!!";
 exit();
 }
?>

<?
if (isset($_POST[loeschen]))
 {
 echo "<font color=\"red\">Lösche eintrag mit id $_POST[id]</font><br><br>";
  mysql_connect($host, $dbuser, $dbpasswd);
   $result=mysql_db_query($db, "DELETE FROM userliste WHERE id=$_POST[id]");
  mysql_close();
 if ($result == 1)
  {
  echo "<b><font color=\"red\">Eintrag erfolgreich gelöscht, Sie werden in 2sec weitergeleitet.</font></b>";
  echo "<meta http-equiv=\"refresh\" content=\"2; URL=./index.php\">";
  }
 }
?>



<?
if (!isset($_POST[loeschen]))
{
echo "<h3>Löschen von Benutzer \"$_GET[username]\" mit ID $_GET[id]</h3><br>";
echo "<center><form action=\"$PHP_SELF\" method=\"post\">";
echo "<input type=\"hidden\" name=\"id\" value=\"$_GET[id]\">";
echo "<input type=\"submit\" value=\"Löschen\" name=\"loeschen\">";
echo "</form>";
}
?>
</center>




<?
include("footer.inc.php");
?>
