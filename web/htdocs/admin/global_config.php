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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
include("./check_it.php");
include("./header.inc.php");

?>
<div class="ueberschrift_seite">Global Config</div>


<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td style="width:50px;text-align:center;">id</td>
  <td style="width:90px;text-align:center;">Option</td>
  <td style="width:70px;text-align:center;">value</td>
 </tr>
<form action="global_config.php" method="post">
<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM config");
$zugriff_mysql->close_mysql();





while($daten=mysql_fetch_assoc($result))
 {
 if ($daten[conf]=="db_version")
  {
   echo "
    <tr>
     <td>$daten[id]<input name=\"id\" value=\"$daten[id]\" type=\"hidden\"/></td>
     <td style=\"text-align:left;\">$daten[conf]:</td>
     <td style=\"text-align:right;\">$daten[value]</td>
    </tr>";   
  }
 else
  {
   echo "
    <tr>
     <td>$daten[id]<input name=\"id\" value=\"$daten[id]\" type=\"hidden\"/></td>
     <td style=\"text-align:left;\">$daten[conf]:</td>
     <td style=\"text-align:right;\"><input name=\"$daten[id]\" value=\"$daten[value]\"/></td>
    </tr>"; 
  }
 }
?>
</table>
</form>


<?
include("footer.inc.php");
?>
