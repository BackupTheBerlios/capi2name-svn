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


   setcookie("ck_ausername",$_GET['use'] );
   setcookie("ck_apasswd",$_GET['pas'] );


echo "Login war erflogreich.<br>Sie werden weitergeleitet.";

if (isset($_GET[seite]))
 {
 echo "<meta http-equiv=\"refresh\" content=\"1; URL=./$_GET[seite]\">";
 }
else
 {
echo "<meta http-equiv=\"refresh\" content=\"1; URL=./index.php\">";
 }
?>
