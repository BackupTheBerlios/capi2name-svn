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
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
 ?>
<?
$seite=base64_encode("configpage.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/blueingrey/configpage.tpl'));
$template->assign_vars(array('L_TITLE_OF_CONFIG_PAGE' => $textdata[configpage_konfiguration]));

//ob er die Page anschauen darf:
 if (!$userconfig['showconfig'])
  {
   $template->assign_block_vars('userconfig_show_configpage', array(
   	'L_NOT_SHOW_THIS_PAGE' => $textdata[configpage_nicht_berechtigt]));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   exit();
  }
?>


<?
// Einstellungen speichern ANFANG
if ($_POST[speichern])
{
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
 $result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET name='$_POST[neuername]' WHERE id=".$_POST[id]);
 if ($result==1)
  {
   echo "<div class=\"blau_mittig\">$textdata[configpage_name_geaendert_ok]</div>";
  }
 else
  {
   echo "<div class=\"rot_mittig\">$textdata[configpage_name_geaendert_failed]</div>";
  }

$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET anzahl='$_POST[neueanzahl]' WHERE id=".$_POST[id]);
if ($result==1)
 { 
  echo "<div class=\"blau_mittig\">$textdata[configpage_anzahl_geaendert_ok]</div>"; 
 }
else
 { 
  echo "<div class=\"rot_mittig\">$textdata[configpage_anzahl_geaendert_failed]</div>";  
 }
 
if ($_POST[zeigerueckruf]=="on")
 {
  $wert="checked";
 }
else
 {
  $wert="";
 }
$result=$zugriff_mysql->sql_abfrage( "UPDATE userliste SET showrueckruf='$wert' WHERE id=".$_POST[id]);
if ($result==1)
 { 
  echo "<div class=\"blau_mittig\">$textdata[configpage_option_rueckruf_ok]</div>"; 
 }
else
 {
  echo "<div class=\"rot_mittig\">$textdata[configpage_option_rueckruf_failed]</div>";
 }
if ($_POST[zeigevorwahl]=="on")
 {
  $wert="checked";
 }
else
 { 
  $wert="";
 }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET showvorwahl='$wert' WHERE id=".$_POST[id]);
if ($result==1)
 {
   echo "<div class=\"blau_mittig\">$textdata[configpage_option_ausOrt_ok]</div>";
 }
else
 { 
  echo "<div class=\"rot_mittig\">$textdata[configpage_option_ausOrt_failed]</div>";
 }
if ($_POST[zeigemsn]=="on")
 {
  $wert="checked";
 }
else
 { 
  $wert="";
 }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET showmsn='$wert' WHERE id=".$_POST[id]);
if ($result==1)
 { 
  echo "<div class=\"blau_mittig\">$textdata[configpage_option_msn_ok]</div>";
 }
else
 {
  echo "<div class=\"rot_mittig\">$textdata[configpage_option_msn_failed]</div>";
 }
if ($_POST[zeigetyp]=="on")
 {
  $wert="checked";
 }
else 
 { 
  $wert="";
 }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET showtyp='$wert' WHERE id=".$_POST[id]);
if ($result==1)
 {
  echo "<div class=\"blau_mittig\">$textdata[configpage_option_dienst_ok]</div>";
 }
else
 {
  echo "<div class=\"rot_mittig\">$textdata[configpage_option_dienst_failed]</div>";
 }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET msns='$_POST[zmsns]' WHERE id=".$_POST[id]);
if ($result==1) 
 { 
  echo "<div class=\"blau_mittig\">$textdata[configpage_msn_ok]</div>";
 }
else
 {
  echo "<div class=\"rot_mittig\">$textdata[configpage_msn_failed]</div>"; 
 }

$zugriff_mysql->close_mysql();
}// Einstellungen speichern ENDE
?>



<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("SELECT id,username,passwd,name,lastlogin_d, lastlogin_t, anzahl, showrueckruf, shownotiz,msns,showvorwahl,showmsn,showtyp FROM userliste WHERE username='".$_SESSION['username']."'");
 $daten=mysql_fetch_assoc($result);
$zugriff_mysql->close_mysql();
//Xhtml konform das checkboxen gechecked sind.
$array=array(showrueckruf,shownotiz,showvorwahl,showmsn,showtyp);
for ($i=0;$i<=4;$i++)
 {
  if ($daten[$array[$i]]=="checked")
   {
    $daten[$array[$i]]="checked=\"checked\"";
   }
 }

 
$template->assign_block_vars('tab1', array(
	'L_USER_NAME' => $textdata[configpage_username],
	'DATA_USER_NAME' => $daten[username],
	'L_CHANGE_PASSWD' => $textdata[configpage_passwort_aendern],
	'L_OLD_PASSWD' => $textdata[configpage_altes_passwd],
	'L_NEW_PASSWD' => $textdata[configpage_neues_passwd],
	'L_NEW_PASSWD_CONFIRM' => $textdata[configpage_wiederholen],
	'L_FULL_NAME' => $textdata[configpage_voller_name],
	'DATA_FULL_NAME' => $daten[name],
	'L_SHOW_NUMBERS_OF_CALLS_IN_STAT' => $textdata[configpage_zeige_letzte_anrufe],
	'DATA_NUMBERS' => $daten[anzahl],
	'L_SHOW_CALL_BACK_FUNC' => $textdata[configpage_zeige_rueckruf],
	'DATA_CALL_BACK_FUNC' => $daten[showrueckruf],
	'L_SHOW_PREFIX_FUNC' => $text[option_splate_vorwahl],
	'DATA_PREFIX_FUNC' => $daten[showvorwahl],
	'L_SHOW_TYP_FROM_CALL' => $text[zeige_typ],
	'DATA_SHOW_TYP_FROM_CALL' => $daten[showtyp],
	'L_SHOW_MSN' => $text[option_splate_msn],
	'DATA_SHOW_MSN_FUNC' => $daten[showmsn],
	'L_SHOW_MSN_FUNC' => $text[zeige_msns],
	'DATA_SHOW_MSN_FUNC' => $daten[msns],
	'L_WARNING_FOR_MSN_FUNC' => $text[warnung_msns],
	'DATA_ID_FROM_DB' => $daten[id],
	'L_SAVE_DATA_TO_DB' => $text[speichern])); 
 

$template->pparse('overall_body');
include("./footer.inc.php");
?>
