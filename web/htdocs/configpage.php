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
$seite=base64_encode("configpage.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>

<? echo "<div class=\"ueberschrift_seite\">$textdata[configpage_konfiguration]</div>"; ?>
<br />
<?
//ob er die Page anschauen darf:
 if ($showconfig=="no")
  {
   echo "<div class=\"rot_mittig\">$textdata[configpage_nicht_berechtigt]</div>";
   include("./footer.inc.php");
   die();
  }
?>


<?
// Einstellungen speichern ANFANG
if ($_POST[speichern])
{

  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
  if ($_POST[aendern]=="on")
  {

   $result=$zugriff_mysql->sql_abfrage("SELECT passwd FROM userliste WHERE id=$id");
    $data=mysql_fetch_array($result);
     if ($data[passwd]==md5($_POST[altespassword]))
      {
       echo "<div class=\"blau_mittig\">$textdata[configpage_altes_passwd_gleich]</div>";
        if ($_POST[password1]==$_POST[password2])
	 {
          $verschluesselt=md5($_POST[password2]);
	  echo "<div class=\"blau_mittig\">$textdata[configpage_neues_passwd_gleich]</div>";
	  $result=mysql_db_query($db, "UPDATE userliste SET passwd='$verschluesselt' WHERE id=$id");
             if ($result==1)
	     { echo "<div class=\"blau_mittig\">$textdata[configpage_geaendert_ok]</div>";
	      }
	      else
	       {
		echo "<div class=\"rot_mittig\">$textdata[configpage_geaendert_failed]</div>>";
	       }

	 }
	 else { echo "<div class=\"rot_mittig\">$textdata[configpage_neues_passwd_failed]</div>"; }
      }
     else { echo "<div class=\"rot_mittig\">$textdata[configpage_altes_passwd_failed]</div>"; }
} // ENDE PASSWD ändern!!!

   $result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET name='$_POST[neuername]' WHERE id=$id");
    if ($result==1)
    {
    echo "<div class=\"blau_mittig\">$textdata[configpage_name_geaendert_ok]</div>";
    }
    else
    {echo "<div class=\"rot_mittig\">$textdata[configpage_name_geaendert_failed]</div>";
    }

  $result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET anzahl='$_POST[neueanzahl]' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_anzahl_geaendert_ok]</div>"; }
  else
  { echo "<div class=\"rot_mittig\">$textdata[configpage_anzahl_geaendert_failed]</div>";  }

if ($_POST[zeigerueckruf]=="on")
 {
  $wert="checked";
 }
 else { $wert=""; }
$result=$zugriff_mysql->sql_abfrage( "UPDATE userliste SET showrueckruf='$wert' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_option_rueckruf_ok]</div>"; }
else
{
echo "<div class=\"rot_mittig\">$textdata[configpage_option_rueckruf_failed]</div>";
}

if ($_POST[zeigenotiz]=="on")
 {
  $wert="checked";
 }
 else { $wert=""; }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET shownotiz='$wert' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_option_notiz_ok]</div>"; }
else
{ echo "<div class=\"rot_mittig\">$textdata[configpage_option_notiz_failed]</div>"; }


if ($_POST[zeigevorwahl]=="on")
 {
  $wert="checked";
 }
 else { $wert=""; }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET showvorwahl='$wert' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_option_ausOrt_ok]</div>"; }
else
{ echo "<div class=\"rot_mittig\">$textdata[configpage_option_ausOrt_failed]</div>"; }


if ($_POST[zeigemsn]=="on")
 {
  $wert="checked";
 }
 else { $wert=""; }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET showmsn='$wert' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_option_msn_ok]</div>"; }
    else
    {
    echo "<div class=\"rot_mittig\">$textdata[configpage_option_msn_failed]</div>";
    }

if ($_POST[zeigetyp]=="on")
 {
  $wert="checked";
 }
 else { $wert=""; }
$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET showtyp='$wert' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_option_dienst_ok]</div>"; }
    else
    {
    echo "<div class=\"rot_mittig\">$textdata[configpage_option_dienst_failed]</div>";
    }




