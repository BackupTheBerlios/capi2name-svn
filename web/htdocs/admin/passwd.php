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


<div class="ueberschrift_seite">Change Administrator password</div>

<?
if (isset($_POST[aendern]))
 { //isset
if ($_POST[passwd1]==$_POST[passwd2])
{
echo "<center><font color=\"red\">Neue Passw�rter gleich!<br></center></font>";
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result = mysql_query("SELECT username, passwd FROM userliste WHERE id=1");
 $daten = mysql_fetch_array($result);
  if (md5($_POST[altespasswd]) == $daten[passwd])
   {
    $verschluesselt=md5($_POST[passwd2]);
    echo "<center><font color=\"red\">Altes Passwd OK !<br></center></font>";
     $result = mysql_query("UPDATE userliste SET passwd='$verschluesselt' WHERE id=1");
     if ($result ==1)
      {
      echo "<center><font color=\"red\"><b>Passwort erfolgreich ge�ndert.<br></center></font></b>";
      }
   }
   else
   {
    echo "<center><font color=\"red\"><b>Altes Passwort nicht gleich !<br></center></font></b>";
   }
  $zugriff_mysql->close_mysql();
}
else
{
echo "<center><font color=\"red\"><b>Neue Passw�rter nicht gleich!!</center></font></b>";
}
} //isset
?>



<center>
<form action="<? $PHP_SELF ?>" method="post">
<table border="0">
 <tr>
  <td>old password:</td>
  <td><input type="password" name="altespasswd"/></td>
 </tr>
 <tr>
  <td>new password:<br>again:</td>
  <td><input type="password" name="passwd1"/><br/><input name="passwd2" type="password"/></td>
 </tr>

</table>
<input type="submit" name="aendern" value="�ndern"/>
</form>
</center>

<?
include("./footer.inc.php");
?>
