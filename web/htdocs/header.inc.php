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
		<div class="menulist"><!--	Menupunkte	Anfang	-->
			<div class="menuitem"><a href="./index.php"><? echo "$textdata[header_inc_index]"; ?></a></div>
			<div class="menuitem"><a href="./powered.php"><? echo "$textdata[header_inc_powered]"; ?></a></div>
<?php
	if ($userconfig['showconfig'])
		echo "	<div class=\"menuitem\"><a href=\"./configpage.php\">$textdata[header_inc_configpage]</a></div>";
?>
			<div style="font-weight:bold; margin-top: 1em;"><?php echo "$textdata[header_inc_telefon]:"; ?></div>
			<div class="menuitem"><a href="./showstatnew.php"><? echo "$textdata[header_inc_anrufstatistik]"; ?></a></div>
			<div style="font-weight:bold; margin-top: 1em;"><? echo "$textdata[header_inc_erweiterte_stat]:"; ?></div>
			<div class="menuitem"><a href="./showstatnew.php?datum=heute"><? echo "$textdata[header_inc_heute_anrufte]"; ?></a></div>
			<div class="menuitem"><a href="./showstatnew.php?datum=gestern"><? echo "$textdata[header_inc_gestrige_anrufe]"; ?></a></div>
			<div class="menuitem"><a href="./showstatnew7days.php"><? echo "$textdata[header_inc_7tage]"; ?></a></div>
			<div class="menuitem"><a href="./stat_gesamt.php"><? echo "$textdata[header_inc_gesamtstatistik]"; ?></a></div>
			<div class="menuitem"><a href="./stat_monat.php"><? echo "Monatsübersicht"; ?></a></div>
			<div class="menuitem"><a href="./globale_suche.php"><? echo "Suche"; ?></a></div>
			<div class="menuitem"><a href="./kalender.php"><? echo "$textdata[header_inc_kalender]"; ?></a></div>
<?
if ($userconfig['loeschen'])
echo "<div class=\"menuitem\">
	<a href=\"./stat_un_loeschen.php\">Löschfunktion</a></div>";
?>			
			
    
<?php
	if ($userconfig['showrueckruf']) {
?>
			<div style="font-weight:bold; margin-top: 1em;"><?php echo $textdata[header_inc_rueckruf]; ?></div>
			<div class="menuitem"><a href="./zurueckruf.php"><?php echo $textdata[header_inc_rueckruf]; ?></a></div>
			<div class="menuitem"><a href="./zurueckruf.php?add=yes&amp;no=yes"><?php echo $textdata[header_inc_neuer_eintrag]; ?></a></div>
<?php
	}
?>
			<div style="font-weight:bold; margin-top: 1em;"><? echo "$textdata[header_inc_adressbuch]:"; ?></div>
			<div class="menuitem"><a href="./adressbuch.php"><? echo "$textdata[header_inc_adressbuch]"; ?></a></div>
			<div class="menuitem"><a href="./addadress.php"><? echo "$textdata[header_inc_neuer_eintrag]"; ?></a></div>
    
<?php
	if ($userconfig['shownotiz']){ 
?>
			<div style="font-weight:bold; margin-top: 1em;"><? echo $textdata[header_inc_notizen];?></div>
			<div class="menuitem"><a href="./notiz.php"><? echo $textdata[header_inc_notizen]; ?></a></div>
			<div class="menuitem"><a href="./notiz.php?new=yes"><? echo $textdata[header_inc_neue_notiz]; ?></a></div>
<?php
	}
	if ($config['capisuite'] == "yes"){ 
?>
			<div style="font-weight:bold; margin-top: 1em;">CapiSuite</div>
			<div class="menuitem"><a href="./cs_answerphone.php"><? echo $textdata[header_inc_cs_answerphone]; ?></a></div>
			<div class="menuitem"><a href="./cs_fax.php"><? echo $textdata[header_inc_cs_fax]; ?></a></div>
			<div class="menuitem"><a href="./cs_help.php"><? echo $textdata[header_inc_cs_help]; ?></a></div>
<?php
}
?>
		</div><!--	Menupunkte	Ende	-->
	</div><!--	Menu		Ende	-->

	<div id="main"><!--	Tabelle		Anfang	-->
	<div class="header2"><?php echo $config['domain']; ?></div>

<?php
	if ( is_dir("up_inst")) {
//		echo "<div style\"text-align:center;\">Verzeichnis <b>up_inst</b> existiert noch! Bitte löschen!</div>";     
//		die("");
	}
?>
