<?
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
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
include("../includes/conf.inc.php");
include("../includes/functions.php");
session_start(); 
$password=$_SESSION['adminpassword'];
$login_ok=0;



$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$zugriff_mysql->sql_abfrage("SELECT username,passwd FROM users WHERE username='admin'");

 if ($result_userlist && $password!="")
  {
  $row_userlist=mysql_fetch_assoc($result_userlist);
    if ($password==$row_userlist['passwd'])
    {
    // echo "PASSWD Richtig...";
     $login_ok=1;
     
      
     
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





//printf("ENDE: CHECK: Loginok: $loginok");
if ($login_ok == 0)
 {
 include("./header.inc.php");
  echo "
<center><h3>Login</h3>


<form action=\"./login.php\" method=\"post\">
<table border=\"0\" >

 <tr>
  <td>Password:</td>
  <td style=\"width:5px\"></td>
  <td><input name=\"login_passwd\" type=\"password\"/></td>
 </tr>
  <tr>
  <td colspan=\"3\" style=\"text-align:center;\">
   <input name=\"absenden\" value=\"Login to Admin-Interface\" type=\"submit\"/></td>
 </tr>

</form>
</table>
</center>

";


 include("./footer.inc.php");
 exit();
 }

?>
