<div  class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN delete_entry_from_db -->
<div class="blau_mittig">{delete_entry_from_db.L_ADDRESS_BOOK_ENTRY_REMOVED</div>
<meta http-equiv="refresh" content="2; URL=./addressbook.php">
<!-- END delete_entry_from_db -->

<!-- BEGIN edit_addr -->
<div class="blau_mittig">{edit_addr.L_MSG_EDIT_OK}</div><br/>
<meta http-equiv="refresh" content="2; URL=./addressbook.php">
<!-- END edit_addr -->

<!-- BEGIN check_if_delete_entry -->
<div class="rot_mittig">{check_if_delete_entry.L_check_if_you_will_delete}</div>
<!-- END check_if_delete_entry -->

<!-- BEGIN entry_not_found -->
<div class="rot_mittig">{entry_not_found.SHOW_ENTRY_NOT_FOUND}</div>
<!-- END entry_not_found -->

<!-- BEGIN tab1 -->

<ins><form action="./addressbook_edit.php" method="post">
<table border="0" cellpadding="3" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td style="text-align:left;">{tab1.L_FIRST_NAME}:</td>
  <td style="width:12px"></td>
  <td><input name="bvorname" type="text" value="{tab1.DATA_FIRST_NAME}"/>
      <input name="bid" value="{tab1.DATA_ID_USER}" type="hidden"/>
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
  <td style="text-align:left;">{tab1.L_TELE_1}:</td>
  <td style="width:12px"></td>
  <td><input name="btele1" type="text" value="{tab1.DATA_TELE_1}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_TELE_2}:</td>
  <td style="width:12px"></td>
  <td><input name="btele2" type="text" value="{tab1.DATA_TELE_2}"/></td>
 </tr>
  <tr>
  <td style="text-align:left;">{tab1.L_TELE_3}:</td>
  <td style="width:12px"></td>
  <td><input name="btele3" type="text" value="{tab1.DATA_TELE_3}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_CELL_PHONE}:</td>
  <td style="width:12px"></td>
  <td><input name="bhandy" type="text" value="{tab1.DATA_CELL_PHONE}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_FAX}:</td>
  <td style="width:12px"></td>
  <td><input name="bfax" type="text" value="{tab1.DATA_FAX}"/></td>
 </tr>
 <tr>
  <td style="text-align:left;">{tab1.L_E_MAIL}:</td>
  <td style="width:12px"></td>
  <td><input name="bemail" type="text" value="{tab1.DATA_E_MAIL}"/></td>
 </tr>
</table>
<br/>
<ins><input name="id" type="hidden" value="{tab1.DATA_ID_USER}" /><input type="submit" name="aendern" value="{tab1.CHANGE_ADDR}" /><p></p></ins>

<!-- END tab1 -->

<!-- BEGIN now_delete_really_entry -->
<ins>
<input type="hidden" name="loeschenID" value="{now_delete_really_entry.ID_FROM_ADDR}" />
<input type="submit" name="wloeschen" value="{now_delete_really_entry.REMOVE_ENTRY}" />
</ins>
<!-- END now_delete_really_entry -->

<!-- BEGIN ask_for_delete_entry -->
<ins>
<input type="hidden" name="loeschen_OK" value="{ask_for_delete_entry.ID_FROM_ADDR}" />
<input type="submit" name="loeschen" value="{ask_for_delete_entry.DELETE_ENTRY}" />
</ins>
<!-- END ask_for_delete_entry -->
</form>
</ins>

<p>
<span style="text-align:center">
<form action="./addressbook.php" method="post">
<input type="submit" value="{CANCEL_EDIT_ADDR}" />
</form>
</span>
</p>

