<?php
	function nummer2Name($nummer) {
		$tab_adressbuch = mysql_query("SELECT `id`, `vorname`, `nachname`, `handy`, `fax` FROM `adressbuch` WHERE `tele1`='$nummer' OR `tele2`='$nummer' OR `tele3`='$nummer' OR `handy`='$nummer' OR `fax`='$nummer'");
		if (mysql_num_rows($tab_adressbuch) == 0) return "<a href=\"addadress.php?" . handynr_vorhanden($nummer) . "\">$nummer</a>";
		else if (mysql_num_rows($tab_adressbuch) == 1) {
			list($id, $vorname, $nachname,$handy,$fax) = mysql_fetch_array($tab_adressbuch);
			if ($fax == $nummer) $zusatz = "(Fax)";
			if ($handy == $nummer) $zusatz = "(Handy)";
			return "<a href=\"adressbuch.php?findnr=$nummer\">$nachname, $vorname<br />$zusatz</a>";
		}
		return "error";
	}
	
	function cmp($a, $b) {
		if (preg_replace("/(.*;)(.*)/","\\1", $a) == preg_replace("/(.*;)(.*)/","\\1", $b)) {
			return 0;
		}
		return (preg_replace("/(.*;)(.*)/","\\1", $a) > preg_replace("/(.*;)(.*)/","\\1", $b)) ? -1 : 1;
	}
?>