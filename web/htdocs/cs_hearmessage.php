<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt and
    					    Kai R�mer
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
$seite=base64_encode("cs_answerphone.php");
include("./login_check.inc.php");
include("./includes/cs_functions.inc.php");

$file = $_GET['file'];
$user = $_GET['csuser'];


	
	$fileDir = $cs_conf['cs_voice_user_dir'] . "/$user/received/"; // supply a path name.
	$fileName = "voice-$file.la"; // supply a file name.
	//$fileName = "voice-0.la"; // supply a file name.
	$fileString=$fileDir.'/'.$fileName; // combine the path and file
	
	exec("sox $fileString " . $cs_conf[cs_temp_dir] . "/capi2name-tmp.mp3");
	$fileString	= $cs_conf[cs_temp_dir] . "/capi2name-tmp.mp3";
	$fileName	= "answerphone-$file.mp3";
	
	// translate file name properly for Internet Explorer.
	if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
		$fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
	}
	// make sure the file exists before sending headers
	if(!$fdl=@fopen($fileString,'r')){
		die("$fileString \nCannot Open File!");
	} else {
		header("Cache-Control: ");// leave blank to avoid IE errors
		header("Pragma: ");// leave blank to avoid IE errors
		header("Content-type: audio/x-mpeg");
		header("Content-Disposition: attachment; filename=\"".$fileName."\"");
		header("Content-length:".(string)(filesize($fileString)));
		sleep(1);
		fpassthru($fdl);
	}
?>