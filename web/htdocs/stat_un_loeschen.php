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
 
$template->set_filenames(array('overall_body' => 'templates/blueingrey/stat_un_loeschen.tpl')); 
$template->assign_vars(array('SITE_TITLE' => 'Einträge mit unbekant aus Datenbank löschen'));

//ob er die Page anschauen darf:
if (!$userconfig['loeschen'])
 {
  $template->assign_block_vars('tab1',array('L_MSG_NOT_ALLOWED' => $text[nichtberechtigt]));
  $template->pparse('overall_body');
  include("./footer.inc.php");
  die();
 }

  
//abfrage:
if (isset($_POST[absenden]))
{
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 if ($_POST[alle_unbekannten]=="on") //loesche alle unbekannten Eintraege
  {
   $result_loeschen=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE rufnummer='unbekannt'");
   if ($result_loeschen==true)
    { 
     $template->assign_block_vars('delete_ok',array(
     		'L_MSG_DELTE_OK' => 'Löschen erflogreich....'));
    }
   else 
    {
      $template->assign_block_vars('delete_failed',array(
      		'L_MSG_DELETE_FAILED' => 'Löschen fehlgeschlagen...'));
    }
    
  }
 else if ($_POST[nur_ruf_unbekannten]=="on") //loesche alle unbekannten Eintraege und lasse die eintraege mit namen
  {
   $result_loeschen=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE rufnummer='unbekannt' AND name='unbekannt'");
   if ($result_loeschen) { echo "<div class=\"blau_mittig\">Löschen erflogreich....</div>"; }
   else { echo "<div class=\"rot_mittig\">Löschen fehlgeschlagen...</div>"; }
    
  }
  else
  {
   $sqlabfrage="DELETE FROM angerufene WHERE";
   $result=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE rufnummer='unbekannt'");
   $anzahl=mysql_num_rows($result);
   $id_letzer=mysql_result($result, $anzahl-1, "id");
   $id_erster=mysql_result($result, "0", "id");
   $first=true;
   for ($e=$id_erster;$e<=$id_letzer;$e++)
    {
     if ($_POST[$e]=="on")
      {
       if ($first)
        {
	 $sqlabfrage=$sqlabfrage." id=$e";
	 $first=false;
	}
       else
        {
	$sqlabfrage=$sqlabfrage." OR id=$e";
	}
      }
    }
  // echo "<br>SQL-Abfrage: $sqlabfrage<br>";
  $result_loeschen=$zugriff_mysql->sql_abfrage($sqlabfrage);
   if ($result_loeschen) { echo "<div class=\"blau_mittig\">Löschen erflogreich....</div><br/>"; }
   else { echo "<div class=\"rot_mittig\">Löschen fehlgeschlagen...</div>"; }
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
$result_angerufene=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE rufnummer='unbekannt' ORDER BY 'id'  DESC");
  
 if ($result_angerufene==true)
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

$template->assign_vars(array(
		'L_MSG_DELETE_UNKOWN' => 'Lösche alle unbekannten Einträge',
		'L_MSG_DELETE_ONLY_NO_NAME' => 'Lösche nur Einträge mit Nummer unbekannt, wo kein Name vergeben wurde.',
		'L_DELETE' => 'Löschen' ));


$template->pparse('overall_body');
include("./footer.inc.php");
?>
