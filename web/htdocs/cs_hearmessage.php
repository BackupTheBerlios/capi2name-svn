<?php
	/*
	 * Hier waere es noch dringend noetig eine benutzerautentifizierung einzufuegen.
	 * muss man mal mit dem jonas reden wie man das am besten macht.
	 *
	 */
	require_once("./cs_capisuite_config.inc.php");
	
	$file = $_GET['file'];
	$user = $_GET['csuser'];

	
	$fileDir = $cs_conf['cs_voice_user_dir'] . "/$user/received/"; // supply a path name.
	$fileName = "voice-$file.la"; // supply a file name.
	$fileString=$fileDir.'/'.$fileName; // combine the path and file
	
	system("sox $fileString " . $cs_conf['cs_tmp_dir'] . "/capi2name-tmp.mp3");
	$fileString	= $cs_conf['cs_tmp_dir'] . "/capi2name-tmp.mp3";
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