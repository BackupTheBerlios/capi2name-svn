<div class="ueberschrift_seite">{L_ADDRESS_BOOK}</div>
<br />

<table border="0" style="margin-right:auto;margin-left:auto;">
<tr>
 <td style="width:150px;font-weight:bold;text-align:left;">
  <a href="./addressbook.php" title="[L_ADDR_SORT_LAST_NAME}">{L_ADDR_LAST_NAME}</a>
 </td>
 <td style="width:100px; font-weight:bold;text-align:left;">
   <a href="./addressbook.php?order=firstname" title="{L_ADDR_SORT_FIRST_NAME}">{L_ADDR_FIRST_NAME}</a>
 </td>
 <td style="width:150px; text-align:center; font-weight:bold;">{L_ADDR_TELEPHON_NUMBER}</td>
 <td style="width:150px; text-align:center; font-weight:bold;">{L_ADDR_CELL_PHONE}</td>
 <td></td>
 <td></td>
 <td></td>
 <td style="width:10px;"></td>
 <td></td>
</tr>
<!-- BEGIN tab -->
   <tr style="background-color:{tab.color}">
   <td style="text-align:left;"><a href="./addressbook_show.php?show={tab.addr_id}" >{tab.addr_last_name}</a></td>
   <td style="text-align:left;"><a href="./addressbook_show.php?show={tab.addr_id}">{tab.addr_first_name}</a></td>
   <td style="text-align:center;">{tab.addr_tele_1}</td>
   <td style="text-align:center;">{tab.addr_cell_phone}</td>
   <td style="text-align:center;">
    <a href="./addressbook_edit.php?bearbeiten={tab.addr_id}" title="{tab.addr_edit_entry}">
     <img src="./images/edit.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
   <td style="width:10px;"></td>
   <td style="text-align:center;">
    <a href="./addressbook_edit.php?bearbeiten={tab.addr_id}&amp;loeschen=1" title="{tab.addr_delete_entry}">
   <img src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
   <td style="width:10px;">&nbsp;</td>
   <td style="text-align:center;">
   <a href="./stat_anrufer.php?id={tab.addr_id}" title="{tab.addr_search_entry}">
   <img src="./images/search.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
  </tr>
<!-- END tab -->
</table>
<br />
