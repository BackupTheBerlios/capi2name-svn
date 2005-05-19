<div class="ueberschrift_seite">{L_SITE_TITLE}</div>
<br />

<!-- BEGIN tab1 -->
<table border="0" width="100%" style="margin-right:auto;margin-left:auto;text-align:left;">
 <tr>
 <td valign="top" >
 <h3>{tab1.L_DETAIL_VIEW}</h3>
      <table border="0" cellpadding="1" cellspacing="2">
       <tr>
             <td>{tab1.L_ADDR_FRIST_NAME}:</td>
	     <td style="width:10px"> </td>
	     <td>{tab1.DATA_FIRST_NAME}</td>
        </tr>
	<tr>
	   <td>{tab1.L_ADDR_LAST_NAME}:</td>
	   <td style="width:10px"> </td>
	   <td>{tab1.DATA_LAST_NAME}</td>
        </tr>
<!-- END tab1 -->
<!-- BEGIN show_tele -->
<tr>
   <td>{show_tele.L_TELE}:</td>
   <td style="width:10px"> </td>
   <td>{show_tele.DATA_TELE}</td>
</tr>
<!-- END show_tele -->
<!-- BEGIN show_cell_phone -->
<tr>
   <td>{show_cell_phone.L_CELL_PHONE}:</td>
   <td style="width:10px"> </td>
   <td>{show_cell_phone.DATA_CELL_PHONE}</td>
</tr>
<!-- END show_cell_phone -->
<!-- BEGIN show_fax -->
<tr>
   <td>{show_fax.L_FAX}:</td>
   <td style="width:10px"> </td>
   <td>{show_fax.DATA_FAX}</td>
</tr>
<!-- END show_fax -->

</table>
<br />

<!-- BEGIN tab2 -->
<h3>{tab2.L_STAT_CALLERS_COUNTS}</h3>
 <table border="0">
  <tr>
    <td>{tab2.L_ALL_CALLS}:</td>
    <td>&nbsp;</td>
    <td>{tab2.DATA_ALL_CALLS}</td>
  </tr>
  <tr>
    <td>{tab2.L_STAT_TIME}:</td>
    <td>&nbsp;</td>
    <td>{tab2.DATA_WEEKS} {tab2.L_WEKKS}</td>
  </tr>
  <tr>
    <td>{tab2.L_LAST_CALL}:</td>
    <td>&nbsp;</td>
    <td>{tab2.DATA_LAST_DATE} / {tab2.DATA_LAST_TIME}</td>
  </tr>
  <tr>
    <td>{tab2.L_FRIST_CALL}:</td>
    <td>&nbsp;</td>
    <td>{tab2.DATA_FIRST_DATE} / {tab2.DATA_FIRST_TIME}</td>
  </tr>
  <tr>
    <td>{tab2.L_CALLS_AVERAGE}:</td>
    <td>&nbsp;</td>
    <td>{tab2.DATA_CALLS_AVERAGE}</td>
  </tr>
</table>
<!-- END tab2 -->
<br/>
<img src="./stat-user.png.php?id={DATA_ID_CALLERS}" style="border-width:0px;" alt="" />

<!-- BEGIN tab3 -->
</td>
  <td style="vertical-align:top;">
  <h3>{tab3.L_LSIT_ALL_CALLS}</h3>

<table border="0" cellpadding="5" cellspacing="2">
  <tr>
   <td style="text-align:center;">{tab3.L_DATE}</td>
   <td style="text-align:center;">{tab3.L_TIME}</td>
   <td style="text-align:center;">{tab3.L_CALL_NUMBER}</td>
   <td style="text-align:center;">{tab3.L_CALL_TO_MSN}</td>
  </tr>
<!-- END tab3 -->

<!-- BEGIN tab4 -->
<tr style="background-color:{tab4.DATA_COLOR}">
<td>{tab4.DATA_DATE}</td>
<td style="text-align:center;">{tab4.DATA_TIME}</td>
<td style="text-align:center;">{tab4.DATA_NUMBER}</td>
<td style="text-align:center;">{tab4.DATA_CALL_TO_MSN}</td>
</tr>
<!-- END tab4 -->
</table>
</td>
</tr>
</table>

<!-- BEGIN no_call_from_user -->
<br />
<span style="text-align:center">{no_call_from_user.L_MSG_NO_CALL}</span>
<!-- END no_call_from_user -->

