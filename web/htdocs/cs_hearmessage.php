<?
/*/
Download a file using fpassthru()
/*/
$fileDir = ""; // supply a path name.
$fileName = ""; // supply a file name.
$fileString=$fileDir.'/'.$fileName; // combine the path and file
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
  header("Content-type: audio/x-wav");
  header("Content-Disposition: attachment; filename=\"".$fileName."\"");
  header("Content-length:".(string)(filesize($fileString)));
   sleep(1);
   fpassthru($fdl);
}
?>