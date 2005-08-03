<div class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN tab2 -->
<br/>
<div class="rot_mittig">{tab2.L_SEARCH_ERROR}</div>
<br/>
<!-- END tab2 -->

<!-- BEGIN tab1 -->
<form method="post" action="global_search.php">
<table border="0" cellpadding="4" cellspacing="2" style="margin-right:auto;margin-left:auto;" >
<tr>
 <td style="vertical-align:top;text-align:left;">{tab1.L_NUMBER}:</td>
 <td style="width:10px;"></td>
 <td style="text-align:left;"><input type="text" name="s_number" value=""/><br/>
     <input type="radio" name="addr_calls" value="call" checked="checked"/>{tab1.L_IN_CALL_STAT}<br/>
     <input type="radio" name="addr_calls" value="addr"/>{tab1.L_IN_ADDR}</td>
</tr>
<tr>
 <td style="text-align:left;">{tab1.L_SEARCH_MSN}:</td>
 <td style="width:10px;"></td>
 <td style="text-align:left;"><input name="s_msn" value=""/></td>
</tr>
<tr>
<td style="vertical-align:top;text-align:left;">
Suche zwischen:
</td>
<td style="width:10px;"></td>
<td style="text-align:left;">
<input type="checkbox" name="be_dates"/><br/>
<select name="first_d">
<!-- BEGIN first_d -->
<option>{tab1.first_d.NR}</option>
<!-- END first_d -->
</select>
<select name="first_m">
<!-- BEGIN first_m -->
<option>{tab1.first_m.NR}</option>
<!-- END first_m -->
</select>
<select name="first_j">
<!-- BEGIN first_j -->
<option>{tab1.first_j.NR}</option>
<!-- END first_j -->
</select>
<p></p>
<select name="last_d">
<!-- BEGIN last_d -->
<option>{tab1.last_d.NR}</option>
<!-- END last_d -->
</select>
<select name="last_m">
<!-- BEGIN last_m -->
<option>{tab1.last_m.NR}</option>
<!-- END last_m -->
</select>
<select name="last_y">
<!-- BEGIN last_y -->
<option>{tab1.last_y.NR}</option>
<!-- END last_y -->
</select>
</td>
</tr>
</table>
<input type="submit" name="n_search" value="{tab1.L_SEARCH}"/>
</form>
<!-- END tab1 -->
<br/><br/>
<!-- BEGIN addr_not_found -->
<div class="blau_mittig">{addr_not_found.L_NOT_FOUND_ADDR}</div>
<br/><br/>
<!-- END addr_not_found -->

<!-- BEGIN addr -->
<table border="0" style="margin-right:auto;margin-left:auto;">
<tr>
 <td style="width:150px;font-weight:bold;text-align:left;">{addr.L_ADDR_LAST_NAME}
 </td>
 <td style="width:100px; font-weight:bold;text-align:left;">{addr.L_ADDR_FIRST_NAME}</td>
 <td style="width:150px; text-align:center; font-weight:bold;">{addr.L_ADDR_TELEPHON_NUMBER}</td>
 <td style="width:150px; text-align:center; font-weight:bold;">{addr.L_ADDR_CELL_PHONE}</td>
 <td></td>
 <td></td>
 <td></td>
 <td style="width:10px;"></td>
 <td></td>
</tr>
<!-- BEGIN data -->
   <tr style="background-color:{addr.data.color}">
   <td style="text-align:left;"><a href="./addressbook_show.php?show={addr.data.addr_id}" >{addr.data.addr_last_name}</a></td>
   <td style="text-align:left;"><a href="./addressbook_show.php?show={addr.data.addr_id}">{addr.data.addr_first_name}</a></td>
   <td style="text-align:center;">{addr.data.addr_tele_1}</td>
   <td style="text-align:center;">{addr.data.addr_cell_phone}</td>
   <td style="text-align:center;">
    <a href="./addressbook_edit.php?edit={addr.data.addr_id}" title="{addr.data.addr_edit_entry}">
     <img src="./images/edit.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
   <td style="width:10px;"></td>
   <td style="text-align:center;">
    <a href="./addressbook_edit.php?edit={addr.data.addr_id}&amp;del=1" title="{addr.data.addr_delete_entry}">
   <img src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
   <td style="width:10px;">&nbsp;</td>
   <td style="text-align:center;">
   <a href="./statistic_person.php?id={addr.data.addr_id}" title="{addr.tab.addr_search_entry}">
   <img src="./images/data.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
  </tr>
