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
$seite=base64_encode("showaddress.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_show_address' => 'templates/blueingrey/show_address.tpl'));
$template->assign_vars(array('L_ADDRESS_BOOK_VIEW_ENTRY' => $textdata[showaddress_deteilansicht]));

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM adressbuch WHERE id='$_GET[show]'");
$data_addr=mysql_fetch_array($result);
$zugriff_mysql->close_mysql();

if ($data_addr==false)
 {
  $template->assign_block_vars('show_msg_entry_not_found', array());
  $template->assign_vars(array('L_MSG_ENTRY_NOT_FOUND'=> $textdata[showaddress_eintrag_nicht] . $_GET[show] . $textdata[showaddress_admin_wenden]));
  include("footer.inc.php");
  die();  
 }

if ($data_addr[tele1] == "99") { $data_addr[tele1]="";}
if ($data_addr[tele2] == "99") { $data_addr[tele2]="";}
if ($data_addr[tele3] == "99") { $data_addr[tele3]="";}
if ($data_addr[handy] == "99") { $data_addr[handy]="";}

$template->assign_vars(array('L_FIRST_NAME' => $textdata[addadress_vorname]));
$template->assign_vars(array('L_LAST_NAME' => $textdata[addadress_nachname]));
$template->assign_vars(array('L_STREET' => $textdata[addadress_strasse]));
$template->assign_vars(array('L_HOUSE_NUMBER' => $textdata[addadress_hausnummer]));
$template->assign_vars(array('L_ZIP_CODE' => $textdata[addadress_plz]));
$template->assign_vars(array('L_CITY' => $textdata[addadress_ort]));
$template->assign_vars(array('L_TELE_1' => $textdata[addadress_telefonnummer1]));
$template->assign_vars(array('L_TELE_2' => $textdata[addadress_telefonnummer2]));
$template->assign_vars(array('L_TELE_3' => $textdata[addadress_telefonnummer3]));
$template->assign_vars(array('L_CELL_PHONE' => $textdata[addadress_handy]));
$template->assign_vars(array('L_FAX' => $textdata[addadress_fax]));
$template->assign_vars(array('L_E_MAIL' => $textdata[addadress_email]));
$template->assign_vars(array('L_EDIT_THIS_ENTRY' => $textdata[adressbuch_eintrag_bearbeiten]));

//Fill form the Database:
$template->assign_vars(array('L_DB_ID_ENTRY' => $data_addr[id]));
$template->assign_vars(array('L_DB_FIRST_NAME' => $data_addr[vorname])); 
$template->assign_vars(array('L_DB_LAST_NAME' => $data_addr[nachname]));
$template->assign_vars(array('L_DB_STREET' => $data_addr[strasse]));
$template->assign_vars(array('L_DB_HOUSE_NUMBER' => $data_addr[hausnr]));
$template->assign_vars(array('L_DB_ZIP_CODE' => $data_addr[plz]));
$template->assign_vars(array('L_DB_CITY' => $data_addr[ort] ));
$template->assign_vars(array('L_DB_TELE_1' => $data_addr[tele1]));
$template->assign_vars(array('L_DB_TELE_2' => $data_addr[tele2]));
$template->assign_vars(array('L_DB_TELE_3' => $data_addr[tele3]));
$template->assign_vars(array('L_DB_CELL_PHONE' => $data_addr[handy]));
$template->assign_vars(array('L_DB_FAX' => $data_addr[fax]));
$template->assign_vars(array('L_DB_E_MAIL' => $data_addr[email]));




$template->pparse('overall_show_address');

include("./footer.inc.php");
?>
