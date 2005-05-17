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
 // 	editor: Kai Römer 

?>
<?php
	$seite=base64_encode("cs_answerphone.php");
	include("./login_check.inc.php");
	include("./header.inc.php");
	require_once("./cs_functions.inc.php");
	
	if (checkUsername($_SESSION['username']) != 0) die("<h1>username does not match local user</h1>");
	
?>
<?php echo "<div class=\"ueberschrift_seite\">$textdata[cs_ap_answerphone]</div>"; ?>
	<h3><?php echo $textdata[cs_ap_liste]; ?></h3>
	<table width="650px" align="center">
		<thead style="text-size:large;">
			<tr>
				<td><?php echo $textdata[cs_ap_time]; ?></td>
				<td><?php echo $textdata[cs_ap_from]; ?></td>
				<td><?php echo $textdata[cs_ap_to]; ?></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		
<?php
	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
	
	$c = 0;
	
	$dir = $cs_conf['cs_voice_user_dir'] . "/" . $_SESSION['username'] . "/received/";
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(preg_match("/voice.*\.txt/i", $file)) {
					$li[$c] = filectime($dir . $file) . ";$file";
					$c++;
				}
			}
			closedir($dh);
		} else "<h1>ERROR: cannot open $dir</h1>";
	} else "<h1>ERROR: cannot open $dir</h1>";
	
	usort($li, "cmp");
	
	foreach ($li as $value) {
		list(,$file) = split(";", $value);
		$lines = file($dir . $file);
		echo "<tr><td>";
		echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[7]);
		echo "</td><td>";
		echo nummer2Name(preg_replace("/(.*=\")(.*)(\"\n)/", "\\2", $lines[5]));
		echo "</td><td>";
		echo msnzuname(preg_replace("/(.*=\")(.*)(\"\n)/", "\\2", $lines[6]));
		echo "</td><td>";
		$a = preg_replace("/(.*-)(\d{1,4})(\.l.*)/", "\\2",$lines[4]);
		echo "<a href=\"cs_hearmessage.php?file=$a&amp;csuser=".$_SESSION['username']."\">$textdata[cs_ap_play]</a>";
		echo "</td></tr>";
	}
	$zugriff_mysql->close_mysql();
?>
			<tr><td></td></tr>
		</tbody>
	</table>



<?php
include("./footer.inc.php");
?>