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