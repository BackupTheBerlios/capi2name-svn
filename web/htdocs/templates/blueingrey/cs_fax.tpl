<div class="ueberschrift_seite">{L_SITE_TITLE}</div>
<!-- BEGIN user_error -->
<div class="rot_mittig">{user_error.L_USER_NOT_FOUND}</div>
<!-- END user_error -->


<!-- BEGIN tab1 -->
<h3>{tab1.CS_FAX_LIST}</h3>
<table border="0" style="margin-right:auto;margin-left:auto;">
<tr style="font-weight:bold;">
   <td style="width:80px;text-align:center">{tab1.CS_AP_DATE}</td>
   <td style="width:70px;text-align:center">{tab1.CS_AP_TIME}</td>
   <td style="width:110px;text-align:center">{tab1.CS_AP_NR}</td>
   <td style="text-align:center">{tab1.CS_AP_MSN}</td>
   <td style="text-align:center">{tab1.CS_AP_NAME}</td>
   <td style="width:120px;text-align:center">{tab1.CS_VIEW}</td>
   <!-- BEGIN del -->
   <td style="text-align:center;">{tab1.del.L_DELETE}</td>
   <!-- END del -->
  </tr>
  <!-- BEGIN tab2 -->
  <tr bgcolor="{tab1.tab2.DATA_COLOR}">
   <td>{tab1.tab2.DATA_DATE}</td>
   <td>{tab1.tab2.DATA_TIME}</td>
   <td>{tab1.tab2.DATA_NUMBER}</td>
   <td>{tab1.tab2.DATA_MSN}</td>
   <td>{tab1.tab2.DATA_NAME}</td>
   <td><a href="ge.php?file={tab1.tab2.DATA_CS_ID}"><img src="./images/view.png" border="0"></a></td>
  <!-- BEGIN delD -->
  <td style="text-align:center;"><a href="./cs_fax.php?del={tab1.tab2.delD.DATA_ID}"><img src="./images/edittrash.png" border="0"></a></td>
  <!-- END delD -->
  </tr>
  <!-- END tab2 -->
</table>
<!-- END tab1 -->
