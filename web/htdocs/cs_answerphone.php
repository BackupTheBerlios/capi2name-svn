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
$seite=base64_encode("cs_answerphone.php");
include("./login_check.inc.php");
include("./header.inc.php");
require_once("./includes/cs_functions.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$_SESSION['template'].'/cs_answerphone.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[cs_ap_answerphone]));

if ($_SESSION['cs_user']=="" OR check_cs_username($_SESSION['cs_user'])!=0)
{
	$template->assign_block_vars('user_error',array(
			'L_USER_NOT_FOUND' => $textdata[cs_user_not_found]));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	die();	
}

if (isset($_GET[del]) && $_SESSION['allow_delete'])
{
	$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
	$sql_query=sprintf("UPDATE capisuite SET aktive='0' WHERE id=%s",
		$dataB->sql_checkn($_GET[del]));
	$result=$dataB->sql_query($sql_query);
	$dataB->sql_close();
}

$template->assign_block_vars('tab1',array(
		'CS_AP_LIST' => $textdata[cs_ap_liste],
		'CS_AP_TIME' => $textdata[stat_anrufer_uhrzeit],
		'CS_AP_DATE' => $textdata[stat_anrufer_datum],
		'CS_AP_NR' => $textdata[stat_anrufer_rufnummer],
		'CS_AP_MSN' => $textdata[stat_anrufer_MSN],
		'CS_AP_NAME' => $textdata[showstatnew_name],
		'CS_PLAY' => $textdata[cs_ap_play]));
if ($_SESSION['allow_delete'])
{
	$template->assign_block_vars('tab1.del',array(
		'L_DELETE' => $textdata[showstatnew_loeschen]));
}


$sql_query=sprintf("SELECT t1.id AS cs_id,
		UNIX_TIMESTAMP(t1.date_time)AS TIME_DATE,t1.from_nr,t1.msn,
		t3.name_first, t3.name_last,t3.id AS ADDR_ID,t4.name AS msn_name 
		FROM capisuite as t1
		LEFT JOIN phonenumbers AS t2 ON t1.from_nr=t2.number
		LEFT JOIN addressbook AS t3 ON t2.addr_id=t3.id
		LEFT JOIN msnzuname AS t4 ON t1.msn=t4.msn
		WHERE ident='1' AND cs_user=%s AND aktive='1' ORDER BY cs_id DESC",
		$dataB->sql_check($_SESSION['cs_user']));
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"], $sql["db"] );
$result_cs=$dataB->sql_query($sql_query);
$i=0;
while($data_cs=$dataB->sql_fetch_assoc($result_cs))
{
	if ($data_cs[msn_name]==NULL)
	{
		$anz_msn=$data_cs[msn];
	}
	else
	{
		$anz_msn=$data_cs[msn_name];
	}
	if ($data_cs[from_nr]=="-")
	{
		$number="unbekannt";
		$name="unbekannt";
	}
	else
	{
		if ($data_cs[name_first]==NULL AND $data_cs[name_last]==NULL)
		{
			$name="unbekannt";
			$number=$data_cs[from_nr];
		}
		else
		{
			$name="<a href=\"./addressbook.php?id=$data_cs[ADDR_ID]\">$data_cs[name_first] $data_cs[name_last]</a>";
			$number=$data_cs[from_nr];
		}
	}
	if ($i%2==0) $color=$row_color_1;
	else $color=$row_color_2;
	
	$template->assign_block_vars('tab1.tab2',array(
		'DATA_COLOR' => $color,
		'DATA_DATE' => date("d.m.Y",$data_cs[TIME_DATE]),
		'DATA_TIME' => date("H:m:s",$data_cs[TIME_DATE]),
		'DATA_NUMBER' => $number,
		'DATA_MSN' => $anz_msn,
		'DATA_NAME' => $name,
		'DATA_CS_ID' => $data_cs[cs_id]));
	if ($_SESSION['allow_delete'])
	{
		$template->assign_block_vars('tab1.tab2.delD',array(
			'DATA_ID' => $data_cs[cs_id]));
	}
	$i++;
}
$dataB->sql_close();
$template->pparse('overall_body');
include("./footer.inc.php");
?>