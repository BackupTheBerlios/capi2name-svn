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
include("./check_it.php");
include("./header.inc.php");
echo "<div class=\"ueberschrift_seite\">create a new user</div>";

if (isset($_POST[save])) {
 if (isset($_POST[username]) && isset($_POST[passwd])) 
  {
   $passwd=md5($_POST[passwd]);
   $dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
   $query=sprintf("INSERT INTO users VALUES(NULL,%s,%s,%s,NULL,NULL,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,NULL,%s)",
   		$dataB->sql_check($_POST[username]),
		$dataB->sql_check($_POST[cs_user]),
		$dataB->sql_check($passwd),
		$dataB->sql_check($_POST[first_name]),
		$dataB->sql_check($_POST[last_name]),
		$dataB->sql_checkn($_POST[show_lines]),
		$dataB->sql_check($_POST[msns_listen]),
		$dataB->sql_checkn($_POST[show_callback]),
		$dataB->sql_checkn($_POST[show_prefix]),
		$dataB->sql_checkn($_POST[show_msn]),
		$dataB->sql_checkn($_POST[show_type]),
		$dataB->sql_checkn($_POST[show_config]),
		$dataB->sql_checkn($_POST[allow_delete]),
		$dataB->sql_checkn($_POST[cs_audio]));
   $result=$dataB->sql_query($query);
   $dataB->sql_close();
   if ($result)
    {
     echo "<div class=\"blau_mittig\">Useradd was successfull, you will be forwarded in 2sec.....</div><meta http-equiv=\"refresh\" content=\"2; URL=./index.php\">";
    }
   else
    {
     echo "<div class=\"rot_mittig\">Useradd failed. Please go back, to check your input.</div>";
    }
  }
 else
  {
   echo "<div class=\"rot_mittig\">You musst set an username and password for creating an user.</div>";
  }
}
?>
<form action="user_add.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
   <td style="text-align:left;"><span style="font-weight:bold;">
   [<a href="./doc.html#1" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;username:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><input type="text" maxlength="8" name="username"/></td>
 </tr>
 <tr>
 <td style="text-align:left;"><span style="font-weight:bold;">
 [<a href="./doc.html#20" onclick="showDoc()"target="showDoc">i</a>]</span>&nbsp;CapiSuite username:</td>
 <td style="width:5px;"></td>
 <td style="text-align:right;"><input type="text" maxlength="8" name="cs_user"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">
   <span style="font-weight:bold;">
   [<a href="./doc.html#2" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;first name:
  </td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><input type="text" name="first_name" maxlength="15" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#3" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;last name:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="last_name" maxlength="15" /></td>
 </tr>
 <tr>
  <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#4" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show configpage:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <select name="show_config"><option value="1">Yes</option>
  			    <option value="0">No</option>
			    </select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#5" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show callback function:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><select name="show_callback">
  <option value="1">Yes</option>
  <option  value="0">No</option></select></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#6" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show the following MSNs in the call stat:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;">
  <input type="text" name="msns_listen" /></td>
 </tr>
 <tr>
  <td style="text-align:left;">
  <span style="font-weight:bold;">[<a href="./doc.html#7" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;set how many rows are display in the stat:</td>
  <td style="width:5px;"></td>
  <td style="text-align:right;"><input type="text" name="show_lines" value="10"/></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#8" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show prefix col in the stat:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="show_prefix"><option value="1">Yes</option>
    <option  value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#9" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show on witch MSN is the call comming:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;">
    <select name="show_msn"><option value="1">Yes</option>
    <option value="0">No</option></select></td>
   </tr>
   <tr>
    <td style="text-align:left;">
    <span style="font-weight:bold;">[<a href="./doc.html#10" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;show call type:</td>
    <td style="width:5px;"></td>
    <td style="text-align:right;"><select name="show_type">
    <option value="1">Yes</option>
    <option value="0">No</option></select></td>
   </tr>
   <tr>
     <td style="text-align:left;">
     <span style="font-weight:bold;">[<a href="./doc.html#11" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;allow delete entries:</td>
     <td style="width:5px;"></td>
     <td style="text-align:right;"><select name="allow_delete">
     <option value="1">Yes</option>
     <option selected="selected" value="0">No</option></select></td>
   </tr>
   <tr>
   </tr>
   <td style="text-align:left;">
     <span style="font-weight:bold;">[<a href="./doc.html#21" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;send type of audio on CS answerphone:</td>
     <td style="width:5px;"></td>
     <td style="text-align:right;"><select name="cs_audio">
     <option value="1">Wave</option>
     <option value="2">MP3</option>
     <option value="3">OGG</option>
     </select></td>
   
   <tr>
      <td style="text-align:left;"><span style="font-weight:bold;">[<a href="./doc.html#12" onClick="showDoc()" target="showDoc">i</a>]</span>&nbsp;password:</td>
      <td style="width:5px;"></td>
      <td style="text-align:right;"><input type="password" name="passwd"/></td>
   </tr>
   <tr>
    <td colspan="3"><input type="submit" name="save" value="add new user"/></td>
   </tr>
 </table>
</form>
<br/>

<?php
include("footer.inc.php");
?>
