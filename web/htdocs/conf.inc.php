<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache,private, must-revalidate");
header ("Pragma: no-cache");








$sql["host"]                = "localhost";
$sql["dbuser"]              = "capi";
$sql["dbpasswd"]            = "kljm";
$sql["db"]                  = "capidb";
$config['domain']           = "www.mein-lokal.de";
$config['capi2name_status'] = "yes";
$config['capisuite']        = "no";
$config['language']         = "de";



/******************************************************************************************************
*******************************************************************************************************
                                Do not edit belong this line
*******************************************************************************************************
*******************************************************************************************************
				Nach dieser Line nichts mehr aendern
*******************************************************************************************************
*******************************************************************************************************/





//VERSIONS INFO UND CODENAMEN:
$codenamen="BETA-VERSION";
$version="0.6.7.4";
//Tabellennamen:
$prefixtab="";
$tabelle["adressbuch"]=$prefixtab."adressbuch";
$tabelle["angerufene"]=$prefixtab."angerufene";
$tabelle["capi_version"]=$prefixtab."capi_version";
$tabelle["farben"]=$prefixtab."farben";
$tabelle["msnzuname"]=$prefixtab."msnzuname";
$tabelle["notiz"]=$prefixtab."notiz";
$tabelle["userliste"]=$prefixtab."userliste";
$tabelle["vorwahl"]=$prefixtab."vorwahl";
$tabelle["zurueckrufen"]=$prefixtab."zurueckrufen";


$host=$sql["host"];
$dbuser=$sql["dbuser"];
$dbpasswd=$sql["dbpasswd"];
$db=$sql["db"];


?>
