<?
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
	header ("Cache-Control: no-cache,private, must-revalidate");
	header ("Pragma: no-cache");
	
?>
<!--
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
-->
<?php
	include("./".$config['language'].".inc.php");

	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$result=$zugriff_mysql->sql_abfrage("SELECT std FROM farben WHERE name='farbwahl'");
	$row=mysql_fetch_array($result);
	$result=$zugriff_mysql->sql_abfrage("SELECT * FROM farben WHERE id='$row[0]'");
	$row=mysql_fetch_array($result);
	$c_color[1]=$row[3];
	$c_color[2]=$row[4];
	$c_color[3]=$row[5];
	$c_color[4]=$row[6];
	$c_color[5]=$row[7];
	$c_color[6]=$row[8];
	$c_color[7]=$row[9];
	$c_color[8]=$row[10];
	$c_color[9]=$row[11];
	$c_color[10]=$row[12];
	$c_color[11]=$row[13];
	$c_color[12]=$row[14];
	$zugriff_mysql->close_mysql();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head> 
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15"/> 
	<style type="text/css"><?php include("./layout_scr.css.php"); ?></style>
	<title><? echo $config['domain']; ?> | Homepage</title>
</head>
<body>
<div id="mainframe"><!--    Hauptkasten	Anfang	-->
	<div id="menu"><!--	Menu		Anfang	-->
		<div class="header"><? echo "$textdata[header_inc_mainmenue]"; ?></div>
<?php
	include("./navigator.inc.php");
?>
	</div><!--	Menu		Ende	-->

	<div id="main"><!--	Tabelle		Anfang	-->
	<div class="header2"><?php echo $config['domain']; ?></div>

<?php
	if ( is_dir("up_inst")) {
//		echo "<div style\"text-align:center;\">Verzeichnis <b>up_inst</b> existiert noch! Bitte löschen!</div>";     
//		die("");
	}
?>
