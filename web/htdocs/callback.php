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
if (isset($add))
 { $seite=base64_encode("zurueckruf.php?add=yes");
 }
else { $seite=base64_encode("zurueckruf.php"); }
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/blueingrey/callback.tpl'));



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
 $result=$zugriff_mysql->sql_abfrage("DELETE FROM zurueckrufen WHERE id=$_GET[loeschen]");
 if ($result != "true") {echo "Fehler-Nr. " . mysql_errno()." - " .mysql_error(); die();}
 $zugriff_mysql->close_mysql();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./zurueckruf.php\">";
 }

if(isset($_POST[eintragen]))
 {
 if (!$_POST[addname]) 
 	{echo "<br/><div class=\"rot_mittig\">Bitte Name eingeben.</div><br/>"; die(); }
 if (!$_POST[addrufnummer])
 	 {echo "<br/><div class=\"rot_mittig\">Bitte Rufnummer eingeben.</div><br/>"; die(); }
if ($_POST[datumno]=="yes")
 {
 $adddatum = date("d.m.Y");
 $addzeit= date("G:i:s");
}
else
{
$adddatum = $_POST[adddatum];
$addzeit= $_POST[addzeit];
}
 $grund =  strip_tags($_POST[grund]);
 $grund =  nl2br($grund);
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("INSERT INTO zurueckrufen VALUES(NULL, '$_POST[addname]', '$_POST[addrufnummer]', '$adddatum', '$addzeit', '$grund','$_POST[addzurueckzeit]')");
 $zugriff_mysql->close_mysql();
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./zurueckruf.php?show=yes\">";

 }


$template->assign_vars(array('L_SITE_TITLE' => $text[zurueckrufen]));

$template->assign_block_vars('tab1',array(
		'L_NAME' => $text[name1],
		'L_NUMBER' => $text[rufnummer],
		'L_CALL_TIME' => $text[anruf_zeit],
		'L_CALL_BACK_TIME' => $text[zurueck_zeit]));

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM zurueckrufen");
while($daten=mysql_fetch_assoc($result))
 {
  $template->assign_block_vars('tab2',array(
  	'DATA_NAME' => $daten[name],
	'DATA_ID' => $daten[id],
	'DATA_NUMBER' => $daten[nummer],
	'L_SHOW_REASON' => 'Grund anzeigen.',
	'DATA_TIME' => $daten[uhrzeit],
	'DATA_DATE' => $daten[datum],
	'DATA_CALL_BACK_TIME' => $daten[rueckzeit]));
 }

  
 
$zugriff_mysql->close_mysql();

if ($_GET[add]== "yes")
 {
 if ($_GET[no] == "yes")
  {
   $anzeige="<input type=\"hidden\" name=\"datumno\" value=\"yes\"/>";
  }
 $addname= base64_decode($_GET[addname]);
 $uhrzeit=base64_decode($_GET[zuhrzeit]);
 $datum=base64_decode($_GET[zdatum]);
 echo "
<br /><br /><hr/>
<div class=\"ueberschrift_seite\">Neuer Eintrag</div>
<form action=\"$PHP_SELF\" method=\"post\">
<table border=\"0\" style=\"margin-right:auto;margin-left:auto;text-align:left;\">
 <tr>
  <td>$text[name1]:</td>
  <td><input name=\"addname\" value=\"$addname\" type=\"text\"/>
   <input type=\"hidden\" name=\"addzeit\" value=\"$uhrzeit\"/>
   <input type=\"hidden\" name=\"adddatum\" value=\"$datum\"/>
  </td>
 </tr>
 <tr>
  <td>$text[rufnummer]:</td>
  <td><input name=\"addrufnummer\" value=\"$_GET[addrufnummer]\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$text[zurueck_zeit]:</td>
  <td>
   <select name=\"addzurueckzeit\">
   <option value=\"Morgens\" >Morgens</option>
   <option value=\"Mittags\" >Mittags</option>
   <option value=\"Abends\"  >Abends</option>
   <option value=\"So bald wie moeglich\" >So bald wie moeglich</option>
   </select></td>
   </tr>
   <tr>
   <td>$text[grund]</td>
    <td>$anzeige
     <textarea rows=\"10\" cols=\"30\" name=\"grund\"></textarea>
    </td>
 </tr>
</table>
<ins><br /><input name=\"eintragen\" value=\"$text[speichern]\" type=\"submit\"/></ins>
</form>
 ";
 }
?>
<br /><br />

<?
$template->pparse('overall_body');
include("./footer.inc.php");
?>
