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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
if (isset($add))
 { $seite=base64_encode("callback.php?add=yes");
 }
else { $seite=base64_encode("callback.php"); }
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/callback.tpl'));



//ob er die Page anschauen darf:
 if (!$userconfig['showrueckruf'])
  {
   $template->assign_block_vars('not_allowed',array('L_MSG_NOT_ALLOWED' =>$text[nichtberechtigt] ));
   $template->pparse('overall_body');
   include("./footer.inc.php");
   die();
  }

if(isset($_GET[loeschen]))
 {
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("DELETE FROM callback WHERE id=$_GET[loeschen]");
 if ($result != "true") {echo "Fehler-Nr. " . mysql_errno()." - " .mysql_error(); die();}
 $zugriff_mysql->close_mysql();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./callback.php\">";
 }

if(isset($_POST[save_with_addr]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $zugriff_mysql->sql_abfrage("INSERT INTO callback VALUES (NULL,'$_POST[addid]','$_POST[user_id]',NOW(),NOW(),'$_POST[callback_time]','$_POST[message]', '1', NULL)");
  $zugriff_mysql->close_mysql();
  $template->assign_block_vars('saved_with_addr',array('L_MSG_SAVED' => 'saved to database'));
 }


$template->assign_vars(array('L_SITE_TITLE' => $text[zurueckrufen]));
$template->assign_block_vars('tab1',array(
		'L_NAME' => $text[name1],
		'L_NUMBER' => $text[rufnummer],
		'L_CALL_TIME' => $text[anruf_zeit],
		'L_CALL_BACK_TIME' => $text[zurueck_zeit]));
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_callback=$zugriff_mysql->sql_abfrage("SELECT t1.*,t2.nachname,t2.vorname,t2.tele1,t2.handy FROM callback AS t1 LEFT JOIN adressbuch AS t2 ON t1.addr_id=t2.id WHERE t1.user_id=".$_SESSION['user_id']);

while($daten=mysql_fetch_assoc($result_callback))
 {
   if ($daten[tele1]=="99")
     {
      $number=$daten[handy];
     }
    else
     {
      $number=$daten[tele1];
     }
   switch ($daten[callback_time])
     {
      case 0:
      	$callback_time="So bald wie moeglich";
	break;
      case 1:
      	$callback_time="Morgens";
	break;
      case 2:
      	$callback_time="Mittags";
	break;
      case 3:
      	$callback_time="Abends";
	break;
     
     };
  $template->assign_block_vars('tab2',array(
  	'DATA_NAME' => $daten[vorname]." ".$daten[nachname],
	'DATA_ID' => $daten[id],
	'DATA_ADDR_ID' => $daten[addr_id],
	'DATA_NUMBER' => $number,
	'L_SHOW_REASON' => 'Grund anzeigen.',
	'DATA_TIME' => $daten[en_time],
	'DATA_DATE' => mysql_datum($daten[en_date]),
	'DATA_CALL_BACK_TIME' => $callback_time));
 }
$zugriff_mysql->close_mysql();

if ($_GET[add]== "yes")
 {
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result_users=$zugriff_mysql->sql_abfrage("SELECT id,username,name_first,name_last FROM users"); 
 if (!empty($_GET[addr]))
  {
   //user kommt von showstatnew.php und hat id vom addr
   $result_addr=$zugriff_mysql->sql_abfrage("SELECT id,tele1,vorname,nachname,handy FROM adressbuch WHERE id='$_GET[addr]'");
   $daten_addr=mysql_fetch_assoc($result_addr);
   if ($daten_addr[tele1]=="99")
    {
     $number=$daten_addr[handy];
    }
   else
    {
     $number=$daten_addr[tele1];
    }
   
   $template->assign_block_vars('insert_with_addr',array(
   		'L_TITLE_NEW' => 'Neuer Eintrag',
		'L_NAME' => $text[name1],
   		'L_DATA_NAME' => $daten_addr[vorname]." ".$daten_addr[nachname],
		'L_DATA_NUMBER' => $number,
		'L_DATA_ID' => $daten_addr[id],
		'L_SAVE_DATA' => $text[speichern],
		'L_NUMBER' => $text[rufnummer],
		'L_CALL_BACK_TIME' => $text[zurueck_zeit],
		'L_MORING' => 'Morgens',
		'L_SOON_AS_POSSIBLE' => 'So bald wie moeglich',
		'L_EVENING' => 'Abends',
		'L_MIDDAY' => 'Mittags',
		'L_USERNAME' => 'Capi2name Benutzer',
		'L_MESSAGE' => $text[grund]));
   while($daten_users=mysql_fetch_assoc($result_users))
    {
     if ($daten_users[username]==$_SESSION[username] && $daten_users[username]!="admin")
      {
       //selectet=selected
       $template->assign_block_vars('insert_with_addr.select_users',array(
       			'L_DATA_NAME' => $daten_users[name_first]." ".$daten_users[name_last],
			'L_DATA_ID' => $daten_users[id],
			'L_DATA_SELECTED' => 'selected="selected"'));
      }
     elseif($daten_users[username]!="admin")
      {
       $template->assign_block_vars('insert_with_addr.select_users',array(
       			'L_DATA_NAME' => $daten_users[name_first]." ".$daten_users[name_last],
			'L_DATA_ID' => $daten_users[id]));
      }
    }//WHILE ZU ENDE
  }

 
/* if ($_GET[no] == "yes")
  {
   $anzeige="<input type=\"hidden\" name=\"datumno\" value=\"yes\"/>";
  } 
 $addname= base64_decode($_GET[addname]);
 $uhrzeit=base64_decode($_GET[zuhrzeit]);
 $datum=base64_decode($_GET[zdatum]);
 $template->assign_block_vars('add_new_entry',array(
 	'L_TITLE_NEW' => 'Neuer Eintrag',
	'L_NAME' => $text[name1],
	'DATA_ADD_NAME' => $addname,
	'DATA_ADD_TIME' => $uhrzeit,
	'DATA_ADD_DATE' => $datum,
	'L_NUMBER' => $text[rufnummer],
	'DATA_NUMBER' => $_GET[addrufnummer],
	'L_CALL_BACK_TIME' => $text[zurueck_zeit],
	'L_REASON' => $text[grund],
	'L_VIEW' => $anzeige,
	'L_SAVE_DATA' => $text[speichern]));
 */
 $zugriff_mysql->close_mysql();
 }

 
$template->pparse('overall_body');
include("./footer.inc.php");
?>

