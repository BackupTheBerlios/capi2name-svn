<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>{CAPI2NAME_PAGE_TITLE}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15"/> 
  <style type="text/css">
	body
	{
  	 background-color:		#9EA3A3;
   	 position:			static;
	}
	a:link, a:visited, a:active
	{
	 color:				#213D56;
	}
	a:hover
	{
	 color:				#346763;
	}
	#mainframe
	{
	 background-color:		#B8BEBE;
	 padding:			3px;
	 padding-top:			0.6cm;
	 min-height:			630px;
	 padding-bottom:		20px;
	}
	#menu
	{
	 background-color:		#C8CECE;
	 border-width:			1px;
	 border-style:			solid;
	 border-color:			#294C6B;
	 width:				148px;
	 position:			fixed;
	}
	*.header
	{
	 background-color:		#6DA5D6;
	 border-width:			1px;
	 border-bottom-style:		solid;
	 font-weight:			bold;
     	 color:				#19242A;
	 padding-top:			3px;
	 padding-left:			11px;
	 padding-bottom:		3px;
	 margin:			0cm;
	 height:			20px;
	}
	*.header2
	{
	 background-color:		#6DA5D6;
	 border-width:			0px;
	 border-style:			solid;
	 border-color:			#B8BEBE;
	 border-bottom-width:		0px;
	 border-bottom-color:		#C8CECE;
	 font-weight:			bold;
	 text-align:			center;
	 color:				#19242A;
	 padding-top:			3px;
	 padding-bottom:		3px;
	 margin:			0cm;
	 height:			20px;
	}
	*.menulist
	{
	 font-family:			arial,helvetica,geneva;
	 font-size:			small;
	 background-color:		#C8CECE;
	 padding:			3px;
	 padding-left:			3px;
	 margin:			0cm;
	}
	*.menuitem {
	margin:				0px;
	padding:			0px;
	}

	*.menuitem:before {
	content:			"· ";
	font-size:			large;
	}
	#main
	{
	 font-family:			arial,helvetica,geneva;
	 background-color:		#C8CECE;
	 margin-left:			158px;
	 border-width:			1px;
	 border-style:			solid;
	 border-color:			#294C6B;
	 text-align:			center;
	 padding-bottom:		7px;
	}
	.ueberschrift_seite
	{
	 text-align:			center;
	 font-size:			22pt;
	 font-weight:			bold;
	 padding-top:			23px;
	 padding-bottom:		23px;
	 
	}
	.rot_mittig
	{
	 text-align:			center;
	 color:				red;
	}
	.blau_mittig
	{
	 text-align:			center;
	 color:				blue;
	}
</style>
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
   <div class="menuitem"><a href="./stat_gesamt.php">{L_CALL_ALL_STAT}</a></div>
   <div class="menuitem"><a href="./stat_monat.php">{L_CALL_STAT_MONTH}</a></div>
   <div class="menuitem"><a href="./globale_suche.php">{L_SEARCH}</a></div>
   <div class="menuitem"><a href="./kalender.php">{L_CALENDAR}</a></div>
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
   <div class="menuitem"><a href="./cs_answerphone.php"><? echo $textdata[header_inc_cs_answerphone]; ?></a></div>
   <div class="menuitem"><a href="./cs_fax.php">{L_CAPI_SUITE_ANSWERPHONE}</a></div>
   <div class="menuitem"><a href="./cs_help.php">{L_CAPI_SUITE_HELP}</a></div>
   <!-- END show_capi_suite_on -->
 </div>
</div>
<div id="main">
<div class="header2">{CAPI2NAME_PAGE_TITLE}</div>
 