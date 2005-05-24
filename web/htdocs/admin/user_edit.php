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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
include("./check_it.php");
include("./header.inc.php");


if (isset($_POST[edit]))
 {
  $username=$_POST[username];
  $id=$_POST[id];
 }
 else
 {
  $username=$_GET[username];
  $id=$_GET[id];
 }
echo "<div class=\"ueberschrift_seite\">Change settings for user $username with ID $id</div>";


//------------------- Daten in DB schreiben: ---------------------------------
if (isset($_POST[edit]))
 {
//UPDATE userliste SET showrueckruf='$wert' WHERE id=".$_POST[id]
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$dataB->sql_query("UPDATE users SET name_first='$_POST[first_name]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating first name in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET name_last='$_POST[last_name]' WHERE id='$_POST[id]'");
if (!result) 
   {
    echo "<div class=\"rot_mittig\">Updating last name in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET show_config='$_POST[show_config]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating show config in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET show_callback='$_POST[show_callback]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating show callback in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET msn_listen='$_POST[msn_listen]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating msn listen in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET show_lines='$_POST[show_lines]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating show lines in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET show_prefix='$_POST[show_prefix]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating show prefix in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET show_msn='$_POST[show_msn]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating show msn in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET show_type='$_POST[show_type]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating show type in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET template='$_POST[template]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating template in database failed!!</div>";
   }
$result=$dataB->sql_query("UPDATE users SET allow_delete='$_POST[allow_delete]' WHERE id='$_POST[id]'");
if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating allow delete in database failed!!</div>";
   }
if (!empty($_POST[passwd]))
{
$passwd=md5($_POST[passwd]);
$result=$dataB->sql_query("UPDATE users SET passwd='$passwd' WHERE id='$_POST[id]'");

if (!$result) 
   {
    echo "<div class=\"rot_mittig\">Updating passwd in database failed!!</div>";
   }
}
$dataB->sql_close();
echo "<div class=\"blau_mittig\">data saved to database...</div>";
 }
//---------------------Daten in DB schreiben ENDE---------------------------


//--------------- Daten aus DB auslesen-------------------------------
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$dataB->sql_query("SELECT * FROM users WHERE id='$id'");
$daten=$dataB->sql_fetch_assoc($result);
$dataB->sql_close();
if ($daten[show_config]=="0" or $daten[show_config]=="f")
	 $option[show_config]="selected";
if ($daten[show_callback]=="0" or $daten[show_callback]=="f")
	 $option[show_callback]="selected";
if ($daten[show_prefix]=="0" or $daten[show_prefix]=="f")
	$option[show_prefix]="selected";
if ($daten[show_msn]=="0" or $daten[show_msn]=="f")
	$option[show_msn]="selected";
if ($daten[show_type]=="0"or $daten[show_type]=="f")
	$option[show_type]="selected";
if ($daten[allow_delete]=="0" or $daten[allow_delete]=="f")
	$option[allow_delete]="selected";
$dir= "../templates/";
$dh=opendir($dir);
 while (false!== ($filename=readdir($dh)))
 {
  if ($filename!="." AND $filename!=".." AND $filename!="index.html")
   {
    $files[] =$filename;
   }
 }
?>
<form action="user_edit.php" method="POST">
<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
   <td style="text-align:left;">
   <span style="font-weight:bold;">
   [<a href="./doc.html#1" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;username:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><input name="id" type="hidden" value="<?=$daten[id]?>"/>
  <input type="hidden"  value="<?=$daten[username]?>"  name="username"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">
   <span style="font-weight:bold;">
   [<a href="./doc.html#2" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;first name:
  </td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" value="<?=$daten[name_first]?>" name="first_name" maxlength="15" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#3" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;last name:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="last_name" value="<?=$daten[name_last]?>" maxlength="15" /></td>
 </tr>
 <tr>
  <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#4" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show configpage:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <select name="show_config"><option value="1">Yes</option>
  			    <option <?=$option[show_config]?> value="0">No</option>
			    </select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#5" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show callback function:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><select name="show_callback">
  <option value="1">Yes</option>
  <option <?=$option[show_callback]?> value="0">No</option></select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#6" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show the following MSNs in the call stat:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="msn_listen" value="<?=$daten[msn_listen]?>" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#7" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;set how many rows are display in the stat:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="show_lines" value="<?=$daten[show_lines]?>"/></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#8" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show prefix col in the stat:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="show_prefix"><option value="1">Yes</option>
    <option <?=$option[show_prefix]?> value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#9" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show on witch MSN is the call comming:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="show_msn"><option value="1">Yes</option>
    <option <?=$option[show_msn]?> value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#10" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show call type:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;"><select name="show_type">
    <option value="1">Yes</option>
    <option <?=$option[show_type]?> value="0">No</option></select></td>
   </tr>
   <tr>
     <td style="text-align:left;">
     <span style="font-weight:bold;">[<a href="./doc.html#11" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;allow delete entries:</td>
     <td style="width:5px;"></td>
     <td style="text-align:right;"><select name="allow_delete">
     <option value="1">Yes</option>
     <option <?=$option[allow_delete]?> value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#13" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;template:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="template">
    <?
    foreach ($files as $dirs)  
    {     
    if ($dirs==$daten[template])
      {
       
	echo "<option selected=\"selected\" value=\"$daten[template]\">$daten[template]</option>";
      }
    else
      {
       echo "<option value=\"$dirs\">$dirs</option>";
      }
    }
    ?>
    </select>
    </td>
   </tr>
   <tr>
      <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#12" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;new password:</td>
      <td style="width:5px;"></td>
      <td style="text-align:right;"><input type="password" name="passwd"/></td>
   </tr>
</table>
<br/>
<input type="submit" name="edit" value="save user"/>
</form>
<br/>
<?
include("footer.inc.php");
?>

