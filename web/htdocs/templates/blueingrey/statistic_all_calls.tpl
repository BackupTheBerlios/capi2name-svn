<div class="ueberschrift_seite">{L_SITE_TITLE}</div>

<!-- BEGIN no_entry_found -->
<div class="rot_mittig">{no_entry_found.L_MSG_NOT_FOUND}</div>
<!-- END no_entry_found -->

<!-- BEGIN tab0 -->
<table border="0" cellpadding="1" cellspacing="2" style="margin-right:auto;margin-left:auto;">
 <tr>
   <td style="width:30px;text-align:center;"></td>
    <td style="width:110px;"><a href="./statistic_all_calls.php?order=lastname&#038;sortby=up"><img src="./images/up.png" border="0"></a> {tab0.L_ADDR_LAST_NAME} <a href="./statistic_all_calls.php?order=lastname&#038;sortby=down"><img src="./images/down.png" border="0"></a></td>
    <td style="width:100px;"><a href="./statistic_all_calls.php?order=firstname&#038;sortby=up"><img src="./images/up.png" border="0"></a> {tab0.L_ADDR_FIRST_NAME} <a href="./statistic_all_calls.php?order=firstname&#038;sortby=down"><img src="./images/down.png" border="0"></a></td>
    <td style="width:80px;text-align:center;"><a href="./statistic_all_calls.php?order=&#038;sortby=up"><img src="./images/up.png" border="0"></a> {tab0.L_ALL_CALLS} <a href="./statistic_all_calls.php?order=&#038;sortby=down"><img src="./images/down.png" border="0"></a></td>
    <td style="width:128px;text-align:center;"><a href="./statistic_all_calls.php?order=date&#038;sortby=up"><img src="./images/up.png" border="0"></a> {tab0.L_LAST_CALL} <a href="./statistic_all_calls.php?order=date&#038;sortby=down"><img src="./images/down.png" border="0"></a></td>
    <td></td>
 </tr>
 <!-- END tab0 -->
 <!-- BEGIN tab1 -->
 <tr style="background-color:{tab1.DATA_COLOR}">
  <td style="width:30px;text-align:left;">{tab1.DATA_INDEX}</td>
  <td><a href="./addressbook.php?id={tab1.DATA_ID}#find">{tab1.DATA_LAST_NAME}</a></td>
  <td><a  href="./addressbook.php?id={tab1.DATA_ID}#find">{tab1.DATA_FIRST_NAME}</a></td>
  <td style="text-align:right;">{tab1.DATA_COUNT}</td>
  <td style="text-align:center;">{tab1.DATA_LAST_CALL}</td>
  <td style="text-align:center;">
  <a href="./statistic_person.php?id={tab1.DATA_ID}" >
  <img src="./images/data.png" style="border-width:0px;vertical-align:middle;" alt="" title="{tab1.L_SEARCH_ENTRY}"/></a>
  </td>
 </tr>
 <!-- END tab1 -->
 <!-- BEGIN tab0 -->
 </table>
 <!-- END tab0 -->
 <br/>
