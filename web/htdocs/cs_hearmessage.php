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

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
$sql_query=sprintf("SELECT data FROM capisuite WHERE id=%s AND cs_user=%s AND ident='1'",
		$dataB->sql_checkn($_GET['file']),
		$dataB->sql_check($_SESSION['cs_user']));
$result=$dataB->sql_query($sql_query);
$result_config=$dataB->sql_query("SELECT * FROM config WHERE conf LIKE 'cs_%'");
while($daten_cs=$dataB->sql_fetch_assoc($result_config))
  {
   $cs_conf[$daten_cs['conf']]=$daten_cs['value'];
  }
$sql_query=sprintf("SELECT cs_audio FROM users WHERE id=%s",
	$dataB->sql_checkn($_SESSION['userid']));
$result_file=$dataB->sql_query($sql_query);
$daten_file=$dataB->sql_fetch_assoc($result_file);
$fileformat=$daten_file['cs_audio'];
$data=$dataB->sql_fetch_assoc($result);
$dataB->sql_close();

if ($result==false or $data==false)
{
	echo "ERROR DATABASE returned ERROR! file=????";
	die();
}

srand((double)microtime()*1000000);
$tmp_file=$cs_conf['cs_temp_dir']."/capi2name-";
for ($i=0;$i<5;$i++)
{
	$num = rand(48,120);
	while (($num >= 58 && $num <= 64) || ($num >= 91 && $num <= 96))
	$num = rand(48,120);
	$tmp_file .= chr($num);
}
//echo "<br>$tmp_file<br>";
$db_filename=$tmp_file.".wav";
if (($file_handler=fopen($db_filename, "w+"))==FALSE)
{
	echo "Could not open file $db_filename!!";
	die();
}
if (!(fwrite($file_handler,base64_decode($data['data']))))
{
	echo "Could not write to file $db_filename!!";
	die();
}
fclose($file_handler);

if ($fileformat==3) //ogg
{
	$s_filename="CapiSuite-AB-$_GET[file].ogg";
	$fi_filename=$tmp_file.".ogg";
	$s_Content_type="application/ogg";
	exec($cs_conf['cs_sox']." -v 1.9 $db_filename $fi_filename");
	exec($cs_conf['cs_rm']." -f $db_filename");
}
elseif ($fileformat==2) //mp3
{
	$fi_filename=$tmp_file.".mp3";
	$s_Content_type="audio/mpeg";
	exec($cs_conf['cs_lame']."  -m s -a $db_filename $fi_filename");
	$s_filename="CapiSuite-AB-$_GET[file].mp3";
	exec($cs_conf['cs_rm']." -f $db_filename");
}
else //wav
{
	$s_Content_type="audio/x-wav";
	$s_filename="CapiSuite-AB-$_GET[file].wav";
	$fi_filename=$db_filename;
}

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
exec($cs_conf['cs_rm']." $fi_filename");
?>