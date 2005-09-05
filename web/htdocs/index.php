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
$seite=base64_encode("index.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/index.tpl'));
$template->assign_vars(array(
	'L_WELCOME_TO_INDEX' => $textdata['index_willkommen'],
	'L_INDEX_TO' => $textdata['index_zu'],
	'L_TO_VERSION' => $textdata['index_Version'],
	'DATA_C2N_CODE_NAME' => $codenamen,
	'DATA_C2N_VERSION' => $version));


if ($config['capi2name_status']) 
{
	if (exec("ps -A | grep capi2name")!="") 
	{
		$template->assign_block_vars('c2n_running',array(
			'MSG_C2N_RUN' => $textdata['index_status_laeuft'],
			'L_STAT' => $textdata['index_status_capi2name']));
	}
	else 
	{
		$template->assign_block_vars('c2n_not_running',array(
			'MSG_C2N_RUN' => $textdata['index_status_laeft_nicht'],
			'L_STAT' => $textdata['index_status_capi2name']));
	}
}
if($config['capisuite']) 
{
	if (exec("ps -A | grep capisuite")!="") 
	{
		$template->assign_block_vars('capisuite_running',array(
			'MSG_CSU_RUN' => $textdata['index_status_laeuft'],
			'L_STAT' => $textdata['index_status_capisuite']));
	}
	else 
	{
		$template->assign_block_vars('capisuite_not_running',array(
			'MSG_CSU_RUN' => $textdata['index_status_laeft_nicht'],
			'L_STAT' => $textdata['index_status_capisuite']));
	}
}
$template->pparse('overall_body');	
include("footer.inc.php");
?>