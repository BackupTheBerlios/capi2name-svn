<!-- BEGIN not_allowed -->
<div class="rot_mittig">{not_allowed.L_MSG_NOT_ALLOWED}</div>
<!-- END not_allowed -->

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
  <a href="./addressbook.php??find=yes&amp;findnr={tab2.DATA_NUMBER}#find">{tab2.DATA_NAME}</a></td>
  <td style="width:150px; text-align:center;">
  <a href="./callback_show.php?anz={tab2.DATA_ID}" title="{tab2.L_SHOW_REASON}">{tab2.DATA_NUMBER}</a></td>
  <td style="text-align:center;">{tab2.DATA_TIME} - {tab2.DATA_DATE}</td>
  <td style="width:150px; text-align:center;">{tab2.DATA_CALL_BACK_TIME}</td>
  <td style="text-align:center;">
  <a href="./callback.php?loeschen={tab2.DATA_ID}" title="Loeschen">
  <img src="./bilder/edittrash.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
</tr>
<!-- END tab2 -->
</table>