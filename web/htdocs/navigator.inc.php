				<div class="menulist"><!--	Menupunkte	Anfang	-->
					<div class="menuitem"><a href="./index.php"><? echo "$textdata[header_inc_index]"; ?></a></div>
					<div class="menuitem"><a href="./powered.php"><? echo "$textdata[header_inc_powered]"; ?></a></div>
<?php
	if ($userconfig['showconfig'])
		echo "	<div class=\"menuitem\"><a href=\"./configpage.php\">$textdata[header_inc_configpage]</a></div>";
?>
					<div style="font-weight:bold; margin-top: 1em;"><?php echo "$textdata[header_inc_telefon]:"; ?></div>
					<div class="menuitem"><a href="./showstatnew.php"><? echo "$textdata[header_inc_anrufstatistik]"; ?></a></div>
					<div style="font-weight:bold; margin-top: 1em;"><? echo "$textdata[header_inc_erweiterte_stat]:"; ?></div>
					<div class="menuitem"><a href="./showstatnew.php?datum=heute"><? echo "$textdata[header_inc_heute_anrufte]"; ?></a></div>
					<div class="menuitem"><a href="./showstatnew.php?datum=gestern"><? echo "$textdata[header_inc_gestrige_anrufe]"; ?></a></div>
					<div class="menuitem"><a href="./showstatnew7days.php"><? echo "$textdata[header_inc_7tage]"; ?></a></div>
					<div class="menuitem"><a href="./stat_gesamt.php"><? echo "$textdata[header_inc_gesamtstatistik]"; ?></a></div>
					<div class="menuitem"><a href="./stat_monat.php"><? echo "Monatsübersicht"; ?></a></div>
					<div class="menuitem"><a href="./globale_suche.php"><? echo "Suche"; ?></a></div>
					<div class="menuitem"><a href="./kalender.php"><? echo "$textdata[header_inc_kalender]"; ?></a></div>
<?
if ($userconfig['loeschen'])
echo "<div class=\"menuitem\">
	<a href=\"./stat_un_loeschen.php\">Löschfunktion</a></div>";
?>			
			
    
<?php
	if ($userconfig['showrueckruf']) {
?>
					<div style="font-weight:bold; margin-top: 1em;"><?php echo $textdata[header_inc_rueckruf]; ?></div>
					<div class="menuitem"><a href="./zurueckruf.php"><?php echo $textdata[header_inc_rueckruf]; ?></a></div>
					<div class="menuitem"><a href="./zurueckruf.php?add=yes&amp;no=yes"><?php echo $textdata[header_inc_neuer_eintrag]; ?></a></div>
<?php
	}
?>
					<div style="font-weight:bold; margin-top: 1em;"><? echo "$textdata[header_inc_adressbuch]:"; ?></div>
					<div class="menuitem"><a href="./adressbuch.php"><? echo "$textdata[header_inc_adressbuch]"; ?></a></div>
					<div class="menuitem"><a href="./addadress.php"><? echo "$textdata[header_inc_neuer_eintrag]"; ?></a></div>
    
<?php
	if ($userconfig['shownotiz']){ 
?>
					<div style="font-weight:bold; margin-top: 1em;"><? echo $textdata[header_inc_notizen];?></div>
					<div class="menuitem"><a href="./notiz.php"><? echo $textdata[header_inc_notizen]; ?></a></div>
					<div class="menuitem"><a href="./notiz.php?new=yes"><? echo $textdata[header_inc_neue_notiz]; ?></a></div>
<?php
	}
	if ($config['capisuite'] == "yes"){ 
?>
					<div style="font-weight:bold; margin-top: 1em;">CapiSuite</div>
					<div class="menuitem"><a href="./cs_answerphone.php"><? echo $textdata[header_inc_cs_answerphone]; ?></a></div>
					<div class="menuitem"><a href="./cs_fax.php"><? echo $textdata[header_inc_cs_fax]; ?></a></div>
					<div class="menuitem"><a href="./cs_help.php"><? echo $textdata[header_inc_cs_help]; ?></a></div>
<?php
}
?>
				</div>