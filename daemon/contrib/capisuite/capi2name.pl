#!/usr/bin/perl

# ***************************************************************************
# *                                                                         *
# *   This program is free software; you can redistribute it and/or modify  *
# *   it under the terms of the GNU General Public License as published by  *
# *   the Free Software Foundation; either version 2 of the License, or     *
# *   any later version.                                   					*
# *                                                                         *
# ***************************************************************************

# copyright 		: Stefan Schöllermann
# email 			: Boarderman@gmx.at

# changed by		: Kai Römer
# email				: kai.roemer@gmx.de
#						to be useable with capisuite
#						version: 0.1.1

################### Einrichtung #############################################
# 
# Für die Nutzung sind ein paar Sachen zu beachten. Perl-DBI musst installiert
# sein, genau wie capisuite und es muss Konfiguriert sein.
# Desweiteren muss die Konfiguration von capisuite angepasst werden. Und zwar
# muss man in /usr/lib/capisuite/incoming.py dieses Skript mit folgenden Zeilen
# in Zeile 28 von incoming.py aufrufen:
#	abas='//usr/lib/capisuite/capi2name.pl %(d)d %(e)s %(f)s &' % {'d': service, "e": call_from, "f": call_to}
#	os.system(abas)
# Am besten man benutzt das beiliegende diff
#
###############################################################################



# Konfiguration
my $dbdb = "capi01db";			# Datenbank
my $dbuser = "capi01";			# User
my $dbpass = "capi01";			# Passwort

###############################################################################
## End configuration                                                         ##
## Do not edit below                                                         ##
###############################################################################

use DBI;
use POSIX;

use strict;
use warnings;

my $dbh=DBI->connect("DBI:mysql:$dbdb","$dbuser","$dbpass") or die $DBI::errstr;
my $call_service = $ARGV[0];
my $call_from = $ARGV[1];
my $call_to = $ARGV[2];

print "Service:\t$call_service\nFrom:\t\t$call_from\nTo:\t\t$call_to\n";

makedaemon(); # Daemon erzeugen

my $i = 3;
my $asa = 0;
my @calling = split("" , $call_from);
my $vorwahl = $calling[0] . $calling[1] . $calling[2];
my $sth = $dbh->prepare ("SELECT * FROM vorwahl WHERE vorwahlnr=?;") or die $DBI::errstr;
while( (($asa = $sth->execute($vorwahl)) != 1) && ($i < 8)) {
	$vorwahl = $vorwahl . $calling[$i++];
	# print "$vorwahl\t\t$asa\n";
	$sth->execute($vorwahl);
}
my $erg = $sth->fetchrow_hashref();
$vorwahl = $erg->{'name'};
$sth->finish;

my $mode = 4;
$dbh->do("INSERT INTO angerufene (id, rufnummer, datum, uhrzeit, aktive, name, msn, vorwahl, dienst) VALUES(\"\",\"$call_from\", NOW(), NOW(), \"1\", \"unbekannt\", \"$call_to\", \"$vorwahl\",\"$mode\");");

$dbh->disconnect;


# Funktion um den Daemon zu Erzeugen
sub makedaemon { 
	FORK: { 
			  if( my $pid = fork) {
				  exit;
			  }
			  elsif ( defined $pid ) {
				  return;
			  }
			  elsif ( $! == EAGAIN) {
				  redo FORK;
			  }
			  else {
				  die "fork failed: $!\n";
			  }
		  }
}
