DROP TABLE `userliste`;

CREATE TABLE `userliste` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `passwd` varchar(50) default NULL,
  `lastlogin_d` varchar(20) default NULL,
  `lastlogin_t` varchar(20) default NULL,
  `name` text,
  `anzahl` int(11) NOT NULL default '0',
  `rueckruf` text,
  `notiz` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;



INSERT INTO `userliste` VALUES (1, 'admin', 'admin', NULL, NULL, 0x41646d696e6973747261746f72, 0, NULL, NULL);

     
