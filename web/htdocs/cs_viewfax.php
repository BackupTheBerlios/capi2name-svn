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
 *   any later version.              		                           *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("cs_fax.php");
include("./login_check.inc.php");
include("./includes/cs_functions.inc.php");

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"]);
$sql_query=sprintf("SELECT data FROM capisuite WHERE id=%s AND cs_user=%s AND ident='2'",
		$dataB->sql_check($_GET[file]),
		$dataB->sql_check($_SESSION['cs_user']));
$result=$dataB->sql_query($sql_query);
$data=$dataB->sql_fetch_assoc($result);
$sql_query=sprintf("SELECT cs_fax FROM users WHERE id=%s",
	$dataB->sql_checkn($_SESSION['userid']));
$result_file=$dataB->sql_query($sql_query);
$daten_file=$dataB->sql_fetch_assoc($result_file);
$fileformat=$daten_file[cs_fax];
$dataB->sql_close();
srand((double)microtime()*1000000);
$tmp_file="$cs_conf[cs_temp_dir]/capi2name-";
for ($i=0;$i<5;$i++)
{
	$num = rand(48,120);
	while (($num >= 58 && $num <= 64) || ($num >= 91 && $num <= 96))
	$num = rand(48,120);
	$tmp_file .= chr($num);
}
$db_filename=$tmp_file.".sff";
if (($file_handler=fopen($db_filename, "w+"))==FALSE)
{
	echo "Could not open file $db_filename!!";
	die();
}
if (!(fwrite($file_handler,base64_decode($data[data]))))
{
	echo "Could not write to file $db_filename!!";
	die();
}
fclose($file_handler);
//$cmd_pdf="/usr/bin/ps2pdf -sPAPERSIZE=a4 $db_filename $pdf_filename";
//exec($cmd_pdf);

if ($fileformat==4)//pdf
{
	$s_Content_type="application/pdf";
	$s_filename="FAX-$_GET[file].pdf";
	$tif_filename=$tmp_file.".tif";
	$fi_filename=$db_filename.".pdf";
	exec("sfftobmp -t $db_filename -o $tif_filename");
	exec("tiff2ps -a2 -h11 -H12 -L.5 -w8.5 $tif_filename | ps2pdf - $fi_filename");
	exec("rm $tif_filename");
	exec("rm $db_filename");
}
elseif ($fileformat==3) //ps
{
	$s_Content_type="application/postscript";
	$s_filename="FAX-$_GET[file].ps";
	$fi_filename=$tmp_file.".ps";
	$tif_filename=$tmp_file.".tif";
	exec("sfftobmp -t $db_filename -o $tif_filename");
	exec("tiff2ps -a2 -h11 -H12 -L.5 -w8.5 $tif_filename -O $fi_filename");
	exec("rm $tif_filename");
	exec("rm $db_filename");
	
}
elseif ($fileformat==2) //tif
{
	$s_Content_type="image/tiff";
	$fi_filename=$tmp_file.".tif";
	$s_filename="FAX-$_GET[file].tif";
	exec("sfftobmp -t $db_filename -o $fi_filename");
	exec("rm $db_filename");
}
else //sff
{
	$s_Content_type="image/sff";
	$s_filename="FAX-$_GET[file].sff";
	$fi_filename=$db_filename;
}
//tiff2ps -a2 -h11 -H12 -L.5 -w8.5 FAX-6.tif | ps2pdf -  test.pdf 
//sfftobmp -t FAX-6.sff -o Fax.tif

// make sure the file exists before sending headers
if(!$fdl=@fopen($fi_filename,'r'))
{
	die("Cannot Open File: $fi_filename!");
}
else
{
	header("Cache-Control: ");// leave blank to avoid IE errors
	header("Pragma: ");// leave blank to avoid IE errors
	header("Content-type: $s_Content_type");
	header("Content-Disposition: attachment; filename=\"$s_filename\"");
	header("Content-length:".(string)(filesize($fi_filename)));
	sleep(1);
	fpassthru($fdl);
}
exec("rm $fi_filename");
?>