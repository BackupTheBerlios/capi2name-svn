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
<h3>MSN zu einem Name zuordnen<br>- Bearbeiten -</h2>
</center>
<br>

<?
 if (isset($_POST[speichern]))
   {
   echo "ID: $_POST[id]";
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$res=mysql_query( "DELETE FROM msnzuname WHERE id=$_POST[id] ");
	 if ($res==1)
	  {
	   echo "<center>Eintrag erfolgreich gelöscht !</center>";
	    $res1=mysql_query("INSERT INTO msnzuname VALUES('$_POST[id]','$_POST[msn]', '$_POST[name]')");
		 if ($res1==1)
		  {
			echo "<center>Eintrag erfolgreich in Datenbank geschreiben !</center>";

		  }
		  else
		  {
		   echo "<center><font color=\"red\">Eintrag NICHT erfolgreich in Datenbank geschreiben !</font></center>";
		  }
	  }
	  else
	  {
	  echo "<center><font color=\"red\">Eintrag NICHT erfolgreich gelöscht</font></center>";
	  echo mysql_error();
	  }

	$zugriff_mysql->close_mysql();
   }
?>

<center>
<form action="msn2nameb.php" method="post">
<table border="1">
<tr>
 <td>MSN</td>
 <td>Name</td>
</tr>
<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=mysql_query("SELECT * FROM msnzuname WHERE id='$_GET[bid]'");
 $daten=mysql_fetch_array($result);

 echo "<tr>
<td><input type=\"text\" name=\"msn\"  value=\"$daten[msn]\"></td>
<td><input type=\"text\" name=\"name\" value=\"$daten[name]\"></td>


 </tr>";
$zugriff_mysql->close_mysql();
?>
</table>
<br>
<input type="hidden" name="id" value="<? echo "$_GET[bid]"; ?>">
<input type="submit" name="speichern" value="Speichern">
</form>
</center>





<?
include("footer.inc.php");
?>
