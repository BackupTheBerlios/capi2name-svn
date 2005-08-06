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
$seite=base64_encode("addressbook.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/addressbook.tpl'));
$template->assign_vars(array('L_ADDRESS_BOOK' => $textdata['header_inc_adressbuch']));

$template->assign_vars(array('L_ADDR_SORT_LAST_NAME' => $textdata['adressbuch_sortiere_nachname']));
$template->assign_vars(array('L_ADDR_LAST_NAME' => $textdata['addadress_nachname']));
$template->assign_vars(array('L_ADDR_SORT_FIRST_NAME' => $textdata['adressbuch_sortiere_vorname']));
$template->assign_vars(array('L_ADDR_FIRST_NAME' => $textdata['addadress_vorname']));
$template->assign_vars(array('L_ADDR_TELEPHON_NUMBER' => $textdata['adressbuch_telefonNR']));
$template->assign_vars(array('L_ADDR_CELL_PHONE' => $textdata['addadress_handy']));


// Auslesen:
if (isset($_GET['order']) && $_GET['order']=="firstname")
{
	$sqlabfrage="SELECT id,name_first,name_last FROM addressbook ORDER BY name_first";
}
else
{
	$sqlabfrage="SELECT id,name_first,name_last FROM addressbook ORDER BY name_last";
}
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$result=$dataB->sql_query($sqlabfrage);
$i=0;
while($data_addr=$dataB->sql_fetch_assoc($result))
{
	if($i%2==0)
	{
		$color=$row_color_1;
		$i=1; 
	}
	else
	{
		$color=$row_color_2;
		$i=0; 
	}
	$result_tele=$dataB->sql_query("SELECT number FROM phonenumbers WHERE  typ='1' AND addr_id='$data_addr[id]' LIMIT 1");
	$data_tele=$dataB->sql_fetch_assoc($result_tele);
	$result_cellphone=$dataB->sql_query("SELECT number FROM phonenumbers WHERE  typ='2' AND addr_id='$data_addr[id]' LIMIT 1");
	$data_cellphone=$dataB->sql_fetch_assoc($result_cellphone);
	
	if (isset($_GET['id']) && $_GET['id']==$data_addr['id'])
	{
		$color=$hightlight_color;
		$data_tele['number']='<a name="find">'.$data_tele['number'].'</a>';
	}
	
	$template->assign_block_vars('tab', array(
				'color' => $color,
				'addr_id' => $data_addr['id'],
				'addr_last_name' => $data_addr['name_last'],
				'addr_first_name' => $data_addr['name_first'],
				'addr_tele_1' => $data_tele['number'],
				'addr_cell_phone' => $data_cellphone['number'],
				'addr_edit_entry' => $textdata['adressbuch_eintrag_bearbeiten'],
				'addr_delete_entry' => $textdata['adressbuch_eintrag_loeschen'],
				'addr_search_entry' => $textdata['adressbuch_suche_eintraege']
				));
}
// Auslesen ENde
$dataB->sql_close();
$template->pparse('overall_body');
include("./footer.inc.php");
?>