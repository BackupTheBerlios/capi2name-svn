<?php
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
session_start();
include("../includes/conf.inc.php");
include("../includes/functions.php");
include("./header.inc.php");
 
if (isset($_POST['login']))
{
$passwd=$_POST['login_passwd'];
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$dataB->sql_query("SELECT username,passwd FROM users WHERE username='admin'");

if ($result_userlist && $passwd!="")
  {
   $row_userlist=$dataB->sql_fetch_assoc($result_userlist);
    if (md5($passwd)==$row_userlist['passwd'])
    {
     $_SESSION['adminpassword']=md5($passwd);
     echo "<span class=\"blau_mittig\">Login: OK.... forwording you.......</span><br/>";
     echo "<meta http-equiv=\"refresh\" content=\"2; URL=index.php\">";
    } 
   else
    {
     echo "<span class=\"rot_mittig\">Password is wrong.<br/> Please go back and try it again!</span><br/>";
    }
   }
else
   {
    echo "<span class=\"rot_mittig\">Password field is empty or SQL querry returned an error.</span>";
   } 
$dataB->sql_close();
}//absenden ende
?>
