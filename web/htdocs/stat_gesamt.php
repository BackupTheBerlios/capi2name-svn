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

$seite=base64_encode("stat_gesamt.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/stat_gesamt.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[stat_gesamt_stat_alle_anrufe]));
   

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_adressbuch=$zugriff_mysql->sql_abfrage("SELECT id,vorname,nachname,tele1,tele2,tele3,handy,fax FROM adressbuch");
$ges_anzahl=mysql_num_rows($result_adressbuch);
  if (!$ges_anzahl)
    {
     $template->assign_block_vars('no_entry_found',array(
     		'L_MSG_NOT_FOUND' => $textdata[stat_gesamt_keine_stat]));
     $zugriff_mysql->close_mysql();
    }
    else
     { // wenn ein eintrag besteht, sonst wird das hier nicht ausgefühert.
   $index_array=0;
   
 while($daten_addr=mysql_fetch_assoc($result_adressbuch))
  {
  $sql_abfrage="SELECT id,rufnummer,datum FROM angerufene WHERE rufnummer=$daten_addr[tele1] OR rufnummer=$daten_addr[tele2] OR rufnummer=$daten_addr[tele3] OR rufnummer=$daten_addr[handy]";
  $result_anrufe=$zugriff_mysql->sql_abfrage($sql_abfrage);
  if ($result_anrufe)
   {
    $ges_anrufe=mysql_num_rows($result_anrufe);
    if ($ges_anrufe)
     {
      $id_letzer=$ges_anrufe -1;
      $datum_letzer=mysql_datum(mysql_result($result_anrufe, $id_letzer, "datum"));
     }
    else
     {
      $datum_letzer="-";
     }
     
   }
   else
   {
   $datum_letzer="-";
   $ges_anrufe=0; 
   }
   
   $array[$index_array]= array("id" => $daten_addr[id], "rang" => $ges_anrufe, "letzter" => $datum_letzer );
   $index_array++;
   
 } //while zu ende  
 
 
if ($_GET[order]=="false") 
 {
  $option_order="true";
  $index=$index_array;
 }
else
 {
  $option_order="false";
  $index=1;
 }




function sortarray($a, $b) {
 if ($a['rang'] == $b['rang']) { return 0;  }
   
  if ($_GET[order]=="false") 
  {
   return ($a['rang'] < $b['rang']) ? -1 : 1;
   }
  else
  {
  return ($b['rang'] < $a['rang']) ? -1 : 1;
   }
  
  
}
usort ($array, "sortarray");

$template->assign_vars(array(
	'DATA_ORDER_OPTION' =>$option_order,
	'L_SORT_OPTION' => $textdata[stat_gesamt_sortierung],
	'L_ADDR_LAST_NAME' =>  $textdata[addadress_nachname],
	'L_ADDR_FIRST_NAME' => $textdata[addadress_vorname],
	'L_ALL_CALLS' => $textdata[stat_gesamt_anrufe],
	'L_LAST_CALL' => $textdata[stat_anrufer_letzter_anruf]));

$i=0;
while (list ($key, $value) = each ($array)) {
 if($i%2==0)
  { $color=$row_color_1; }
 else
  { $color=$row_color_2; }
  
  
  $id=$value["id"];
  $rang=$value["rang"];
  $letzer_anruf=$value["letzter"];
  
  $result_adressbuch=$zugriff_mysql->sql_abfrage("SELECT vorname,nachname FROM adressbuch where id=$id");
  $daten_adressbuch=mysql_fetch_assoc($result_adressbuch);
  
  $template->assign_block_vars('tab1',array(
  	'DATA_COLOR' => $color,
	'DATA_INDEX' => $index,
	'DATA_ID' => $id,
	'DATA_LAST_NAME' => $daten_adressbuch[nachname],
	'DATA_FIRST_NAME' => $daten_adressbuch[vorname],
	'DATA_COUNT' => $rang,
	'DATA_LAST_CALL' => $letzer_anruf));
  
  if ($letzer_anruf=="-")
    {
     $template->assign_block_vars('tab1.no_call_from_user', array());
    }
   else
   {
    $template->assign_block_vars('tab1.call_from_user', array(
    	'DATA_ID' => $id,
	'L_SEARCH_ENTRY' => $textdata[adressbuch_suche_eintraege]));
   }
if ($_GET[order]=="false") 
 {
  $index--;
 }
else
 {
  $index++;
 }
$i++;  
}

$zugriff_mysql->close_mysql();
} // ENDE wenn kein eintrag besteht

$template->pparse('overall_body');  
include("./footer.inc.php");
?>
