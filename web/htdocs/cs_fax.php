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
	$seite=base64_encode("cs_fax.php");
	include("./login_check.inc.php");
	include("./header.inc.php");
	require_once("./cs_functions.inc.php");
	
	if (checkUsername($_SESSION['username']) != 0) die("<h1>username does not match local user</h1>");
	
?>
<?php echo "<div class=\"ueberschrift_seite\">$textdata[cs_fax_headline]</div>"; ?>
<div style="margin:5px;">
<?php
	$dir = $cs_conf['cs_fax_user_dir'] . "/" . $_SESSION['username'] . "/received/";
	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	
	if(isset($_GET['viewfax'])) {
		$fax = $_GET['fax'];
		$rotate = "0";
		if($_GET['rotate'] == "180") $rotate = "180";
		$file = "fax-$fax.txt";
		$lines = file($dir . $file);
		
?>
	<h3><?php echo $textdata[cs_fax_incoming]; ?></h3>
	<p>
		<?php echo $textdata[cs_fax_time]; ?>: <?php echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[7]); ?><br />
		<?php echo $textdata[cs_fax_from]; ?>: <?php echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[5]); ?><br />
		<?php echo $textdata[cs_fax_to]; ?>: <?php echo msnzuname(preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[6])); ?><br />
	</p>
<?php
	if (($cs_conf['use_mogrify'] == "yes") && ($rotate != "180")) {
		echo "<p style=\";text-align:center;\"><a href=\"cs_fax.php?viewfax&amp;fax=$fax&amp;rotate=180\">drehen</a></p>";
	}
	else {
		echo "<p style=\";text-align:center;\"><a href=\"cs_fax.php?viewfax&amp;fax=$fax&amp;rotate=0\">drehen</a></p>";
	}
?>
	<p style="margin:4px;text-align:center;">Achtung! Es wird derzeit nur die <b>erste</b> Seite des Faxes angezeigt.<br /><img alt="fax" width="98%" border="1" src="cs_viewfax.php?file=<?php echo $fax; ?>&amp;csuser=<?php echo $_SESSION['username']; ?>&amp;rotate=<?php echo $rotate; ?>" /></p>
<?php
	if (($cs_conf['use_mogrify'] == "yes") && ($rotate != "180")) {
		echo "<p style=\";text-align:center;\"><a href=\"cs_fax.php?viewfax&amp;fax=$fax&amp;rotate=180\">drehen</a></p>";
	}
	else {
		echo "<p style=\";text-align:center;\"><a href=\"cs_fax.php?viewfax&amp;fax=$fax&amp;rotate=0\">drehen</a></p>";
	}
?>
	
<?
	}
	else {
?>
	<h3><?php echo $textdata[cs_fax_liste]; ?></h3>
	<table width="650px" align="center">
		<thead style="text-size:large;">
			<tr>
				<td><?php echo $textdata[cs_fax_time]; ?></td>
				<td><?php echo $textdata[cs_fax_from]; ?></td>
				<td><?php echo $textdata[cs_fax_to]; ?></td>
				<td></td>
			</tr>
		</thead>
		<tbody>

<?php
	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
	
	$c = 0;
	
	$dir = $cs_conf['cs_fax_user_dir'] . "/" .$_SESSION['username'] . "/received/";
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(preg_match("/fax-\d{1,7}\.txt/i", $file)) {
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
		$a = preg_replace("/(.*-)(\d{1,4})(\.sff.*)/", "\\2",$lines[4]);
		echo "<a href=\"cs_fax.php?viewfax&amp;fax=$a\">$textdata[cs_fax_view]</a>";
		echo "</td></tr>";
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
