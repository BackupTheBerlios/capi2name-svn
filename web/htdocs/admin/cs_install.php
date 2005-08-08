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
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (isset($_POST['save']))
 {
 $data_array=array('cs_temp_dir','cs_sox','cs_lame','cs_ps2pdf','cs_sfftobmp','cs_tiff2ps','cs_rm');
 for ($i=0;$i<=6;$i++)
  {
   $query=sprintf("UPDATE config SET value=%s WHERE conf=%s",
   		$dataB->sql_check($_POST[$data_array[$i]]),
		$dataB->sql_check($data_array[$i]));
   $result=$dataB->sql_query($query);
   if (!$result)
    {
     echo "Error on update the config table: $value!<br>Mysql-Says: ";
     echo mysql_error();
    }
   
 }
 echo "<br/><br/><div class=\"blau_mittig\">Data saved to database</div><br/>";
  
 }//if isset ENDE


$result=$dataB->sql_query("SELECT * FROM config WHERE conf LIKE 'cs_%'");
 while($daten_cs=$dataB->sql_fetch_assoc($result))
  {
   $cs_conf[$daten_cs['conf']]=$daten_cs['value'];
  }
$dataB->sql_close();

?>
<div class="ueberschrift_seite">CapiSuite Setup</div>
<div style="text-align:left; margin:5px; width:80%;margin:0px 10%;">
<form action="./cs_install.php" method="post">
<h3>Programms</h3>
<table border="1">
<tr>
 <td>rm</td>
 <td style="width:10px;"></td>
 <td><input name="cs_rm" value="<?=$cs_conf['cs_rm']?>"/></td>
</td>
</tr>
<tr>
<td>sfftobmp</td>
 <td style="width:10px;"></td>
 <td><input name="cs_sfftobmp" value="<?=$cs_conf['cs_sfftobmp']?>"/></td>
</tr>
<tr>
<td>tiff2ps</td>
 <td style="width:10px;"></td>
 <td><input name="cs_tiff2ps" value="<?=$cs_conf['cs_tiff2ps']?>"/></td>
</tr>
<tr>
<td>ps2pdf</td>
 <td style="width:10px;"></td>
 <td><input name="cs_ps2pdf" value="<?=$cs_conf['cs_ps2pdf']?>"/></td>
</tr>
<tr>
<td>sox</td>
 <td style="width:10px;"></td>
 <td><input name="cs_sox" value="<?=$cs_conf['cs_sox']?>"/></td>
</tr>
<tr>
<td>lame</td>
 <td style="width:10px;"></td>
 <td><input name="cs_lame" value="<?=$cs_conf['cs_lame']?>"/></td>
</tr>
</table>

<h3>Temp</h3>
<table border="1">
<tr>
 <td>temp dir</td>
 <td style="width:10px;"></td>
 <td> <input name="cs_temp_dir" value="<?=$cs_conf['cs_temp_dir']?>" type="text" /></td>
</tr>
</table> 
<br/>
<input type="submit" name="save" value="save to database" />
</form>
</div>

<?
include("./footer.inc.php");
?>