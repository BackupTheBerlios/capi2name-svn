<?
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
	header ("Cache-Control: no-cache,private, must-revalidate");
	header ("Pragma: no-cache");
	
?>
<!--
/*
    copyright            : (C) 2002-2004 by Jonas Genannt
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
-->
<?php
include("./templates/template.php");
include("./language/".$config['language'].".inc.php");
$template = new Template("./templates/blueingey/");
$template->set_filenames(array('overall_header' => 'templates/blueingrey/header.tpl'));



$template->assign_vars(array('CAPI2NAME_PAGE_TITLE' => $config['domain']));
$template->assign_vars(array('L_HAUPTMENU' => $textdata[header_inc_mainmenue]));

$template->assign_vars(array('L_INDEX' => $textdata[header_inc_index]));
$template->assign_vars(array('L_POWERED_BY' => $textdata[header_inc_powered]));
if ($userconfig['showconfig'])
   {
    $template->assign_block_vars('show_config_page_on', array());
    $template->assign_vars(array('L_CONFIGPAGE' => $textdata[header_inc_configpage]));
   }
  
$template->assign_vars(array('L_TELEPOHN' => $textdata[header_inc_telefon]));
$template->assign_vars(array('L_CALL_STAT_NORMAL' => $textdata[header_inc_anrufstatistik]));
$template->assign_vars(array('L_CALL_STAT_EXTENED' => $textdata[header_inc_erweiterte_stat]));
$template->assign_vars(array('L_CALL_STAT_TODAY' => $textdata[header_inc_heute_anrufte]));
$template->assign_vars(array('L_CALL_STAT_YESTERDAY' => $textdata[header_inc_gestrige_anrufe]));
$template->assign_vars(array('L_CALL_STAT_7_DAYS' => $textdata[header_inc_7tage]));
$template->assign_vars(array('L_CALL_ALL_STAT' => $textdata[header_inc_gesamtstatistik]));
$template->assign_vars(array('L_CALL_STAT_MONTH' => 'Monatsübersicht'));
$template->assign_vars(array('L_SEARCH' => 'Suche'));
$template->assign_vars(array('L_CALENDAR' => $textdata[header_inc_kalender]));
if ($userconfig['loeschen'])
   {
    $template->assign_block_vars('show_delete_page_unkown_calls_on', array());
    $template->assign_vars(array('L_DELETE_FUNCTION' => 'Löschfunktion'));
   }
if ($userconfig['showrueckruf'])
   {
    $template->assign_block_vars('show_call_back_pages_on', array());
    $template->assign_vars(array('L_CALL_BACK' => $textdata[header_inc_rueckruf]));
    $template->assign_vars(array('L_NEW_ENTRY' => $textdata[header_inc_neuer_eintrag]));
   }
$template->assign_vars(array('L_ADDRESS_BOOK' => $textdata[header_inc_adressbuch]));
$template->assign_vars(array('L_NEW_ENTRY' => $textdata[header_inc_neuer_eintrag]));
if ($userconfig['shownotiz'])
   {
    $template->assign_block_vars('show_memo_pages_on', array());
    $template->assign_vars(array('L_MEMO' => $textdata[header_inc_notizen]));
    $template->assign_vars(array('L_NEW_MEMO' => $textdata[header_inc_neue_notiz]));
   }
if ($config['capisuite'] == "yes")
   {
    $template->assign_block_vars('show_capi_suite_on', array());
    $template->assign_vars(array('L_CAPI_SUITE' => 'CapiSuite'));
    $template->assign_vars(array('L_CAPI_SUITE_ANSWERPHONE' => $textdata[header_inc_cs_answerphone]));
    $template->assign_vars(array('L_CAPI_SUITE_HELP' => $textdata[header_inc_cs_help]));
   }





//if ( is_dir("up_inst")) {
//		echo "<div style\"text-align:center;\">Verzeichnis <b>up_inst</b> existiert noch! Bitte löschen!</div>";     
//		die("");
//}
$template->pparse('overall_header');


?>
