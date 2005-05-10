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
$seite=base64_encode("addressbook_add.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/'.$userconfig['template'].'/addressbook_add.tpl'));
$template->assign_vars(array('L_NEW_ENTRY_TO_ADDR' => $textdata[addadress_neuer_adressbuch_eintrag]));
?>


<?
// Eintrag eintragen.
if (isset($_POST[eintragen]))
 {
   if (empty($_POST[bvorname]) and empty($_POST[bnachname]))
     {
      $template->assign_block_vars('show_error_msg_name_not_set', array());
      $template->assign_vars(array('L_ADD_MSG_NAME_NOT_SET' => $textdata[adddress_nicht_eingetragen]));
      $template->assign_vars(array('L_BACK' => $textdata[adddress_zurueck]));
     $template->pparse('overall_body');
     include("footer.inc.php");
     exit();
     }

 if ($_POST[bhandy] =="")  { $bhandy="99"; } else { $bhandy=$_POST[bhandy]; }
 if ($_POST[btele1] =="")  { $btele1="99"; }   else { $btele1=$_POST[btele1]; }
 if ($_POST[btele2] =="")  { $btele2="99"; }  else { $btele2=$_POST[btele2]; }
 if ($_POST[btele3] =="")  { $btele3="99"; }   else { $btele3=$_POST[btele3]; }     
 
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$res_value=$zugriff_mysql->sql_abfrage("INSERT INTO adressbuch 
					VALUES(NULL,'$_POST[bvorname]',
					'$_POST[bnachname]', '$_POST[bstrasse]', '$_POST[bhausnr]', '$_POST[bplz]', '$_POST[bort]', '$btele1', '$btele2', '$btele3',  '$bhandy', '$_POST[bfax]', '$_POST[bemail]')");

$zugriff_mysql->close_mysql();

if($res_value)
 {
  $template->assign_block_vars('show_success_msg_forward_msg', array());
  $template->assign_vars(array('L_MSG_SUCCESS_FORWARD' => $textdata[addadress_eintrag_aufgenommen_weiterleitung]));

 }
else
 {
  $template->assign_block_vars('show_error_msg_add_entry', array());
  $template->assign_vars(array('L_MSG_ERROR_ADD_ENTRY' => 'Eintrag nicht aufgenommen - Fehler'));
  echo "";
 }


 }//ende if


$template->assign_block_vars('tab',array(
		'L_ADDR_FRIST_NAME' => $textdata[addadress_vorname],
		'L_ADDR_LAST_NAME' => $textdata[addadress_nachname],
		'L_ADDR_STREET' => $textdata[addadress_strasse],
		'L_ADDR_HOUSE_NR' => $textdata[addadress_hausnummer],
		'L_ADDR_ZIP_CODE' => $textdata[addadress_plz],
		'L_ADDR_CITY' => $textdata[addadress_ort],
		'L_ADDR_TELE_1' => $textdata[addadress_telefonnummer1],
		'L_ADDR_TELE_2' => $textdata[addadress_telefonnummer2],
		'L_ADDR_TELE_3' => $textdata[addadress_telefonnummer3],
		'L_ADDR_CELL_PHONE' => $textdata[addadress_handy],
		'L_ADDR_FAX' => $textdata[addadress_fax],
		'L_ADDR_E_MAIL' => $textdata[addadress_email],
		'L_ADDR_ADD_NEW_ENTRY' => $textdata[addadress_eintrag_aufnehmen],
		'L_GET_RUFNR' => $_GET[rufnr],
		'L_GET_HANDYNR' => $_GET[handy]));
 


$template->pparse('overall_body');
include("./footer.inc.php");
?>
