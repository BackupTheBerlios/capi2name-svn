<?
/*
    copyright            : (C) 2002-2003 by Jonas Genannt
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
 ?>
<?
$seite="index.php";
include("../conf.inc.php");
include("header.inc.php");
include("./check_it.php");

?>


<br>
<center>
<h3>Vorwahlbereiche Anpassen</h3>
</center>
<br>
Hier kann man die Vorwahlbereiche festlegen, das hei�t, z.B. wenn jemand aus dem Vorwahlbereich 089 anruft, steht in der Anrufstatistik  M�nchen.
<br>
<br>
Dies kann hier festlegen.

<center>


<br><br>
<form action="vorwahlan.php" method="post">
<input name="anpassen" type="submit" value="Abgleichen"><br>
Dieser Button gleich die angerufene Tabelle mit der Vorwahltabelle ab, so sind die Vorwahlnamen wieder auf einem neuen Stand sind!<br>
<b>Wichtig: Diese Funktion dauert sehr lange. Es k�nnen bis 3 min sein. Je nach Hardware des Servers auf dem die Datenbank l�uft!</b>
</form>
<br><br>



<a href="./vorwahlshow.php">Zeige alle Eintr�ge der Tabelle Vorwahl</a><br>Dauert sehr lange! �ber 5000 Eintr�ge in einer Tabelle!



<?
include("./footer.inc.php");
?>
