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
  <td style="width:150px;">
  <a href="./addressbook.php?id={tab2.DATA_ADDR_ID}#find">{tab2.DATA_NAME}</a></td>
  <td style="width:150px; text-align:center;">
  <a href="./callback_show.php?anz={tab2.DATA_ID}" title="{tab2.L_SHOW_REASON}">{tab2.DATA_NUMBER}</a></td>
  <td style="text-align:center;">{tab2.DATA_TIME} - {tab2.DATA_DATE}</td>
  <td style="width:150px; text-align:center;">{tab2.DATA_CALL_BACK_TIME}</td>
  <td style="text-align:center;">
  <a href="./callback.php?loeschen={tab2.DATA_ID}" title="Loeschen">
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
   <input name="addnumber" value="{insert_with_addr.L_DATA_NUMBER}"/>
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
 <td colspan="3" style="text-align:right;">
  <textarea name="message" ></textarea>
 </td>
</tr>
</table>
<ins>
<br />
<input name="save_with_addr" value="{insert_with_addr.L_SAVE_DATA}" type="submit"/>
</ins>
</form>
<!-- END insert_with_addr -->














<!-- BEGIN add_new_entry -->
<br /><br /><hr/>
<div class="ueberschrift_seite">{add_new_entry.L_TITLE_NEW}</div>
<form action=callback.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
 <tr>
  <td>{add_new_entry.L_NAME}:</td>
  <td>

     <td>
     <input name="addname" value="{add_new_entry.insert_with_addr.L_DATA_NAME}"/>
     <input name="addid" value="{add_new_entry.insert_with_addr.L_DATA_ID}"/>
     </td>
  
  </td>
 </tr>
 <tr>
  <td>{add_new_entry.L_NUMBER}:</td>

 </tr>
 <tr>
  <td>{add_new_entry.L_CALL_BACK_TIME}:</td>
  <td>
   <select name="addzurueckzeit">
   <option value="Morgens" >Morgens</option>
   <option value="Mittags" >Mittags</option>
   <option value="Abends"  >Abends</option>
   <option value="So bald wie moeglich" >So bald wie moeglich</option>
   </select></td>
 </tr>
   <tr>
   <td>{add_new_entry.L_REASON}</td>
    <td>{add_new_entry.L_VIEW}
     <textarea rows="10" cols="30" name="grund"></textarea>
    </td>
 </tr>
</table>
<ins>
<br />
 <input name="eintragen" value="{add_new_entry.L_SAVE_DATA}" type="submit"/>
</ins>
</form>
<!-- END add_new_entry -->

<br /><br />