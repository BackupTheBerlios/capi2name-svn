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
$seite=base64_encode("stat_anrufer.php");
include("./login_check.inc.php");
include("./header.inc.php");
 

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$sql_query=sprintf("SELECT * FROM adressbuch WHERE id=%s", mysql_real_escape_string($_GET[id]));
$result_adressbuch=$zugriff_mysql->sql_abfrage($sql_query);
$data_adressbuch=mysql_fetch_array($result_adressbuch);
$zugriff_mysql->close_mysql();


$template->set_filenames(array('overall_body' => 'templates/blueingrey/stat_anrufer.tpl'));
$template->assign_vars(array(
		'L_SITE_TITLE'  => $textdata[stat_anrufer_ueberschrift]." ".$data_adressbuch[vorname]." ".$data_adressbuch[nachname]));


//Daten sammeln:
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); $result_anrufe=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE rufnummer='$data_adressbuch[tele1]' OR rufnummer='$data_adressbuch[tele2]' OR rufnummer='$data_adressbuch[tele3]' OR rufnummer='$data_adressbuch[handy]'");
$zugriff_mysql->close_mysql();
$ges_anzahl=mysql_num_rows($result_anrufe);


 if ($ges_anzahl!=false) //wenn gar kein anruf gibt
  {

 $id_letzer=$ges_anzahl - 1;
 $datum_letzter=mysql_datum(mysql_result($result_anrufe, $id_letzer, "datum"));
 $uhrzeit_letzer=mysql_result($result_anrufe, $id_letzer, "uhrzeit");
 $datum_erster=mysql_datum(mysql_result($result_anrufe, "0", "datum"));
 $uhrzeit_erster=mysql_result($result_anrufe, "0", "uhrzeit");


//Durchschnittlich Anrufe pro Woche ausrechen:
$a_datum_erster=explode(".", $datum_erster);
$a_datum_letzer=explode(".", $datum_letzter);
$utime_date_erster = gmmktime(0,0,0,$a_datum_erster[1], $a_datum_erster[0], $a_datum_erster[2]);
$utime_date_letzer = gmmktime(0,0,0,$a_datum_letzer[1], $a_datum_letzer[0], $a_datum_letzer[2]);
$ergbis=$utime_date_letzer-$utime_date_erster;
$wochen=$ergbis/60/60/24/7;
$wochen_genau=ceil($wochen);
 if ($wochen_genau==0) $wochen_genau=1;
$anrufe_woche= round($ges_anzahl/$wochen_genau, 2);
//ende daten sammeln!!!!


$template->assign_block_vars('tab1',array(
	'L_DETAIL_VIEW' => 'Detailansicht',
	'L_ADDR_FRIST_NAME' => $textdata[addadress_vorname],
	'L_ADDR_LAST_NAME' => $textdata[addadress_nachname],
	'DATA_FIRST_NAME' => $data_adressbuch[vorname],
	'DATA_LAST_NAME' => $data_adressbuch[nachname]));




if ($data_adressbuch[tele1]!="99")
 { 
   $template->assign_block_vars('show_tele1',array(
   		'L_TELE_1' => $textdata[addadress_telefonnummer1],
		'DATA_TELE_1' => $data_adressbuch[tele1]));
 }
if ($data_adressbuch[tele2]!="99")
 {
   $template->assign_block_vars('show_tele2',array(
   		'L_TELE_2' => $textdata[addadress_telefonnummer2],
		'DATA_TELE_2' => $data_adressbuch[tele2]));
 }
if ($data_adressbuch[tele3]!="99")
 {
  $template->assign_block_vars('show_tele3',array(
   		'L_TELE_3' => $textdata[addadress_telefonnummer3],
		'DATA_TELE_3' => $data_adressbuch[tele3]));
 }
if ($data_adressbuch[handy]!="99")
 { 
  $template->assign_block_vars('show_cell_phone',array(
		'L_CELL_PHONE' => $textdata[addadress_handy],
		'DATA_CELL_PHONE' => $data_adressbuch[handy]));
 }
 
 
$template->assign_block_vars('tab2',array(
	'L_STAT_CALLERS_COUNTS' => $textdata[stat_anrufer_zahlen_fakten],
	'L_ALL_CALLS' => $textdata[stat_anrufer_gesamte_anrufe],
	'DATA_ALL_CALLS' => $ges_anzahl,
	'L_STAT_TIME' => $textdata[stat_anrufer_geht_ueber],
	'DATA_WEEKS' => $wochen_genau,
	'L_WEKKS' => 'Wochen',
	'L_LAST_CALL' => $textdata[stat_anrufer_letzter_anruf],
	'DATA_LAST_DATE' => $datum_letzter,
	'DATA_LAST_TIME' => $uhrzeit_letzer,
	'L_FRIST_CALL' => $textdata[stat_anrufer_erster_anruf],
	'DATA_FIRST_DATE' => $datum_erster,
	'DATA_FIRST_TIME' => $uhrzeit_erster,
	'L_CALLS_AVERAGE' => $textdata[stat_anrufer_durchschnitt_anrufe],
	'DATA_CALLS_AVERAGE' => $anrufe_woche)); 
 
$template->assign_vars(array('DATA_ID_CALLERS' => $_GET[id])); 

$template->assign_block_vars('tab3',array(
	'L_LSIT_ALL_CALLS' => $textdata[stat_anrufer_alle_anrufe_von]." ".$data_adressbuch[vorname]." ".$data_adressbuch[nachname],
	'L_DATE' => $textdata[stat_anrufer_datum],
	'L_TIME' => $textdata[stat_anrufer_uhrzeit],
	'L_CALL_NUMBER' => $textdata[stat_anrufer_rufnummer],
	'L_CALL_TO_MSN' => $textdata[stat_anrufer_MSN]));
$i=0;

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT id,datum,uhrzeit,msn,rufnummer FROM angerufene WHERE rufnummer='$data_adressbuch[tele1]' OR rufnummer='$data_adressbuch[tele2]' OR rufnummer='$data_adressbuch[tele3]' OR rufnummer='$data_adressbuch[handy]' ORDER BY id DESC");
$zugriff_mysql->close_mysql();
 while ($data_angerufene=mysql_fetch_array($result))
  {
  if($i%2==0)
   { $color=$row_color_1; }
    else
    { $color=$row_color_2; }

   $template->assign_block_vars('tab4', array(
   	'DATA_COLOR' => $color,
	'DATA_DATE' => mysql_datum($data_angerufene[datum]),
	'DATA_TIME' => $data_angerufene[uhrzeit],
	'DATA_NUMBER' => $data_angerufene[rufnummer],
	'DATA_CALL_TO_MSN' => $data_angerufene[msn]));
   $i++;
  }
 

 } // gar kein anruf da ist:
else
 {
  $template->assign_block_vars('no_call_from_user',array(
  	'L_MSG_NO_CALL' => $textdata[stat_anrufer_keine_anrufe_gefunden]." ".$data_adressbuch[vorname]." ".$data_adressbuch[nachname]." ".$textdata[stat_anrufer_keine_anrufe_gefunden_ende]));
 }


$template->pparse('overall_body');
include("./footer.inc.php");
?>
