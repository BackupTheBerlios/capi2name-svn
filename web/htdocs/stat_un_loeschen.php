<?
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
 ?>
<?
$seite=base64_encode("stat_un_loeschen.php");
include("./login_check.inc.php");
include("./header.inc.php");
 
 
echo "<div class=\"ueberschrift_seite\">Einträge mit unbekant aus Datenbank löschen</div>";
?>

<br />
<?
//ob er die Page anschauen darf:
 if ($showloeschen=="no")
  {
   echo "<div class=\"rot_mittig\">$text[nichtberechtigt]</div>";
   include("./footer.inc.php");
   die();
  }
?>
<?
//abfrage:
if (isset($_POST[absenden]))
{
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 if ($_POST[alle_unbekannten]=="on") //loesche alle unbekannten Eintraege
  {
   $result_loeschen=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE rufnummer='unbekannt'");
   if ($result_loeschen==true) { echo "<div class=\"blau_mittig\">Löschen erflogreich....</div>"; }
   else { echo "<div class=\"rot_mittig\">Löschen fehlgeschlagen...</div>"; }
    
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
?>



<form action="stat_un_loeschen.php" method="post">
<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;" >
 <tr>
  <td></td>
  <td style="text-align:center"><? echo "$textdata[stat_anrufer_datum]"; ?></td>
  <td style="text-align:center"><? echo "$textdata[stat_anrufer_uhrzeit]"; ?></td>
  <td style="width:110px; text-align:center">
       <? echo "$textdata[stat_anrufer_rufnummer]"; ?></td>
  <td style="text-align:center"><? echo "$textdata[stat_anrufer_MSN]"; ?></td>
  <td style="text-align:center"><? echo "$textdata[showstatnew_name]"; ?></td>
  </tr>
  <?
   $i=0;
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $result_angerufene=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE rufnummer='unbekannt' ORDER BY 'id'  DESC");
   
   if ($result_angerufene==true)
   {
   
    while($daten=mysql_fetch_row($result_angerufene))
     {
      if($i%2==0){ $color="$c_color[11]"; }
      else       { $color="$c_color[12]"; }
     $datum=mysql_datum($daten[2]);
     $msn=msnzuname($daten[6]);
      echo "<tr style=\"background-color:$color\">
      		<td><input type=\"checkbox\" name=\"$daten[0]\"/></td>
		<td>$datum</td>
		<td>$daten[3]</td>
		<td style=\"text-align:center\">$daten[1]</td>
		<td style=\"text-align:center\">$msn</td>
		<td style=\"text-align:center\">$daten[5]</td>
	    </tr>";
     $i++;
     }
   }//if true
   else
   {
    echo "<div class=\"rot_mittig\">Keine Anrufe mit Nummer/Name unbekannt gefunden.</div>";
   }
  $zugriff_mysql->close_mysql();
  ?>
 </table>

<p><input type="checkbox" name="alle_unbekannten"/>Lösche alle unbekannten Einträge</p>
<p><input type="checkbox" name="nur_ruf_unbekannten"/>Lösche nur Einträge mit Nummer unbekannt, wo kein Name vergeben wurde.</p>
<ins><input type="submit" name="absenden" value="Löschen"/></ins>
</form>




<?
include("./footer.inc.php");
?>
