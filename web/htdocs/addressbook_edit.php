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
$seite=base64_encode("addressbook_edit.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/addressbook_edit.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[editadress_adressbucheintrag_editieren]));


// Eintrag loeschen:
if (isset($_POST[wloeschen]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $result=$zugriff_mysql->sql_abfrage("DELETE FROM adressbuch WHERE id = $_POST[loeschenID]");
  $zugriff_mysql->close_mysql();
  $template->assign_block_vars('delete_entry_from_db', array(
  	'L_ADDRESS_BOOK_ENTRY_REMOVED' => $textdata[editadress_eintrag_geloescht]));
  $template->pparse('overall_body');
  include("./footer.inc.php");
  exit;
 }

if (isset($_POST[loeschen]) or $_GET[loeschen]==1)
 {
 $template->assign_block_vars('check_if_delete_entry', array(
 	'L_check_if_you_will_delete' => $textdata[editadress_wirklich_loeschen]));
 }

// Eintrag loeschen und neu mit gleicher ID reinschreiben.
if (isset($_POST[aendern]))
 {
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("DELETE FROM adressbuch WHERE id = $_POST[bid]");
 //eintragen:
 $bhandy=$_POST[bhandy];
 $btele1=$_POST[btele1];
 $btele2=$_POST[btele2];
 $btele3=$_POST[btele3];
 if ($bhandy =="")  { $bhandy="99"; }
 if ($btele1 =="")  { $btele1="99"; }
 if ($btele2 =="")  { $btele2="99"; }
 if ($btele3 =="")  { $btele3="99"; }
 $res=$zugriff_mysql->sql_abfrage("INSERT INTO adressbuch VALUES('$_POST[bid]','$_POST[bvorname]','$_POST[bnachname]', '$_POST[bstrasse]', '$_POST[bhausnr]', '$_POST[bplz]', '$_POST[bort]', '$btele1', '$btele2', '$btele3', '$bhandy', '$_POST[bfax]',  '$_POST[bemail]')");
 $zugriff_mysql->close_mysql();
 $template->assign_block_vars('edit_addr',array(
 		'L_MSG_EDIT_OK' => $textdata[editadress_eintrag_veraendert],
		'LINK_NAME' => "?id=$_POST[bid]#find"));

 }


//=======================================================================================// auslesen, baerbeiten = muss gesetzt sein.
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (isset($_POST[id]))
 {
  $eintrag=$_POST[id];
 }
 else
 {
  $eintrag=$_GET[bearbeiten];
 }
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM adressbuch WHERE id='$eintrag'");
$zugriff_mysql->close_mysql();
$daten=mysql_fetch_assoc($result);
if (!$daten)
 {
  $template->assign_block_vars('entry_not_found', array(
  	'SHOW_ENTRY_NOT_FOUND' => $textdata[editadress_eintrag_mit_nicht_gefunden]));
  include("footer.inc.php");
  exit();
 }
if ($daten[tele1]=="99") { $daten[tele1]=""; }
if ($daten[tele2]=="99") { $daten[tele2]=""; }
if ($daten[tele3]=="99") { $daten[tele3]=""; }
if ($daten[handy]=="99") { $daten[handy]=""; }
if ($daten[fax]=="99")   { $daten[fax]=""; }
 
$template->assign_block_vars('tab1', array(
	'L_FIRST_NAME' => $textdata[addadress_vorname],
	'DATA_FIRST_NAME' => $daten[vorname],
	'DATA_ID_USER' => $daten[id],
	'L_LAST_NAME' => $textdata[addadress_nachname],
	'DATA_LAST_NAME' => $daten[nachname],
	'L_STREET_NAME' => $textdata[addadress_strasse],
	'DATA_STREET_NAME' => $daten[strasse],
	'L_HOUSE_NUMBER' => $textdata[addadress_hausnummer],
	'DATA_HOUSE_NUMBER' => $daten[hausnr],
	'L_ZIP_CODE' => $textdata[addadress_plz],
	'DATA_ZIP_CODE' => $daten[plz],
	'L_CITY' => $textdata[addadress_ort],
	'DATA_CITY' => $daten[ort],
	'L_TELE_1' => $textdata[addadress_telefonnummer1],
	'L_TELE_2' => $textdata[addadress_telefonnummer2],
	'L_TELE_3' => $textdata[addadress_telefonnummer3],
	'DATA_TELE_1' => $daten[tele1],
	'DATA_TELE_2' => $daten[tele2],
	'DATA_TELE_3' => $daten[tele3],
	'L_CELL_PHONE' => $textdata[addadress_handy],
	'DATA_CELL_PHONE' => $daten[handy],
	'L_FAX' => $textdata[addadress_fax],
	'DATA_FAX' => $daten[fax],
	'L_E_MAIL' => $textdata[addadress_email],
	'DATA_E_MAIL' => $daten[email],
	'CHANGE_ADDR' => $textdata[editadress_eintrag_aendern]));
 
$template->assign_block_vars('cancel_edit',array(
			'CANCEL_EDIT_ADDR' => $textdata[editadress_abbrechen]));

if (isset($_POST[loeschen_OK]) or $_GET[loeschen]==1)
 {
  $template->assign_block_vars('now_delete_really_entry', array(
  		'ID_FROM_ADDR' => $daten[id],
		'REMOVE_ENTRY' => $textdata[adressbuch_eintrag_loeschen]));
 }
else
 {
 $template->assign_block_vars('ask_for_delete_entry',array(
 		'ID_FROM_ADDR' => $daten[id],
		'DELETE_ENTRY' => $textdata[adressbuch_eintrag_loeschen]));
 }  



$template->pparse('overall_body');
include("./footer.inc.php");
?>
