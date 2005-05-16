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

<?
if (isset($_POST[submit_data]))
 {
  $all_ok=true;
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if ($_POST[template]== "user_define")
   {
    $result=$zugriff_mysql->sql_abfrage("UPDATE config SET value='' WHERE conf='template'");
   }
  else
   {
   $result=$zugriff_mysql->sql_abfrage("UPDATE config SET value='$_POST[template]' WHERE conf='template'");
   }
   $result=$zugriff_mysql->sql_abfrage("UPDATE config SET value='$_POST[default_template]' WHERE conf='default_template'");
   
 if (!$all_ok)
  {
   echo "<div class=\"rot_mittig\">Somethink is wrong, please check your imput!</div>";
  }
 // $zugriff_mysql->sql_abfrage("UPDATE");
  $zugriff_mysql->close_mysql();
 }
?>


<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td style="width:50px;text-align:center;">id</td>
  <td style="width:144px;text-align:left;">Option</td>
  <td style="width:70px;text-align:center;">value</td>
 </tr>
<form action="global_config.php" method="post">
<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM config");
$zugriff_mysql->close_mysql();

$dir= "../templates/";
$dh=opendir($dir);
 while (false!== ($filename=readdir($dh)))
 {
  if ($filename!="." AND $filename!=".." AND $filename!="index.html")
   {
    $files[] =$filename;
   }
 }

while($daten=mysql_fetch_assoc($result))
 {
 if ($daten[conf]=="db_version")
  {
   echo "
    <tr>
     <td>$daten[id]</td>
     <td style=\"text-align:left;\">$daten[conf]:</td>
     <td style=\"text-align:right;\">$daten[value]</td>
    </tr>";   
  }
 elseif ($daten[conf]=="template")
  {
   
   echo "<tr>
         <td>$daten[id]</td>
         <td style=\"text-align:left;\">Template: </td><td><select name=\"template\">";
   foreach ($files as $dirs)  
   {

    if ($dirs==$daten[value])
      {
       
	echo "<option selected=\"selected\" value=\"$daten[value]\">$daten[value]</option>";
      }
    else
      {
       echo "<option value=\"$dirs\">$dirs</option>";
      }
   } 
  if ($daten[value]==NULL)
   {
    echo "<option selected=\"selected\" value=\"user_define\">User define</option>";
   }
  else
   {
    echo "<option  value=\"user_define\">User define</option>";
   }
   
  echo "</select></td></tr>";
  }
 elseif ($daten[conf]=="default_template")
  {
     
   echo "<tr>
         <td>$daten[id]</td>
	 <td style=\"text-align:left;\">Default template: </td><td>
	 <select name=\"default_template\">";
   foreach ($files as $dirs)  
   {

    if ($dirs==$daten[value])
      {
       
	echo "<option selected=\"selected\" value=\"$daten[value]\">$daten[value]</option>";
      }
    else
      {
       echo "<option value=\"$dirs\">$dirs</option>";
      }
   } 
  
  echo "</select></td></tr>";
  }
 else
  {
   /*echo "
    <tr>
     <td>$daten[id]</td>
     <td style=\"text-align:left;\">$daten[conf]:</td>
     <td style=\"text-align:right;\"><input name=\"$daten[id]\" typ=\"text\" value=\"$daten[value]\"/></td>
    </tr>"; */
  }
 }
?>
</table>
<input name="submit_data" type="submit" value="Submit data"/>
</form>


<?
include("footer.inc.php");
?>
