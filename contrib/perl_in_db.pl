#!/usr/bin/perl
#Capi2Name - ISDN  capi monitor
#Capi2Name interface for CapiSuite
#Copyright (C) 2002-2005 Jonas Genannt <jonas.genannt@capi2name.de>
#capi2name comes with ABSOLUTELY NO WARRANTEY; for details see COPYING.
#This is free software, and you are welcome to redistribute it
#under certain conditions; see COPYING for details.
#needed: libconfig-simple-perl
#Options for the perl script:
#cs_ident=2 <-<-< FAX
#cs_ident=1 <-<-< voice
#./script_name -caller 07551309861 -called 309861 -cs_user jonas -cs_ident 1 -cs_file /var/capisuite/fax/vouce.file
use DBI;
use MIME::Base64;
use Getopt::Long;
use Config::Simple;

$cfg = new Config::Simple('/etc/capi2name.conf');
my $db_uname = $cfg->param("username");
my $db_passwd = $cfg->param("password");
my $dbname=$cfg->param("database");
my $hostname=$cfg->param("hostname");

GetOptions ('caller=s' => \$caller,
	'called=s' => \$called,
	'cs_user=s' => \$cs_user,
	'cs_ident=s' => \$ident,
	'cs_file=s' => \$cs_file);
open(FD, "< $cs_file");
$lines =encode_base64(join("\n", <FD>));
close(FD);

my $dsn = "DBI:mysql:$dbname:$hostname";
#my $dbh = DBI->connect("DBI:mysql:database=$dbname;host=$hostname",$db_uname,$db_passwd) or  print "$DBI::db_errstr\n";
my $dbh = DBI->connect($dsn,$db_uname,$db_passwd);
my $sqlquery="INSERT INTO capisuite VALUES(NULL,'1',NOW(),'$ident','$called','$caller','$cs_user','$lines')";
$sth = $dbh->prepare($sqlquery);
$sth->execute();
$dbh->disconnect();
