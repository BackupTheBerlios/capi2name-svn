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

$seite=base64_encode("addressbook.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/blueingrey/addressbook.tpl'));
$template->assign_vars(array('L_ADDRESS_BOOK' => $textdata[header_inc_adressbuch]));

$template->assign_vars(array('L_ADDR_SORT_LAST_NAME' => $textdata[adressbuch_sortiere_nachname]));
$template->assign_vars(array('L_ADDR_LAST_NAME' => $textdata[addadress_nachname]));
$template->assign_vars(array('L_ADDR_SORT_FIRST_NAME' => $textdata[adressbuch_sortiere_vorname]));
$template->assign_vars(array('L_ADDR_FIRST_NAME' => $textdata[addadress_vorname]));
$template->assign_vars(array('L_ADDR_TELEPHON_NUMBER' => $textdata[adressbuch_telefonNR]));
$template->assign_vars(array('L_ADDR_CELL_PHONE' => $textdata[addadress_handy] ));




$i=0;
// Auslesen:
if ($_GET[order]=="vorname")
 {
  $sqlabfrage="SELECT id,vorname,nachname,tele1,handy FROM adressbuch ORDER BY vorname";
 }
else
 {
  $sqlabfrage="SELECT id,vorname,nachname,tele1,handy FROM adressbuch ORDER BY nachname";
 }
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$result=$zugriff_mysql->sql_abfrage($sqlabfrage);
$zugriff_mysql->close_mysql();
while($data_addr=mysql_fetch_assoc($result))
 {
   if($i%2==0)
   { $color=$row_color_1;
     $i=1; }
  else
   { $color=$row_color_2;
     $i=0; }
  if ($data_addr[handy]== 99) { $data_addr[handy]=""; }
  if ($data_addr[tele1]== 99) { $data_addr[tele1]=""; }
  if (isset($_GET[id]) )
   {
    if($_GET[id]==$data_addr[id] )
     {
      $color="yellow";
      $data_addr[tele1]="<a name=\"find\">$data_addr[tele1]</a>";
     }
   }
   
$template->assign_block_vars('tab', array(
				'color' => $color,
				'addr_id' => $data_addr[id],
				'addr_last_name' => $data_addr[nachname],
				'addr_first_name' => $data_addr[vorname],
				'addr_tele_1' => $data_addr[tele1],
				'addr_cell_phone' => $data_addr[handy],
				'addr_edit_entry' => $textdata[adressbuch_eintrag_bearbeiten],
				'addr_delete_entry' => $textdata[adressbuch_eintrag_loeschen],
				'addr_search_entry' => $textdata[adressbuch_suche_eintraege]
  				));

 }
// Auslesen ENde
$template->pparse('overall_body');
include("./footer.inc.php");
?>
