<?
/*
    copyright            : (C) 2002,2005 by Jonas Genannt
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
session_start();
include("../conf.inc.php");
include("../func.inc.php");
include("./header.inc.php");
 

if (isset($_POST['absenden']))
{
$passwd=$_POST['login_passwd'];
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$zugriff_mysql->sql_abfrage("SELECT username,passwd FROM userliste WHERE username='admin'");

if ($result_userlist && $passwd!="")
  {
  $row_userlist=mysql_fetch_array($result_userlist);
    if (md5($passwd)==$row_userlist['passwd'])
    {
     $_SESSION['adminpassword']=md5($passwd);
     echo "<center>Login: OK.... forwording you.......<br/>";
     echo "<meta http-equiv=\"refresh\" content=\"2; URL=index.php\">";
    } 
   else
    {
     echo "<center>Passwd Falsch.....<br/></center>";
    }
 }

$zugriff_mysql->close_mysql();
}//absenden ende







?>
