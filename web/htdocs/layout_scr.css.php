<?
echo "
body
	{
  	 background-color:		$c_color[3];
   	 position:			static;
	}
a:link, a:visited, a:active
	{
	 color:				$c_color[1];
	}
a:hover
	{
	 color:				$c_color[2];
	}
#mainframe
	{
	 background-color:		$c_color[7];
	 padding:			3px;
	 padding-top:			0.6cm;
	 min-height:			550px;
	 padding-bottom:		20px;
	}
#menu
	{
	 background-color:		$c_color[6];
	 border-width:			1px;
	 border-style:			solid;
	 border-color:			#294C6B;
	 width:				148px;
	 position:			fixed;
	}
*.header
	{
	 background-color:		$c_color[4];
	 border-width:			1px;
	 border-bottom-style:		solid;
	 font-weight:			bold;
     	 color:				$c_color[5];
	 padding-top:			3px;
	 padding-left:			11px;
	 padding-bottom:		3px;
	 margin:			0cm;
	 height:			20px;
	}
*.header2
	{
	 background-color:		$c_color[4];
	 border-width:			0px;
	 border-style:			solid;
	 border-color:			#B8BEBE;
	 border-bottom-width:		0px;
	 border-bottom-color:		#C8CECE;
	 font-weight:			bold;
	 text-align:			center;
	 color:				$c_color[5];
	 padding-top:			3px;
	 padding-bottom:		3px;
	 margin:			0cm;
	 height:			20px;
	}
*.menulist
	{
	 font-family:			arial,helvetica,geneva;
	 font-size:			small;
	 background-color:		$c_color[6];
	 padding:			3px;
	 padding-left:			3px;
	 margin:			0cm;
	}
*.menuitem {
	margin:				0px;
	padding:			0px;
}

*.menuitem:before {
	content:			\"· \";
	font-size:			large;
}

#main
	{
	 font-family:			arial,helvetica,geneva;
	 background-color:		$c_color[10];
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

";
?>
