<?
/*
    copyright            : (C) 2002,2003 by Jonas Genannt
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
include("../conf.inc.php");
if (isset($_POST['absenden']))
{
mysql_connect($host, $dbuser, $dbpasswd);
$userliste=mysql_db_query($db, "SELECT id,username, passwd FROM userliste WHERE id=1");
$daten=mysql_fetch_array($userliste);
$id=$daten[id];
if ("admin"==$daten[username])
 {
  if (md5($_POST[login_passwd])==$daten[passwd])
   {
   // echo "LOGIN OK";
    $loginok=1;
   }
   else
    {
   // echo "LOGIN Failed!";
    $loginok=0;
    }
 }
 else
 {
// echo "LOGIN Failed!";
 $loginok=0;
 }









if ($loginok == "1")
 {

  $username_c = md5($daten[username]);
  $passwd_c   = md5($daten[passwd]);
  echo "<meta http-equiv=\"refresh\" content=\"2; URL=./login1.php?use=$username_c&pas=$passwd_c&seite=$_GET[seite]\">";
 }
}// if isset ende


?>
