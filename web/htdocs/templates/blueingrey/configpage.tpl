<div class="ueberschrift_seite">{L_TITLE_OF_CONFIG_PAGE}</div>
<br />
<!-- BEGIN userconfig_show_configpage -->
<div class="rot_mittig">{userconfig_show_configpage.L_NOT_SHOW_THIS_PAGE}</div>
<!-- END userconfig_show_configpage -->

<!-- BEGIN update_passwd_failed -->
<div class="rot_mittig">{update_passwd_failed.L_MSG_PASSWD_FAILED}</div>
<!-- END update_passwd_failed -->
<!-- BEGIN update_empty_passwd -->
<div class="rot_mittig">{update_empty_passwd.L_MSG_NEW_PASSWD}</div>
<!-- END update_empty_passwd -->
<!-- BEGIN update_old_passwd -->
<div class="rot_mittig">{update_old_passwd.L_MSG_OLD_PASSWD}</div>
<!-- END update_old_passwd -->


<!-- BEGIN db_update_tempalte -->
<div class="rot_mittig">{db_update_tempalte.L_MSG_TEMPLATE_FAILED}</div>
<!-- END db_update_tempalte -->
<!-- BEGIN db_update_first_name -->
<div class="rot_mittig">{db_update_first_name.L_MSG_FIRST_NAME}</div>
<!-- END db_update_first_name -->
<!-- BEGIN db_update_last_name -->
<div class="rot_mittig">{db_update_last_name.L_MSG_LAST_NAME}</div>
<!-- END db_update_last_name -->
<!-- BEGIN db_update_callback -->
<div class="rot_mittig">{db_update_callback.L_MSG_SHOW_CALLBACK}</div>
<!-- END db_update_callback -->
<!-- BEGIN db_update_msn_listen -->
<div class="rot_mittig">{db_update_msn_listen.L_MSG_MSN_LISTEN}</div>
<!-- END db_update_msn_listen -->
<!-- BEGIN db_update_show_lines -->
<div class="rot_mittig">{db_update_show_lines.L_MSG_SHOW_LINES}</div>
<!-- END db_update_show_lines -->
<!-- BEGIN db_update_show_prefix -->
<div class="rot_mittig">{db_update_show_prefix.L_MSG_SHOW_PREFIX}</div>
<!-- END db_update_show_prefix -->
<!-- BEGIN db_update_show_msn -->
<div class="rot_mittig">{db_update_show_msn.L_MSG_SHOW_MSN}</div>
<!-- END db_update_show_msn -->
<!-- BEGIN db_update_show_type -->
<div class="rot_mittig">{db_update_show_type.L_MSG_SHOW_TYPE}</div>
<!-- END db_update_show_type -->
<!-- BEGIN db_update -->
<div class="blau_mittig">{db_update.L_MSG_SAVED}</div>
<!-- END db_update -->


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
  <td><input type="password" name="old_passwd"/></td>
 </tr>
 <tr>
  <td>{tab1.L_NEW_PASSWD}:<br />{tab1.L_NEW_PASSWD_CONFIRM}:</td>
  <td style="width:10px;"></td>
  <td><input type="password" name="password1"/><br /><input type="password" name="password2"/></td>
 </tr>
 <tr>
  <td>{tab1.L_FIRST_NAME}:</td>
  <td style="width:10px;"></td>
  <td><input type="text" name="name_first" value="{tab1.DATA_FIRST_NAME}"/></td>
 </tr>
 <tr>
  <td>{tab1.L_LAST_NAME}:</td>
  <td style="width:10px;"></td>
  <td><input type="text" name="name_last" value="{tab1.DATA_LAST_NAME}"/></td>
 </tr>
 <tr>
   <td>{tab1.L_SHOW_NUMBERS_OF_CALLS_IN_STAT}:</td>
   <td style="width:10px;"></td>
   <td>
   <input type="text" name="show_lines" value="{tab1.DATA_NUMBERS}" /></td>
 </tr>
<tr>
 <td>{tab1.L_SHOW_CALL_BACK_FUNC}:</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="show_callback"  {tab1.DATA_CALL_BACK_FUNC} /></td>
</tr>
<tr>
 <td>{tab1.L_SHOW_PREFIX_FUNC}</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="show_prefix" {tab1.DATA_PREFIX_FUNC} /></td>
</tr>

<tr>
 <td style="vertical-align:top;">{tab1.L_SHOW_TYP_FROM_CALL}</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="show_type" {tab1.DATA_SHOW_TYP_FROM_CALL} /></td>
</tr>

<tr>
 <td>{tab1.L_SHOW_MSN}</td>
 <td style="width:10px;"></td>
 <td><input type="checkbox" name="show_msn" {tab1.DATA_SHOW_MSN} /></td>
</tr>
<!-- BEGIN template_on -->
<tr>
 <td>{tab1.template_on.L_SET_TEMPLATE}:</td>
 <td style="width:10px;"></td>
 <td>
 <select name="template">
  <!-- BEGIN tab2 -->
  <option {tab1.template_on.tab2.DATA_SELECT} value="{tab1.template_on.tab2.DATA_TEMPLATE}" >{tab1.template_on.tab2.DATA_TEMPLATE}</option>
  <!-- END tab2 -->
 </select>
 
 </td>
</tr>
<!-- END template_on -->
<tr>
 <td style="vertical-align:top;">{tab1.L_SHOW_MSN_FUNC}</td>
 <td style="width:10px;"></td>
 <td>
 <input type="text" name="msn_listen" value="{tab1.DATA_SHOW_MSN_FUNC}"/>
 <br />{tab1.L_WARNING_FOR_MSN_FUNC}</td>
</tr>
</table>

<ins>
<input type="hidden" name="id" value="{tab1.DATA_ID_FROM_DB}"/>
<br/>
<input type="submit" name="save_data" value="{tab1.L_SAVE_DATA_TO_DB}"/></ins>
</form>

<!-- END tab1 -->