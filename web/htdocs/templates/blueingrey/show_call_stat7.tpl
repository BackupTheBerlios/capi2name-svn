<div class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN change_name_from_unkown -->
<br />
<form action="./showstatnew7days.php" method="post">
<input type="hidden" name="newid" value="{change_name_from_unkown.DATA_ID_FROM_DB}">
Name: <input name="newname" type="text">
<input type="submit" name="eintragen" value="{change_name_from_unkown.L_SUBMIT_ENTRY}">
 </form><br />
<!-- END change_name_from_unkown -->

<!-- BEGIN tab0 -->
<p style="text-align:left; margin-bottom:0px; font-weight:bold">{tab0.L_DATE_P} - {tab0.L_DAY_P}</p>
<br />
<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;">
 <tr style="font-weight:bold;">
  <td></td>
  <td style="width:80px;text-align:center">{tab0.L_DATE}</td>
  <td style="width:70px;text-align:center">{tab0.L_CLOCK}</td>
  <td style="width:110px;text-align:center">{tab0.L_CALL_NUMBER}</td>
  <!-- BEGIN userconfig_show_typ -->
  <td style="width:70px;text-align:center">{tab0.userconfig_show_typ.L_CALLERS_TYP}</td>
  <!-- END userconfig_show_typ -->
  
  <!-- BEGIN userconfig_show_prefix -->
  <td style="text-align:center">{tab0.userconfig_show_prefix.L_FROM_CITY}</td>
  <!-- END userconfig_show_prefix -->
  
  <!-- BEGIN userconfig_show_msn -->
  <td style="text-align:center">{tab0.userconfig_show_msn.L_CALL_TO_MSN}</td>
  <!-- END userconfig_show_msg -->

  <td style="text-align:center">{tab0.L_CALLERS_NAME}</td>
  
  <!-- BEGIN userconfig_show_call_back -->
  <td style="text-align:center">{tab0.userconfig_show_call_back.L_SHOW_CALL_BACK}</td>
  <!-- END userconfig_show_call_back -->

  <td style="text-align:center">{tab0.L_COPY_TO_ADDR}</td>
  <!-- BEGIN userconfig_show_delete -->
  <td>{tab0.userconfig_show_delete.L_DELETE_ENTRY_TITLE}</td>
  <!-- END userconfig_show_delete -->
   <!-- BEGIN show_cs_link -->
  <td style="text-align:center;">{tab0.show_cs_link.L_LINK_TO_AB}</td>
  <!-- END show_cs_link -->
 </tr>

<!-- BEGIN tab1 -->
 <tr style="background-color:{tab0.tab1.DATA_ROW_COLOR}">
  <td>{tab0.tab1.DATA_SHOW_SINGEL_STAT}</td>
  <td style="text-align:center">{tab0.tab1.DATA_SHOW_DATE}</td>
  <td style="text-align:center">{tab0.tab1.DATA_SHOW_CLOCK}</td>
  <td style="text-align:center">{tab0.tab1.DATA_SHOW_NUMBER}</td>
  <!-- BEGIN show_typ -->
  <td style="text-align:center">{tab0.tab1.show_typ.DATA_CALLERS}</td>
  <!-- END show_call_typ -->
  <!-- BEGIN show_prefix -->
  <td style="text-align:center">{tab0.tab1.show_prefix.DATA_SHOW_PREFIX}</td>
  <!-- END show_prefix -->
  <!-- BEGIN show_msn -->
  <td>{tab0.tab1.show_msn.DATA_SHOW_MSN}</td>
  <!-- END show_msn -->
  <td style="text-align:center">{tab0.tab1.DATA_SHOW_CALLERS_NAME}
	<!-- BEGIN show_sfcallnr -->
	<a href="http://www.dasoertliche.de/DB4Web/es/oetb2suche/home.htm?kw_invers={tab0.tab1.show_sfcallnr.DATA_NUMBERTOSF}&main=Antwort&AKTION=START_INVERS_SUCHE&SEITE=INVERSSUCHE_V&s=2&rg=1&taoid=&SKN=0&SEITE=INVERSSUCHE_V&AKTION=START_SUCHE" target="_blank">
	<img src="./images/launch.png" alt="" /></a>
	<!-- END show_sfcallnr -->

</td>
  <!-- BEGIN show_call_back -->
  <td style="text-align:center">{tab0.tab1.show_call_back.DATA_SHOW_CALL_BACK}</td>
  <!-- END show_call_back -->
  <td style="text-align:center">{tab0.tab1.DATA_TO_ADDR}</td>
  <!-- BEGIN show_delete_func -->
  <td style="text-align:center">
   <a href="./statistic_del_entry.php?id={tab0.tab1.show_delete_func.DATA_LINK_DELETE_FUNC}" title="{tab0.tab1.show_delete_func.L_DELETE_ENTRY_FROM_DB}">
   <img  src="./images/edittrash.png" style="border-width:0px;vertical-align:middle;"
   alt=""/>
   </a>
   </td>
  <!-- END show delete_func -->
  <!-- BEGIN show_cs_ab -->
  <td style="text-align:center">{tab0.tab1.show_cs_ab.DATA_SHOW_AB}</td>
  <!-- END show_cs_ab -->
 </tr>
 <!-- END tab1 --> 
</table>
<!-- END tab0 -->