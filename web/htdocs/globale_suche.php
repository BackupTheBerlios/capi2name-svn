<?php
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
<?php
$seite=base64_encode("globale_suche.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>
<? echo "<div class=\"ueberschrift_seite\">Suche</div>"; ?>

<br />
<br />
<form method="post" action="globale_suche.php">
<CENTER>
<table border="0">
  <tr>
   <td>Suche Rufnummer:</td>
   <td> </td>
   <td><input type="text" name="suche_rufnummer"/></td>
  </tr>
  <tr>
   <td style="vertical-align:top;">Suche Anrufe zwischen:</td>
   <td> </td>
   <td>
    <select name="suche_anfang_tag">
     <?
       for ($i=1;$i<=31; $i++)
        {  echo "<option>$i</option>"; }
     ?>
    </select>
    <select name="suche_anfang_monat"> 
     <?
       for ($i=1;$i<=12; $i++)
        {  echo "<option>$i</option>"; }
     ?>
    </select>
    <select name="suche_anfang_jahr">
     <?
       for ($i=2000;$i<=2008; $i++)
        { echo "<option>$i</option>"; }
     ?>
    </select><br/>
    <select name="suche_ende_tag">
     <?
       for ($i=1;$i<=31; $i++)
        {  echo "<option>$i</option>"; }
     ?>
    </select>
    <select name="suche_ende_monat">
     <?
       for ($i=1;$i<=12; $i++)
        { echo "<option>$i</option>"; }
     ?>
    </select>
    <select name="suche_ende_jahr">
     <?
       for ($i=2000;$i<=2008; $i++)
        { echo "<option>$i</option>"; }
     ?> 
    </select><br/>
    <input type="checkbox" name="suche_auch_rufnummer" value="yes" /> nur mit Rufnummer s.o.<br/>
    Suche nur auf MSN: <input type="text" name="suche_msn" />
    
   </td>
  </tr>
  <tr>
   <td style="vertical-align:top;">Suche Anrufe ohne<br />Adressbucheintrag:</td>
   <td></td>
   <td style="vertical-align:top;">
   <input type="checkbox" name="suche_anrufe_ohne_adressbuch" value="yes"/> Ja<br />
   <input type="checkbox" name="suche_nur_msn" value="yes"/> Suche nur auf dieser MSN s.o.
   </td>
  </tr>
</table>
</CENTER>



<br />
<center>
<input type="submit" name="suchen" value="suchen">
</center>
</form>

<?
if (isset($_POST[suchen]))
 {
 
   
  if ($_POST[suche_rufnummer]!="" && $_POST[suche_auch_rufnummer]!="yes") //Anfang suche nur im Adressbuch nach Nummer
   {
    $sruf=$_POST[suche_rufnummer];
    echo "<br>Suche im Adressbuch nur nach der Nummer $sruf...<br><br>";
    $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $result=mysql_query("SELECT id,vorname,nachname,tele1,tele2,tele3,handy FROM adressbuch WHERE tele1=$sruf OR tele2=$sruf OR tele3=$sruf OR handy=$sruf ");
    $row=mysql_fetch_row($result);
      if ($row==true)
      {
       $color=$c_color[11];
       echo "<table border=\"0\" align=\"center\">
        <tr>
  	<td style=\"width:150px;font-weight:bold;text-align:left;\">        
       $textdata[addadress_nachname]</td>
        <td style=\"width:100px; font-weight:bold;text-align:left;\">        
      $textdata[addadress_vorname]</td>
      <td style=\"width:150px; text-align:center; font-weight:bold;\">
      $textdata[adressbuch_telefonNR]</td>
     <td style=\"width:150px; text-align:center; font-weight:bold;\">$textdata[addadress_handy]</td>
  <td></td>
  <td></td>
  <td></td>
  <td  style=\"width:10px;\"></td>
  <td></td>
 </tr>
 <tr style=\"background-color:$color\">
   <td style=\"text-align:left;\"><a href=\"./showaddress.php?show=$row[0]\" >$row[2]</a></td>
   <td style=\"text-align:left;\"><a href=\"./showaddress.php?show=$row[0]\">$row[1]</a></td>
   <td style=\"text-align:center;\">$row[3]</td>
   <td style=\"text-align:center;\">$row[6]</td>
   <td style=\"text-align:center;\">
     <a href=\"./editadress.php?bearbeiten=$row[0]\" title=\"$textdata[adressbuch_eintrag_bearbeiten]\">
     <img src=\"./bilder/edit.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   <td style=\"width:10px;\"></td>
   <td style=\"text-align:center;\">
    <a href=\"./editadress.php?bearbeiten=$row[0]&amp;loeschen=1\" title=\"$textdata[adressbuch_eintrag_loeschen]\">
   <img src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   <td style=\"width:10px;\">&nbsp;</td>
   <td style=\"text-align:center;\">
   <a href=\"./stat_anrufer.php?id=$row[0]\" title=\"$textdata[adressbuch_suche_eintraege]\">
   <img src=\"./bilder/search.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
  </tr>
 </table>
";
       
      }
      else
      {
       echo "Leider keine Nummer im Adressbuch gefunden</br>";
      }
    $zugriff_mysql->close_mysql();
   } // ENDE nur nach Rufnummer im Adressbuch zu suchen.
 if ($_POST[suche_rufnummer]=="" && $_POST[suche_auch_rufnummer]!="yes" && $_POST[suche_anrufe_ohne_adressbuch]!="yes" || $_POST[suche_rufnummer]!="" && $_POST[suche_auch_rufnummer]=="yes"  && $_POST[suche_anrufe_ohne_adressbuch]!="yes" ) //suche nur nach anrufen zwischen zwei daten
  {
   $datum1="$_POST[suche_anfang_jahr]-$_POST[suche_anfang_monat]-$_POST[suche_anfang_tag]";
   $datum2="$_POST[suche_ende_jahr]-$_POST[suche_ende_monat]-$_POST[suche_ende_tag]";
   $i=0;
  // echo "<br>Suche nach Anrufen zwischen zwei Daten, ohne Rufnummer...<br><br>";
   echo "
   <CENTER>
   <table border=\"0\" cellpadding=\"1\" cellspacing=\"2\" align=\"center\">
    <tr>
    <td></td>
    <td style=\"text-align:center\">$textdata[stat_anrufer_datum]</td>
    <td style=\"text-align:center\">$textdata[stat_anrufer_uhrzeit]</td>
    <td style=\"width:110px; text-align:center\">$textdata[stat_anrufer_rufnummer]</td>";
  if ($showtyp=="yes") 
    { echo "<td style=\"text-align:center\">$textdata[showstatnew_anrufertyp]</td>"; } 
  if ($show_vorwahl=="yes")
    { echo "<td style=\"text-align:center\">$textdata[showstatnew_aus_ort]</td>"; } 
  if ($show_msn=="yes")
    { echo "<td style=\"text-align:center\">$textdata[stat_anrufer_MSN]</td>"; } 
  echo "<td style=\"text-align:center\">$textdata[showstatnew_name]</td>";
  if ($show_rueckruf=="yes")
   { echo "<td style=\"text-align:center\">$textdata[showstatnew_zurueckrufen]</td>"; } 
  echo "<td style=\"text-align:center\">$textdata[showstatnew_ins_addr]</td>";
  if ($showloeschen=="yes") { echo "<td>$textdata[showstatnew_loeschen]</td>"; }
 echo " </tr>";
   
   

    
    //SQL ABfragen erstellen
    if ($_POST[suche_rufnummer]=="" && $_POST[suche_auch_rufnummer]!="yes") //suche nur nach anrufen zwischen zwei daten
   {
  $query="SELECT * FROM angerufene WHERE  UNIX_TIMESTAMP(datum)>=UNIX_TIMESTAMP('$datum1') AND UNIX_TIMESTAMP(datum)<=UNIX_TIMESTAMP('$datum2') ORDER BY 'id' desc ";
   }
  if ($_POST[suche_rufnummer]!="" && $_POST[suche_auch_rufnummer]=="yes") //suche nach rufnummer zweischen zwei daten
   {
   $query="SELECT * FROM angerufene WHERE  UNIX_TIMESTAMP(datum)>=UNIX_TIMESTAMP('$datum1') AND UNIX_TIMESTAMP(datum)<=UNIX_TIMESTAMP('$datum2') AND rufnummer=$_POST[suche_rufnummer] ORDER BY 'id' desc ";
   }
   if ($_POST[suche_rufnummer]=="" && $_POST[suche_auch_rufnummer]!="yes" && $_POST[suche_msn]!="") //suche nach zwei daten mit msn
    {
     $query="SELECT * FROM angerufene WHERE  UNIX_TIMESTAMP(datum)>=UNIX_TIMESTAMP('$datum1') AND UNIX_TIMESTAMP(datum)<=UNIX_TIMESTAMP('$datum2') AND msn='$_POST[suche_msn]' ORDER BY 'id' desc ";
    }
   if ($_POST[suche_rufnummer]!="" && $_POST[suche_auch_rufnummer]=="yes" && $_POST[suche_msn]!="") 
   {
   $query="SELECT * FROM angerufene WHERE  UNIX_TIMESTAMP(datum)>=UNIX_TIMESTAMP('$datum1') AND UNIX_TIMESTAMP(datum)<=UNIX_TIMESTAMP('$datum2') AND rufnummer=$_POST[suche_rufnummer] AND msn='$_POST[suche_msn]' ORDER BY 'id' desc ";
   }
  //ENDE SQL ABFRAGEN ERSTELLEN   
   

   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   
   $result=$zugriff_mysql->sql_abfrage($query);
   echo "Anrufe gefunden:".mysql_num_rows($result). "<br>";
    while($data=mysql_fetch_row($result))
   {

    //alles zurücksetzten:
    $data[2]=mysql_datum($data[2]);
    $anz_name="";
    $anz_reuckruf="";
    $anz_vorwahl="";
    $anz_insaddr="";
    $anz_statistik="";

    if($i%2==0)
      { $color="$c_color[11]"; }
    else
      { $color="$c_color[12]"; }

    //MSNS überprüfen:
    $show_entry_msns=msns_ueberpruefen($msns,$data[6]);

   $tab_adressbuch =$zugriff_mysql->sql_abfrage("SELECT id,vorname,nachname,tele1,tele2,tele3,handy FROM adressbuch WHERE tele1='$data[1]' OR tele2='$data[1]' OR tele3='$data[1]' OR handy='$data[1]'");
  $adress_data=mysql_fetch_row($tab_adressbuch);
   if ($adress_data==false)
    {
     if ($data[1]=="unbekannt")
      {
        if ($data[5]=="unbekannt")
         {
          $anz_name="<a href=\"./showstatnew.php?unbekannt=yes&amp;einid=$data[0]\">unbekannt</a>";
		  $anz_name1_d="unbekannt";
	 }
	else
	 {
	  $anz_name="$data[5]";
	  $anz_name1_d="$data[5]";
	 }
      } // if data[1]==unbekannt ebde
     else
      {
      //ins adressbuch anzeigen
     $anz_name=$textdata[showstatnew_unbekannt];
     
  //erkenne handyNr oder Festnetznummer:
  $wertaddaddr=handynr_vorhanden($data[1]); 
       

      $anz_insaddr="<a href=\"./addadress.php?$wertaddaddr\"><img src=\"./bilder/1rightarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
      }
    $anz_name1=$anz_name;
    } // if adresse gefunden in DB ENDE
    else
    {
      if ($adress_data[6]==$data[1])
       {
        $full_name="$adress_data[1] $adress_data[2] $textdata[showstatnew_handy]";
       }
      else
       {
       $full_name="$adress_data[1] $adress_data[2]";
       }
     $anz_name1_d=$full_name;
     $anz_name="<a href=\"./adressbuch.php?findnr=$data[1]#find\">$full_name</a>";
     $anz_statistik="<a href=\"./stat_anrufer.php?id=$adress_data[0]\" title=\"$textdata[showstatnew_zeige_anrufstat] $adress_data[1] $adress_data[2]\">
      <img  src=\"./bilder/data.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
    } // else ende adresse in DB gefunden
   $d_name=base64_encode($anz_name1_d);
   $d_uhrzeit=base64_encode($data[3]);
   $d_datum=base64_encode($data[2]);
   $anz_rueckruf="<a href=\"./zurueckruf.php?add=yes&amp;addname=$d_name&amp;addrufnummer=$data[1]&amp;zuhrzeit=$d_uhrzeit&amp;zdatum=$d_datum\">
   <img src=\"./bilder/1leftarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";

//show_vorwahl ende   
if ($show_vorwahl=="yes")
 {
  $anz_vorwahl=$data[7];
 }
//MSN zu Name
$anz_msn=msnzuname($data[6]);

// Anruftyp bzw Dienstkennung erkennen:
$anz_dienst=ermittle_typ_anruf($data[8]);




// SCHREIBE DATEN in TABELLE:
//datenblock in eine Variable schreiben:
$vorwahl_data="";
$msn_data="";
$rueckruf_data="";
$anruftyp="";
$anruf_loeschen="";
 if ($show_vorwahl=="yes") 
     { $vorwahl_data="<td style=\"text-align:center\">$anz_vorwahl</td>";  }
 if ($show_msn=="yes") 
     { $msn_data="<td>$anz_msn</td>";  }
 if ($show_rueckruf=="yes") 
     { $rueckruf_data="<td style=\"text-align:center\">$anz_rueckruf</td>";  }
 if ($showtyp=="yes")
     { $anruftyp="<td style=\"text-align:center\">$anz_dienst</td>"; }
 if ($showloeschen=="yes")
     { $anruf_loeschen="<td style=\"text-align:center\"><a href=\"./stat_loeschen.php?id=$data[0]$loeschen_seiten\" title=\"$textdata[showstatnew_loesche_db]\">
 <img  src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>"; }
 
 
 $ALL="<tr style=\"background-color:$color\">
       <td>$anz_statistik</td>
       <td style=\"text-align:center\">$data[2]</td>
       <td style=\"text-align:center\">$data[3]</td>
       <td style=\"text-align:center\">$data[1]</td>
       $anruftyp
       $vorwahl_data
       $msn_data
       <td style=\"text-align:center\">$anz_name</td>
       $rueckruf_data
       <td style=\"text-align:center\">$anz_insaddr</td>
       $anruf_loeschen
       </tr>";
   

  echo "$ALL"; 
  $i++;   


} // ENDE WHILE angerufene
echo "</table>"; 
$zugriff_mysql->close_mysql();
}//suche nur nach anrufen zwischen zwei daten ENDE

  
//suche anrufe die keinen Eintrag im Adressbuch hat
if(isset($_POST[suche_anrufe_ohne_adressbuch]))
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );

  if ($_POST[suche_nur_msn]=="yes")
   {
    $sqlquery="SELECT * FROM angerufene WHERE rufnummer!='unbekannt' AND msn='$_POST[suche_msn]' ORDER BY 'id' desc";
   }
  else
   {
    $sqlquery="SELECT * FROM angerufene WHERE rufnummer!='unbekannt' ORDER BY 'id' desc";
   }
  $result=$zugriff_mysql->sql_abfrage($sqlquery);
  
  //echo "<br>Suche alle anrufe ohne nummer im ADDR";
   echo "
   <CENTER>
   <table border=\"0\" cellpadding=\"1\" cellspacing=\"2\" align=\"center\">
    <tr>
    <td></td>
    <td style=\"text-align:center\">$textdata[stat_anrufer_datum]</td>
    <td style=\"text-align:center\">$textdata[stat_anrufer_uhrzeit]</td>
    <td style=\"width:110px; text-align:center\">$textdata[stat_anrufer_rufnummer]</td>";
  if ($showtyp=="yes") 
    { echo "<td style=\"text-align:center\">$textdata[showstatnew_anrufertyp]</td>"; } 
  if ($show_vorwahl=="yes")
    { echo "<td style=\"text-align:center\">$textdata[showstatnew_aus_ort]</td>"; } 
  if ($show_msn=="yes")
    { echo "<td style=\"text-align:center\">$textdata[stat_anrufer_MSN]</td>"; } 
  echo "<td style=\"text-align:center\">$textdata[showstatnew_name]</td>";
  if ($show_rueckruf=="yes")
   { echo "<td style=\"text-align:center\">$textdata[showstatnew_zurueckrufen]</td>"; } 
  echo "<td style=\"text-align:center\">$textdata[showstatnew_ins_addr]</td>";
  if ($showloeschen=="yes") { echo "<td>$textdata[showstatnew_loeschen]</td>"; }
 echo " </tr>";
 
   while($data=mysql_fetch_row($result))
    {
     //data[1]==rufnummer
    $data[2]=mysql_datum($data[2]);
    $anz_name="";
    $anz_reuckruf="";
    $anz_vorwahl="";
    $anz_insaddr="";
    $anz_statistik="";
    $anz_typ="";


    if($i%2==0)
      { $color=$c_color[11]; }
    else
      { $color=$c_color[12]; }

  
     
       $result_adresse=mysql_query("SELECT id,vorname,nachname,tele1,tele2,tele3,handy FROM adressbuch WHERE tele1='$data[1]' OR tele2='$data[1]' OR tele3='$data[1]' OR handy='$data[1]'");
       $adress_data=mysql_fetch_row($result_adresse);
       if($adress_data==false)
        {
	 $anz_name="unbekannt";
	  //erkenne handyNr oder Festnetznummer:
	$wertaddaddr=handynr_vorhanden($data[1]); 

      $anz_insaddr="<a href=\"./addadress.php?$wertaddaddr\"><img src=\"./bilder/1rightarrow.gif\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a>";
      if ($show_vorwahl=="yes")
   {
   	  $anz_vorwahl=$data[7];

    }//show_vorwahl ende
//MSN zu Name
$anz_msn=msnzuname($data[6]);
// Anruftyp bzw Dienstkennung erkennen:
$anz_dienst=ermittle_typ_anruf($data[8]);

   // SCHREIBE DATEN in TABELLE:
   //datenblock in eine Variable schreiben:
$vorwahl_data="";
$msn_data="";
$rueckruf_data="";
$anruftyp="";
$anruf_loeschen="";
 if ($show_vorwahl=="yes") 
     { $vorwahl_data="<td style=\"text-align:center\">$anz_vorwahl</td>";  }
 if ($show_msn=="yes") 
     { $msn_data="<td>$anz_msn</td>";  }
 if ($show_rueckruf=="yes") 
     { $rueckruf_data="<td style=\"text-align:center\">$anz_rueckruf</td>";  }
 if ($showtyp=="yes")
     { $anruftyp="<td style=\"text-align:center\">$anz_dienst</td>"; }
 if ($showloeschen=="yes")
     { $anruf_loeschen="<td style=\"text-align:center\"><a href=\"./stat_loeschen.php?id=$data[0]$loeschen_seiten\" title=\"$textdata[showstatnew_loesche_db]\">
 <img  src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>"; }
 
 
 $ALL="<tr style=\"background-color:$color\">
       <td>$anz_statistik</td>
       <td style=\"text-align:center\">$data[2]</td>
       <td style=\"text-align:center\">$data[3]</td>
       <td style=\"text-align:center\">$data[1]</td>
       $anruftyp
       $vorwahl_data
       $msn_data
       <td style=\"text-align:center\">$anz_name</td>
       $rueckruf_data
       <td style=\"text-align:center\">$anz_insaddr</td>
       $anruf_loeschen
       </tr>";
   


  
      echo "$ALL"; $i++; 

	} //ENDE wenn nummer nicht im ADDR
    }
  echo "</table>"; 
 $zugriff_mysql->close_mysql();
 }
//suche anrufe die keinen Eintrag im Adressbuch hat ENDE
  
 }//ende isset $_POST[suchen]
?>


<?php
include("./footer.inc.php");
?>
