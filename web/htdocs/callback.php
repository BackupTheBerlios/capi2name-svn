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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
if (isset($add))
{
	$seite=base64_encode("callback.php?add=yes");
}
else
{
	$seite=base64_encode("callback.php");
}
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/callback.tpl'));

$template->assign_vars(array('L_SITE_TITLE' => $textdata[callback_title]));

//ob er die Page anschauen darf:
if (!$userconfig['showrueckruf'])
{
	$template->assign_block_vars('not_allowed',array('L_MSG_NOT_ALLOWED' =>$textdata[nichtberechtigt] ));
	$template->pparse('overall_body');
	include("./footer.inc.php");
	die();
}

if(isset($_GET[del])&& is_numeric($_GET[del]))
{
	$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$d_id=$dataB->sql_checkn($_GET[del]);
	$result=$dataB->sql_query("DELETE FROM callback WHERE id=$d_id");
	$dataB->sql_close();
	if ($result)
	{
		$template->assign_block_vars('del_entry',array(
		'L_MSG_DEL_FORWARD' => $textdata[del_OK_forward]));
		$template->pparse('overall_body');
		include("./footer.inc.php");
		die();
	}
}

 
if(isset($_POST[save_without_addr]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  if (is_numeric($_POST[addname]))
   {
    $sql_query=sprintf("INSERT INTO callback VALUES(NULL,%s,%s,NOW(),NOW(),%s,%s,'1',NULL,NULL)",
    	$dataB->sql_checkn($_POST[addname]),
	$dataB->sql_checkn($_POST[user_id]),
	$dataB->sql_checkn($_POST[callback_time]),
	$dataB->sql_check($_POST[message]));
   }
  else
   {
    $sql_query=sprintf("INSERT INTO callback VALUES(NULL,'-1',%s,NOW(),NOW(),%s,%s,'1',%s,%s)",
    	$dataB->sql_checkn($_POST[user_id]),
	$dataB->sql_checkn($_POST[callback_time]),
	$dataB->sql_check($_POST[message]),
	$dataB->sql_check($_POST[addnumber]),
	$dataB->sql_check($_POST[addname]));
   }
  $dataB->sql_query($sql_query);
  $dataB->sql_close();
  $template->assign_block_vars('saved_with_addr',array('L_MSG_SAVED' => $textdata[saved_to_db]));
 } 
 
if(isset($_POST[save_with_addr]))
 {
  $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $query=sprintf("INSERT INTO callback VALUES(NULL,%s,%s,NOW(),NOW(),%s,%s,'1',NULL,NULL)",
  	$dataB->sql_checkn($_POST[addid]),
	$dataB->sql_checkn($_POST[user_id]),
	$dataB->sql_checkn($_POST[callback_time]),
	$dataB->sql_check($_POST[message]));
  $dataB->sql_query($query);
  $dataB->sql_close();
  $template->assign_block_vars('saved_with_addr',array('L_MSG_SAVED' => $textdata[saved_to_db]));
 }

$template->assign_block_vars('tab1',array(
		'L_NAME' => $textdata[showstatnew_name],
		'L_NUMBER' => $textdata[stat_anrufer_rufnummer],
		'L_CALL_TIME' => $textdata[stat_anrufer_datum] ." / ". $textdata[stat_anrufer_uhrzeit],
		'L_CALL_BACK_TIME' => $textdata[callback_time]));
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_callback=$dataB->sql_query("SELECT t1.*,t2.name_last,t2.name_first,t3.number AS RUFNR FROM callback AS t1 LEFT JOIN addressbook AS t2 ON t1.addr_id=t2.id LEFT JOIN phonenumbers AS t3 ON t3.addr_id=t2.id WHERE t1.user_id=".$_SESSION['user_id']." GROUP BY t1.id");
$i=0;
while($daten=$dataB->sql_fetch_assoc($result_callback))
{
	if ($i%2==0)
	{
		$color=$row_color_1;
	}
	else
	{
		$color=$row_color_2;
	}
	$i++;
	if($daten[addr_id]==-1)
	{
		$number=$daten[number];
	}
	else
	{
		$number=$daten[RUFNR];
	}
	
	switch ($daten[callback_time])
	{
	case 0:
		$callback_time=$textdata[callback_soon_as_posible];
		break;
	case 1:
		$callback_time=$textdata[callback_morning];
		break;
	case 2:
		$callback_time=$textdata[callback_midday];
		break;
	case 3:
		$callback_time=$textdata[callback_evening];
		break;
	}; 
	
	if ($daten[addr_id]==-1)
	{
		$full_name=$daten[full_name];
	}
	else  
	{
		$full_name="<a href=\"./addressbook.php?id=$daten[addr_id]\">$daten[name_first] $daten[name_last]</a>";
	}
	$template->assign_block_vars('tab2',array(
	'DATA_COLOR' => $color,
	'DATA_NAME' => $full_name,
	'DATA_ID' => $daten[id],
	'DATA_NUMBER' => $number,
	'L_SHOW_REASON' => $textdata[show_reason],
	'DATA_TIME' => $daten[en_time],
	'DATA_DATE' => mysql_datum($daten[en_date]),
	'DATA_CALL_BACK_TIME' => $callback_time,
	'L_DELETE' => $textdata[delet]));
}
$dataB->sql_close();
if ($_GET[add]== "yes")
{
	$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$result_users=$dataB->sql_query("SELECT id,username,name_first,name_last FROM users");
	if (!empty($_GET[addr]))
	{
	//user kommt von showstatnew.php und hat id vom addr
		$query=sprintf("SELECT t1.id,t1.name_first,t1.name_last,t2.number FROM addressbook AS t1 LEFT JOIN  phonenumbers AS t2 ON t2.addr_id=t1.id WHERE t1.id=%s LIMIT 1", $dataB->sql_checkn($_GET[addr]));
		$result_addr=$dataB->sql_query($query);
		$daten_addr=$dataB->sql_fetch_assoc($result_addr);
		$template->assign_block_vars('insert_with_addr',array(
		'L_TITLE_NEW' => $textdata[new_entry],
		'L_NAME' => $textdata[showstatnew_name],
		'L_DATA_NAME' => $daten_addr[name_first]." ".$daten_addr[name_last],
		'L_DATA_NUMBER' => $number,
		'L_DATA_ID' => $daten_addr[id],
		'L_SAVE_DATA' => $textdata[save],
		'L_NUMBER' => $textdata[stat_anrufer_rufnummer],
		'L_CALL_BACK_TIME' => $textdata[callback_time],
		'L_MORING' => $textdata[callback_morning],
		'L_SOON_AS_POSSIBLE' => $textdata[callback_soon_as_posible],
		'L_EVENING' => $textdata[callback_evening],
		'L_MIDDAY' => $textdata[callback_midday],
		'L_USERNAME' => $textdata[capi2name_user],
		'L_MESSAGE' => $textdata[reason]));
   while($daten_users=$dataB->sql_fetch_assoc($result_users))
    {
     if (empty($daten_users[name_first]) && empty($daten_users[name_last]))
      {
	$full_name="$daten_users[username]";
      }
     else 
      {
        $full_name=$daten_users[name_first]." ".$daten_users[name_last];
      }
     if ($daten_users[username]==$_SESSION[username] && $daten_users[username]!="admin")
      {
       //selectet=selected
       $template->assign_block_vars('insert_with_addr.select_users',array(
       			'L_DATA_NAME' => $full_name,
			'L_DATA_ID' => $daten_users[id],
			'L_DATA_SELECTED' => 'selected="selected"'));
      }
     elseif($daten_users[username]!="admin")
      {
       $template->assign_block_vars('insert_with_addr.select_users',array(
       			'L_DATA_NAME' => $full_name,
			'L_DATA_ID' => $daten_users[id]));
      }
    }//WHILE ZU ENDE
  }
  else
  {//ANFANG insert_without_addr
  $template->assign_block_vars('insert_without_addr',array(
  		'L_TITLE_NEW' => $textdata[new_entry],
		'L_NAME' => $textdata[showstatnew_name],
		'L_NUMBER' => $textdata[stat_anrufer_rufnummer],
		'L_CALL_BACK_TIME' => $textdata[callback_time],
		'L_MORING' => $textdata[callback_morning],
		'L_SOON_AS_POSSIBLE' => $textdata[callback_soon_as_posible],
		'L_EVENING' => $textdata[callback_evening],
		'L_MIDDAY' => $textdata[callback_midday],
		'L_USERNAME' => $textdata[capi2name_user],
		'L_SAVE_DATA' => $textdata[save],
		'L_MESSAGE' => $textdata[reason],
		'DATA_NR' => $_GET[nr]));
  while($daten_users=$dataB->sql_fetch_assoc($result_users))
    {
    if (empty($daten_users[name_first]) && empty($daten_users[name_last]))
      {
	$full_name="$daten_users[username]";
      }
     else 
      {
        $full_name=$daten_users[name_first]." ".$daten_users[name_last];
      }
     if ($daten_users[username]==$_SESSION[username] && $daten_users[username]!="admin")
      {
       //selectet=selected
       $template->assign_block_vars('insert_without_addr.select_users',array(
       			'L_DATA_NAME' => $full_name,
			'L_DATA_ID' => $daten_users[id],
			'L_DATA_SELECTED' => 'selected="selected"'));
      }
     elseif($daten_users[username]!="admin")
      {
       $template->assign_block_vars('insert_without_addr.select_users',array(
       			'L_DATA_NAME' => $full_name,
			'L_DATA_ID' => $daten_users[id]));
      }
    }
  $result_addr=$dataB->sql_query("SELECT id,name_last,name_first FROM addressbook ORDER BY name_last");
  while($daten_addr=$dataB->sql_fetch_assoc($result_addr))
   {
    $template->assign_block_vars('insert_without_addr.tab1',array(
  		'DATA_ADDR_ID' => $daten_addr[id],
		'DATA_ADDR_NAME' => $daten_addr[name_first]." ".$daten_addr[name_last]));
   }  

  }//END insert_without_addr

 

 $dataB->sql_close();
 }

 
$template->pparse('overall_body');
include("./footer.inc.php");
?>

