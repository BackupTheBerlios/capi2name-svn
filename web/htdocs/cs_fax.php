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
 // 	editor: Kai R�mer 

?>
<?php
	$seite=base64_encode("cs_answerphone.php");
	include("./login_check.inc.php");
	include("./header.inc.php");
	
?>
<?php echo "<div class=\"ueberschrift_seite\">CapiSuite Fax Betrachter</div>"; ?>
<div style="text-align:left;">
<?php
	$dir = "/var/spool/capisuite/users/$login_name/received/";
	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	
	if(isset($_GET['viewfax'])) {
		$fax = $_GET['fax'];
		$file = "fax-$fax.txt";
		$lines = file($dir . $file);
		
?>
	<h3>Eingegangenes Fax</h3>
	<p>
		Datum: <?php echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[7]); ?><br />
		Absender: <?php echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[5]); ?><br />
		Empf�nger: <?php echo msnzuname(preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[6])); ?><br />
	</p>
	<p><img align="middle" alt="fax" src="cs_viewfax.php?file=<?php echo $fax; ?>&amp;csuser=<?php echo $login_name; ?>" /></p>
	
<?
	}
	else {
?>
	<h3>Liste der eingegangenen Faxe</h3>
	<table width="80%" align="center">
		<thead style="text-size:large;">
			<tr>
				<td>Zeit</td>
				<td>von</td>
				<td>an</td>
				<td>ansehen</td>
			</tr>
		</thead>
		<tbody>
		
<?php
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(preg_match("/.*\.\wff/i", $file)) {
					$lines = file($dir . $file);
					echo "<tr><td>";
					echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[7]);
					echo "</td><td>";
					echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[5]);
					echo "</td><td>";
					echo msnzuname(preg_replace("/(.*=\")(.*)(\"\n)/", "\\2", $lines[6]));
					echo "</td><td>";
					$a = preg_replace("/(.*-)(\d{1,4})(\.l.*)/", "\\2",$lines[4]);
					echo "<a href=\"cs_fax.php?viewfax&amp;fax=$a\">ansehen</a>";
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
	}
	$zugriff_mysql->close_mysql();
?>
</div>
<?php
include("./footer.inc.php");
?>
