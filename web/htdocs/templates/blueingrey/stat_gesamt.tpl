<div class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN no_entry_found -->
<div class="rot_mittig">{no_entry_found.L_MSG_NOT_FOUND}</div>
<!-- END no_entry_found -->


<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;">
 <tr>
   <td style="width:30px;text-align:center;">
   <a href="./stat_gesamt.php?order={DATA_ORDER_OPTION}" title="{L_SORT_OPTION}">
    <img src="./bilder/rotate.png" style="border-width:0px;vertical-align:middle;" alt=""/></a></td>
    <td style="width:100px;">{L_ADDR_LAST_NAME}</td>
    <td style="width:100px;">{L_ADDR_FIRST_NAME}</td>
    <td style="width:50px;text-align:center;">{L_ALL_CALLS}</td>
    <td style="width:95px;text-align:center;">{L_LAST_CALL}</td>
    <td style="width:10px;"></td>
    <td></td>
 </tr>
 
 <!-- BEGIN tab1 -->
 <tr style="background-color:{tab1.DATA_COLOR}">
  <td style="width:30px;text-align:left;">{tab1.DATA_INDEX}</td>
  <td><a href="./addressbook.php?id={tab1.DATA_ID}#find">{tab1.DATA_LAST_NAME}</a></td>
  <td><a  href="./addressbook.php?id={tab1.DATA_ID}#find">{tab1.DATA_FIRST_NAME}</a></td>
  <td style="text-align:right;">{tab1.DATA_COUNT}</td>
  <td style="text-align:center;">{tab1.DATA_LAST_CALL}</td>
  <td style="width:10px;"></td>
  <!-- BEGIN no_call_from_user -->
  <td></td>
  <!-- END no_call_from_user -->
  <!-- BEGIN call_from_user -->
  <td style="text-align:center;">
  <a href="./stat_anrufer.php?id={tab1.call_from_user.DATA_ID}" title="{tab1.call_from_user.L_SEARCH_ENTRY}">
  <img src="./bilder/search.png" style="border-width:0px;vertical-align:middle;" alt=""/></a>
  </td>
  <!-- END call_from_user -->
 </tr>
 <!-- END tab1 -->
 
 </table>
 <br/>
