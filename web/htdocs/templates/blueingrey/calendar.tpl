<div class="ueberschrift_seite">{L_SITE_TITLE}</div>



<table border="0" cellpadding="3" cellspacing="2" style="margin-right:auto;margin-left:auto;text-align:left">
<tr>
 <td style="font-weight:bold;">
  <a href="./kalender.php?datum=yes&monat={DATA_CUR_MONTH1}&jahr={DATA_CUR_YEAR1}">&laquo;</a>
 </td>
    <td colspan="5" style="text-align:center;font-weight:bold; font-size:large;">{DATA_TITLE_YEAR}</td>
    <td style="font-weight:bold;">
    <a href="./kalender.php?datum=yes&monat={DATA_CUR_MONTH2}&jahr={DATA_CUR_YEAR1}">&raquo;</a></td>
</tr>
<tr>
    <td style="font-weight:bold; font-size:large;">{L_DAY_MO}</td>
    <td style="font-weight:bold; font-size:large;">{L_DAY_TUE}</td>
    <td style="font-weight:bold; font-size:large;">{L_DAY_WED}</td>
    <td style="font-weight:bold; font-size:large;">{L_DAY_THU}</td>
    <td style="font-weight:bold; font-size:large;">{L_DAY_FRI}</td>
    <td style="font-weight:bold; font-size:large;">{L_DAY_SAT}</td>
    <td style="font-weight:bold; font-size:large;">{L_DAY_SUN}</td>
</tr>
<tr>
<!-- BEGIN tab1 -->
<td style="text-align:center;background-color:{tab1.DATA_COLOR}">
<a href="./showstatnew.php?sdatum={tab1.DATA_DAY_BEFOR}.{tab1.DATA_MONTH}.{tab1.DATA_YEAR}">{tab1.DATA_DAY_BEFOR}</a></td>
<!-- END tab1 -->
<!-- BEGIN tab2 -->
<td style="text-align:center;background-color:{tab2.DATA_COLOR}">
<a href="./showstatnew.php?sdatum={tab2.DATA_DAY}.{tab2.DATA_MONTH}.{tab2.DATA_YEAR}">{tab2.DATA_E}</a>
</td>
<!-- END tab2 -->
<!-- BEGIN tab3 -->
</tr>
<tr>
<!-- END tab3 -->
<!-- BEGIN tab4 -->
<td style="text-align:center;background-color:{tab4.DATA_COLOR}">
<a href="./showstatnew.php?sdatum=0{tab4.DATA_DAY}.{tab4.DATA_MONTH}.{tab4.DATA_YEAR}">{tab4.DATA_DAY}</a></td>
<!-- END tab4 -->
      
</tr>
</table>
<br />