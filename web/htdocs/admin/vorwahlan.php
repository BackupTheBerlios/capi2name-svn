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
<h3>Vorwahlbereiche Abgleichen</h3>
</center>
<br>

Vorgang wird gestartet!<br><br>
Bitte warten .....<br>
<?

if(isset($_GET[start_zahl]))
 {
   $start=$_GET[start_zahl];
 }
 else
 {
  $start=1;
 }

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$res_anzahl=mysql_query("SELECT * FROM angerufene");
$rows_anzahl=mysql_num_rows($res_anzahl);
echo "Rows Anzahl: $rows_anzahl<br>";


 $result=mysql_query("SELECT * FROM angerufene LIMIT $start , 50");
  while($daten=mysql_fetch_array($result))
  {
  $wert=$daten[0];
  if ($daten[1]!= "unbekannt")
  {
  $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
   while($vorwahl_row=mysql_fetch_row($tab_vorwahl))
    {

	 $laenge=strlen($vorwahl_row[1]);
	 $vorwahl_nr=substr($daten[1],0,$laenge);
	 if($vorwahl_row[1]==$vorwahl_nr)
	  {
	   $res=mysql_query("UPDATE angerufene SET vorwahl='$vorwahl_row[2]' WHERE id='$daten[0]'");
	    if ($res==1) { echo "<br>Eintrag mit ID Nr. $daten[0] neu geschrieben !"; }

	  }
	}
	} // if
  }

$zugriff_mysql->close_mysql();
echo "<br>Wert: $wert<br>Rows: $rows_anzahl";
if ($wert <= $rows_anzahl)
 {

   echo "<meta http-equiv=\"refresh\" content=\"1; URL=./vorwahlan.php?start_zahl=$wert\">";
 }
 else
 {
  echo "<font color=\"red\"><b><br>Fertig</b></font>";
 }
?>


<?
include("./footer.inc.php");
?>
