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
<h3>Vorwahlbereiche Anpassen<? if(isset($_GET[loschen])) echo " - Löschen  -"; else echo " - Ändern -";  ?></h3>
</center>
<br>

<?
if (isset($_GET[loschen]))
 {
  if (isset($_GET[ok]))
   {
    echo "<center>Eintrag mit ID-Nr. $loeschid gelöscht!</center>";
    mysql_connect($host, $dbuser, $dbpasswd);
    $result=mysql_db_query($db, "DELETE  FROM vorwahl WHERE id=$_GET[loeschid]");
    if ($result!="true") { echo "Capi2Name meldet Fehler. Mysql-Says:". mysql_error(); }
    mysql_close();
   }//if isset ok ende
  else
   {

    mysql_connect($host, $dbuser, $dbpasswd);
    $result=mysql_db_query($db, "SELECT id,vorwahlnr,name FROM vorwahl WHERE id=$_GET[loeschid]");
    $daten=mysql_fetch_array($result);
    mysql_close();
       echo "Eintrag mit ID-Nr. $daten[id] wirklich löschen ?<center>- $daten[vorwahlnr] - $daten[name] -<br><br>";
       echo "-> <a href=\"./vorwahlb.php?loschen=yes&loeschid=$daten[id]&ok=yes\">Löschen</a> <-</center>";
   } //else ende
 } // isset$loschen zuende
?>

<?
if (isset($_GET[edit]))
 {
  echo "<center><table border=\"0\"><form action=\"./vorwahlb.php\" method=\"post\">";
  mysql_connect($host, $dbuser, $dbpasswd);
  $result=mysql_db_query($db, "SELECT id,vorwahlnr,name FROM vorwahl WHERE id=$_GET[editid]");
  $daten=mysql_fetch_array($result);
  mysql_close();
  echo "<tr>
         <td>ID</td>
	 <td>Vorwahl</td>
	 <td>Name</td>
        </tr> ";
  echo "<tr>
         <td><input type=\"hidden\" name=\"eid\" value=\"$daten[id]\" >$daten[id]</td>
	 <td><input type=\"text\" name=\"evorwahl\" value=\"$daten[vorwahlnr]\"></td>
	 <td><input type=\"text\" name=\"ename\" value=\"$daten[name]\"></td>  
        </tr>";
  echo "</table>" ;
  echo "<input type=\"submit\" name=\"aendern\" value=\"Ändern\"></center>";
 }

// aenderung in DB schreiben:

if (isset($_POST[aendern]))
  {
  echo "ID: $_POST[eid]<br>Vorwahl: $_POST[evorwahl]<br>Name: $_POST[ename]";
   mysql_connect($host, $dbuser, $dbpasswd);
    mysql_db_query($db, "UPDATE vorwahl SET vorwahlnr='$_POST[evorwahl]',name='$_POST[ename]' WHERE id=$_POST[eid]");
   mysql_close();
  }



?>


<?
include("./footer.inc.php");
?>
