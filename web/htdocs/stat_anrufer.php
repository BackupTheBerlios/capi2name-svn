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
$seite=base64_encode("stat_anrufer.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>



<?
 $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result_adressbuch=$zugriff_mysql->sql_abfrage("SELECT * FROM adressbuch WHERE id=$_GET[id]");
 $data_adressbuch=mysql_fetch_array($result_adressbuch);
 $zugriff_mysql->close_mysql();

echo "<div class=\"ueberschrift_seite\">$textdata[stat_anrufer_ueberschrift] $data_adressbuch[vorname] $data_adressbuch[nachname]</div>";
echo "<br />";
?>


<?
//Daten sammeln:

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); $result_anrufe=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE rufnummer='$data_adressbuch[tele1]' OR rufnummer='$data_adressbuch[tele2]' OR rufnummer='$data_adressbuch[tele3]' OR rufnummer='$data_adressbuch[handy]'");
$zugriff_mysql->close_mysql();
 $ges_anzahl=mysql_num_rows($result_anrufe);


 if ($ges_anzahl!=false) //wenn gar kein anruf gibt
  {

 $id_letzer=$ges_anzahl - 1;
 $datum_letzter=mysql_datum(mysql_result($result_anrufe, $id_letzer, "datum"));
 $uhrzeit_letzer=mysql_result($result_anrufe, $id_letzer, "uhrzeit");
 $datum_erster=mysql_datum(mysql_result($result_anrufe, "0", "datum"));
 $uhrzeit_erster=mysql_result($result_anrufe, "0", "uhrzeit");


//Durchschnittlich Anrufe pro Woche ausrechen:
$a_datum_erster=explode(".", $datum_erster);
$a_datum_letzer=explode(".", $datum_letzter);
$utime_date_erster = gmmktime(0,0,0,$a_datum_erster[1], $a_datum_erster[0], $a_datum_erster[2]);
$utime_date_letzer = gmmktime(0,0,0,$a_datum_letzer[1], $a_datum_letzer[0], $a_datum_letzer[2]);
$ergbis=$utime_date_letzer-$utime_date_erster;
$wochen=$ergbis/60/60/24/7;
$wochen_genau=ceil($wochen);
 if ($wochen_genau==0) $wochen_genau=1;
$anrufe_woche= round($ges_anzahl/$wochen_genau, 2);
//ende daten sammeln!!!!
?>



<table border="0" width="100%" style="margin-right:auto;margin-left:auto;text-align:left;">
  <tr>
    <td valign="top">
    <h3>Detailansicht</h3>
      <table border="0" cellpadding="1" cellspacing="2">
       <tr>
             <td><? echo "$textdata[addadress_vorname]:"; ?></td>
	     <td style="width:10px"> </td>
	     <td><? echo "$data_adressbuch[vorname]"; ?></td>
        </tr>
	<tr>
	   <td><? echo "$textdata[addadress_nachname]:"; ?></td>
	   <td style="width:10px"> </td>
	   <td><? echo "$data_adressbuch[nachname]"; ?></td>
        </tr>
<?
if ($data_adressbuch[tele1]!="99")
 { echo "
	<tr>
	   <td>$textdata[addadress_telefonnummer1]:</td>
	   <td style=\"width:10px\"> </td>
	   <td>$data_adressbuch[tele1]</td>
        </tr>";
}
if ($data_adressbuch[tele2]!="99")
 { echo "

	<tr>
	   <td>$textdata[addadress_telefonnummer2]:</td>
	   <td style=\"width:10px\"> </td>
	   <td>$data_adressbuch[tele2]</td>
        </tr>";
}
if ($data_adressbuch[tele3]!="99")
 { echo "
	<tr>
	   <td>$textdata[addadress_telefonnummer3]:</td>
	   <td style=\"width:10px\"> </td>
	   <td>$data_adressbuch[tele3]</td>
        </tr>";
}
if ($data_adressbuch[handy]!="99")
 { echo "
	<tr>
	   <td>$textdata[addadress_handy]:</td>
	   <td style=\"width:10px\"> </td>
	   <td>$data_adressbuch[handy]</td>
        </tr>";
}
echo "
       </table>
     <br />
    <h3>$textdata[stat_anrufer_zahlen_fakten]</h3>
 <table border=\"0\">
   <tr>
    <td>$textdata[stat_anrufer_gesamte_anrufe]:</td>
	<td>&nbsp;</td>
	<td>$ges_anzahl</td>
   </tr>
   <tr>
     <td>$textdata[stat_anrufer_geht_ueber]:</td>
     <td>&nbsp;</td>
     <td>$wochen_genau Wochen</td>
   </tr>
   <tr>
    <td>$textdata[stat_anrufer_letzter_anruf]:</td>
	<td>&nbsp;</td>
	<td>$datum_letzter / $uhrzeit_letzer</td>
   </tr>
   <tr>
    <td>$textdata[stat_anrufer_erster_anruf]:</td>
	<td>&nbsp;</td>
	<td>$datum_erster / $uhrzeit_erster</td>
   </tr>
   <tr>
    <td>$textdata[stat_anrufer_durchschnitt_anrufe]:</td>
	<td>&nbsp;</td>
	<td>$anrufe_woche</td>
   </tr>
  </table>";

 echo "
    </td>
    <td style=\"vertical-align:top;\">
 <h3>$textdata[stat_anrufer_alle_anrufe_von] $data_adressbuch[vorname] $data_adressbuch[nachname]</h3>
<table border=\"0\" cellpadding=\"5\" cellspacing=\"2\">
  <tr>
   <td style=\"text-align:center;\">$textdata[stat_anrufer_datum]</td>
   <td style=\"text-align:center;\">$textdata[stat_anrufer_uhrzeit]</td>
   <td style=\"text-align:center;\">$textdata[stat_anrufer_rufnummer]</td>
   <td style=\"text-align:center;\">$textdata[stat_anrufer_MSN]</td>
  </tr>";

  $i=0;
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE rufnummer='$data_adressbuch[tele1]' OR rufnummer='$data_adressbuch[tele2]' OR rufnummer='$data_adressbuch[tele3]' OR rufnummer='$data_adressbuch[handy]' ORDER BY id DESC");
$zugriff_mysql->close_mysql();
 while ($data_angerufene=mysql_fetch_array($result))
  {
  if($i%2==0)
   { $color=$c_color[11]; }
    else
    { $color=$c_color[12]; }
   $tmp=mysql_datum($data_angerufene[datum]);
   echo "
   <tr style=\"background-color:$color\">
    <td>$tmp</td>
	<td style=\"text-align:center;\">$data_angerufene[uhrzeit]</td>
	<td style=\"text-align:center;\">$data_angerufene[rufnummer]</td>
	<td style=\"text-align:center;\">$data_angerufene[msn]</td>
    </tr>";
   $i++;
  }
 

   } // gar kein anruf da ist:
   else
    {
     echo "<br /><span style=\"text-align:center\">$textdata[stat_anrufer_keine_anrufe_gefunden] $data_adressbuch[vorname] $data_adressbuch[nachname] $textdata[stat_anrufer_keine_anrufe_gefunden_ende]</span>";
    }
?>


 </table>

    </td>
  </tr>
</table>

















  <?
  include("./footer.inc.php");
  ?>
