<?php
/*
    copyright            : (C) 2002-2004 by Jonas Genannt
    email                : jonasge@gmx.net
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
 // 	editor: Kai Römer 

?>
<?php
	$seite=base64_encode("cs_help.php");
	include("./login_check.inc.php");
	include("./header.inc.php");
	
?>
<?php echo "<div class=\"ueberschrift_seite\">CapiSuite Hilfe</div>"; ?>
<div style="text-align:left; margin: 5px;">
	<h2>Wieso capisuite</h2>
	<p><a href="http://www.capisuite.de" target="_blank">capisuite</a> bietet einen größeren Funktionsumfang als der Daemon von <a href="http://www.capi2name.de" target="_blank">capi2name</a>: Anrufbeantworter und Faxempfang/versand. <a href="http://www.capisuite.de" target="_blank">capisuite</a> hat aber kein Webinterface. Deshalb kann es sinnvoll sein <a href="http://www.capisuite.de" target="_blank">capisuite</a> mit dem Webinterface von <a href="http://www.capi2name.de" target="_blank">capi2name</a> zu kombinieren.</p>
	<h2>Installation</h2>
	<p>Folgende Veränderungen müssen auf <a href="http://www.capisuite.de" target="_blank">capisuite</a> angewandt werden, damit es zusammen mit <a href="http://www.capi2name.de" target="_blank">capi2name</a> läuft:</p>
	<ul>
		<li>Im <span style="font-family:monospace;">capisuite/daemon/contrib/capisuite/</span> Verzeichnis ist ein diff für die <span style="font-family:monospace;">/usr/lib/capisuite/incoming.py</span>. Dieses muss angewandt werden. Eine Beispiel <span style="font-family:monospace;">incoming.py</span> kann von <a href="http://www.openwww.org/software/capi2name/files/incoming.py">openwww.org</a> heruntergeladen werden.</li>
		<li>Die Datei <span style="font-family:monospace;">capisuite/daemon/contrib/capisuite/capi2name.pl</span> muss nach /usr/lib/capisuite kopiert werden.</li>
		<li>Versichern sie sich, dass alle Verzeichnisse unterhalb von <span style="font-family:monospace;">/var/spool/capisuite</span> für den Webserver lesbar und "ausführbar" sind sind. (rx Tags)</li>
		<li>Der Username bei capi2name muss dem Systemnutzer entsprechen, der die Faxe und Nachrichten von capisuite erhält.</li>
	</ul>
	<h2>Anrufbeantworter</h2>
	<p>nix besonderes</p>
	<h2>Fax</h2>
	<p>Um Faxe einfach online ansehen zu können, empfiehlt es sich auf dem capi2name Server sff2mix installiert zu haben. Den Source gibts <a href="http://capircvd.berlios.de/download/sff2misc/sff-1.0-jpegx2.tar.gz">hier</a></p>
	<p>Wer Faxe drehen können will, muss <a href="http://www.imagemagick.org" target="_blank">mogrify</a> auf dem Server installiert haben.</p>
</div>
<?php
include("./footer.inc.php");
?>