$result=$zugriff_mysql->sql_abfrage("UPDATE userliste SET msns='$_POST[zmsns]' WHERE id=$id");
    if ($result==1) { echo "<div class=\"blau_mittig\">$textdata[configpage_msn_ok]</div>"; }
    else
    { echo "<div class=\"rot_mittig\">$textdata[configpage_msn_failed]</div>"; }

  $zugriff_mysql->close_mysql();
}
// Einstellungen speichern ENDE
?>



<?
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$zugriff_mysql->sql_abfrage("SELECT username,passwd,name,lastlogin_d, lastlogin_t, anzahl, showrueckruf, shownotiz,msns,showvorwahl,showmsn,showtyp FROM userliste WHERE id= $id ");
 $daten=mysql_fetch_array($result);

$zugriff_mysql->close_mysql();

echo "
<center>
<form action=\"$SELF_PHP\" method=\"post\">
<table border=\"0\">
 <tr>
  <td>$textdata[configpage_username]:</td>
  <td style=\"width:10px;\">&nbsp;</td>
  <td>$daten[username]</td>
 </tr>
 <tr>
  <td>$textdata[configpage_passwort_aendern]:</td>
  <td style=\"width:10px;\">&nbsp;</td>
  <td><input type=\"checkbox\" name=\"aendern\"></td>
 </tr>
 <tr>
  <td>$textdata[configpage_altes_passwd]:</td>
  <td style=\"width:10px;\">&nbsp;</td>
  <td><input type=\"password\" name=\"altespassword\"></td>
 <tr>
  <td>$textdata[configpage_neues_passwd]:<BR />$textdata[configpage_wiederholen]:</td>
  <td style=\"width:10px;\">&nbsp;</td>
  <td><input type=\"password\" name=\"password1\"><BR /><input type=\"password\" name=\"password2\"></td>
 </tr>
 <tr>
  <td>$textdata[configpage_voller_name]:</td>
  <td style=\"width:10px;\">&nbsp;</td>
  <td><input type=\"text\" name=\"neuername\" value=\"$daten[name]\"></td>
 </td>
 <tr>
   <td>$textdata[configpage_zeige_letzte_anrufe]:</td>
   <td style=\"width:10px;\">&nbsp;</td>
   <td><input type=\"text\" name=\"neueanzahl\" value=\"$daten[anzahl]\" maxlength=\"5\" size=\"10\"></td>
 </tr>
<tr>
 <td>$textdata[configpage_zeige_rueckruf]:</td>
 <td style=\"width:10px;\">&nbsp;</td>
 <td><input type=\"checkbox\", name=\"zeigerueckruf\" name=\"reuckruf\" $daten[showrueckruf] ></td>
</tr>
<tr>
 <td>$textdata[configpage_zeige_notiz]:</td>
 <td style=\"width:10px;\">&nbsp;</td>
 <td><input type=\"checkbox\", name=\"zeigenotiz\" name=\"notiz\" $daten[shownotiz] ></td>
</tr>
<tr>
 <td>$text[option_splate_vorwahl]</td>
 <td style=\"width:10px;\">&nbsp;</td>
 <td><input type=\"checkbox\", name=\"zeigevorwahl\" name=\"vorwahl\" $daten[showvorwahl] ></td>
</tr>

<tr>
 <td style=\"vertical-align:top;\">$text[zeige_typ]</td>
 <td style=\"width:10px;\">&nbsp;</td>
 <td><input type=\"checkbox\", name=\"zeigetyp\" name=\"typ\" $daten[showtyp] ></td>
</tr>


<tr>
 <td>$text[option_splate_msn]</td>
 <td style=\"width:10px;\">&nbsp;</td>
 <td><input type=\"checkbox\", name=\"zeigemsn\" name=\"msn\" $daten[showmsn] ></td>
</tr>

<tr>
 <td style=\"vertical-align:top;\">$text[zeige_msns]</td>
 <td style=\"width:10px;\">&nbsp;</td>
 <td><input type=\"text\" name=\"zmsns\" value=\"$daten[msns]\"><br />$text[warnung_msns]
 </td>
</tr>





</table>
</center>

<input type=\"hidden\" value=\"$id\" >
<br />
<span style=\"text-align:center;\">
 <input type=\"submit\" name=\"speichern\" value=\"$text[speichern]\">
</span>


</form>";
?>


<?
include("./footer.inc.php");
?>
