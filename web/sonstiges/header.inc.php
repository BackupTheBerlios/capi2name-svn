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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>capi2name</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-cache">
	<style type="text/css"><?php include("./layout_scr.css.php"); ?></style>
</head>
<body>
	<div id="whitebox">
		<div id="navbox">
			<div class="headline">Hauptmenü</div>
			<div class="content">
<?php
	include("./navigator.inc.php");
?>
			</div>
		</div>
		<div id="mainbox"><!--	Tabelle		Anfang	-->
			<div class="headline"><?php echo $config['domain']; ?></div>
			<div class="content">
<?php
	if ( is_dir("up_inst")) {
//		echo "<div style\"text-align:center;\">Verzeichnis <b>up_inst</b> existiert noch! Bitte löschen!</div>";     
//		die("");
	}
?>
