<div class="ueberschrift_seite">{L_CALL_STAT_TITLE}</div>

<!-- BEGIN change_name_from_unkown -->
<br />
<form action="./showstatnew.php" method="post">
<input type="hidden" name="newid" value="{change_name_from_unkown.DATA_ID_FROM_DB}">
Name: <input name="newname" type="text">
<input type="submit" name="eintragen" value="{change_name_from_unkown.L_SUBMIT_ENTRY}">
 </form><br />
<!-- END change_name_from_unkown -->

<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td></td>
  <td style="text-align:center">{L_DATE}</td>
  <td style="text-align:center">{L_CLOCK}</td>
  <td style="width:110px; text-align:center">{L_CALL_NUMBER}</td>
  <!-- BEGIN userconfig_show_typ -->
  <td style="text-align:center">{L_CALLERS_TYP}</td>
  <!-- END userconfig_show_typ -->
  
  <!-- BEGIN userconfig_show_prefix -->
  <td style="text-align:center">{L_FROM_CITY}</td>
  <!-- END userconfig_show_prefix -->
  
  <!-- BEGIN userconfig_show_msn -->
  <td style="text-align:center">{L_CALL_TO_MSN}</td>
  <!-- END userconfig_show_msg -->

  <td style="text-align:center">{L_CALLERS_NAME}</td>
  
  <!-- BEGIN userconfig_show_call_back -->
  <td style="text-align:center">{L_SHOW_CALL_BACK}</td>
  <!-- END userconfig_show_call_back -->

  <td style="text-align:center">{L_COPY_TO_ADDR}</td>
  <!-- BEGIN userconfig_show_delete -->
  <td>{L_DELETE_ENTRY_TITLE}</td>
  <!-- END userconfig_show_delete -->
 </tr>

<!-- BEGIN tab1 -->
 <tr style="background-color:{tab1.DATA_ROW_COLOR}">
  <td>{tab1.DATA_SHOW_SINGEL_STAT}</td>
  <td style="text-align:center">{tab1.DATA_SHOW_DATE}</td>
  <td style="text-align:center">{tab1.DATA_SHOW_CLOCK}</td>
  <td style="text-align:center">{tab1.DATA_SHOW_NUMBER}</td>
  <!-- BEGIN show_call_typ -->
  <td style="text-align:center">{tab1.show_call_typ.DATA_CALLERS_TYP}</td>
  <!-- END show_call_typ -->
  <!-- BEGIN show_prefix -->
  <td style="text-align:center">{tab1.show_prefix.DATA_SHOW_PREFIX}</td>
  <!-- END show_prefix -->
  <!-- BEGIN show_msn -->
  <td>{tab1.show_msn.DATA_SHOW_MSN}</td>
  <!-- END show_msn -->
  <td style="text-align:center">{tab1.DATA_SHOW_CALLERS_NAME}</td>
  <!-- BEGIN show_call_back -->
  <td style="text-align:center">{tab1.show_call_back.DATA_SHOW_CALL_BACK}</td>
  <!-- END show_call_back -->
  <td style="text-align:center">{tab1.DATA_TO_ADDR}</td>
  <!-- BEGIN show_delete_func -->
  <td style="text-align:center">
   <a href="./stat_loeschen.php?id={tab1.show_delete_func.DATA_LINK_DELETE_FUNC}" title="{tab1.show_delete_func.L_DELETE_ENTRY_FROM_DB}">
   <img  src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;"
   alt=""/>
   </a>
   </td>
  <!-- END show delete_func -->
  
  
 </tr>
<!-- END tab1 --> 
 
</table>




<br />
<span style="text-align:center">
<a href="./showstatnew.php?maxlist=alle">{L_SHOW_ALL_CALLS_FROM_AB}</a><br />
</span>


