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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("addressbook_add.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/'.$userconfig['template'].'/addressbook_add.tpl'));
$template->assign_vars(array('L_NEW_ENTRY_TO_ADDR' => $textdata[addadress_neuer_adressbuch_eintrag]));

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

  
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$query=sprintf("INSERT INTO addressbook VALUES(NULL,%s,%s,%s,%s,%s,%s,%s)",
	$dataB->sql_check($_POST[bvorname]),
	$dataB->sql_check($_POST[bnachname]),
	$dataB->sql_check($_POST[bstrasse]),
	$dataB->sql_check($_POST[bhausnr]),
	$dataB->sql_check($_POST[bplz]),
	$dataB->sql_check($_POST[bort]),
	$dataB->sql_check($_POST[bemail]));
$result=$dataB->sql_query($query);
if (!$result)
 {
  echo "errrorr";
 }
$last_id=$dataB->sql_return_last_id($result);
//echo "### $last_id ----";
//die();
if ($_POST[btele]!="")
 {
   if (cellphone_number($_POST[btele]))
   {
    $typ='2';
   }
  else
   {
    $typ=get_id_from_prefix($_POST[btele]);
   }
  $query=sprintf("INSERT INTO phonenumbers VALUES(NULL,'$last_id',%s,'1','$typ')", $dataB->sql_check($_POST[btele]));
  $result=$dataB->sql_query($query);
 }
if ($_POST[bhandy]!="")
 {
   if (cellphone_number($_POST[bhandy]))
   {
    $typ='2';
   }
  else
   {
    $typ=get_id_from_prefix($_POST[bhandy]);
   }
  $query=sprintf("INSERT INTO phonenumbers VALUES(NULL,'$last_id',%s,'2','$typ')",$dataB->sql_check($_POST[bhandy]));
  $result=$dataB->sql_query($query);
 }
if ($_POST[bfax]!="")
 {
   if (cellphone_number($_POST[bfax]))
   {
    $typ='2';
   }
  else
   {
    $typ=get_id_from_prefix($_POST[bfax]);
   }
  $query=sprintf("INSERT INTO phonenumbers VALUES(NULL,'$last_id',%s,'3','$typ')",$dataB->sql_check($_POST[bfax]));
  $result=$dataB->sql_query($query);
 }
$dataB->sql_close();

if($result)
 {
  $template->assign_block_vars('show_success_msg_forward_msg', array(
  		'FORWARD_ID' => "?id=$last_id#find",
		'L_MSG_SUCCESS_FORWARD' =>$textdata[addadress_eintrag_aufgenommen_weiterleitung] ));


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
		'L_ADDR_TELE' => $textdata[addadress_telefonnummer],
		'L_ADDR_CELL_PHONE' => $textdata[addadress_handy],
		'L_ADDR_FAX' => $textdata[addadress_fax],
		'L_ADDR_E_MAIL' => $textdata[addadress_email],
		'L_ADDR_ADD_NEW_ENTRY' => $textdata[addadress_eintrag_aufnehmen],
		'L_GET_RUFNR' => $_GET[rufnr],
		'L_GET_HANDYNR' => $_GET[handy]));
 


$template->pparse('overall_body');
include("./footer.inc.php");
?>
