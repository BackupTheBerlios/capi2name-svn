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
	$seite=base64_encode("cs_answerphone.php");
	include("./login_check.inc.php");
	include("./header.inc.php");
	
?>
<?php echo "<div class=\"ueberschrift_seite\">CapiSuite Anrufbeantworter</div>"; ?>
	<h3>Liste der eingegangenen Nachrichten</h3>
	<table width="80%" align="center">
		<thead style="text-size:large;">
			<tr>
				<td>Zeit</td>
				<td>von</td>
				<td>an</td>
				<td>abspielen</td>
				<td>löschen</td>
			</tr>
		</thead>
		<tbody>
<a href="cs_hearmessage.php?file=" target="_blank">abspielen</a>
<?php
	$dir = "/var/spool/capisuite/users/$login_name/received/";
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(preg_match("/.*txt/i", $file)) {
					$lines = file($dir . $file);
					echo "<tr><td>";
					echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[7]);
					echo "</td><td>";
					echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[5]);
					echo "</td><td>";
					echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[6]);
					echo "</td><td>";
					$a = preg_replace("/(.*-)(\d{1,4})(\.l.*)/", "\\2",$lines[4]);
					echo "<a href=\"cs_hearmessage.php?file=$a&amp;csuser=$login_name\" target=\"_blank\">abspielen</a>";
					echo "</td><td>";
					echo "löschen";
					echo "</td></tr>";
				}
			}
			closedir($dh);
		}
	}
?>
			<tr><td></td></tr>
		</tbody>
	</table>

<?php
include("./footer.inc.php");
?>
