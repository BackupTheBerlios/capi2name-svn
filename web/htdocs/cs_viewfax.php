<?php
	/*
	 * Hier waere es noch dringend noetig eine benutzerautentifizierung einzufuegen.
	 * muss man mal mit dem jonas reden wie man das am besten macht.
	 *
	 */
	
	$file = $_GET['file'];
	$user = $_GET['csuser'];
	
	$fileDir = "/var/spool/capisuite/users/$user/received/"; // supply a path name.
	$fileName = "fax-$file.sff"; // supply a file name.
	$fileString=$fileDir.'/'.$fileName; // combine the path and file
	
	system("sff2mix -j $fileString /tmp/tmp");
	$fileString	= "/tmp/tmp.jpeg";
	$fileName	= "fax-$file.jpeg";
	// translate file name properly for Internet Explorer.
	if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
		$fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
	}
	// make sure the file exists before sending headers
	if(!$fdl=@fopen($fileString,'r')){
		die("Cannot Open File!");
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