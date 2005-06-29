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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("cs_answerphone.php");
include("./login_check.inc.php");
include("./header.inc.php");
require_once("./cs_functions.inc.php");
	
if (checkUsername($_SESSION['username']) != 0)
 die("<h1>username does not match local user</h1>");
 
$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/cs_answerphone.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[cs_ap_answerphone]));

$template->assign_block_vars('tab1',array(
		'CS_AP_LIST' => $textdata[cs_ap_liste],
		'CS_AP_TIME' => $textdata[cs_ap_time],
		'CS_AP_FROM' => $textdata[cs_ap_from],
		'CS_AP_TO' => $textdata[cs_ap_to]));


$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
$c = 0;
$dir = $cs_conf['cs_voice_user_dir']."/".$_SESSION['username']."/received/";

if (is_dir($dir)) {
 if ($dh = opendir($dir)) {
   while (($file = readdir($dh)) !== false) {
     if(preg_match("/voice.*\.txt/i", $file)) {
      $li[$c] = filectime($dir . $file) . ";$file";
      $c++;
     }
   }
  closedir($dh);
 }
 else "<h1>ERROR: cannot open $dir</h1>";
}
else "<h1>ERROR: cannot open $dir</h1>";
	
usort($li, "cmp");
	
foreach ($li as $value) {
		list(,$file) = split(";", $value);
		$lines = file($dir . $file);
		echo "<tr><td>";
		echo preg_replace("/(.*=\")(.*)(\")/", "\\2", $lines[7]);
		echo "</td><td>";
		echo nummer2Name(preg_replace("/(.*=\")(.*)(\"\n)/", "\\2", $lines[5]));
		echo "</td><td>";
		echo msnzuname(preg_replace("/(.*=\")(.*)(\"\n)/", "\\2", $lines[6]));
		echo "</td><td>";
		$a = preg_replace("/(.*-)(\d{1,4})(\.l.*)/", "\\2",$lines[4]);
		echo "<a href=\"cs_hearmessage.php?file=$a&amp;csuser=".$_SESSION['username']."\">$textdata[cs_ap_play]</a>";
		echo "</td></tr>";
	}
	$dataB->sql_close();

$template->pparse('overall_body');
include("./footer.inc.php");
?>