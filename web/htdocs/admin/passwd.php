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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
include("./check_it.php");
include("./header.inc.php");

echo "<div class=\"ueberschrift_seite\">Change Administrator password</div>";

if (isset($_POST['change']))
{
if ($_POST['passwd1']==$_POST['passwd2'] && ! empty($_POST['passwd1']))
{
 $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
 $result=$dataB->sql_query("SELECT username,passwd FROM users WHERE username='admin'");
 $daten=$dataB->sql_fetch_assoc($result);
  if (md5($_POST['altespasswd']) == $daten['passwd'])
   {
    $passwd_md5=md5($_POST[passwd2]);
    $query=sprintf("UPDATE users SET passwd=%s", $dataB->sql_check($passwd_md5));
    $result=$dataB->sql_query($query);
    if ($result)
     {
      echo "<div class=\"blau_mittig\">Password successfully changed!</div>";
     }
    else
     {
     echo "<div class=\"rot_mittig\">Password NOT sucessfully changed!</a>";
     }
   }
  else
   {
    echo "<div class=\"rot_mittig\">Old password not the same like in the database.</div>";
   }
  $dataB->sql_close();
}
else
{
echo "<div class=\"rot_mittig\">The new passwords are not the same or the new password is empty!</div>";
}
}//isset
?>
<form action="passwd.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td style="text-align:left;">old password:</td>
  <td style="width:10px;"></td>
  <td style="text-align:right;"><input type="password" name="altespasswd"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">new password:<br/>again:</td>
  <td style="width:10px;"></td>
  <td style="text-align:right;"><input type="password" name="passwd1"/><br/><input name="passwd2" type="password"/></td>
 </tr>
 <tr>
  <td colspan="3"><input type="submit" name="change" value="save data"/></td>
 </tr>
</table>
</form>
<?php
include("./footer.inc.php");
?>
