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
	function nummer2Name($nummer) {
		$tab_adressbuch = mysql_query("SELECT `id`, `vorname`, `nachname`, `handy`, `fax` FROM `adressbuch` WHERE `tele1`='$nummer' OR `tele2`='$nummer' OR `tele3`='$nummer' OR `handy`='$nummer' OR `fax`='$nummer'");
		if (mysql_num_rows($tab_adressbuch) == 0) return "<a href=\"addressbook_add.php?" . handynr_vorhanden($nummer) . "\">$nummer</a>";
		else if (mysql_num_rows($tab_adressbuch) == 1) {
			list($id, $vorname, $nachname,$handy,$fax) = mysql_fetch_array($tab_adressbuch);
			if ($fax == $nummer) $zusatz = "(Fax)";
			if ($handy == $nummer) $zusatz = "(Handy)";
			return "<a href=\"addressbook.php?id=$id#find\">$nachname, $vorname<br />$zusatz</a>";
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
?> 