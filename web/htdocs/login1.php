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
//echo "Username: $_GET[use]";
//echo "Passwd: $_GET[pas]";
  if ($_GET[wieviel]=="0") // fuer immer
   {
   setcookie("ck_username",$_GET['use'], time()+172800000 );
   setcookie("ck_passwd",$_GET['pas'], time()+172800000 );
   setcookie("ck_name",$_GET['name'], time()+172800000 );
   }
  elseif ($_GET[wieviel]=="2")    // 2 Tage
   {
   setcookie("ck_username",$_GET['use'], time()+172800 );
   setcookie("ck_passwd",$_GET['pas'], time()+172800 );
   setcookie("ck_name",$_GET['name'], time()+172800 );
   }
else { // gleich addeee
setcookie("ck_username",$_GET['use'] );
setcookie("ck_passwd",$_GET['pas'] );
setcookie("ck_name",$_GET['name'] );
 }
echo "$text[login_ok]";
if (isset($_GET[seite]))
 {
$seite1=base64_decode($_GET[seite]);
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./$seite1\">";
 }
else
 {
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./index.php\">";
 }
?>

