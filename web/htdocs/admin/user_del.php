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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
include("./check_it.php");
include("./header.inc.php");

if (isset($_POST['id']) &&$_POST['id']==1)
 {
 echo "<span class=\"rot_mittig\">You can not delete the administator!<br/>GO AWAY!!!</span>";
 include("footer.inc.php");
 exit();
 }


if (isset($_POST['loeschen']))
 {
 $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $query=sprintf("DELETE FROM users WHERE id=%s", $dataB->sql_checkn($_POST['id']));
 $result=$dataB->sql_query($query);
 $dataB->sql_close();
 if ($result)
 {
  echo "<span class=\"blau_mittig\">User with ID ".$_POST['id']." sucessfully deleted.<br>You will be forwarded in 2 seconds...</span>";
  echo "<meta http-equiv=\"refresh\" content=\"2; URL=./index.php\">";
 }
 else
 {
   echo "<span class=\"rot_mittig\">User with ID ".$_POST['id']." NOT sucessfully deleted!</span>";
  }
 }

 
if (isset($_GET['id']) && isset($_GET['username']) && !isset($_POST['loeschen']))
{
echo "<h3>Löschen von Benutzer \"$_GET[username]\" mit ID $_GET[id]</h3><br/>";
echo "<form action=\"./user_del.php\" method=\"post\">";
echo "<input type=\"hidden\" name=\"id\" value=\"$_GET[id]\"/>";
echo "<input type=\"submit\" value=\"delete\" name=\"loeschen\"/>";
echo "</form>";
}

include("footer.inc.php");
?>
