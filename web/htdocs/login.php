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
include("./conf.inc.php");
include("./func.inc.php");
include("./header.inc.php");
$loginok=0;

if (isset($_POST['absenden']))
{
mysql_connect($host, $dbuser, $dbpasswd);
$userliste=mysql_db_query($db, "SELECT * FROM userliste");
$nummer=mysql_numrows($userliste);
for ($i = 0; $i < $nummer;$i++)
 {
  $username = mysql_result($userliste, $i, "username");
   if ($username == $_POST['login_name'])
    {
   //  print("<BR />Username gleich.<BR />");
     $passwd = mysql_result($userliste, $i, "passwd");
     if ($passwd == md5($_POST['login_passwd']))
      {
  //    print("<BR />PASSWd gleich<BR />");
      $id = mysql_result($userliste, $i, "id");
      $name = mysql_result($userliste, $i, "name");
      $loginok=1;
 //     print("<BR />1.) LoginOK: $loginok");
     if ($login_name=="admin") { $loginok=0; }
      break;
      }

    }

 }
mysql_close();
//echo "2.) LoginOk: $loginok";
if ($loginok == 1)
 {
 //print("<BR />In loginok==1<BR />");
  echo "$wieviel ";
  $datum = date("d.m.Y");
  $uhrzeit = date("G:i:s");
  mysql_connect($host, $dbuser, $dbpasswd);
  $res1=mysql_db_query($db, "UPDATE userliste SET lastlogin_d='$datum' WHERE id=$id");
  $res2=mysql_db_query($db, "UPDATE userliste SET lastlogin_t='$uhrzeit' WHERE id=$id");
  mysql_close();
  $username_c = md5($username);
  $passwd_c   = md5($passwd);
  echo "<meta http-equiv=\"refresh\" content=\"1; URL=./login1.php?use=$username_c&amp;pas=$passwd_c&amp;name=$name&amp;seite=$_POST[seite]&amp;wieviel=$_POST[wieviel]\">";
 }
if ($loginok == 0)
 {
  echo "
  <center>$text[falslogin]<BR /></center>
  <meta http-equiv=\"refresh\" content=\"5; URL=./login.php\"><BR />";
  include("./footer.inc.php");
  exit();
 }

}// if isset ende

if ($loginok == 0)
{

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
  <td colspan=\"3\"><center><INPUT name=\"absenden\" value=\"$text[login]\" type=\"submit\"></center></td>
 </tr>

</FORM>
</table>
</center>


";
}
include("./footer.inc.php");
?>
