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


<div class="ueberschrift_seite">Adressbook BUG</div>

<?
if (isset($_GET[aufrufen]))
  {
   echo "<br/><b>Funktion Adressbuch BUG beheben wird gestartet. (Seite wird öfters neu geladen, warte bis FERTIG unten steht!)</b><br/>";
    if (isset($_GET[start_zahl]))
      {
        $start=$_GET[start_zahl];
      }
      else
      {
       $start=1;
      }
      
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
     $res_anzahl=mysql_query("SELECT * FROM adressbuch");
     $rows_anzahl=mysql_num_rows($res_anzahl);
     $result=mysql_query("SELECT * FROM adressbuch LIMIT $start, 10");
  
   
     while($daten=mysql_fetch_array($result))
      {
      $wert=$daten[id];
        if ($daten[tele1]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET tele1='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br/>Tele 1 von Eintrag $daten[id] neu geschrieben: OK"; }
	  }
        if ($daten[tele2]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET tele2='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br/>Tele 2 von Eintrag $daten[id] neu geschrieben: OK"; }
	 }
        if ($daten[tele3]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET tele3='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br/>Tele 3 von Eintrag $daten[id] neu geschrieben: OK"; }
	  }   
        if ($daten[handy]==NULL)
	  {
	   $res=mysql_query("UPDATE adressbuch SET handy='99' WHERE id='$daten[id]'");
	    if ($res==1) { echo "<br/>Handy von Eintrag $daten[id] neu geschrieben: OK"; }
	  }   
      }
      
  $zugriff_mysql->close_mysql();    
   if ($wert <= $rows_anzahl)
 {

   echo "<meta http-equiv=\"refresh\" content=\"1; URL=./adressbuch_bug.php?start_zahl=$wert&aufrufen=OK\">";
 }
 else
 {
  echo "<font color=\"red\"><b><br/><h2>Fertig</h2></b><hr/></font>";
 }   
  } // isset aufrufen

?>

Mit diser Funktion kann man den AdressbuchBug in der Datenbank beheben.<br>

Ab Version 0.5 war im Adressbuch ein BUG. Der Bug hatte mit dem Eintragen von neuen Einträgen zu tun.<br><br>

Diese Funktion sollte einmal ausgeführt werden.<br>
Wenn der Fehler in der Datenbank steht, kann es sein, das Anrufe falsch zugeordnet werden, oder die Gesamtstatistik nicht richtig zählt!!!<br>


<br/>
<br/>
<span style="text-align:center;">
  <form action="./adressbuch_bug.php" method="get">
    <input type="submit" name="aufrufen" value="try to find the bug an resolve it"/>
  </form>
</span>




<?
include("./footer.inc.php");
?>
