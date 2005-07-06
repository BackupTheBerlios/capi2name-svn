<div  class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN delete_entry_from_db -->
<div class="blau_mittig">{delete_entry_from_db.L_ADDRESS_BOOK_ENTRY_REMOVED}</div>
<meta http-equiv="refresh" content="2; URL=./addressbook.php">
<!-- END delete_entry_from_db -->

<!-- BEGIN check_if_delete_entry -->
<div class="rot_mittig">{check_if_delete_entry.L_check_if_you_will_delete}</div>
<!-- END check_if_delete_entry -->

<!-- BEGIN entry_not_found -->
<div class="rot_mittig">{entry_not_found.SHOW_ENTRY_NOT_FOUND}</div>
<!-- END entry_not_found -->

<!-- BEGIN tab1 -->


<table border="0" cellpadding="3" style="margin-right:auto;margin-left:auto;">
<form action="./addressbook_edit.php" method="post">
 <tr>
  <td style="text-align:left;">{tab1.L_FIRST_NAME}:</td>
  <td style="width:12px"></td>
  <td><input name="bvorname" type="text" value="{tab1.DATA_FIRST_NAME}"/>
      <input name="id" value="{tab1.DATA_ID_USER}" type="hidden"/>
  </td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_LAST_NAME}:</td>
  <td style="width:12px"></td>
  <td><input name="bnachname" type="text" value="{tab1.DATA_LAST_NAME}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_STREET_NAME}:</td>
  <td style="width:12px"></td>
  <td><input name="bstrasse" type="text" value="{tab1.DATA_STREET_NAME}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_HOUSE_NUMBER}:</td>
  <td style="width:12px"></td>
  <td><input name="bhausnr" type="text" value="{tab1.DATA_HOUSE_NUMBER}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_ZIP_CODE}:</td>
  <td style="width:12px"></td>
  <td><input name="bplz" type="text" value="{tab1.DATA_ZIP_CODE}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_CITY}:</td>
  <td style="width:12px"></td>
  <td><input name="bort" type="text" value="{tab1.DATA_CITY}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_E_MAIL}:</td>
  <td style="width:12px"></td>
  <td><input name="bemail" type="text" value="{tab1.DATA_E_MAIL}"/></td>
 </tr>
 <tr>
  <td colspan="3" style="text-align:center;">
  <input name="id" type="hidden" value="{tab1.DATA_ID_USER}" />
  <input type="submit" name="aendern" value="{tab1.CHANGE_ADDR}" />
  </td>
 </tr>
 </form>
 <!-- BEGIN telephon -->
 <form action="./addressbook_edit.php" method="post">
 <tr>
  <td style="text-align:left;">{tab1.telephon.L_TELE}:</td>
  <td style="width:12px"></td>
  <td><input name="telephonnr" type="text" value="{tab1.telephon.L_DB_TELE}"/></td>
  <td>
  <input name="tele_id" value="{tab1.telephon.L_DB_TELE_ID}" type="hidden"/>
  <input name="id" value="{tab1.telephon.L_DB_ID}" type="hidden"/>
  <input name="tele_save" value="{tab1.telephon.L_SAVE}" type="submit"/>
  <input name="tele_delete" value="{tab1.telephon.L_DELETE}" type="submit"/></td>
 </tr>
 </form>
 <!-- END telephon -->
 <!-- BEGIN cellphone -->
 <form action="./addressbook_edit.php" method="post">
 <tr>
  <td style="text-align:left;">{tab1.cellphone.L_CELL_PHONE}:</td>
  <td style="width:12px"></td>
  <td><input name="telephonnr" type="text" value="{tab1.cellphone.L_DB_TELE}"/></td>
  <td>
  <input name="tele_id" value="{tab1.cellphone.L_DB_TELE_ID}" type="hidden"/>
  <input name="id" value="{tab1.cellphone.L_DB_ID}" type="hidden"/>
  <input name="tele_save" value="{tab1.cellphone.L_SAVE}" type="submit"/>
  <input name="tele_delete" value="{tab1.cellphone.L_DELETE}" type="submit"/></td>
 </tr>
 </form>
 <!-- END cellphone -->
 <!-- BEGIN fax -->
 <form action="./addressbook_edit.php" method="post">
 <tr>
  <td style="text-align:left;">{tab1.fax.L_FAX}:</td>
  <td style="width:12px"></td>
  <td><input name="telephonnr" type="text" value="{tab1.fax.L_DB_TELE}"/></td>
  <td>
  <input name="tele_id" value="{tab1.fax.L_DB_TELE_ID}" type="hidden"/>
  <input name="id" value="{tab1.fax.L_DB_ID}" type="hidden"/>
  <input name="tele_save" value="{tab1.fax.L_SAVE}" type="submit"/>
  <input name="tele_delete" value="{tab1.fax.L_DELETE}" type="submit"/></td>
 </tr>
 </form>
 <!-- END fax -->
 <tr>
  <td>
  </td>
 </td>
 <tr>
  <td colspan="3" style="text-align:left;"><b>{tab1.L_ADD_NUMBER}:</b></td>
 </tr>
 <!-- BEGIN add -->
 <form action="./addressbook_edit.php" method="post">
 <tr>
  <td style="text-align:left;">Nummer:</td>
  <td style="width:12px"></td>
  <td><input name="telephonnr" type="text"/></td>
  <td>
  <select name="typ">
  <option value="1">{tab1.add.L_TELE}</option>
  <option value="2">{tab1.add.L_CELL_PHONE}</option>
  <option value="3">{tab1.add.L_FAX}</option>
  </select>
  <input name="id" type="hidden" value="{tab1.add.ID}"/>
  <input name="add" value="{tab1.add.L_ADD}" type="submit"/></td>
 </tr>
 </form>
 <!-- END add -->
</table>
<br/>
<!-- END tab1 -->


<!-- BEGIN now_delete_really_entry -->
<ins>
<form action="./addressbook_edit.php" method="post">
<input type="hidden" name="loeschenID" value="{now_delete_really_entry.ID_FROM_ADDR}" />
<input type="submit" name="wloeschen" value="{now_delete_really_entry.REMOVE_ENTRY}" />
</form>
</ins>
<!-- END now_delete_really_entry -->

<!-- BEGIN ask_for_delete_entry -->
<ins>
 <form action="./addressbook_edit.php" method="post">
<input type="hidden" name="id" value="{ask_for_delete_entry.id}"/>
<input type="hidden" name="loeschen_OK" value="{ask_for_delete_entry.ID_FROM_ADDR}" />
<input type="submit" name="del" value="{ask_for_delete_entry.DELETE_ENTRY}" />
</form>
</ins>
<!-- END ask_for_delete_entry -->



<!-- BEGIN cancel_edit -->
<p>
<span style="text-align:center">
<form action="./addressbook.php" method="post">
<input type="submit" value="{cancel_edit.CANCEL_EDIT_ADDR}" />
</form>
</span>
</p>
<!-- END cancel_edit -->