<?php
	$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
	$result=$zugriff_mysql->sql_abfrage("SELECT std FROM farben WHERE name='farbwahl'");
	$row=mysql_fetch_array($result);
	$result=$zugriff_mysql->sql_abfrage("SELECT name, wert1, wert2, wert3, wert4, wert5, wert6, wert7, wert8, wert9, wert10, wert11, wert12  FROM farben WHERE id='$row[0]'");
	$c_color=mysql_fetch_array($result);
	$zugriff_mysql->close_mysql();
?>
body {
	font-family:		Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size:			11pt;
	font-weight:		normal;
	background-color:	<?php echo $c_color[3]; ?>;
} 
#whitebox {
	width:				98%;
	margin:				0px auto;
	text-align:			left;
	padding:			5px;
	border:				solid 1px #A3A3CB;
	background-color:	<?php echo $c_color[7]; ?>;
	-moz-border-radius:	7px;
}
#navbox {
	width:				14%;
	float:				left;
	line-height:		18px;
	border:				solid 1px #606096;
	background-color:	<?php echo $c_color[6]; ?>;
	font-size:			10pt;
	overflow:			hidden;
	-moz-border-radius:	7px;
}

*.menuitem {
	margin:				0px;
	padding:			0px;
}

*.menuitem:before {
	content:			"· ";
	font-size:			large;
}

#mainbox {
	width:				85%;
	float:				right;
	background-color:	red;
	margin-top:			35px;
	border:				solid 1px #606096;
	background-color:	<?php echo $c_color[10]; ?>;
	text-align:			center;
	-moz-border-radius:	7px;
}

.content  {
	margin:				5px;
}
.headline {
	background-color:	<?php echo $c_color[4]; ?>;
	padding:			5px;
	text-align:			center;
	vertical-align:		middle;
	font-weight:		bold;
	border-bottom:		solid 1px;
	border-color:		#606096;
	font-size:			11pt;
	color:				<?php echo $c_color[5]; ?>;
	-moz-border-radius-topleft:		7px;
	-moz-border-radius-topright:	7px;
}
#navbox .navboxh {
	font-weight:		bold;
	margin-top:			1em;
}
#navbox .navboxlist {
	margin-left:		5px;
	margin-top:			5px;
}

.footer {
	clear:				both;
	text-align:			right;
	padding:			5px;
	font-size:			x-small;
}

.code {
	background:			#FFFFFF;
	border:				solid 1px #000000;
	font-family:		monospace;
	font-size:			11px;
	padding:			1em;
	margin:				2em;
}
.ueberschrift_seite
	{
	 text-align:		center;
	 font-size:			22pt;
	 font-weight:		bold;
	 padding-top:		23px;
	 padding-bottom:	23px;
	 
	}
.rot_mittig
	{
	 text-align:		center;
	 color:				red;
	}
.blau_mittig
	{
	 text-align:		center;
	 color:				blue;
	}
a:link, a:visited, a:active
	{
	 color:				<?php echo $c_color[1]; ?>;
	}
a:hover
	{
	 color:				<?php echo $c_color[2]; ?>;
	}
