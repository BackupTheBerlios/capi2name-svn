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
include("./includes/conf.inc.php");
include("./includes/functions.php");


//Bilddaten:
$bild_hoehe=400;
$bild_breite=570; //600
$max_pixel_anzahl=$bild_hoehe-60;


for ($e=0;$e<=9;$e++) {
	$tstamp  = mktime(0, 0, 0, date("m")-$e, 1, date("Y"));
	$datum_jahr[$e]=date("Y",$tstamp);
	$datum_monat[$e]=date("m", $tstamp);
}

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
//echo "$result[tele1], $result[fax]";
for ($e=0;$e<=9;$e++) {
	$query=sprintf("SELECT rufnummer FROM angerufene, phonenumbers AS t2
	WHERE MONTH(datum)=%s 
	AND YEAR(datum)=%s 
	AND rufnummer=t2.number  AND t2.addr_id=%s",
	$dataB->sql_checkn($datum_monat[$e]),
	$dataB->sql_checkn($datum_jahr[$e]),
	$dataB->sql_checkn($_GET['id']));
	$result_alle=$dataB->sql_query($query);
	$anzahl_monat_alle[$e]=$dataB->sql_num_rows($result_alle);
}
$dataB->sql_close();

$max_anrufe=max($anzahl_monat_alle);
$hoehe_ein_anruf=$max_pixel_anzahl/$max_anrufe;


$im = imagecreate($bild_breite, $bild_hoehe) or die("Cannot Initialize new GD image stream");
$bc = imagecolorallocate($im, 130, 130, 130);
$col = imagecolorallocate($im, 255,255,255);
$rc = imagerectangle($im, 3,3, $bild_breite-3,$bild_hoehe-3,$col); //weisser rahmen
$col = imagecolorallocate($im, 0,0,0);
$ln =imageline($im,25,$bild_hoehe-30,$bild_breite-30,$bild_hoehe-30,$col);
$ln =imageline($im, 35,$bild_hoehe-20,35,20, $col);

//Pfeil rechten unten:
$ln = imageline($im, $bild_breite-30,$bild_hoehe-30,$bild_breite-30-5,$bild_hoehe-30-5, $col);
$ln = imageline($im, $bild_breite-30,$bild_hoehe-30,$bild_breite-30-5,$bild_hoehe-30+5, $col);
//Pfeil links oben:
$ln = imageline($im, 35,20,35-5,20+5, $col);
$ln = imageline($im, 35,20,35+5,20+5, $col);
$col_rot = imagecolorallocate($im, 255,0,0);
$col_blau= imagecolorallocate($im, 0,0,255);
$col_gruen= imagecolorallocate($im, 0,255,0);

$e=10;
do {
	$temp=$hoehe_ein_anruf*$e;
	$ln =imageline($im, 25,$bild_hoehe-30-$temp,40,$bild_hoehe-30-$temp, $col);
	$is =imagestring($im, 2,17,$bild_hoehe-30-$temp,$e , $col );
	$e+=10;
}while($e<=$max_anrufe);

$einheit=45; 
for ($i=0;$i<=9;$i++) {
	$pixel_alle=$hoehe_ein_anruf*$anzahl_monat_alle[$i];
	$rc = imagefilledrectangle($im, $einheit,$bild_hoehe-30-$pixel_alle,$einheit+7,$bild_hoehe-30, $col_rot);
	$iss = imagestring($im,2,$einheit+9,$bild_hoehe-48-$pixel_alle, $anzahl_monat_alle[$i], $col);
	$is =imagestring($im, 2,$einheit-4,$bild_hoehe-27,"$datum_monat[$i]/$datum_jahr[$i]" , $col );
	$einheit+=50; //90
}

header("Cache-Control: ");// leave blank to avoid IE errors
header("Pragma: ");// leave blank to avoid IE errors
imagepng($im);
imagedestroy($im);
?>