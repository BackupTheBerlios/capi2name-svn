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


################### Einrichtung #############################################
# 
# Für die Nutzung sind ein paar Sachen zu beachten. Perl-DBI musst installiert
# sein, genau wie isdn4linux und es muss Konfiguriert sein.
# Desweiteren muss die Konfiguration von isdnlog angepasst werden. Und zwar
# muss man in /etc/isdn/isdnlog.isdnctrl0 (entsprechender Pfad auf dem Sytstem)
# angeben, dass isdnlog den stdout in eine Named Pipe schreibt. Dazu setzt man
# console = /pfad/zur/Pipe. Eine Pipe erstelle man mit "mkfifo pipe". 
# Hat man das geschafft sollte man noch die Konfiguration in diesem Script 
# anpassen. 
#
###############################################################################



# Konfiguration
my $dbdb = "capi";			# Datenbank
my $dbuser = "root";			# User
my $dbpass = "";			# Passwort

my $npipe = "/root/isdn";		# Pfad zur Named Pipe

## Ende Konfiguration ##


use DBI;
use POSIX;
#use Errno qw/EAGAIN/;

use strict;
use warnings;

my $dbh=DBI->connect("DBI:mysql:$dbdb","$dbuser","$dbpass") or die $DBI::errstr;

open( FH, $npipe) or die $!;

makedaemon(); # Daemon erzeugen
	
while (<FH>) {
	if ( my ($from, $msn, $mode) = m/Call to tei 127 from (\?|.*) on (.+), .*? RING \((.+)\)/ ) {
		my (undef, $msn) = split /\//, $msn;
		my ($rufnr, $vorwahl);
		if( $mode =~ m/Speech/i || $mode =~ m/audio/i ) { $mode = 4; }
		else { $mode = 2; }

		if ($from eq "\?") {
			$rufnr = "unbekannt";
			$vorwahl = "";
		}
		else {
			($from, undef) = split /\,/, $from;
			($vorwahl, $rufnr) = split /\//, $from;			#
			$vorwahl =~ s/\+49 /0/;							# komischer Code. Muss mal testen ob es besser
			$rufnr = $vorwahl . $rufnr;						# ist als 2x s////; 
			my $sth = $dbh->prepare ("SELECT * FROM vorwahl WHERE vorwahlnr=\"$vorwahl\";");
			$sth->execute();
			my $erg = $sth->fetchrow_hashref();
			$vorwahl = $erg->{'name'};
		}

		my $pdate = strftime("%d.%m.%Y",localtime);
		my $ptime = strftime("%H:%M:%S",localtime);
			
		$dbh->do("INSERT INTO angerufene (id, rufnummer, datum, uhrzeit, aktive, name, msn, vorwahl, dienst) VALUES(\"\",\"$rufnr\", \"$pdate\", \"$ptime\", \"1\", \"unbekannt\", \"$msn\", \"$vorwahl\",\"$mode\")");
	}
}

close FH;
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
