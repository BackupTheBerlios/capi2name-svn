<div class="ueberschrift_seite">{L_TITLE_OF_CONFIG_PAGE}</div>
<br />
<!-- BEGIN userconfig_show_configpage -->
<div class="rot_mittig">{userconfig_show_configpage.L_NOT_SHOW_THIS_PAGE}</div>";
<!-- END userconfig_show_configpage -->

<!-- BEGIN tab1 -->
<form action="./configpage.php" method="post" >
<table border="0" style="margin-right:auto;margin-left:auto;text-align:left;">
 <tr>
  <td>{tab1.L_USER_NAME}:</td>
  <td style="width:10px;"></td>
  <td>{tab1.DATA_USER_NAME}</td>
 </tr>
 <tr>
  <td>{tab1.L_CHANGE_PASSWD}:</td>
  <td style="width:10px;"></td>
  <td></td>
 </tr>
 <tr>
  <td>{tab1.L_OLD_PASSWD}:</td>
  <td style="width:10px;"></td>
  <td><input type="password" name="altespassword"/></td>
 </tr>
 <tr>
  <td>{tab1.L_NEW_PASSWD}:<br />{tab1.L_NEW_PASSWD_CONFIRM}:</td>
  <td style="width:10px;"></td>
  <td><input type="password" name="password1"/><br /><input type="password" name="password2"/></td>
 </tr>
 <tr>
  <td>{tab1.L_FIRST_NAME}:</td>
  <td style="width:10px;"></td>
  <td><input type="text" name="first_name" value="{tab1.DATA_FIRST_NAME}"/></td>
 </tr>
 <tr>
  <td>{tab1.L_LAST_NAME}:</td>
  <td style="width:10px;"></td>
  <td><input type="text" name="last_name" value="{tab1.DATA_LAST_NAME}"/></td>
 </tr>
 <tr>
   <td>{tab1.L_SHOW_NUMBERS_OF_CALLS_IN_STAT}:</td>
   <td style="width:10px;"></td>
   <td>
   <input type="text" name="neueanzahl" value="{tab1.DATA_NUMBERS}" /></td>
 </tr>
<tr>
 <td>{tab1.L_SHOW_CALL_BACK_FUNC}:</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="zeigerueckruf"  {tab1.DATA_CALL_BACK_FUNC} /></td>
</tr>
<tr>
 <td>{tab1.L_SHOW_PREFIX_FUNC}</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="zeigevorwahl" {tab1.DATA_PREFIX_FUNC} /></td>
</tr>

<tr>
 <td style="vertical-align:top;">{tab1.L_SHOW_TYP_FROM_CALL}</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="zeigetyp" {tab1.DATA_SHOW_TYP_FROM_CALL} /></td>
</tr>

<tr>
 <td>{tab1.L_SHOW_MSN}</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="zeigemsn" {tab1.DATA_SHOW_MSN} /></td>
</tr>
<!-- BEGIN template_on -->
<tr>
 <td>{tab1.template_on.L_SET_TEMPLATE}:</td>
 <td style="width:10px;"></td>
 <td>
 <select name="new_template">
  <!-- BEGIN tab2 -->
  <option value="{tab1.template_on.tab2.DATA_TEMPLATE}" {tab1.template_on.tab2.DATA_SELECTED}>{tab1.template_on.tab2.DATA_TEMPLATE}</option>
  <!-- END tab2 -->
 </select>
 
 </td>
</tr>
<!-- END template_on -->
<tr>
 <td style="vertical-align:top;">{tab1.L_SHOW_MSN_FUNC}</td>
 <td style="width:10px;"></td>
 <td>
 <input type="text" name="zmsns" value="{tab1.DATA_SHOW_MSN_FUNC}"/>
 <br />{tab1.L_WARNING_FOR_MSN_FUNC}</td>
</tr>
</table>

<ins>
<input type="hidden" name="id" value="{tab1.DATA_ID_FROM_DB}"/>
<br/>
<input type="submit" name="speichern" value="{tab1.L_SAVE_DATA_TO_DB}"/></ins>
</form>

<!-- END tab1 -->