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
 ?>
<?php
$seite=base64_encode("addressbook_show.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/addressbook_show.tpl'));
$template->assign_vars(array('L_ADDRESS_BOOK_VIEW_ENTRY' => $textdata[showaddress_deteilansicht]));

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM addressbook WHERE id='$_GET[show]'");
$data_addr=mysql_fetch_assoc($result);

if ($data_addr==false)
 {
  $template->assign_block_vars('show_msg_entry_not_found', array());
  $template->assign_vars(array('L_MSG_ENTRY_NOT_FOUND'=> $textdata[showaddress_eintrag_nicht] . $_GET[show] . $textdata[showaddress_admin_wenden]));
  $template->pparse('overall_body');
  $zugriff_mysql->close_mysql();
  include("./footer.inc.php");
  die();  
 }


$template->assign_vars(array('L_FIRST_NAME' => $textdata[addadress_vorname]));
$template->assign_vars(array('L_LAST_NAME' => $textdata[addadress_nachname]));
$template->assign_vars(array('L_STREET' => $textdata[addadress_strasse]));
$template->assign_vars(array('L_HOUSE_NUMBER' => $textdata[addadress_hausnummer]));
$template->assign_vars(array('L_ZIP_CODE' => $textdata[addadress_plz]));
$template->assign_vars(array('L_CITY' => $textdata[addadress_ort]));
$template->assign_vars(array('L_E_MAIL' => $textdata[addadress_email]));
$template->assign_vars(array('L_EDIT_THIS_ENTRY' => $textdata[adressbuch_eintrag_bearbeiten]));


//Fill form the Database:
$template->assign_vars(array('L_DB_ID_ENTRY' => $data_addr[id]));
$template->assign_vars(array('L_DB_FIRST_NAME' => $data_addr[name_first])); 
$template->assign_vars(array('L_DB_LAST_NAME' => $data_addr[name_last]));
$template->assign_vars(array('L_DB_STREET' => $data_addr[street]));
$template->assign_vars(array('L_DB_HOUSE_NUMBER' => $data_addr[housenr]));
$template->assign_vars(array('L_DB_ZIP_CODE' => $data_addr[zipcode]));
$template->assign_vars(array('L_DB_CITY' => $data_addr[city] ));
$template->assign_vars(array('L_DB_E_MAIL' => $data_addr[email]));


// telephon:
$result_tele=$zugriff_mysql->sql_abfrage("SELECT number FROM phonenumbers WHERE typ='1' AND addr_id='$data_addr[id]'");
while($daten_tele=mysql_fetch_assoc($result_tele))
 {
  $template->assign_block_vars('telephon',array(
  	'L_TELE' => $textdata[addadress_telefonnummer],
	'L_DB_TELE' => $daten_tele[number]));
 }
//cell phone
$result_cell=$zugriff_mysql->sql_abfrage("SELECT number FROM phonenumbers WHERE typ='2' AND addr_id='$data_addr[id]'");
while($daten_cell=mysql_fetch_assoc($result_cell))
 {
  $template->assign_block_vars('cellphone',array(
  	'L_CELL_PHONE' => $textdata[addadress_handy],
	'L_DB_CELL_PHONE' => $daten_cell[number]));
 }
//fax numbers
$result_fax=$zugriff_mysql->sql_abfrage("SELECT number FROM phonenumbers WHERE typ='3' AND addr_id='$data_addr[id]'");
while($daten_fax=mysql_fetch_assoc($result_fax))
 {
  $template->assign_block_vars('fax',array(
  	'L_FAX' => $textdata[addadress_fax],
	'L_DB_FAX' => $daten_fax[number]));
 }
  
 
$zugriff_mysql->close_mysql();




$template->pparse('overall_body');

include("./footer.inc.php");
?>
