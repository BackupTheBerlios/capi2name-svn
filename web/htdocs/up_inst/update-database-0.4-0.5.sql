UPDATE `userliste` SET `passwd` = '21232f297a57a5a743894a0e4a801fc3',
 `lastlogin_d` = NULL ,
 `lastlogin_t` = NULL ,
 `rueckruf` = NULL ,
 `notiz` = NULL ,
 `msns` = NULL WHERE `id` = '1' LIMIT 1 ;

 
CREATE TABLE `vorwahl` (
 `id` INT NOT NULL AUTO_INCREMENT ,
 `vorwahlnr` CHAR( 7 ) ,
 `name` TEXT,
 PRIMARY KEY ( `id` )
);


ALTER TABLE `userliste` ADD `vorwahl` TEXT;
ALTER TABLE `userliste` ADD `showmsn` CHAR( 20 ) ;

 

