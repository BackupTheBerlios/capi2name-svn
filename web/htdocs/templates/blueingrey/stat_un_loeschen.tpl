<div class="ueberschrift_seite">{SITE_TITLE}</div>
<br />
<!-- BEGIN delete_ok -->
<div class="blau_mittig">{L_MSG_DELTE_OK}</div>
<!-- END delte_ok -->
<!-- BEGIN delete_failed -->
<div class="rot_mittig">{L_MSG_DELETE_FAILED}</div>
<!-- END delete_failed -->
<!-- BEGIN tab1 -->
<div class="rot_mittig">{tab1.L_MSG_NOT_ALLOWED}</div>
<!-- END tab1 -->

<!-- BEGIN tab2 -->
<form action="stat_un_loeschen.php" method="post">
<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;" >
 <tr>
  <td></td>
  <td style="text-align:center">{tab2.L_DATE}</td>
  <td style="text-align:center">{tab2.L_TIME}</td>
  <td style="width:110px; text-align:center">{tab2.L_NUMBER}</td>
  <td style="text-align:center">{tab2.L_MSN}</td>
  <td style="text-align:center">{tab2.L_NAME}</td>
  </tr>
<!-- END tab2 -->

<!-- BEGIN tab3 -->
<tr style="background-color:{tab3.DATA_COLOR}">
  <td><input type="checkbox" name="{tab3.DATA_ID}"/></td>
  <td>{tab3.DATA_DATE}</td>
  <td>{tab3.DATA_TIME}</td>
  <td style="text-align:center">{tab3.DATA_NUMBER}</td>
  <td style="text-align:center">{tab3.DATA_MSN}</td>
  <td style="text-align:center">{tab3.DATA_NAME}</td>
</tr>
<!-- END tab3 -->

 </table>
 
<!-- BEGIN no_calls_found -->
<div class="rot_mittig">{L_MSG_CALLS_NOT_FOUND}</div>
<!-- END no_calls_found -->

<p><input type="checkbox" name="alle_unbekannten"/>{L_MSG_DELETE_UNKOWN}</p>
<p><input type="checkbox" name="nur_ruf_unbekannten"/>{L_MSG_DELETE_ONLY_NO_NAME}</p>
<ins>
<input type="submit" name="absenden" value="{L_DELETE}"/>
</ins>
</form>