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
$seite=base64_encode("stat_loeschen.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>

<div class="ueberschrift_seite"><? echo "$text[stat_loeschen]"; ?></div>
<br /><br />
<?
//ob er die Page anschauen darf:
 if (!$userconfig['loeschen'])
  {
   echo "<div class=\"rot_mittig\">$text[nichtberechtigt]</div>";
   include("./footer.inc.php");
   die();
  }
?>
<br />
<?
if (isset($_POST[btn_loeschen]))
  {
   //Eintrag löschen:
   $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $res=$zugriff_mysql->sql_abfrage("DELETE FROM angerufene WHERE id=$_POST[id]");
   $zugriff_mysql->close_mysql();
     if ($_POST[datum]!="")
      {
       $datum="?datum=$_POST[datum]";
      }
    else
      {
       $datum="";
      }
 if ($res == 1)
  {
  echo "<div class=\"blau_mittig\">Eintrag erfolgreich gelöscht, Sie werden in 2sec weitergeleitet.</div>";
  echo "<meta http-equiv=\"refresh\" content=\"2; URL=./showstatnew.php$datum\">";
  }
  }
?>



<?
if (isset($_GET[id]))
  {
   echo "<div class=\"rot_mittig\">Soll dieser Eintrag mit ID $_GET[id] gelöscht werden?&nbsp;-Zum Löschen einfach nochmal auf \"Löschen\" klicken!</div>";
    $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
    $result=$zugriff_mysql->sql_abfrage("SELECT * FROM angerufene WHERE id=$_GET[id]");
    $zugriff_mysql->close_mysql();
    $daten=mysql_fetch_array($result);
    $datum=mysql_datum($daten[datum]);
     echo "
     <br />
      <table border=\"0\" style=\"margin-right:auto;margin-left:auto;\">
        <tr>
	  <td>ID</td>
	  <td style=\"text-align:center\">Datum</td>
	  <td style=\"text-align:center\">Uhrzeit</td>
	  <td style=\"text-align:center\">Rufnummer</td>
	</tr>
	<tr>
	 <td style=\"text-align:center\">$daten[id]</td>
	 <td style=\"text-align:center\">$datum</td>
	 <td style=\"text-align:center\">$daten[uhrzeit]</td>
	 <td style=\"text-align:center\">$daten[rufnummer]</td>
	</tr>
      </table>
     ";


   echo "<br />
    <form action=\"stat_loeschen.php\" method=\"post\">
    <ins>
      <input type=\"hidden\" name=\"id\" value=\"$_GET[id]\"/>
      <input type=\"hidden\" name=\"datum\" value=\"$_GET[datum]\"/>
      <input type=\"submit\" name=\"btn_loeschen\" value=\"Löschen\"/>
     </ins>
    </form>
   ";

  }
?>



<?
include("./footer.inc.php");
?>
