CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `conf` char(20) NOT NULL default '',
  `value` char(20) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` char(8) NOT NULL default '',
  `passwd` char(40) NOT NULL default '',
  `lastlogin_d` date default NULL,
  `lastlogin_t` time default NULL,
  `name_first` char(15) default NULL,
  `name_last` char(15) default NULL,
  `show_lines` tinyint(3) unsigned NOT NULL default '15',
  `msn_listen` char(30) default NULL,
  `show_callback` tinyint(1) unsigned NOT NULL default '0',
  `show_prefix` tinyint(1) unsigned NOT NULL default '0',
  `show_msn` tinyint(1) unsigned NOT NULL default '0',
  `show_type` tinyint(1) unsigned NOT NULL default '0',
  `show_config` tinyint(1) unsigned NOT NULL default '0',
  `allow_delete` tinyint(1) unsigned NOT NULL default '0',
  `template` char(10) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM;

INSERT INTO `config` VALUES (1, 'template', 'blueingrey'),
(2, 'db_version', '0.6.7.6'),
(3, 'default_template', 'blueingrey');



INSERT INTO `users` VALUES (1, 'admin', '123', NULL, NULL, NULL, NULL, 15, NULL, 0, 0, 0, 0, 0, 0, NULL);

