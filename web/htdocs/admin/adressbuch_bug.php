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
<h3>Adressbuch BUG beheben</h3>
</center>

<?
if (isset($_GET[aufrufen]))
  {
   echo "<br><b>Funktion Adressbuch BUG beheben wird gestartet. (Seite wird �fters neu geladen, warte bis FERTIG unten steht!)</b><br>";
    if (isset($_GET[start_zahl]))
      {
        $start=$_GET[start_zahl];
      }
      else
      {
       $start=1;
      }
      
   mysql_connect($host, $dbuser, $dbpasswd);
    mysql_select_db($db);
     $res_anzahl=mysql_query("SELECT * FROM adressbuch");
     $rows_anzahl=mysql_num_rows($res_anzahl);
     $result=mysql_query("SELECT * FROM adressbuch LIMIT $start, 10");
  
   
     while($daten=mysql_fetch_array($result))
      {
      $wert=$daten[id];
        if ($daten[tele1]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET tele1='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br>Tele 1 von Eintrag $daten[id] neu geschrieben: OK"; }
	  }
        if ($daten[tele2]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET tele2='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br>Tele 2 von Eintrag $daten[id] neu geschrieben: OK"; }
	 }
        if ($daten[tele3]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET tele3='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br>Tele 3 von Eintrag $daten[id] neu geschrieben: OK"; }
	  }   
        if ($daten[handy]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET handy='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br>Handy von Eintrag $daten[id] neu geschrieben: OK"; }
	  }   
      }
      
   mysql_close();    
   if ($wert <= $rows_anzahl)
 {

   echo "<meta http-equiv=\"refresh\" content=\"1; URL=./adressbuch_bug.php?start_zahl=$wert&aufrufen=OK\">";
 }
 else
 {
  echo "<font color=\"red\"><b><br><h2>Fertig</h2></b><hr></font>";
 }   
  } // isset aufrufen

?>

Mit diser Funktion kann man den AdressbuchBug in der Datenbank beheben.<br>

Ab Version 0.5 war im Adressbuch ein BUG. Der Bug hatte mit dem Eintragen von neuen Eintr�gen zu tun.<br><br>

Diese Funktion sollte einmal ausgef�hrt werden.<br>
Wenn der Fehler in der Datenbank steht, kann es sein, das Anrufe falsch zugeordnet werden, oder die Gesamtstatistik nicht richtig z�hlt!!!<br>


<br>
<br>
<center>
  <form action="./adressbuch_bug.php" method="GET">
    <input type="SUBMIT" name="aufrufen" value="Bug in der Datenbank beheben">
  </form>
</center>




<?
include("./footer.inc.php");
?>
