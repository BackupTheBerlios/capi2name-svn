<?









$sql["host"]                = "localhost";
$sql["dbuser"]              = "capi";
$sql["dbpasswd"]            = "kljmkgd";
$sql["db"]                  = "capidb";
$config['domain']           = "www.mein-lokal.de";
$config['capi2name_status'] = "yes";
$config['capisuite']        = "no";
$config['language']         = "de";

//BETA MUSS WIEDER RAUS!!!!!!!!!!!!!
include("./templates/blueingrey/config.php");


/******************************************************************************************************
*******************************************************************************************************
                                Do not edit belong this line
*******************************************************************************************************
*******************************************************************************************************
				Nach dieser Line nichts mehr aendern
*******************************************************************************************************
*******************************************************************************************************/





//VERSIONS INFO UND CODENAMEN:
$codenamen="pepy-BETA-VERSION";
$version="0.6.7.6";
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




?>