<!-- END data -->

</table>
<!-- END addr -->



<!-- BEGIN cell -->
<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;">
 <tr style="font-weight:bold;">
  <td></td>
  <td style="width:80px;text-align:center">{cell.L_DATE}</td>
  <td style="width:70px;text-align:center">{cell.L_CLOCK}</td>
  <td style="width:110px;text-align:center">{cell.L_CALL_NUMBER}</td>
  <!-- BEGIN userconfig_show_typ -->
  <td style="width:70px;text-align:center">{cell.userconfig_show_typ.L_CALLERS_TYP}</td>
  <!-- END userconfig_show_typ -->
  
  <!-- BEGIN userconfig_show_prefix -->
  <td style="text-align:center">{cell.userconfig_show_prefix.L_FROM_CITY}</td>
  <!-- END userconfig_show_prefix -->
  
  <!-- BEGIN userconfig_show_msn -->
  <td style="text-align:center">{cell.userconfig_show_msn.L_CALL_TO_MSN}</td>
  <!-- END userconfig_show_msg -->

  <td style="text-align:center">{cell.L_CALLERS_NAME}</td>
  
  <!-- BEGIN userconfig_show_call_back -->
  <td style="text-align:center">{cell.userconfig_show_call_back.L_SHOW_CALL_BACK}</td>
  <!-- END userconfig_show_call_back -->

  <td style="text-align:center">{cell.L_COPY_TO_ADDR}</td>
  <!-- BEGIN userconfig_show_delete -->
  <td>{cell.userconfig_show_delete.L_DELETE_ENTRY_TITLE}</td>
  <!-- END userconfig_show_delete -->
 </tr>
<!-- BEGIN data -->
 <tr style="background-color:{cell.data.DATA_ROW_COLOR}">
  <td>{cell.data.DATA_SHOW_SINGEL_STAT}</td>
  <td style="text-align:center">{cell.data.DATA_SHOW_DATE}</td>
  <td style="text-align:center">{cell.data.DATA_SHOW_CLOCK}</td>
  <td style="text-align:center">{cell.data.DATA_SHOW_NUMBER}</td>
  <!-- BEGIN show_call_typ -->
  <td style="text-align:center">{cell.data.show_call_typ.DATA_CALLERS_TYP}</td>
  <!-- END show_call_typ -->
  <!-- BEGIN show_prefix -->
  <td style="text-align:center">{cell.data.show_prefix.DATA_SHOW_PREFIX}</td>
  <!-- END show_prefix -->
  <!-- BEGIN show_msn -->
  <td>{cell.data.show_msn.DATA_SHOW_MSN}</td>
  <!-- END show_msn -->
  <td style="text-align:center">{cell.data.DATA_SHOW_CALLERS_NAME}</td>
  <!-- BEGIN show_call_back -->
  <td style="text-align:center">{cell.data.show_call_back.DATA_SHOW_CALL_BACK}</td>
  <!-- END show_call_back -->
  <td style="text-align:center">{cell.data.DATA_TO_ADDR}</td>
  <!-- BEGIN show_delete_func -->
  <td style="text-align:center">
   <a href="./statistic_del_entry.php?id={cell.data.show_delete_func.DATA_LINK_DELETE_FUNC}" title="{cell.data.show_delete_func.L_DELETE_ENTRY_FROM_DB}">
   <img  src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;"
   alt=""/>
   </a>
   </td>
  <!-- END show delete_func -->
</tr>

<!-- END data -->
</table>
<!-- END cell -->




