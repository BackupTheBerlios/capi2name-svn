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
$seite="index.php";
include("../conf.inc.php");
include("header.inc.php");
include("./check_it.php");

?>


<br>
<center>
<h3>Admin Passwort ändern</h3>
</center>


<?
if (isset($_POST[aendern]))
 { //isset
if ($_POST[passwd1]==$_POST[passwd2])
{
echo "<center><font color=\"red\">Neue Passwörter gleich!<br></center></font>";
 mysql_connect($host, $dbuser, $dbpasswd);
 $result = mysql_db_query($db, "SELECT username, passwd FROM userliste WHERE id=1");
 $daten = mysql_fetch_array($result);
  if (md5($_POST[altespasswd]) == $daten[passwd])
   {
    $verschluesselt=md5($_POST[passwd2]);
    echo "<center><font color=\"red\">Altes Passwd OK !<br></center></font>";
     $result = mysql_db_query($db, "UPDATE userliste SET passwd='$verschluesselt' WHERE id=1");
     if ($result ==1)
      {
      echo "<center><font color=\"red\"><b>Passwort erfolgreich geändert.<br></center></font></b>";
      }
   }
   else
   {
    echo "<center><font color=\"red\"><b>Altes Passwort nicht gleich !<br></center></font></b>";
   }
 mysql_close();
}
else
{
echo "<center><font color=\"red\"><b>Neue Passwörter nicht gleich!!</center></font></b>";
}
} //isset
?>



<center>
<form action="<? $PHP_SELF ?>" method="post">
<table border="1">
 <tr>
  <td>Altes Passwort:</td>
  <td><input type="password" name="altespasswd"></td>
 </tr>
 <tr>
  <td>Neues Passwort:<br>Wiederholen:</td>
  <td><input type="password" name="passwd1"><br><input name="passwd2" type="password"></td>
 </tr>

</table>
<input type="submit" name="aendern" value="Ändern">
</form>
</center>

<?
include("./footer.inc.php");
?>
