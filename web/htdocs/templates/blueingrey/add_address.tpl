<div class="ueberschrift_seite">{L_NEW_ENTRY_TO_ADDR}</div>
<br />

<form action="$SELF_PHP" method="post" >
<table border="0" cellpadding="3" style="margin-right:auto;margin-left:auto;">
<!-- BEGIN tab -->
 <tr>
  <td>{tab.L_ADDR_FRIST_NAME}:</td>
  <td style="width:12px;"></td>
  <td><input name="bvorname" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_LAST_NAME}:</td>
  <td style="12px;"></td>
  <td><input name="bnachname" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_STREET}:</td>
  <td style="12px;"></td>
  <td><input name="bstrasse" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_HOUSE_NR}:</td>
  <td style="12px;"></td>
  <td><input name="bhausnr" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_ZIP_CODE}:</td>
  <td style="12px;"></td>
  <td><input name="bplz" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_CITY}:</td>
  <td style="12px;"></td>
  <td><input name="bort" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_TELE_1}:</td>
  <td style="12px;"></td>
  <td><input name="btele1" type="text" value="$_GET[rufnr]"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_TELE_2}:</td>
  <td style="12px;"></td>
  <td><input name="btele2" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_TELE_3}:</td>
  <td style="12px;"></td>
  <td><input name="btele3" type="text"/></td>
 </tr>
 <tr>
  <td>{tab.L_ADDR_CELL_PHONE}:</td>
  <td style="12px;"></td>
  <td><input name="bhandy" type="text" value="$_GET[handy]"/></td>
 </tr>
  <tr>
  <td>{tab.L_ADDR_FAX}:</td>
  <td style="12px;"></td>
  <td><input name="bfax" type="text"/></td>
 </tr>

 <tr>
  <td>{tab.L_ADDR_E_MAIL}:</td>
  <td style="12px;"></td>
  <td><input name="bemail" type="text"/></td>
 </tr>
</table>
<ins><br/><input type="submit" name="eintragen" value="{tab.L_ADDR_ADD_NEW_ENTRY}"/></ins>
</form>
<!-- END tab -->
