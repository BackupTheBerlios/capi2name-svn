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

<div align="center"><h2><? echo "$text[stat_loeschen]"; ?></h2></div>
<br /><br />
<?
//ob er die Page anschauen darf:
 if ($showloeschen=="no")
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
   mysql_connect($host,$dbuser, $dbpasswd);
    mysql_select_db($db);
    $res=mysql_query("DELETE FROM angerufene WHERE id=$_POST[id]");
   mysql_close();
     if ($_POST[datum]!="")
      {
       $datum="?datum=$_POST[datum]";
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
   echo "<div class=\"rot_mittig\">Soll dieser Eintrag mit ID $_GET[id] gelöscht werden?</b> &nbsp;-Zum Löschen einfach nochmal auf \"Löschen\" klicken!</div>";
   mysql_connect($host,$dbuser, $dbpasswd);
    mysql_select_db($db);
    $result=mysql_query("SELECT * FROM angerufene WHERE id=$_GET[id]");
    $daten=mysql_fetch_array($result);
    $datum=mysql_datum($daten[datum]);
     echo "
     <center><br />
      <table border=\"0\">
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
      </table></center>
     ";
   mysql_close();

   echo "<br /><center>
    <form action=\"stat_loeschen.php\" method=\"POST\">
      <input type=\"hidden\" name=\"id\" value=\"$_GET[id]\">
      <input type=\"hidden\" name=\"datum\" value=\"$_GET[datum]\">
      <input type=\"submit\" name=\"btn_loeschen\" value=\"Löschen\">
    </form>
   </center>";

  }
?>



<?
include("./footer.inc.php");
?>
