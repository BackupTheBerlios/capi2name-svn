<!-- BEGIN not_allowed -->
<div class="rot_mittig">{not_allowed.L_MSG_NOT_ALLOWED}</div>
<!-- END not_allowed -->

<!-- BEGIN saved_with_addr -->
<br/><div class="blau_mittig">{saved_with_addr.L_MSG_SAVED}</div><br/>
<!-- END saved_with_addr -->

<div class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN tab1 -->
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
 <tr>
  <td style="width:150px;font-weight:bold;">{tab1.L_NAME}</td>
  <td style="width:150px;text-align:center;font-weight:bold;">{tab1.L_NUMBER}</td>
  <td style="text-align:center;font-weight:bold;">{tab1.L_CALL_TIME}</td>
  <td style="width:150px; text-align:center;font-weight:bold;">{tab1.L_CALL_BACK_TIME}</td>
  <td></td>
 </tr>
<!-- END tab1 -->

<!-- BEGIN tab2 -->
<tr>
  <td style="width:150px;">{tab2.DATA_NAME}</td>
  <td style="width:150px; text-align:center;">
  <a href="./callback_show.php?id={tab2.DATA_ID}" title="{tab2.L_SHOW_REASON}">{tab2.DATA_NUMBER}</a></td>
  <td style="text-align:center;">{tab2.DATA_TIME} - {tab2.DATA_DATE}</td>
  <td style="width:150px; text-align:center;">{tab2.DATA_CALL_BACK_TIME}</td>
  <td style="text-align:center;">
  <a href="./callback.php?del={tab2.DATA_ID}" title="{tab2.L_DELETE}">
  <img src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
</tr>
<!-- END tab2 -->
</table>


<!-- BEGIN insert_with_addr -->
<br /><br /><hr/>
<div class="ueberschrift_seite">{insert_with_addr.L_TITLE_NEW}</div>
<form action="callback.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
<tr>
 <td>{insert_with_addr.L_NAME}:</td>
 <td style="width:10px;"></td>
 <td>
   <input name="addname" value="{insert_with_addr.L_DATA_NAME}"/>
   <input name="addid" type="hidden" value="{insert_with_addr.L_DATA_ID}"/>
 </td>
</tr>
<tr>
  <td>{insert_with_addr.L_NUMBER}:</td>
  <td style="width:10px;"></td>
  <td>
   <input name="addnumber" disabled="disabled" value="{insert_with_addr.L_DATA_NUMBER}"/>
  </td>
</tr>
<tr>
 <td>{insert_with_addr.L_CALL_BACK_TIME}:</td>
 <td style="width:10px;"></td>
 <td>
   <select name="callback_time">
   <option value="1" >{insert_with_addr.L_MORING}</option>
   <option value="2" >{insert_with_addr.L_MIDDAY}</option>
   <option value="3" >{insert_with_addr.L_EVENING}</option>
   <option value="0" >{insert_with_addr.L_SOON_AS_POSSIBLE}</option>
   </select>
 </td>
</tr>
<tr>
 <td>{insert_with_addr.L_USERNAME}:</td>
 <td style="width:10px;"></td>
 <td>
 <select name="user_id">
  <!-- BEGIN select_users -->
   <option value="{insert_with_addr.select_users.L_DATA_ID}"  {insert_with_addr.select_users.L_DATA_SELECTED} >{insert_with_addr.select_users.L_DATA_NAME}</option>
  <!-- END select_users -->
 </select>
 </td>
</tr>
<tr>
 <td>{insert_with_addr.L_MESSAGE}</td>
 <td></td>
 <td></td>
</tr>
<tr>
 <td></td>
 <td></td>
 <td colspan="1" style="text-align:left;">
  <textarea name="message" cols="35" rows="4" ></textarea>
 </td>
</tr>
</table>
<ins>
<br />
<input name="save_with_addr" value="{insert_with_addr.L_SAVE_DATA}" type="submit"/>
</ins>
</form>
<!-- END insert_with_addr -->

<!-- BEGIN insert_without_addr -->
<br /><br /><hr/>
<div class="ueberschrift_seite">{insert_without_addr.L_TITLE_NEW}</div>
<form action="callback.php" method="post" name="form" >
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
<tr>
 <td>{insert_without_addr.L_NAME}:</td>
 <td style="width:10px;"></td>
 <td>
   <select name="addname" OnChange="enableNUMBER('form.addnumber')">
   <!-- BEGIN tab1 -->
   <option value="{insert_without_addr.tab1.DATA_ADDR_ID}">{insert_without_addr.tab1.DATA_ADDR_NAME}</option>
   <!-- END tab1 -->
   </select> <input type="button" value="{insert_without_addr.L_TITLE_NEW}" onClick="addValue('form.addname','form.addnumber')"/>

 </td>
</tr>
<tr>
 <td>{insert_without_addr.L_NUMBER}:</td>
 <td style="width:10px;"></td>
 <td><input name="addnumber" disabled="disabled" value="{insert_without_addr.DATA_NR}" /></td>
</tr>
<tr>
 <td>{insert_without_addr.L_CALL_BACK_TIME}:</td>
 <td style="width:10px;"></td>
 <td>
   <select name="callback_time">
   <option value="1" >{insert_without_addr.L_MORING}</option>
   <option value="2" >{insert_without_addr.L_MIDDAY}</option>
   <option value="3" >{insert_without_addr.L_EVENING}</option>
   <option value="0" >{insert_without_addr.L_SOON_AS_POSSIBLE}</option>
   </select>
 </td>
</tr>
<tr>
 <td>{insert_without_addr.L_USERNAME}:</td>
 <td style="width:10px;"></td>
 <td>
 <select name="user_id">
  <!-- BEGIN select_users -->
   <option value="{insert_without_addr.select_users.L_DATA_ID}"  {insert_without_addr.select_users.L_DATA_SELECTED} >{insert_without_addr.select_users.L_DATA_NAME}</option>
  <!-- END select_users -->
 </select>
 </td>
</tr>
<tr>
 <td>{insert_without_addr.L_MESSAGE}</td>
 <td></td>
 <td></td>
</tr>
<tr>
 <td></td>
 <td></td>
 <td colspan="1" style="text-align:left;">
  <textarea name="message" cols="35" rows="4" ></textarea>
 </td>
</tr>
</table>
<ins>
<br />
<input name="save_without_addr" value="{insert_without_addr.L_SAVE_DATA}" type="submit"/>
</ins>
</form>
<!-- END insert_without_addr -->
<br /><br />