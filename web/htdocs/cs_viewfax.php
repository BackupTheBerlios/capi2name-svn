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
$sql_query=sprintf("SELECT data FROM capisuite WHERE id=%s AND cs_user=%s",
		$dataB->sql_check($_GET[file]),
		$dataB->sql_check($_SESSION['cs_user']));
$result=$dataB->sql_query($sql_query);
$data=$dataB->sql_fetch_assoc($result);
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
$jpg_filename=$tmp_file."-jp.jpg";
echo "<br>$tmp_file<br>$db_filename<br>$jpg_filename<br>";
if (($file_handler=fopen($db_filename, "w+"))==FALSE)
{
	echo "Could not open file $db_filename!!";
	die();
}
if (!(fwrite($file_handler,$data[data])))
{
	echo "Could not write to file $db_filename!!";
	die();
}
fclose($file_handler);
$cmd_sff="/usr/bin/sfftobmp -f -j $db_filename -o $jpg_filename";
echo "- $cmd_sff -<br>";
exec($cmd_sff);



// translate file name properly for Internet Explorer.
if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
{
	$fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
}
// make sure the file exists before sending headers
if(!$fdl=@fopen($fileString,'r'))
{
	die("Cannot Open File!");
}
else
{
	header("Cache-Control: ");// leave blank to avoid IE errors
	header("Pragma: ");// leave blank to avoid IE errors
	header("Content-type: image/jpeg");
	header("Content-Disposition: attachment; filename=\"".$fileName."\"");
	header("Content-length:".(string)(filesize($fileString)));
	sleep(1);
	fpassthru($fdl);
}
?>