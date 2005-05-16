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
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (isset($_POST[save]))
 {
 $data_array=array("cs_voice_user_dir", "cs_fax_user_dir","cs_use_mogrify", "cs_mogrify", "cs_sff2misc", "cs_temp_dir" );
 for ($i=0;$i<=5;$i++)
  {
   $value=$data_array[$i];
   $result=$zugriff_mysql->sql_abfrage("UPDATE config SET value='$_POST[$value]' WHERE conf='$value'");
   if (!$result)
    {
     echo "Error on updaten config tabele: $value!<br>Mysql-Says: ";
     echo mysql_error();
    }
   
 }
 echo "<br/><br/><div class=\"blau_mittig\">Data saved to database</div><br/>";
  
 }//if isset ENDE


$result=$zugriff_mysql->sql_abfrage("SELECT * FROM config WHERE conf LIKE 'cs_%'");
 while($daten_cs=mysql_fetch_assoc($result))
  {
   $cs_conf[$daten_cs[conf]]=$daten_cs[value];
  }
$zugriff_mysql->close_mysql();

?>
<div class="ueberschrift_seite">CapiSuite Setup</div>
<div style="text-align:left; margin:5px; width:80%;margin:0px 10%;">
<form action="./cs_install.php" method="post">
<h3>capisuite Variablen</h3>
<p style="margin-right:20%; text-align:right;">
Have a look at your /etc/capisuite/* files for more information.<br />
voice_user_dir: <input name="cs_voice_user_dir" value="<?=$cs_conf['cs_voice_user_dir']?>" type="text" size="40" maxlength="80" />
<br />
fax_user_dir : <input name="cs_fax_user_dir" value="<?=$cs_conf['cs_fax_user_dir']?>" type="text" size="40" maxlength="80" />
<br />
</p>
<h3>Programms</h3>
<p style="margin-right:20%; text-align:right;">
use mogrify: <select name="cs_use_mogrify" size="1">
<option <?php if ($cs_conf['cs_use_mogrify'] == "yes") echo "selected"; ?>>yes</option>
<option <?php if ($cs_conf['cs_use_mogrify'] == "no") echo "selected"; ?>>no</option>
</select><br />
mogrify: <input name="cs_mogrify" value="<?=$cs_conf['cs_mogrify']?>" type="text" size="40" maxlength="80" />
<br />
sff2misc : <input name="cs_sff2misc" value="<?=$cs_conf['cs_sff2misc']?>" type="text" size="40" maxlength="80" />
<br />
</p>
<h3>Temp</h3>
<p style="margin-right:20%; text-align:right;">
temp dir: <input name="cs_temp_dir" value="<?=$cs_conf['cs_temp_dir']?>" type="text" size="40" maxlength="80" />
<br />
</p>
<input type="submit" name="save" value="save to database" />
</form>
</div>

<?
include("./footer.inc.php");
?>