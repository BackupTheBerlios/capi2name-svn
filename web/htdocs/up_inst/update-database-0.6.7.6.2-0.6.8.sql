CREATE TABLE `phonenumbers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `addr_id` int(10) unsigned NOT NULL default '0',
  `number` char(30) NOT NULL default '',
  `typ` tinyint(3) unsigned NOT NULL default '0',
  `areacode` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
CREATE TABLE `addressbook` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name_first` char(20) default NULL,
  `name_last` char(20) default NULL,
  `street` char(25) default NULL,
  `housenr` char(10) default NULL,
  `zipcode` char(10) default NULL,
  `city` char(30) default NULL,
  `email` char(40) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

UPDATE `vorwahl` SET `name` = 'cell phone' WHERE `id` =2 LIMIT 1 ;

ALTER TABLE `users` ADD `cs_user` char (8) AFTER `username`;
ALTER TABLE `users` ADD `cs_audio` TINYINT( 2 ) DEFAULT '1' NOT NULL ;
ALTER TABLE `users` ADD `cs_fax` TINYINT( 2 ) DEFAULT '1' NOT NULL ;

ALTER TABLE `angerufene` CHANGE `aktive` `aktive` TINYINT( 2 ) DEFAULT '1' NOT NULL;
UPDATE `angerufene` SET `aktive` = '1';

ALTER TABLE `config` CHANGE `value` `value` CHAR( 50 ) DEFAULT NULL;

INSERT INTO `config` VALUES (NULL, 'cs_use_mogrify', 'no'),
(NULL, 'cs_mogrify', '/usr/bin/mogrify'),
(NULL, 'cs_sff2misc', '/usr/bin/sff2misc'),
(NULL, 'cs_temp_dir', '/tmp');


CREATE TABLE `capisuite` (
  `id` int(11) NOT NULL auto_increment,
  `aktive` tinyint(2) NOT NULL default '1',
  `date_time` timestamp(14) NOT NULL,
  `ident` tinyint(1) NOT NULL default '0',
  `msn` varchar(20) NOT NULL default '',
  `from_nr` varchar(30) NOT NULL default '',
  `cs_user` varchar(40) NOT NULL default '',
  `data` longblob NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;