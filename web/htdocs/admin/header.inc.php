<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15"/> 
  <title>Capi2Name: Administration Panel</title>
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
	 min-height:			550px;
	 padding-bottom:		20px;
	}
#menu
	{
	 background-color:		#C8CECE;
	 border-width:			1px;
	 border-style:			solid;
	 border-color:			#294C6B;
	 width:				168px;
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
	 margin-left:			178px;
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
  <script type="text/javascript">
   //<!--
   function showDoc(){
     window.open("", "showDoc", "width=500,height=300,toolbar=0,status=0,scrollbars=1,location=0,menubar=1,resizable=1");}
   //-->
  </script>
 </head>
 <body>
 <div id="mainframe">
  <div id="menu">
   <div class="header">Menuitem</div>
   <div class="menulist"><!--	Menupunkte	Anfang	-->
   <div style="font-weight:bold; margin-top: 1em;"></div>
   
   <div class="menuitem"><a href="../index.php">Go to Webinterface</a></div>
   <div class="menuitem"><a href="http://www.capi2name.de" target="_blank">Go to Projecthomepage</a></div>
   <br/>
   <div class="menuitem"><a href="./index.php">Index</a></div>
   <div class="menuitem"><a href="./user_add.php">Add new User</a></div>
   <div class="menuitem"><a href="./global_config.php">Global Config</a></div>
   <div class="menuitem"><a href="./passwd.php">Change Password</a></div>
   <div class="menuitem"><a href="./vorwahl.php">Change Prefix</a></div>
  <!-- <div class="menuitem"><a href="./farben.php">Colorsetup</a></div> -->
   <div class="menuitem"><a href="./msn2name.php">MSN to name</a></div>
   <div class="menuitem"><a href="./adressbuch_bug.php">Adressbook BUG</a></div>
   <div class="menuitem"><a href="./cs_install.php">CapiSuite Integrator</a></div>
   </div><!-- Menupunkte Ende-->
  </div><!--Menu ENDE -->
  <div id="main"><!--	Tabelle		Anfang	-->
   <div class="header2">Capi2Name: Administration Panel</div>



