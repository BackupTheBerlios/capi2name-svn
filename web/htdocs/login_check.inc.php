<?
include("./conf.inc.php");
include("./func.inc.php");
session_start(); 
$realname=$_SESSION['realname'];
$username=$_SESSION['username']; 
$password=$_SESSION['password'];
$login_ok=0;

if ($_SESSION['remember_login'])
 {
  setcookie("ck_username",$username, time()+172800000 );  
  setcookie("ck_passwd",$password, time()+172800000 );  
  setcookie("ck_realname",$realname, time()+172800000 );  
  $_SESSION['remember_login']=false;
 }

if ($_COOKIE['ck_username']!="" && $_COOKIE['ck_passwd']!="" && $_COOKIE['ck_realname']!="")
 {
  $_SESSION['realname']=$_COOKIE['ck_realname'];
  $_SESSION['username']=$_COOKIE['ck_username']; 
  $_SESSION['password']=$_COOKIE['ck_passwd'];
  $realname=$_SESSION['realname'];
  $username=$_SESSION['username']; 
  $password=$_SESSION['password'];
 }



$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$zugriff_mysql->sql_abfrage("SELECT * FROM userliste WHERE username='$username'");

 if ($result_userlist && $username!="" && $password!="")
  {
  $row_userlist=mysql_fetch_array($result_userlist);
    if ($password==$row_userlist['passwd'])
    {
    // echo "PASSWD Richtig...";
     $login_ok=1;
     //Usersettings auslesen und in $userconfig[] schreiben...
     $userconfig['anzahl']=$row_userlist['anzahl'];
     $userconfig['msns']=$row_userlist['msns'];
     if ($row_userlist['showrueckruf']=="checked")
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
      //update lastlogin_d and lastlogin_t
      //UPDATE capi_version SET version='0.6.7.2' WHERE id='1'
      $datum=mysql_fetch_array($zugriff_mysql->sql_abfrage("SELECT lastlogin_d FROM userliste WHERE username='$username'"));
     if ($datum[lastlogin_d]!=date("Y-m-d"))
       {
      $zugriff_mysql->sql_abfrage("UPDATE userliste SET lastlogin_t=NOW() WHERE username='$username'");
      $zugriff_mysql->sql_abfrage("UPDATE userliste SET lastlogin_d=NOW() WHERE username='$username'");
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
  <td colspan=\"3\"><input name=\"remember_login\" type=\"checkbox\"/> Eingeloggt bleiben</td>
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
