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
<div class="ueberschrift_seite">edit MSN to Name</div>
<?
if (isset($_POST[save]))
 {
  
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $res=mysql_query("DELETE FROM msnzuname WHERE id=$_POST[id]");
  if ($res)
   {
    $result=mysql_query("INSERT INTO msnzuname VALUES('$_POST[id]','$_POST[msn]', '$_POST[name]')");
    if ($result)
      {
	echo "<span style=\"text-align:center;color:blue;\">Eintrag erfolgreich in Datenbank geschreiben !</span>";
      }
    else
      {
      echo "<span style=\"text-align:center;color:red;\">Eintrag NICHT erfolgreich in Datenbank geschreiben !</span>";
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

<?
if (isset($_GET[bid]))
 {
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=mysql_query("SELECT id,name,msn FROM msnzuname WHERE id='$_GET[bid]'");
$daten=mysql_fetch_array($result);
$zugriff_mysql->close_mysql();
?>
<form action="msn2nameb.php" method="post">
<table border="0"  style="margin-right:auto;margin-left:auto;">
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
<?
} //nur anzeigen wenn bid gesetzt ist.
?>




<?
include("footer.inc.php");
?>
