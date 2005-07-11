<div class="ueberschrift_seite">Login</div>

<form action="./login.php" method="post">
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left">
 <tr>
  <td>{L_USERNAME}:</td>
  <td style="width:5px"></td>
  <td><input name="login_name" type="text"/></td>
 </tr>
 <tr>
  <td>{L_PASSWD}:</td>
  <td style="width:5px"></td>
  <td><input name="login_passwd" type="password"/></td>
 </tr>
 <tr>
  <td colspan="3"><input name="remember_login" type="checkbox"/> {L_STAY_LOGIN}</td>
 </tr>
 <tr>
  <td colspan="3" style="text-align:center;">
  <input name="seite" type="hidden" value="{DATA_TO_SITE}"/>
  <input name="absenden" value="{L_LOGIN}" type="submit"/></td>
 </tr>

</form>
</table>