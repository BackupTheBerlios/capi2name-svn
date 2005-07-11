<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonasge@gmx.net
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                			   *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("addressbook_edit.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/addressbook_edit.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[editadress_adressbucheintrag_editieren]));


// Eintrag loeschen:
if (isset($_POST[wloeschen]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $id=$dataB->sql_checkn($_POST[loeschenID]);
  $result=$dataB->sql_query("DELETE FROM addressbook WHERE id=$id");
  $result=$dataB->sql_query("DELETE FROM phonenumbers WHERE addr_id=$id");
  $dataB->sql_close();
  $template->assign_block_vars('delete_entry_from_db', array(
  	'L_ADDRESS_BOOK_ENTRY_REMOVED' => $textdata[editadress_eintrag_geloescht]));
  $template->pparse('overall_body');
  include("./footer.inc.php");
  exit;
 }

//telephonenumber update BEGIN:
if (isset($_POST[tele_save]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (cellphone_number($_POST[telephonnr]))
   {
    $typ='2';
   }
  else
   {
    $typ=get_id_from_prefix($_POST[telephonnr]);
   }
  if (is_numeric($_POST[tele_id]))
   {
    $query=sprintf("UPDATE phonenumbers SET number=%s WHERE id=%s",
  	$dataB->sql_check($_POST[telephonnr]),
	$dataB->sql_check($_POST[tele_id]));
    $dataB->sql_query($query);
    $query=sprintf("UPDATE phonenumbers SET areacode='$typ' WHERE id=%s",
  	$dataB->sql_check($_POST[tele_id]));
    $dataB->sql_query($query);
   }
  $dataB->sql_close();
 }
//telephonenumber update END
//telephonenumber delete BEGIN:
if (isset($_POST[tele_delete]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (is_numeric($_POST[tele_id]))
   {
    $query=sprintf("DELETE FROM phonenumbers WHERE id=%s", $dataB->sql_check($_POST[tele_id]));
    $dataB->sql_query($query);
   }
  $dataB->sql_close();
 }
//telephonenumber delete END

//telephonnumber add BEGIN:
if (isset($_POST[add]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (cellphone_number($_POST[telephonnr]))
   {
    $typ='2';
   }
  else
   {
    $typ=get_id_from_prefix($_POST[telephonnr]);
   }
  if (is_numeric($_POST[id]))
   {
    $query=sprintf("INSERT INTO phonenumbers VALUES(NULL,%s,%s,%s,'$typ')",
    	$dataB->sql_check($_POST[id]),
	$dataB->sql_check($_POST[telephonnr]),
	$dataB->sql_check($_POST[typ]));
    $result=$dataB->sql_query($query);
   }
  $dataB->sql_close();
 }
//telephonnumber add END
 
 
if (isset($_POST[del]) or $_GET[del])
 {
 $template->assign_block_vars('check_if_delete_entry', array(
 	'L_check_if_you_will_delete' => $textdata[editadress_wirklich_loeschen]));
 }

// Eintrag loeschen und neu mit gleicher ID reinschreiben.
if (isset($_POST[aendern]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (is_numeric($_POST[id]))
   {
    $query=sprintf("DELETE FROM addressbook WHERE id=%s", $dataB->sql_check($_POST[id]));
    $result=$dataB->sql_query($query);
    $query=sprintf("INSERT INTO addressbook VALUES(%s,%s,%s,%s,%s,%s,%s,%s)",
	$dataB->sql_check($_POST[id]),
	$dataB->sql_check($_POST[bvorname]),
	$dataB->sql_check($_POST[bnachname]),
	$dataB->sql_check($_POST[bstrasse]),
	$dataB->sql_check($_POST[bhausnr]),
	$dataB->sql_check($_POST[bplz]),
	$dataB->sql_check($_POST[bort]),
	$dataB->sql_check($_POST[bemail]));
    $result=$dataB->sql_query($query);
   }
  $dataB->sql_close();
  
 }


//===============================// auslesen, baerbeiten = muss gesetzt sein.
$id=(isset($_POST[id]) ? $_POST[id] : $_GET[edit]);
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );

if (is_numeric($id))
 {
  $id=$dataB->sql_check($id);
  $result=$dataB->sql_query("SELECT * FROM addressbook WHERE id=$id");
  $daten=$dataB->sql_fetch_assoc($result);
 }
 
if (!$daten)
 {
  $template->assign_block_vars('entry_not_found', array(
  	'SHOW_ENTRY_NOT_FOUND' => $textdata[editadress_eintrag_mit_nicht_gefunden]));
  $template->pparse('overall_body');
  $dataB->sql_close();	
  include("footer.inc.php");
  exit();
 }

$template->assign_block_vars('tab1', array(
	'L_FIRST_NAME' => $textdata[addadress_vorname],
	'DATA_FIRST_NAME' => $daten[name_first],
	'DATA_ID_USER' => $daten[id],
	'L_LAST_NAME' => $textdata[addadress_nachname],
	'DATA_LAST_NAME' => $daten[name_last],
	'L_STREET_NAME' => $textdata[addadress_strasse],
	'DATA_STREET_NAME' => $daten[street],
	'L_HOUSE_NUMBER' => $textdata[addadress_hausnummer],
	'DATA_HOUSE_NUMBER' => $daten[housenr],
	'L_ZIP_CODE' => $textdata[addadress_plz],
	'DATA_ZIP_CODE' => $daten[zipcode],
	'L_CITY' => $textdata[addadress_ort],
	'DATA_CITY' => $daten[city],
	'L_E_MAIL' => $textdata[addadress_email],
	'DATA_E_MAIL' => $daten[email],
	'CHANGE_ADDR' => $textdata[editadress_eintrag_aendern],
	'L_ADD_NUMBER' => $textdata[adddress_add_number]));

//telephon:
$result_tele=$dataB->sql_query("SELECT id,number FROM phonenumbers WHERE typ='1' AND addr_id='$daten[id]'");
while($daten_tele=$dataB->sql_fetch_assoc($result_tele))
 {
  $template->assign_block_vars('tab1.telephon',array(
	'L_TELE' => $textdata[addadress_telefonnummer],
	'L_DB_TELE' => $daten_tele[number],
	'L_DB_TELE_ID' => $daten_tele[id],
	'L_DB_ID' => $daten[id],
	'L_SAVE' => $textdata[save],
	'L_DELETE' => $textdata[delet]));
 }
//cell phone:
$result_cellphone=$dataB->sql_query("SELECT id,number FROM phonenumbers WHERE typ='2' AND addr_id='$daten[id]'");
while($daten_cellphone=$dataB->sql_fetch_assoc($result_cellphone))
 {
  $template->assign_block_vars('tab1.cellphone',array(
	'L_CELL_PHONE' => $textdata[addadress_handy],
	'L_DB_TELE' => $daten_cellphone[number],
	'L_DB_TELE_ID' => $daten_cellphone[id],
	'L_DB_ID' => $daten[id],
	'L_SAVE' => $textdata[save],
	'L_DELETE' => $textdata[delet]));
 }
//fax number:
$result_fax=$dataB->sql_query("SELECT id,number FROM phonenumbers WHERE typ='3' AND addr_id='$daten[id]'");
while($daten_fax=$dataB->sql_fetch_assoc($result_fax))
 {
  $template->assign_block_vars('tab1.fax',array(
	'L_FAX' => $textdata[addadress_fax],
	'L_DB_TELE' => $daten_fax[number],
	'L_DB_TELE_ID' => $daten_fax[id],
	'L_DB_ID' => $daten[id],
	'L_SAVE' => $textdata[save],
	'L_DELETE' => $textdata[delet]));
 }
 
//add number dialog:
$template->assign_block_vars('tab1.add',array(
	'ID' => $daten[id],
	'L_ADD' => $textdata[add],
	'L_CELL_PHONE' => $textdata[cell_phone],
	'L_TELE' => $textdata[telephon],
	'L_FAX' => $textdata[fax])); 
 
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
		'id' => $daten[id],
		'DELETE_ENTRY' => $textdata[adressbuch_eintrag_loeschen]));
 }  

$dataB->sql_close();
$template->pparse('overall_body');
include("./footer.inc.php");
?>
