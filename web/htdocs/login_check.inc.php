<?
include("./conf.inc.php");
include("./func.inc.php");

// $login_name aus cookie und login_passwd aus cookie auslesen als md5 verschluesselt.
$login_name="";
$login_passwd="";
$login_name =$_COOKIE['ck_username'];
$login_passwd =$_COOKIE['ck_passwd'];
$loginok="0";
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$userliste=$zugriff_mysql->sql_abfrage("SELECT * FROM userliste");
$nummer=mysql_numrows($userliste);
for ($i = 0; $i < $nummer;$i++)
 {
  $username = mysql_result($userliste, $i, "username");
  $username = md5($username);
   if ($username == $login_name)
    {
   //  print("check: Username OK");
     $passwd = mysql_result($userliste, $i, "passwd");
     $passwd = md5($passwd);
     if ($passwd == $login_passwd)
      {
   //   print ("check: passwd OK");
      $loginok="1";
      if ($login_name="admin") { $loginok=1; }
      $id = mysql_result($userliste, $i, "id");
      $zeigteintrage=mysql_result($userliste, $i, "anzahl");
      $msns=mysql_result($userliste, $i, "msns");
      $wert=mysql_result($userliste, $i, "showrueckruf");
       if ($wert=="checked") { $show_rueckruf="yes"; }
       else { $show_rueckruf="no"; }

      $wert=mysql_result($userliste, $i, "shownotiz");
       if ($wert=="checked") { $shownotiz="yes"; }
       else { $shownotiz="no"; }

      $wert=mysql_result($userliste, $i, "showvorwahl");
       if ($wert=="checked") { $show_vorwahl="yes"; }
       else { $show_vorwahl="no"; }

     $wert=mysql_result($userliste, $i, "showmsn");
      if ($wert=="checked") { $show_msn="yes"; }
      else { $show_msn="no"; }

     $wert=mysql_result($userliste, $i, "showconfig");
      if ($wert=="checked") { $showconfig="yes"; }
      else { $showconfig="no"; }

     $wert=mysql_result($userliste, $i, "showtyp");
      if ($wert=="checked") { $showtyp="yes"; }
      else { $showtyp="no"; }

      $wert=mysql_result($userliste, $i, "loeschen");
      if ($wert=="checked") { $showloeschen="yes"; }
      else { $showloeschen="no"; }
      }

    }

 }
$zugriff_mysql->close_mysql();
//printf("ENDE: CHECK: Loginok: $loginok");
if ($loginok == 0)
 {
 include("./header.inc.php");
  echo "
<div align=\"center\"><h2>$text[login]</h2></div><BR />

<FORM action=\"./login.php\" method=\"post\">
<center>
<table border=\"0\">
 <tr>
  <td>$text[username]</td>
  <td width=\"5\"></td>
  <td><INPUT name=\"login_name\" type=\"text\"></td>
 </tr>
 <tr>
  <td>$text[passwd]</td>
  <td width=\"5\"></td>
  <td><INPUT name=\"login_passwd\" type=\"password\"></td>
 </tr>
 <tr>
  <td>$text[login1]</td>
  <td width=\"5\"></td>
  <td><input type=\"radio\" name=\"wieviel\" value=\"2\">$text[login2]<BR />

  <input type=\"radio\" name=\"wieviel\" value=\"0\">$text[login3]<BR />$text[login4]</td>
 </tr>
  <tr>
  <td colspan=\"3\"><center><INPUT name=\"seite\" type=\"hidden\" value=\"$seite\"><INPUT name=\"absenden\" value=\"$text[login]\" type=\"submit\"></center></td>
 </tr>

</FORM>
</table>
</center>


";


 include("./footer.inc.php");
 exit();
 }

?>
