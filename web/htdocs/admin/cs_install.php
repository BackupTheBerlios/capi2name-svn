<?php
/*
    copyright            : (C) 2002-2004 by Jonas Genannt
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
 // 	editor: Kai Römer 

?>
<?php
	if(!function_exists('write_ini_file')) {
		function write_ini_file($path, $assoc_array) {
			foreach($assoc_array as $key => $item) {
				if(is_array($item)) {
					$content .= "\n[{$key}]\n";
					foreach ($item as $key2 => $item2) {
						if(is_numeric($item2) || is_bool($item2))
							$content .= "{$key2} = {$item2}\n";
						else
							$content .= "{$key2} = \"{$item2}\"\n";
					}       
				} else {
					if(is_numeric($item) || is_bool($item))
						$content .= "{$key} = {$item}\n";
					else
						$content .= "{$key} = \"{$item}\"\n";
				}
			}
			
			if(!$handle = fopen($path, 'w')) {
				return false;
			}

			if(!fwrite($handle, $content)) {
				return false;
			}

			fclose($handle);
			
			return true;
		}
	}
?>
<?php
	$seite=base64_encode("cs_install.php");
	include("./check_it.php");
	include("./header.inc.php");
	$cs_conf = parse_ini_file("cs_conf.inc.ini");	
	
	if (isset($_POST['submit'])) {
		$cs_conf['mogrify'] = "";
		$cs_conf['use_mogrify'] = $_POST['use_mogrify'];
		$cs_conf['mogrify'] = $_POST['mogrify'];
		$cs_conf['sff2misc'] = $_POST['sff2misc'];
		$cs_conf['cs_voice_user_dir'] = $_POST['voice_user_dir'];
		$cs_conf['cs_fax_user_dir'] = $_POST['fax_user_dir'];
		$cs_conf['cs_tmp_dir'] = $_POST['temp_dir'];
	
		write_ini_file("cs_conf.inc.ini",$cs_conf);
	}
?>
<?php echo $cs_conf['']; ?>
<?php echo "<div class=\"ueberschrift_seite\">$textdata[cs_config_headline]</div>"; ?>
<div style="text-align:left; margin:5px; width:80%;margin:0px 10%;">
	<form action="./cs_install.php" method="POST">
		<h3>capisuite Variablen</h3>
		<p style="margin-right:20%; text-align:right;">
			Have a look at your /etc/capisuite/* files for more information. <br />
			voice_user_dir: <input name="voice_user_dir" value="<?php echo $cs_conf['cs_voice_user_dir']; ?>" type="text" size="40" maxlength="80" /><br />
			fax_user_dir : <input name="fax_user_dir" value="<?php echo $cs_conf['cs_fax_user_dir']; ?>" type="text" size="40" maxlength="80" /><br />
		</p>
		<h3>Programms<?php echo $cs_conf['sff2misc']; ?></h3>
		<p style="margin-right:20%; text-align:right;">
			use mogrify: <select name="use_mogrify" size="1">
					<option <?php if ($cs_conf['use_mogrify'] == "yes") echo "selected"; ?>>yes</option>
					<option <?php if ($cs_conf['use_mogrify'] == "no") echo "selected"; ?>>no</option>
				</select><br />
			mogrify: <input name="mogrify" value="<?php echo $cs_conf['mogrify']; ?>" type="text" size="40" maxlength="80" /><br />
			sff2misc : <input name="sff2misc" value="<?php echo $cs_conf['sff2misc']; ?>" type="text" size="40" maxlength="80" /><br />
		</p>
		
		<h3>Temp</h3>
		<p style="margin-right:20%; text-align:right;">
			temp dir: <input name="temp_dir" value="<?php echo $cs_conf['cs_tmp_dir']; ?>" type="text" size="40" maxlength="80" /><br />
		</p>
		<input type="submit" name="submit" value="submit" />
	</form>
</div>
<?php
	include("./footer.inc.php");
?>