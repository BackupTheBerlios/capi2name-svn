<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonas.genannt@capi2name.de
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.              		                           *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("cs_answerphone.php");
include("./login_check.inc.php");
include("./includes/cs_functions.inc.php");

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
$sql_query=sprintf("SELECT data FROM capisuite WHERE id=%s AND cs_user=%s",
		$dataB->sql_check($_GET[file]),
		$dataB->sql_check($_SESSION['cs_user']));
$result=$dataB->sql_query($sql_query);
$dataB->sql_close();
$data=$dataB->sql_fetch_assoc($result);
srand((double)microtime()*1000000);
$tmp_file="$cs_conf[cs_temp_dir]/capi2name-";
for ($i=0;$i<5;$i++)
{
	$num = rand(48,120);
	while (($num >= 58 && $num <= 64) || ($num >= 91 && $num <= 96))
	$num = rand(48,120);
	$tmp_file .= chr($num);
}
//echo "<br>$tmp_file<br>";
$db_filename=$tmp_file.".wav";
$mp3_filename=$tmp_file.".wav";
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


$mp3_filename=$db_filename;
// make sure the file exists before sending headers
if(!$fdl=@fopen($mp3_filename,'r'))
{
	die("$mp3_filename \nCannot Open File! on sending");
}
else
{
	header("Cache-Control: ");// leave blank to avoid IE errors
	header("Pragma: ");// leave blank to avoid IE errors
	header("Content-type: audio/x-mpeg");
	header("Content-Disposition: attachment; filename=\"capisuite-AB.wav\"");
	header("Content-length:".(string)(filesize($mp3_filename)));
	sleep(1);
	fpassthru($fdl);
}
exec("rm $mp3_filename");
?>
