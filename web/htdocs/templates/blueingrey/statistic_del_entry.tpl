<div class="ueberschrift_seite">{L_SITE_TITLE}</div>
<br />
<!-- BEGIN not_allowed_view -->
<div class="rot_mittig">{not_allowed_view.L_MSG_NOT_ALLOWED}</div>
<!-- END not_allowed_view -->
<br/>
<!-- BEGIN del_entry_successfully -->
<div class="blau_mittig">{del_entry_successfully.L_MSG_SUCCESS}</div>
<meta http-equiv="refresh" content="2; URL=./showstatnew.php{del_entry_successfully.DATA_DATE}">
<!-- END del_entry_successfully -->


<!-- BEGIN check_if_del -->
<div class="rot_mittig">{check_if_del.L_MSG_CHECK_TO_DEL}</div>
<br />
<table border="0" style="margin-right:auto;margin-left:auto;">
  <tr>
   <td>{check_if_del.L_ID}</td>
   <td style="text-align:center\">{check_if_del.L_DATE}</td>
   <td style="text-align:center\">{check_if_del.L_TIME}</td>
   <td style="text-align:center\">{check_if_del.L_NUMBER}</td>
  </tr>
  <tr>
   <td style="text-align:center">{check_if_del.DATA_ID}</td>
   <td style="text-align:center">{check_if_del.DATA_DATE}</td>
   <td style="text-align:center">{check_if_del.DATA_TIME}</td>
   <td style="text-align:center">{check_if_del.DATA_NUMBER}</td>
  </tr>
</table>
<br />
<form action="statistic_del_entry.php" method="post">
 <ins>
  <input type="hidden" name="id" value="{check_if_del.DATA_ID}"/>
  <input type="hidden" name="datum" value="{check_if_del.DATA_FROM_GET}"/>
  <input type="submit" name="btn_loeschen" value="{check_if_del.L_DELETE}"/>
 </ins>
</form>
<!-- END check_if_del -->