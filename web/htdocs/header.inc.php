<?php
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
	header ("Cache-Control: no-cache,private, must-revalidate");
	header ("Pragma: no-cache");
	
?>
<!--
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonas.genannt@capi2name.de
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
-->
<?php
include("./templates/".$_SESSION['template']."/config.php");
include("./includes/template.php");
$template = new Template("./templates/".$_SESSION['template']);
$template->set_filenames(array('overall_header' => 'templates/'.$_SESSION['template'].'/header.tpl'));



$template->assign_vars(array('CAPI2NAME_PAGE_TITLE' => $config['domain']));
$template->assign_vars(array('L_HAUPTMENU' => $textdata['header_inc_mainmenue']));

$template->assign_vars(array('L_INDEX' => $textdata['header_inc_index']));
$template->assign_vars(array('L_POWERED_BY' => $textdata['header_inc_powered']));
if (isset($_SESSION['show_config'])&&$_SESSION['show_config'])
{
	$template->assign_block_vars('show_config_page_on', array());
	$template->assign_vars(array('L_CONFIGPAGE' => $textdata['header_inc_configpage']));
}
$template->assign_vars(array('L_LOGOUT' => $textdata['header_inc_logout']));  
$template->assign_vars(array('L_TELEPOHN' => $textdata['header_inc_telefon']));
$template->assign_vars(array('L_CALL_STAT_NORMAL' => $textdata['header_inc_anrufstatistik']));
$template->assign_vars(array('L_CALL_STAT_EXTENED' => $textdata['header_inc_erweiterte_stat']));
$template->assign_vars(array('L_CALL_STAT_TODAY' => $textdata['header_inc_heute_anrufte']));
$template->assign_vars(array('L_CALL_STAT_YESTERDAY' => $textdata['header_inc_gestrige_anrufe']));
$template->assign_vars(array('L_CALL_STAT_7_DAYS' => $textdata['header_inc_7tage']));
$template->assign_vars(array('L_CALL_ALL_STAT' => $textdata['header_inc_gesamtstatistik']));
$template->assign_vars(array('L_CALL_STAT_MONTH' => 'Monatsübersicht'));
$template->assign_vars(array('L_SEARCH' => 'Suche'));
$template->assign_vars(array('L_CALENDAR' => $textdata['header_inc_kalender']));
if (isset($_SESSION['allow_delete'])&&$_SESSION['allow_delete'])
{
	$template->assign_block_vars('show_delete_page_unkown_calls_on', array());
	$template->assign_vars(array('L_DELETE_FUNCTION' => 'Löschfunktion'));
}
if (isset($_SESSION['show_callback'])&&$_SESSION['show_callback'])
{
	$template->assign_block_vars('show_call_back_pages_on', array());
	$template->assign_vars(array('L_CALL_BACK' => $textdata['header_inc_rueckruf']));
	$template->assign_vars(array('L_NEW_ENTRY' => $textdata['header_inc_neuer_eintrag']));
}
$template->assign_vars(array('L_ADDRESS_BOOK' => $textdata['header_inc_adressbuch']));
$template->assign_vars(array('L_NEW_ENTRY' => $textdata['header_inc_neuer_eintrag']));
if ($config['capisuite'] == "yes")
{
	$template->assign_block_vars('show_capi_suite_on', array());
	$template->assign_vars(array('L_CAPI_SUITE' => 'CapiSuite'));
	$template->assign_vars(array('L_CAPI_SUITE_ANSWERPHONE' => $textdata['header_inc_cs_answerphone']));
	//$template->assign_vars(array('L_CAPI_SUITE_FAX' => 'Meine Faxe'));
}

if (isset($_SESSION['show_callback_notify']) && $_SESSION['show_callback_notify'])
{
  echo " <script type=\"text/javascript\">
  <!--
  F1 = window.open(\"callback_notify.php\",\"Fenster1\",\"width=570,height=190,left=0,top=0\");
  //-->
  </script>";
 }
//check if DB-Layout and files are the same version.
if (isset($db_version['value']) && $db_version['value']!=$version && $login_ok ==1 )
 {
  $template->assign_block_vars('current_version',array(
  		'L_MSG_VERSION' => "The Database version and file version are not the same.<br>Please use the up_inst/update.php for update the database."));
		$template->pparse('overall_header');
		include("footer.inc.php");
		die();
		
 }

if ( is_dir("up_inst")) {

	$template->assign_block_vars('up_inst',array(
	'L_MSG_UP_INST' => 'The installtions directory <b>up_inst</b> exists.<br/> Please delete it after updating or installation!!'));
	$template->pparse('overall_header');
	include("footer.inc.php");
	die();
}

$template->pparse('overall_header');
?>