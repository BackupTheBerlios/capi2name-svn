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
<div class="ueberschrift_seite">MSN to name</div>


Hier kann man den lokaklen MSNs Namen zuordnen, diese Namen tauchen den in der Anrufstatistik anstatt der Nummer auf.<br><br>

<?
 if (isset($_GET[loeschen]))
  {
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
    $result=mysql_query("DELETE FROM msnzuname WHERE id=$_GET[loeschen]");
	 if ($result==1)
	   {
	    echo "<center><br>Eintrag mit ID Nr. $_GET[loeschen] erflogreich gelöscht!<br></center>";
	   }
	   else
	   {
	    echo "<center><br><font color=\"red\">Eintrag mit ID Nr. $_GET[loeschen] NICHT erflogreich gelöscht!<br></font></center>";
	   }
   $zugriff_mysql->close_mysql(); 
  }

  if (isset($_GET[nreintrag]))
   {
    echo "<br><center><h2>Neuer Eintrag</h2>";
	echo "<form action=\"msn2name.php\" method=\"post\">
	<table border=\"1\">
	 <tr>
	  <td>MSN:</td>
	  <td><input type=\"text\" name=\"msn\"></td>
	 </tr>
	 <tr>
	  <td>Name:</td>
	  <td><input type=\"text\" name=\"name\"></td>
	 </tr>
	</table>
	<input type=\"submit\" name=\"absenden\" value=\"Eintragen\">
	</form>";
	echo "<br><br></center>";
   }

if (isset($_POST[absenden]))
 {
  if (isset($_POST[msn]))
   {
     if (isset($_POST[name]))
	  {
	  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	    $res=mysql_query("INSERT INTO msnzuname VALUES('', '$_POST[msn]', '$_POST[name]')");
		 if ($res==1)
		  {
		   echo "<center><br>Daten erflogreich eingetragen!<br></center>";
		  }
		  else
		  {
		  echo "<center><font color=\"red\">Daten NICHT erflogreich eingetragen!</font></center>";
		  }
	   $zugriff_mysql->close_mysql(); 
	  }
	  else
	  {
       echo "<center><font color=\"red\">Bitte Name ausfüllen!</font></center>";
	  }
   }
   else
   {
   echo "<center><font color=\"red\">Bitte MSN ausfüllen!</font></center>";
   }

 }


?>
<center>
  <table border="1">
   <tr>
    <td>MSN</td>
	<td>Name</td>
	<td>Bearbeiten</td>
	<td>Löschen</td>
   </tr>

<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=mysql_query("SELECT * FROM msnzuname");
 while($row=mysql_fetch_array($result))
  {
   echo "<tr>
    <td>$row[msn]</td>
	<td>$row[name]</td>
	<td><center><a href=\"./msn2nameb.php?bid=$row[id]\">OK</a></center></td>
	<td><center><a href=\"./msn2name.php?loeschen=$row[id]\">OK</a></center></td>
   </tr>";
  }
 $zugriff_mysql->close_mysql();
?>



  </table>
<br><br>
- <a href="./msn2name.php?nreintrag=yes">Neuer Eintrag</a> -<br>
</center>



<?
include("footer.inc.php");
?>
