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
session_start(); 
include("./header.inc.php");
$loginok=0;

if (isset($_POST['absenden']))
{

$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result_userlist=$zugriff_mysql->sql_abfrage("SELECT id,username,passwd,name FROM userliste WHERE username='".$_POST['login_name']."'");
 if ($result_userlist && $_POST['login_name']!="" && $_POST['login_passwd']!="")
  {
  $row_userlist=mysql_fetch_array($result_userlist);
    if (md5($_POST['login_passwd'])==$row_userlist['passwd'])
    {
     
     echo "PASSWD Richtig... Sie werden weitergeleitet...";
     $seite=base64_decode($_POST['seite']);
     if ($_POST['remember_login']=="on")
      {
       $_SESSION['remember_login']=true;
      }
     $_SESSION['realname']=$row_userlist['name'];
     $_SESSION['username']=$_POST['login_name'];
     $_SESSION['password']=$row_userlist['passwd'];
    //$_SESSION['id']=$row_userlist['id'];
     $loginok=1;
     echo "<meta http-equiv=\"refresh\" content=\"2; URL=./$seite\">";
    }
    else
    {
    $loginok=0;
    }
  }
 else
  {
   $loginok=0;
  }
$zugriff_mysql->close_mysql();

}
else
 {
  echo "Falscher Aufruf...... EXIT";
  include("./footer.inc.php");
  exit();
 }

include("./footer.inc.php");
?>
