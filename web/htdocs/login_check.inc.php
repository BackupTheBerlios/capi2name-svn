<?
include("./conf.inc.php");
include("./func.inc.php");
session_start(); 
$realname=$_SESSION['realname'];
$username=$_SESSION['username']; 
$password=$_SESSION['password'];
$login_ok=0;



$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$zugriff_mysql->sql_abfrage("SELECT * FROM userliste WHERE username='$username'");

 if ($result_userlist && $username!="" && $password!="")
  {
  $row_userlist=mysql_fetch_array($result_userlist);
    if ($password==$row_userlist['passwd'])
    {
     echo "PASSWD Richtig...";
     $login_ok=1;
     //Usersettings auslesen und in $userconfig[] schreiben...
     $userconfig['anzahl']=$row_userlist['anzahl'];
     $userconfig['msns' ]=$row_userlist['msns'];
     if ($row_userlist['showrueckruf ']=="checked")
      {
       $userconfig['showrueckruf']=true;
      }
     else
      {
       $userconfig['showrueckruf']=false;
      }
     if ($row_userlist['shownotiz']=="checked" ) 
      {
       $userconfig['shownotiz']=true;
      }
     else
      {
       $userconfig['shownotiz']=false;
      }
     if ($row_userlist['showvorwahl']=="checked")
      {
       $userconfig['showvorwahl']=true;
      }
     else
      {
       $userconfig['showvorwahl']=false;
      }
     if ($row_userlist['showmsn']=="checked")
      {
       $userconfig['showmsn']=true;
      }
     else
      {
       $userconfig['showmsn']=false;
      }
     if ($row_userlist['showconfig']=="checked")
      {
       $userconfig['showconfig']=true;
      }
     else
      {
       $userconfig['showconfig']=false;
      }
     if ($row_userlist['showtyp']=="checked")
      {
       $userconfig['showtyp']=true;
      }
     else
      {
       $userconfig['showtyp']=false;
      }
     if ($row_userlist['loeschen']=="checked")
      {
       $userconfig['loeschen']=true;
      }
     else
      {
       $userconfig['loeschen']=false;
      }
     
    }//if passwd OK
   else
    {
     $login_ok=0;
    }
  }//if username es gibt
 else
  {
   $login_ok=0;
  }
  
$zugriff_mysql->close_mysql();


/*
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

*/


//printf("ENDE: CHECK: Loginok: $loginok");
if ($login_ok == 0)
 {
 include("./header.inc.php");
  echo "
<div class=\"ueberschrift_seite\">Login</div>


<form action=\"./login.php\" method=\"post\">
<table border=\"0\" style=\"margin-right:auto;margin-left:auto;text-align:left\">
 <tr>
  <td>$text[username]</td>
  <td style=\"width:5px\"></td>
  <td><input name=\"login_name\" type=\"text\"/></td>
 </tr>
 <tr>
  <td>$text[passwd]</td>
  <td style=\"width:5px\"></td>
  <td><input name=\"login_passwd\" type=\"password\"/></td>
 </tr>
  <tr>
  <td colspan=\"3\" style=\"text-align:center;\"><input name=\"seite\" type=\"hidden\" value=\"$seite\"/>
   <input name=\"absenden\" value=\"$text[login]\" type=\"submit\"/></td>
 </tr>

</form>
</table>


";


 include("./footer.inc.php");
 exit();
 }

?>
