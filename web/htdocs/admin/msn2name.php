<?php
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
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"]);
?>
<div class="ueberschrift_seite">MSN to name</div>
You can set up names for your local MSN's. These names will you see in the calling stat in the normal userinterface instead of the local MSN's numbers.
<br/>
<br/>
<?php
 if (isset($_GET['delmsn']))
  {
   $query=sprintf("DELETE FROM msnzuname WHERE id=%s",
   	 $dataB->sql_check($_GET[delmsn]));
   $result=$dataB->sql_query($query);
   if ($result)
    {
     echo "<br/><span class=\"blau_mittig\">Database entry with ID $_GET[delmsn] sucessfull deleted</span><br/><br/>";
    }
   else
    {
     echo "<br/><span class=\"rot_mittig\">Database entry with ID $_GET[delmsn] NOT sucessfull deleted!</span><br/><br/>";
    }
  }

if (isset($_POST['absenden']))
{
	if (isset($_POST['msn']) && isset($_POST['name']))
	{
		$query=sprintf("INSERT INTO msnzuname VALUES(NULL,%s,%s)",
			$dataB->sql_checkn($_POST['msn']),
			$dataB->sql_check($_POST['name']));
		$result=$dataB->sql_query($query);
		if ($result)
		{
			echo "<br/><span class=\"blau_mittig\">Data sucessfully written to database.</span><br/><br/>";	
		}
		else
		{
			echo "<br/><span class=\"rot_mittig\">Data NOT sucessfully written to database.</span><br/><br/>";
		}
	}
	else
	{
		echo "<br/><span class=\"rot_mittig\">Please insert name and MSN number for the MSN!</span><br/><br/>";
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

<?php
$result=$dataB->sql_query("SELECT * FROM msnzuname");
while($row=$dataB->sql_fetch_assoc($result))
 {
   echo "
   <tr>
   <td>$row[msn]</td>
   <td>$row[name]</td>
   <td style=\"text-align:center;\"><a href=\"./msn2nameb.php?bid=$row[id]\"><img src=\"../images/edit.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   <td style=\"text-align:center;\"><a href=\"./msn2name.php?delmsn=$row[id]\"><img src=\"../images/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   </tr>";
 }
echo "</table>";

if (isset($_GET['newentry']) )
 {
  echo "
  <br/><hr/>
  <h2>Neuer Eintrag</h2>
  <form action=\"msn2name.php\" method=\"post\">
  <table border=\"0\" style=\"margin-right:auto;margin-left:auto;\">
  <tr>
   <td>MSN:</td>
   <td><input type=\"text\" name=\"msn\"/></td>
  </tr>
  <tr>
   <td>Name:</td>
   <td><input type=\"text\" name=\"name\"/></td>
  </tr>
  <tr>
   <td colspan=\"2\"><input type=\"submit\" name=\"absenden\" value=\"Eintragen\"/></td>
  </tr>
  </table>
  </form><br/><br/>";
 }
   
if (!isset($_GET['newentry']))
{
	echo "<br/><br/>- <a href=\"./msn2name.php?newentry=yes\">New entry</a> -<br>";
}
$dataB->sql_close();
include("footer.inc.php");
?>
