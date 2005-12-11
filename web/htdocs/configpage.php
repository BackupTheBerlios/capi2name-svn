<?php
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
$seite=base64_encode("configpage.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => './templates/'.$_SESSION['template'].'/configpage.tpl'));
//ob er die Page anschauen darf:
if (!$_SESSION['show_config'])
{
	$template->assign_block_vars('userconfig_show_configpage', array(
		'L_NOT_SHOW_THIS_PAGE' => $textdata[configpage_nicht_berechtigt]));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	exit();
}
$template->assign_vars(array('L_TITLE_OF_CONFIG_PAGE' => $textdata['configpage_konfiguration']));


$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$sqlquery=sprintf("SELECT * FROM users WHERE id=%s", $dataB->sql_checkn($_SESSION['userid']));
$result=$dataB->sql_query($sqlquery);
$daten=$dataB->sql_fetch_assoc($result);
$result_config=$dataB->sql_query("SELECT * FROM config WHERE conf='template'"); 
$daten_config=$dataB->sql_fetch_assoc($result_config); 
$dataB->sql_close();
//Xhtml konform das checkboxen gechecked sind.
$array=array('show_callback','show_prefix','show_msn','show_type','show_sfcallnr','show_linktoam');
for ($i=0;$i<=5;$i++)
{
	if ($daten[$array[$i]])
	{
		$daten[$array[$i]]="checked=\"checked\"";
	}
}

$template->assign_block_vars('tab1', array(
	'L_USER_NAME' => $textdata['configpage_username'],
	'DATA_USER_NAME' => $daten['username'],
	'L_CHANGE_PASSWD' => $textdata['configpage_passwort_aendern'],
	'L_OLD_PASSWD' => $textdata['configpage_altes_passwd'],
	'L_NEW_PASSWD' => $textdata['configpage_neues_passwd'],
	'L_NEW_PASSWD_CONFIRM' => $textdata['configpage_wiederholen'],
	'L_FIRST_NAME' => $textdata['addadress_vorname'],
	'L_LAST_NAME' => $textdata['addadress_nachname'],
	'DATA_FIRST_NAME' => $daten['name_first'],
	'DATA_LAST_NAME' => $daten['name_last'],
	'L_SHOW_NUMBERS_OF_CALLS_IN_STAT' => $textdata['configpage_zeige_letzte_anrufe'],
	'DATA_NUMBERS' => $daten['show_lines'],
	'L_SHOW_CALL_BACK_FUNC' => $textdata['configpage_zeige_rueckruf'],
	'DATA_CALL_BACK_FUNC' => $daten['show_callback'],
	'L_SHOW_PREFIX_FUNC' => $textdata['option_splate_vorwahl'],
	'DATA_PREFIX_FUNC' => $daten['show_prefix'],
	'L_SHOW_TYP_FROM_CALL' => $textdata['zeige_typ'],
	'DATA_SHOW_TYP_FROM_CALL' => $daten['show_type'],
	'L_SHOW_MSN' => $textdata['option_splate_msn'],
	'DATA_SHOW_MSN' => $daten['show_msn'],
	'L_SHOW_SFCALLNR' => $textdata['option_spalte_sfcallnr'],
	'DATA_SHOW_SFCALLNR' =>  $daten['show_sfcallnr'],
	'L_SHOW_MSN_FUNC' => $textdata['zeige_msns'],
	'DATA_SHOW_MSN_FUNC' => $daten['msn_listen'],
	'L_WARNING_FOR_MSN_FUNC' => $textdata['warnung_msns'],
	'DATA_ID_FROM_DB' => $daten['id'],
	'L_SAVE_DATA_TO_DB' => $textdata['save']));

if ($config['capisuite'])
{
	$template->assign_block_vars('tab1.cs',array(
		'L_T_CS_AUDIO' =>$textdata['cs_type_cs_audio'],
		'L_T_CS_FAX' => $textdata['cs_type_cs_fax'])); 
	
	//cs_audio selection:
	for ($i=1;$i<=3;$i++)
	{
		if ($daten['cs_audio']==$i)
		{
			$template->assign_block_vars('tab1.cs.tab3',array(
				'DATA_NAME' => $textdata['cs_audio_'.$i],
				'DATA_ID' => $i,
				'DATA_SELECT' => 'selected="selected"'));
		}
		else
		{
			$template->assign_block_vars('tab1.cs.tab3',array(
				'DATA_NAME' => $textdata['cs_audio_'.$i],
				'DATA_ID' => $i,
				'DATA_SELECT' => ''));
		}
	}
	//CS_fax auswahl
	for ($i=1;$i<=4;$i++)
	{
		if ($daten['cs_fax']==$i)
		{
			$template->assign_block_vars('tab1.cs.tab4',array(
				'DATA_NAME' => $textdata['cs_fax_'.$i],
				'DATA_ID' => $i,
				'DATA_SELECT' => 'selected="selected"'));
		}
		else
		{
			$template->assign_block_vars('tab1.cs.tab4',array(
				'DATA_NAME' => $textdata['cs_fax_'.$i],
				'DATA_ID' => $i,
				'DATA_SELECT' => ''));
		}
	}
}


if ($daten_config['value']==NULL)
{
	$template->assign_block_vars('tab1.template_on',array(
		'L_SET_TEMPLATE' => 'Template setzten'));
	$dir= "templates";
	$dh=opendir($dir);
	while (false!== ($filename=readdir($dh)))
	{
		if ($filename!="." AND $filename!=".." AND $filename!="index.html")
		{
			$files[] =$filename;
		}
	}
	foreach ($files as $value)
	{
		if ($value==$daten['template'])
		{
			$template->assign_block_vars('tab1.template_on.tab2',array(
				'DATA_TEMPLATE' => $value,
				'DATA_SELECT' => 'selected="selected"'));
		}
		else
		{
			$template->assign_block_vars('tab1.template_on.tab2',array('DATA_TEMPLATE' => $value));
		}
	}
}//wenn user selber template setzten darf
$template->pparse('overall_body');
include("./footer.inc.php");
?>