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
$seite=base64_encode("stat_un_loeschen.php");
include("./login_check.inc.php");
include("./header.inc.php");
 
$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/stat_un_loeschen.tpl')); 
//ob er die Page anschauen darf:
if (!$userconfig['loeschen'])
 {
  $template->assign_block_vars('tab1',array('L_MSG_NOT_ALLOWED' => $text[nichtberechtigt]));
  $template->pparse('overall_body');
  include("./footer.inc.php");
  die();
 }
$template->assign_vars(array('SITE_TITLE' => 'Eintr�ge mit unbekant aus Datenbank l�schen'));
  
//abfrage:
if (isset($_POST[absenden]))
{
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 if ($_POST[alle_unbekannten]=="on") 
 //loesche alle unbekannten Eintraege
  {
   $result_loeschen=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE rufnummer='unbekannt'");
   if ($result_loeschen)
    { 
     $template->assign_block_vars('delete_ok',array(
     		'L_MSG_DELTE_OK' => 'L�schen erflogreich....'));
    }
   else 
    {
      $template->assign_block_vars('delete_failed',array(
      		'L_MSG_DELETE_FAILED' => 'L�schen fehlgeschlagen...'));
    }
    
  }
 else if ($_POST[nur_ruf_unbekannten]=="on") 
 //loesche alle unbekannten Eintraege und lasse die eintraege mit namen
  {
   $result_loeschen=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE rufnummer='unbekannt' AND name='unbekannt'");
   if ($result_loeschen)
    { 
     $template->assign_block_vars('delete_ok',array(
     		'L_MSG_DELTE_OK' => 'L�schen erflogreich....'));
    }
   else 
    {
      $template->assign_block_vars('delete_failed',array(
      		'L_MSG_DELETE_FAILED' => 'L�schen fehlgeschlagen...'));
    }
    
  }
  else
  {
   $sqlabfrage="DELETE FROM angerufene WHERE";
   $result=$zugriff_mysql->sql_abfrage("SELECT id FROM angerufene WHERE rufnummer='unbekannt'");
   $first=true;
   while($daten=mysql_fetch_assoc($result))
    {
     if ($_POST[$daten[id]]=="on")
      {
       if ($first)
        {
	 $sqlabfrage .=" id=$daten[id]";
	 $first=false;
	}
       else
        {
	 $sqlabfrage .=" OR id=$daten[id]";
	}
      }
    }//END WHILE
    //echo "<br>SQL-Abfrage: $sqlabfrage<br>";
 $result_loeschen=$zugriff_mysql->sql_abfrage($sqlabfrage);
 if ($result_loeschen)
   { 
    $template->assign_block_vars('delete_ok',array(
    		'L_MSG_DELTE_OK' => 'L�schen erflogreich....'));
   }
 else 
   {
    $template->assign_block_vars('delete_failed',array(
      		'L_MSG_DELETE_FAILED' => 'L�schen fehlgeschlagen...'));
   }
$zugriff_mysql->close_mysql();
}//if isset absenden



$template->assign_block_vars('tab2',array(
		'L_DATE' => $textdata[stat_anrufer_datum],
		'L_TIME' => $textdata[stat_anrufer_uhrzeit],
		'L_NUMBER' => $textdata[stat_anrufer_rufnummer],
		'L_MSN' => $textdata[stat_anrufer_MSN],
		'L_NAME' => $textdata[showstatnew_name]));
$i=0;
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_angerufene=$zugriff_mysql->sql_abfrage("SELECT id,rufnummer,name,datum,uhrzeit FROM angerufene WHERE rufnummer='unbekannt' ORDER BY 'id'  DESC");
  /*
if ($result_angerufene)
  {
   while($daten=mysql_fetch_assoc($result_angerufene))
    {
     if($i%2==0){ $color=$row_color_1; }
     else       { $color=$row_color_2; }
     $datum=mysql_datum($daten[datum]);
     $msn=msnzuname($daten[msn]);
     $template->assign_block_vars('tab3',array(
     		'DATA_COLOR' => $color,
		'DATA_ID' =>$daten[id],
		'DATA_DATE' => $datum,
		'DATA_TIME' => $daten[uhrzeit],
		'DATA_NUMBER' => $daten[rufnummer],
		'DATA_MSN' => $msn,
		'DATA_NAME' => $daten[name]));
     $i++;
     }
   }//if true
   else
   {
    $template->assign_block_vars('no_calls_found',array(
    	'L_MSG_CALLS_NOT_FOUND' => 'Keine Anrufe mit Nummer/Name unbekannt gefunden.'));
   }
$zugriff_mysql->close_mysql();
*/
/*$template->assign_vars(array(
		'L_MSG_DELETE_UNKOWN' => 'L�sche alle unbekannten Eintr�ge',
		'L_MSG_DELETE_ONLY_NO_NAME' => 'L�sche nur Eintr�ge mit Nummer unbekannt, wo kein Name vergeben wurde.',
		'L_DELETE' => 'L�schen' ));
*/

//$template->pparse('overall_body');
//include("./footer.inc.php");
?>