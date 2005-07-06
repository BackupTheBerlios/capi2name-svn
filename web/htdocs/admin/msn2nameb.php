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
echo "<div class=\"ueberschrift_seite\">edit MSN to Name</div>";

if (isset($_POST[save]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $query=sprintf("DELETE FROM msnzuname WHERE id=%s", $dataB->sql_checkn($_POST[id]));
  $result=$dataB->sql_query($query);
  if ($result)
   {
    $query=sprintf("INSERT INTO msnzuname VALUES(%s,%s,%s)",
    		$dataB->sql_checkn($_POST[id]),
		$dataB->sql_checkn($_POST[msn]),
		$dataB->sql_check($_POST[name]));
    $result=$dataB->sql_query($query);
    if ($result)
     {
      echo "<span style=\"text-align:center;color:blue;\">Database entry sucessfully changed.<br/>You will be forwarded in 2 seconds...</span>";
      echo "<meta http-equiv=\"refresh\" content=\"2; URL=./msn2name.php\">";
      }
    else
      {
      echo "<span style=\"text-align:center;color:red;\">Database entry NOT sucessfully changed!</span>";
      }
   }
  else
   {
    echo "<center><font color=\"red\">Database entry NOT sucessfully deleted!</font></center>";
   }
$dataB->sql_close();
} //SAVE TO DB

if (isset($_GET[bid]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"]);
  $query=sprintf("SELECT id,msn,name FROM msnzuname WHERE id=%s",
  		$dataB->sql_checkn($_GET[bid]));
  $result=$dataB->sql_query($query);
  $daten=$dataB->sql_fetch_assoc($result);
  $dataB->sql_close();
?>
<form action="msn2nameb.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;">
<tr>
 <td style="text-align:left;">MSN:</td>
 <td stype="width:7px;"></td>
 <td style="text-align:right;">
 <?="<input type=\"text\" name=\"msn\" value=\"$daten[msn]\"/>"?></td>
</tr>
<tr>
 <td style="text-align:left;">name:</td>
 <td stype="width:7px;"></td>
 <td style="text-align:right;">
 <?="<input type=\"text\" name=\"name\" value=\"$daten[name]\"/>"?></td>
</tr>
<tr>
 <td colspan="3"><br/>
<input type="hidden" name="id" value="<?="$_GET[bid]"?>"/>
<input type="submit" name="save" value="save"/></td>
</tr>
</table>
</form>
<?php
} //nur anzeigen wenn bid gesetzt ist.

include("footer.inc.php");
?>
