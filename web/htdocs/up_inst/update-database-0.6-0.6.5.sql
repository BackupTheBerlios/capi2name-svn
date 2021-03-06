UPDATE `capi_version` SET `version` = '0.6.5' WHERE `id` = '1' LIMIT 1 ;
ALTER TABLE `angerufene` ADD `dienst` INT;
ALTER TABLE `userliste` ADD `showtyp` VARCHAR( 10 ) ;
ALTER TABLE `userliste` ADD `loeschen` VARCHAR( 10 ) ;
ALTER TABLE `angerufene` CHANGE `uhrzeit` `uhrzeit` TIME NOT NULL;
ALTER TABLE `userliste` CHANGE `showconfig` `showconfig` VARCHAR( 20 ) DEFAULT NULL;
ALTER TABLE `userliste` CHANGE `showtyp` `showtyp` VARCHAR( 20 ) DEFAULT NULL;
ALTER TABLE `userliste` CHANGE `vorwahl` `showvorwahl` VARCHAR( 20 ) DEFAULT NULL;
ALTER TABLE `userliste` CHANGE `notiz` `shownotiz` VARCHAR( 20 ) DEFAULT NULL;
ALTER TABLE `notiz` CHANGE `datum` `datum` VARCHAR( 10 ) DEFAULT NULL;
ALTER TABLE `notiz` CHANGE `uhrzeit` `uhrzeit` TIME DEFAULT NULL;
ALTER TABLE `notiz` CHANGE `topic` `topic` VARCHAR( 100 ) DEFAULT NULL;
ALTER TABLE `notiz` CHANGE `schreiber` `schreiber` VARCHAR( 75 ) DEFAULT NULL;
ALTER TABLE `userliste` CHANGE `name` `name` VARCHAR( 100 ) DEFAULT NULL;
ALTER TABLE `userliste` CHANGE `rueckruf` `showrueckruf` VARCHAR( 20 ) DEFAULT NULL;
INSERT INTO farben VALUES (5,'blau in blau','','#213D56','#346763','#294C6B','#6DA5D6',' #19242',' #4B8DC',' #3C709','#294C6B','#294C6B','#3C709D','#87C5E4','#6DA5D6');
INSERT INTO farben VALUES (6,'gr�n in gr�n','','yellow','red','#69932B','#638A28','#3D5519','#7CAD32','#7CAD32','black','black','#91CB3B','#87BC37','#69932B');
INSERT INTO farben VALUES (7,'blau in grau','','#213D56','#346763','#9EA3A3','#6DA5D6','#19242A','#C8CECE','#B8BEBE','#294C6B','#B6BCBC','#C8CECE','#87C5E4','#6DA5D6');
