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
 ?>
<?
include("./check_it.php");
include("./header.inc.php");
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
?>
<div class="ueberschrift_seite">MSN to name</div>


Hier kann man den lokalen MSNs Namen zuordnen, diese Namen tauchen den in der Anrufstatistik anstatt der Nummer auf.<br/><br/>

<?
 if (isset($_GET[loeschen]))
  {
   $result=mysql_query("DELETE FROM msnzuname WHERE id=$_GET[loeschen]");
    if ($result)
     {
      echo "<br/><span class=\"blau_mittig\">Database entry with ID $_GET[loeschen] sucessfull deleted</span><br/><br/>";
     }
    else
     {
      echo "<br/><span class=\"rot_mittig\">Eintrag mit ID Nr. $_GET[loeschen] NICHT erflogreich gelöscht!</span><br/><br/>";
     }
  
  }



if (isset($_POST[absenden]))
 {
  if (isset($_POST[msn]))
   {
     if (isset($_POST[name]))
	  {
	  
	 $result=mysql_query("INSERT INTO msnzuname VALUES('', '$_POST[msn]', '$_POST[name]')");
		 if ($result)
		  {
		   echo "<br/><span class=\"blau_mittig\">Daten erflogreich eingetragen!</span><br/><br/>";
		  }
		  else
		  {
		  echo "<br/><span class=\"rot_mittig\">Daten NICHT erflogreich eingetragen!</span><br/><br/>>";
		  }
	   
	  }
	  else
	  {
      echo "<br/><span class=\"rot_mittig\">
      Please insert name!</span><br/><br/>";
	  }
   }
   else
   {
   echo "<br/><span class=\"rot_mittig\">
   Please insert MSN</span><br/><br/>";
   }

 }


?>

 <table border="0" style="margin-right:auto;margin-left:auto;">
   <tr>
        <td style="width:80px;text-align:center;">MSN</td>
	<td style="width:80px;text-align:center;">name</td>
	<td style="width:60px;text-align:center;">edit</td>
	<td style="width:60px;text-align:center;">delete</td>
   </tr>

<?
$result=mysql_query("SELECT * FROM msnzuname");
 while($row=mysql_fetch_array($result))
  {
   echo "<tr>
    <td>$row[msn]</td>
	<td>$row[name]</td>
	<td style=\"text-align:center;\"><a href=\"./msn2nameb.php?bid=$row[id]\"><img src=\"../bilder/edit.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
	<td style=\"text-align:center;\"><a href=\"./msn2name.php?loeschen=$row[id]\"><img src=\"../bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   </tr>";
  }
 
?>



  </table>
  
 <? 
    if (isset($_GET[newentry]))
   {
    echo "<br><center><h2>Neuer Eintrag</h2>";
	echo "<form action=\"msn2name.php\" method=\"post\">
	<table border=\"1\">
	 <tr>
	  <td>MSN:</td>
	  <td><input type=\"text\" name=\"msn\"/></td>
	 </tr>
	 <tr>
	  <td>Name:</td>
	  <td><input type=\"text\" name=\"name\"/></td>
	 </tr>
	</table>
	<input type=\"submit\" name=\"absenden\" value=\"Eintragen\"/>
	</form>";
	echo "<br><br></center>";
   }
  
  ?>
<br/><br/>
- <a href="./msn2name.php?newentry=yes">New entry</a> -<br>




<?
$zugriff_mysql->close_mysql();
include("footer.inc.php");
?>
