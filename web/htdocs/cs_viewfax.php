<?php
	/*
	 * Hier waere es noch dringend noetig eine benutzerautentifizierung einzufuegen.
	 * muss man mal mit dem jonas reden wie man das am besten macht.
	 *
	 */
	
	require_once("./cs_capisuite_config.inc.php");
	
	$file = $_GET['file'];
	$user = $_GET['csuser'];
	$rotate = $_GET['rotate'];
	
	$fileDir	= $cs_conf['cs_fax_user_dir'] . "/$user/received"; // supply a path name.
	$fileName	= "fax-$file.sff"; // supply a file name.
	$fileString	= $fileDir.'/'.$fileName; // combine the path and file
	exec("rm " . $cs_conf['cs_tmp_dir'] . "/capi2name.tmp.*");
	exec($cs_conf['sff2misc'] . " -j $fileString " . $cs_conf['cs_tmp_dir'] . "/capi2name.tmp");
	$fileString	= $cs_conf['cs_tmp_dir'] . "/capi2name.tmp.001.jpg";
	
	
	if (($cs_conf['use_mogrify'] == "yes") && ($rotate == "180")) system($cs_conf['mogrify'] . " -rotate 180 $fileString");
	else if($cs_conf['use_mogrify'] == "yes") system($cs_conf['mogrify'] . " $fileString");
	
	
	$fileName	= "fax-$file.jpg";
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
		header("Content-type: image/jpeg");
		header("Content-Disposition: attachment; filename=\"".$fileName."\"");
		header("Content-length:".(string)(filesize($fileString)));
		sleep(1);
		fpassthru($fdl);
	}
	system("rm " . $cs_conf['cs_tmp_dir'] . "/capi2name.tmp.*");
?>