<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonasge@gmx.net
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
  // 	editor: Kai Römer 
function nummer2Name($nummer) 
{
	$tab_adressbuch = mysql_query("SELECT t1.name_first,t1.name_last,t1.id,
	 	t2.areacode
		FROM phonenumbers AS t2 
		LEFT JOIN addressbook AS t1 ON t2.addr_id=t1.id WHERE t2.number='$nummer'");
		if (mysql_num_rows($tab_adressbuch) == 0)
		{
			return "<a href=\"addressbook_add.php?rufnr=$nummer\">$nummer</a>";
		}
		else if (mysql_num_rows($tab_adressbuch) == 1) {
			$data=mysql_fetch_assoc($tab_adressbuch);
			if ($fax == $nummer) $zusatz = "(Fax)";
			if ($handy == $nummer) $zusatz = "(Handy)";
			return "<a href=\"addressbook.php?id=$data[id]#find\">$data[name_last], $data[name_first]<br />$zusatz</a>";
		}
		
		return "error";
	}
	
	function cmp($a, $b) {
		if (preg_replace("/(.*;)(.*)/","\\1", $a) == preg_replace("/(.*;)(.*)/","\\1", $b)) {
			return 0;
		}
		return (preg_replace("/(.*;)(.*)/","\\1", $a) > preg_replace("/(.*;)(.*)/","\\1", $b)) ? -1 : 1;
	}
	
	function checkUsername ($name) {
		$a = exec("id -g $name",$a, $retval);
		return $retval;
	}

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );

$result=$dataB->sql_query("SELECT * FROM config WHERE conf LIKE 'cs_%'");
 while($daten_cs=$dataB->sql_fetch_assoc($result))
  {
   $cs_conf[$daten_cs[conf]]=$daten_cs[value];
  }
$dataB->sql_close();
?>