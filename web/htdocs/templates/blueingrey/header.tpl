<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>{CAPI2NAME_PAGE_TITLE}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" /> 
  <link rel="stylesheet" type="text/css" href="templates/blueingrey/css.css" />
  <script type="text/javascript">
   function addValue(form,forma)
   {
    var value = prompt("Please enter the new option");
    var select = eval('document.' + form);
    var number = eval('document.'+forma);
    if (value == "")
    {
        alert("You must specify a value");
        return false;
    }
    if (value != null)
    {
        var newOpt = new Option(value, value);
        select.options[select.length] = newOpt;
        select.options.selectedIndex = select.length-1;
	number.disabled=false;
    }
  }
  function enableNUMBER(form)
   {
    var number =eval('document.'+form);
    number.disabled=true;
   }
</script>
  
</head>
<body>
<div id="mainframe">
 <div id="menu">
  <div class="header">{L_HAUPTMENU}</div>
  <div class="menulist">
   <div class="menuitem"><a href="./index.php">{L_INDEX}</a></div>
   <div class="menuitem"><a href="./powered.php">{L_POWERED_BY}</a></div>
   <!-- BEGIN show_config_page_on -->
   <div class="menuitem"><a href="./configpage.php">{L_CONFIGPAGE}</a></div>
   <!-- END show_config_page_on -->
   <div style="font-weight:bold; margin-top: 1em;">{L_TELEPOHN}:</div>
   <div class="menuitem"><a href="./showstatnew.php">{L_CALL_STAT_NORMAL}</a></div>
   <div style="font-weight:bold; margin-top: 1em;">{L_CALL_STAT_EXTENED}:</div>
   <div class="menuitem"><a href="./showstatnew.php?datum=heute">{L_CALL_STAT_TODAY}</a></div>
   <div class="menuitem"><a href="./showstatnew.php?datum=gestern">{L_CALL_STAT_YESTERDAY}</a></div>
   <div class="menuitem"><a href="./showstatnew7days.php">{L_CALL_STAT_7_DAYS}</a></div>
   <div class="menuitem"><a href="./statistic_all_calls.php">{L_CALL_ALL_STAT}</a></div>
   <div class="menuitem"><a href="./stat_monat.php">{L_CALL_STAT_MONTH}</a></div>
   <div class="menuitem"><a href="./global_search.php">{L_SEARCH}</a></div>
   <div class="menuitem"><a href="./calendar.php">{L_CALENDAR}</a></div>
   <!-- BEGIN show_delete_page_unkown_calls_on -->
   <div class="menuitem"><a href="./stat_un_loeschen.php">{L_DELETE_FUNCTION}</a></div>
   <!-- END show_delete_page_unkown_calls_on -->
   <!-- BEGIN show_call_back_pages_on -->
   <div style="font-weight:bold; margin-top: 1em;">{L_CALL_BACK}:</div>
   <div class="menuitem"><a href="./callback.php">{L_CALL_BACK}</a></div>
   <div class="menuitem"><a href="./callback.php?add=yes">{L_NEW_ENTRY}</a></div>
   <!-- END show_call_back_pages_on -->
   
   <div style="font-weight:bold; margin-top: 1em;">{L_ADDRESS_BOOK}:</div>
   <div class="menuitem"><a href="./addressbook.php">{L_ADDRESS_BOOK}</a></div>
   <div class="menuitem"><a href="./addressbook_add.php">{L_NEW_ENTRY}</a></div>
   
   <!-- BEGIN show_capi_suite_on -->
   <div style="font-weight:bold; margin-top: 1em;">{L_CAPI_SUITE}</div>
   <div class="menuitem"><a href="./cs_answerphone.php">{L_CAPI_SUITE_ANSWERPHONE}</a></div>
   <div class="menuitem"><a href="./cs_fax.php">{L_CAPI_SUITE_FAX}</a></div>
   <div class="menuitem"><a href="./cs_help.php">{L_CAPI_SUITE_HELP}</a></div>
   <!-- END show_capi_suite_on -->
 </div>
</div>
<div id="main">
<div class="header2">{CAPI2NAME_PAGE_TITLE}</div>
<!-- BEGIN up_inst -->
<div style"text-align:center;">{up_inst.L_MSG_UP_INST}</div>
<!-- END up_inst -->

<!-- BEGIN current_version -->
<div style"text-align:center;">{current_version.L_MSG_VERSION}</div>
<!-- END current_version -->
 