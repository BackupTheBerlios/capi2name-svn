<?
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");



//Daten hier eintragen:
$host       ="localhost";
$db         ="capidb";
$dbuser     ="capi";
$dbpasswd   ="passwd";
$domain     ="www.localserv.de";
$show_status_capi2name="yes";
$capisuite="no"; //capisuite BETA PLEASE DO NOT USE
$language   ="de";  // eng for english
                   // de  für deutsch




//NOT EDIT ***************************************************************************************************
//*************************************************************************************************************
//ENDE DATEN EINTRAGEN

//DEVELOPMENT SACHEN
$sql["host"]     =$host;
$sql["dbuser"]   =$dbuser;
$sql["dbpasswd"] =$dbpasswd;
$sql["db"]       =$db ;
$prefixtab="";




//VERSIONS INFO UND CODENAMEN:
$codenamen="Käferhaufen";
$version="0.6.7.3";


//Tabellennamen:
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
