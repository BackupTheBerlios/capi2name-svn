<table border="0" style="margin-right:auto;margin-left:auto;">
<tr>
<td style="width:60px;text-aligen:left;">
<a href="./showstatnew.php?{date_back}" title="{day_left}"><img src="./images/1leftarrow.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
<td style="text-aligen:center;"><div class="ueberschrift_seite">{L_CALL_STAT_TITLE}</div></td>
<td style="width:60px;text-aligen:right;">
<!-- BEGIN b_right -->
<a href="./showstatnew.php?{date_for}" title="{day_right}">
<img src="./images/1rightarrow.png" style="border-width:0px;vertical-align:middle;" alt="" /></a>
<!-- END b_right -->
</td>
</tr>
</table>
<!-- BEGIN change_name_from_unkown -->
<br />
<form action="./showstatnew.php{change_name_from_unkown.DATE}" method="post">
<input type="hidden" name="newid" value="{change_name_from_unkown.DATA_ID_FROM_DB}">
Name: <input name="newname" type="text">
<input type="submit" name="eintragen" value="{change_name_from_unkown.L_SUBMIT_ENTRY}">
 </form><br />
<!-- END change_name_from_unkown -->

<!-- BEGIN in_future -->
<div class="blau_mittig"><span style="font-size:medium;font-weight:bold;color:red;">{in_future.warning}:</span> {in_future.L_DATA}</div><br/><br/>
<!-- END in_future -->

<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;">
 <tr style="font-weight:bold;">
  <td></td>
  <td style="width:80px;text-align:center">{L_DATE}</td>
  <td style="width:70px;text-align:center">{L_CLOCK}</td>
  <td style="width:110px;text-align:center">{L_CALL_NUMBER}</td>
  <!-- BEGIN userconfig_show_typ -->
  <td style="width:70px;text-align:center">{L_CALLERS_TYP}</td>
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
  <!-- BEGIN show_cs -->
  <td style="text-align:center;">{show_cs.L_LINK_TO_AB}</td>
  <!-- END show_cs -->
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
   <a href="./statistic_del_entry.php?id={tab1.show_delete_func.DATA_LINK_DELETE_FUNC}" title="{tab1.show_delete_func.L_DELETE_ENTRY_FROM_DB}">
   <img  src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;"
   alt=""/>
   </a>
   </td>
  <!-- END show delete_func -->
  
  <!-- BEGIN show_cs_ab -->
  <td style="text-align:center">{tab1.show_cs_ab.DATA_SHOW_AB}</td>
  <!-- END show_cs_ab -->
   
 </tr>
<!-- END tab1 --> 
 
</table>
<br /><br/>
<!-- BEGIN show_pages -->
<span style="text-align:center;{show_pages.D_BOLD}">
 | <a href="./showstatnew.php?maxlist=yes&amp;page={show_pages.D_PAGE}">
{show_pages.D_PAGE}</a> | 
</span>
<!-- END show_pages -->
