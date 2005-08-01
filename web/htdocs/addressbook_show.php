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
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("addressbook_show.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/addressbook_show.tpl'));
$template->assign_vars(array('L_ADDRESS_BOOK_VIEW_ENTRY' => $textdata[showaddress_deteilansicht]));

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$s_id=$dataB->sql_checkn($_GET[show]);
$result=$dataB->sql_query("SELECT * FROM addressbook WHERE id=$s_id");
$data_addr=$dataB->sql_fetch_assoc($result);
if (!$data_addr)
 {
  $template->assign_block_vars('show_msg_entry_not_found', array());
  $template->assign_vars(array('L_MSG_ENTRY_NOT_FOUND'=> $textdata[showaddress_eintrag_nicht] . $_GET[show]." ".$textdata[showaddress_admin_wenden]));
  $template->pparse('overall_body');
  $dataB->sql_close();
  include("./footer.inc.php");
  die();  
 }


$template->assign_block_vars('tab1',array(
		'L_FIRST_NAME' => $textdata[addadress_vorname],
		'L_LAST_NAME' => $textdata[addadress_nachname],
		'L_STREET' => $textdata[addadress_strasse],
		'L_HOUSE_NUMBER' => $textdata[addadress_hausnummer],
		'L_ZIP_CODE' => $textdata[addadress_plz],
		'L_CITY' => $textdata[addadress_ort],
		'L_E_MAIL' => $textdata[addadress_email],
		'L_EDIT_THIS_ENTRY' => $textdata[adressbuch_eintrag_bearbeiten],
		'L_DB_ID_ENTRY' => $data_addr[id],
		'L_DB_FIRST_NAME' => $data_addr[name_first],
		'L_DB_LAST_NAME' => $data_addr[name_last],
		'L_DB_STREET' => $data_addr[street],
		'L_DB_HOUSE_NUMBER' => $data_addr[housenr],
		'L_DB_ZIP_CODE' => $data_addr[zipcode],
		'L_DB_CITY' => $data_addr[city],
		'L_DB_E_MAIL' => $data_addr[email]));


// telephon:
$result_tele=$dataB->sql_query("SELECT number FROM phonenumbers WHERE typ='1' AND addr_id='$data_addr[id]'");
while($daten_tele=$dataB->sql_fetch_assoc($result_tele))
 {
  $template->assign_block_vars('tab1.telephon',array(
  	'L_TELE' => $textdata[addadress_telefonnummer],
	'L_DB_TELE' => $daten_tele[number]));
 }
//cell phone
$result_cell=$dataB->sql_query("SELECT number FROM phonenumbers WHERE typ='2' AND addr_id='$data_addr[id]'");
while($daten_cell=$dataB->sql_fetch_assoc($result_cell))
 {
  $template->assign_block_vars('tab1.cellphone',array(
  	'L_CELL_PHONE' => $textdata[addadress_handy],
	'L_DB_CELL_PHONE' => $daten_cell[number]));
 }
//fax numbers
$result_fax=$dataB->sql_query("SELECT number FROM phonenumbers WHERE typ='3' AND addr_id='$data_addr[id]'");
while($daten_fax=$dataB->sql_fetch_assoc($result_fax))
 {
  $template->assign_block_vars('tab1.fax',array(
  	'L_FAX' => $textdata[addadress_fax],
	'L_DB_FAX' => $daten_fax[number]));
 }
  
$dataB->sql_close();
$template->pparse('overall_body');
include("./footer.inc.php");
?>
