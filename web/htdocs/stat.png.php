<?
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
	$bild_hoehe_org=440;
	$bild_breite=600;
	$max_pixel_anzahl=$bild_hoehe-60;
	
	for ($e=0;$e<=5;$e++) {
	
		$tstamp  = mktime(0, 0, 0, date("m")-$e, 1, date("Y"));
		$datum_jahr[$e]=date("Y",$tstamp);
		$datum_monat[$e]=date("m", $tstamp);
	
	}
	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	for ($e=0;$e<=5;$e++) {
		
		$result_alle=$zugriff_mysql->sql_abfrage("SELECT id,rufnummer FROM angerufene WHERE MONTH(datum)=$datum_monat[$e] AND YEAR(datum)=$datum_jahr[$e]");
		$result_unbekannt=$zugriff_mysql->sql_abfrage("SELECT id,rufnummer FROM angerufene WHERE MONTH(datum)=$datum_monat[$e] AND YEAR(datum)=$datum_jahr[$e] AND rufnummer='unbekannt'");
		
		$anzahl_monat_alle[$e]=mysql_num_rows($result_alle);
		$anzahl_monat_unbekannt[$e]=mysql_num_rows($result_unbekannt);
		$anzahl_monat_bekannt[$e]=$anzahl_monat_alle[$e]-$anzahl_monat_unbekannt[$e];
	}
	$zugriff_mysql->close_mysql();
	$max_anrufe=max($anzahl_monat_alle);
	
	$hoehe_ein_anruf=$max_pixel_anzahl/$max_anrufe;
	
	
	//header("Content-type: image/png");
	$im = imagecreate($bild_breite, $bild_hoehe_org) or die("Cannot Initialize new GD image stream");
	$bc = imagecolorallocate($im, 130, 130, 130);
	$col = imagecolorallocate($im, 255,255,255);
	$rc = imagerectangle($im, 3,3, $bild_breite-3,$bild_hoehe_org-3,$col); //weisser rahmen
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
	
	//Rot,gruen,blau definieren:
	$is =imagestring($im, 2,35,410, "Alle Anrufe:" , $col );
	$rc =imagefilledrectangle($im,115,412,150,425, $col_rot);
	$is =imagestring($im, 2,180,410, "Bekannte Anrufe:" , $col );
	$rc =imagefilledrectangle($im,280,412,315,425, $col_blau);
	$is =imagestring($im, 2,345,410, "Unbekannte Anrufe:" , $col );
	$rc =imagefilledrectangle($im,460,412,495,425, $col_gruen);
	
	$e=10;
	do {
		$temp=$hoehe_ein_anruf*$e;
		$ln =imageline($im, 25,$bild_hoehe-30-$temp,40,$bild_hoehe-30-$temp, $col);
		$is =imagestring($im, 2,17,$bild_hoehe-30-$temp,$e , $col );
		$e+=10;
	}while($e<=$max_anrufe);
	
	$einheit=45;
	for ($i=0;$i<=5;$i++) {
		$pixel_alle=$hoehe_ein_anruf*$anzahl_monat_alle[$i];
		$pixel_unbekannt=$hoehe_ein_anruf*$anzahl_monat_unbekannt[$i];
		$pixel_bekannt=$hoehe_ein_anruf*$anzahl_monat_bekannt[$i];
		$rc = imagefilledrectangle($im, $einheit,$bild_hoehe-30-$pixel_alle,$einheit+7,$bild_hoehe-30, $col_rot);
		$is =imagestring($im, 2,$einheit-4,$bild_hoehe-27,"$datum_monat[$i]/$datum_jahr[$i]" , $col );
		$rc = imagefilledrectangle($im, $einheit+10,$bild_hoehe-30-$pixel_bekannt,$einheit+7+10,$bild_hoehe-30, $col_blau);
		$rc = imagefilledrectangle($im, $einheit+20,$bild_hoehe-30-$pixel_unbekannt,$einheit+7+20,$bild_hoehe-30, $col_gruen);
		
		
		$einheit+=90;
	}
	
	$fileName	= "stats.png";
	
	// translate file name properly for Internet Explorer.
	if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
		$fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
	}
	header("Cache-Control: ");// leave blank to avoid IE errors
	header("Pragma: ");// leave blank to avoid IE errors
	header("Content-type: image/png");
	header("Content-Disposition: attachment; filename=\"".$fileName."\"");
	
	
	
	
	//$tc = imagecolorallocate($im, 0, 0, 0);
	//imagestring($im, 1, 4, 4,  "ffsdf", $tc);
	
	imagepng($im);
	imagedestroy($im);
?>