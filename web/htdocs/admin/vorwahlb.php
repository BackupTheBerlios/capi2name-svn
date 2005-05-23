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
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
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
    $result=$dataB->sql_query("DELETE  FROM vorwahl WHERE id=$_GET[loeschid]");
    if ($result!="true") { echo "Capi2Name meldet Fehler. Mysql-Says:". mysql_error(); }
   }//if isset ok ende
  else
   {

    $result=$dataB->sql_query("SELECT id,vorwahlnr,name FROM vorwahl WHERE id=$_GET[loeschid]");
    $daten=$dataB->sql_fetch_assoc($result);
       echo "Eintrag mit ID-Nr. $daten[id] wirklich löschen ?<center>- $daten[vorwahlnr] - $daten[name] -<br><br>";
       echo "-> <a href=\"./vorwahlb.php?loschen=yes&loeschid=$daten[id]&ok=yes\">Löschen</a> <-</center>";
   } //else ende
 } // isset$loschen zuende
?>

<?
if (isset($_GET[edit]))
 {
  echo "<center><table border=\"0\"><form action=\"./vorwahlb.php\" method=\"post\">";
  $result=$dataB->sql_query("SELECT id,vorwahlnr,name FROM vorwahl WHERE id=$_GET[editid]");
  $daten=$dataB->sql_fetch_assoc($result);
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
  $dataB->sql_query("UPDATE vorwahl SET vorwahlnr='$_POST[evorwahl]',name='$_POST[ename]' WHERE id=$_POST[eid]");
  }



?>


<?
$dataB->sql_close();
include("./footer.inc.php");
?>
