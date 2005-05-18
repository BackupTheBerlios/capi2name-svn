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
  $result=$zugriff_mysql->sql_abfrage("DELETE FROM addressbook WHERE id='$_POST[loeschenID]'");
  $result=$zugriff_mysql->sql_abfrage("DELETE FROM phonenumbers WHERE addr_id='$_POST[loeschenID]'");
  $zugriff_mysql->close_mysql();
  $template->assign_block_vars('delete_entry_from_db', array(
  	'L_ADDRESS_BOOK_ENTRY_REMOVED' => $textdata[editadress_eintrag_geloescht]));
  $template->pparse('overall_body');
  include("./footer.inc.php");
  exit;
 }

//telephonenumber update BEGIN:
if (isset($_POST[tele_save]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (cellphone_number($_POST[telephonnr]))
   {
    $typ='2';
   }
  else
   {
      $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
      $prefix=0;
       while($vorwahl_row=mysql_fetch_assoc($tab_vorwahl))
        {
          $laenge=strlen($vorwahl_row[vorwahlnr]);
          $vorwahl_nr=substr($_POST[telephonnr],0,$laenge);
          if($vorwahl_row[vorwahlnr]==$vorwahl_nr)
	   { 
	    $typ=$vorwahl_row[id];
	    break;
	   }
      }//while vorwahl END
   }
  $zugriff_mysql->sql_abfrage("UPDATE phonenumbers SET number='$_POST[telephonnr]' WHERE id='$_POST[tele_id]'");
  $zugriff_mysql->sql_abfrage("UPDATE phonenumbers SET areacode='$typ' WHERE id='$_POST[tele_id]'");
  $zugriff_mysql->close_mysql();
 }
//telephonenumber update END
//telephonenumber delete BEGIN:
if (isset($_POST[tele_delete]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $zugriff_mysql->sql_abfrage("DELETE FROM phonenumbers WHERE id='$_POST[tele_id]'");
  $zugriff_mysql->close_mysql();
 }
//telephonenumber delete END

//telephonnumber add BEGIN:
if (isset($_POST[add]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (cellphone_number($_POST[telephonnr]))
   {
    $typ='2';
   }
  else
   {
      $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
      $prefix=0;
       while($vorwahl_row=mysql_fetch_assoc($tab_vorwahl))
        {
          $laenge=strlen($vorwahl_row[vorwahlnr]);
          $vorwahl_nr=substr($_POST[telephonnr],0,$laenge);
          if($vorwahl_row[vorwahlnr]==$vorwahl_nr)
	   { 
	    $typ=$vorwahl_row[id];
	    break;
	   }
      }//while vorwahl END
   }
  $result=$zugriff_mysql->sql_abfrage("INSERT INTO phonenumbers VALUES(
  		'', '$_POST[id]', '$_POST[telephonnr]', '$_POST[typ]', '$typ')");
  $zugriff_mysql->close_mysql();
 }
//telephonnumber add END
 
 
if (isset($_POST[loeschen]) or $_GET[loeschen]==1)
 {
 $template->assign_block_vars('check_if_delete_entry', array(
 	'L_check_if_you_will_delete' => $textdata[editadress_wirklich_loeschen]));
 }

// Eintrag loeschen und neu mit gleicher ID reinschreiben.
if (isset($_POST[aendern]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $result=$zugriff_mysql->sql_abfrage("DELETE FROM addressbook WHERE id='$_POST[id]'");
  $result=$zugriff_mysql->sql_abfrage("INSERT INTO addressbook VALUES(
  	'$_POST[id]', '$_POST[bvorname]', '$_POST[bnachname]',
	'$_POST[bstrasse]', '$_POST[bhausnr]',
	'$_POST[bplz]', '$_POST[bort]', '$_POST[bemail]')");
  $zugriff_mysql->close_mysql();
  
 }


//===============================// auslesen, baerbeiten = muss gesetzt sein.
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (isset($_POST[id]))
 {
  $eintrag=$_POST[id];
 }
 else
 {
  $eintrag=$_GET[bearbeiten];
 }
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM addressbook WHERE id='$eintrag'");
$daten=mysql_fetch_assoc($result);
if (!$daten)
 {
  $template->assign_block_vars('entry_not_found', array(
  	'SHOW_ENTRY_NOT_FOUND' => $textdata[editadress_eintrag_mit_nicht_gefunden]));
  $template->pparse('overall_body');
  $zugriff_mysql->close_mysql();	
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
	'CHANGE_ADDR' => $textdata[editadress_eintrag_aendern]));

//telephon:
$result_tele=$zugriff_mysql->sql_abfrage("SELECT id,number FROM phonenumbers WHERE typ='1' AND addr_id='$daten[id]'");
while($daten_tele=mysql_fetch_assoc($result_tele))
 {
  $template->assign_block_vars('tab1.telephon',array(
	'L_TELE' => $textdata[addadress_telefonnummer],
	'L_DB_TELE' => $daten_tele[number],
	'L_DB_TELE_ID' => $daten_tele[id],
	'L_DB_ID' => $daten[id]));
 }
//cell phone:
$result_cellphone=$zugriff_mysql->sql_abfrage("SELECT id,number FROM phonenumbers WHERE typ='2' AND addr_id='$daten[id]'");
while($daten_cellphone=mysql_fetch_assoc($result_cellphone))
 {
  $template->assign_block_vars('tab1.cellphone',array(
	'L_CELL_PHONE' => $textdata[addadress_handy],
	'L_DB_TELE' => $daten_cellphone[number],
	'L_DB_TELE_ID' => $daten_cellphone[id],
	'L_DB_ID' => $daten[id]));
 }
//fax number:
$result_fax=$zugriff_mysql->sql_abfrage("SELECT id,number FROM phonenumbers WHERE typ='3' AND addr_id='$daten[id]'");
while($daten_fax=mysql_fetch_assoc($result_fax))
 {
  $template->assign_block_vars('tab1.fax',array(
	'L_FAX' => $textdata[addadress_fax],
	'L_DB_TELE' => $daten_fax[number],
	'L_DB_TELE_ID' => $daten_fax[id],
	'L_DB_ID' => $daten[id]));
 }
 
//add number dialog:
$template->assign_block_vars('tab1.add',array(
	'ID' => $daten[id])); 
 
	
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


$zugriff_mysql->close_mysql();
$template->pparse('overall_body');
include("./footer.inc.php");
?>
