/* capi2name - ISDN capi monitor
   Copyright (C) 2002-2005  Jonas Genannt <jonasge@gmx.net>
   Copyright (C) 2000  Carsten paeth <calle@calle.in-berlin.de>
   Copyright (C) 2000 AVM GmbH Berlin <info@avm.de>

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA */
#include <stdio.h>
#include <malloc.h>
#include <stdlib.h>
#include <getopt.h>
#include "capiconn.h"
#define MAIN
#include  "capi.h"
#include "config_api.h"

 char *command = "capi2name";
 char hostname[100]="";
 char username[100]="";
 char password[100]="";
 char database[100]="";
 char tkanlage[100]="";
 char use_smbclient[5]="";
 char smbclient_hosts[200]="";
 char export_joetxt[80]="";
 char export_joetxt_file[100]="";
 char rufnummer[1024]="";
 config_t conf;
 char a_rufnummer[20][80];
 char a_smbclient_hosts[20][80];
 int alles=1;
/* -------------------------------------------------------------------- */

static int opt_debug = 0;
static char *opt_ddi = 0;
static char opt_ndigits = 0;
static int opt_contr = 1;
static int opt_reject = 0;
static int opt_ignore = 0;
static int opt_alert = 0;
static char *opt_conf ="/etc/capi2name.conf";
int cmp;
static void usage(void)
{
    fprintf(stderr, "Usage: capi2name [CAPIOPTION]\n");
    fprintf(stderr, "Wait for incoming connections.\n");
    fprintf(stderr, "CAPIOPTIONS:\n");
    fprintf(stderr, "   -d, --debug\n");
    fprintf(stderr, "   -c, --controller contr  (default %d)\n", opt_contr);
    fprintf(stderr, "   -C config-file  (default /etc/capi2name.conf)\n");
}

/* -------------------------------------------------------------------- */

static char msgbuf[4096];

void vxerrmsg(const char *prefix, const char *suffix,
		const char *format, va_list args)
{
   char *s = msgbuf;
   char *e = msgbuf + sizeof(msgbuf);

   (void)snprintf(s, e-s, "%s: %s", command, prefix);
   s += strlen(s);
   (void)vsnprintf(s, e-s, format, args);
   s += strlen(s);
   (void)snprintf(s, e-s, "%s", suffix);
   s += strlen(s);

   fprintf(stderr, "%s\n", msgbuf);
}

void errmsg(const char *format, ...)
{
   va_list args;

   va_start(args, format);
   vxerrmsg("Error: ", "", format, args);
   va_end(args);
}

void infomsg(const char *format, ...)
{
   va_list args;

   va_start(args, format);
   vxerrmsg("Info: ", "", format, args);
   va_end(args);
}

void debugmsg(const char *format, ...)
{
   va_list args;

   if (!opt_debug) return;

   va_start(args, format);
   vxerrmsg("Debug: ", "", format, args);
   va_end(args);
}

/* -------------------------------------------------------------------- */

static char *conninfo(capi_connection *p)
{
	static char buf[1024];
	capi_conninfo *cp = capiconn_getinfo(p);

	snprintf(buf, sizeof(buf),
		"appl=%d plci=0x%x ncci=0x%x %s",
			cp->appid,
			cp->plci,
			cp->ncci,
			cp->isincoming ? "incoming" : "outgoing"
			);
	return buf;
}

static void disconnected(capi_connection *cp,
				int localdisconnect,
				unsigned reason,
				unsigned reason_b3)
{
	infomsg("disconnected(%s): %s: 0x%04x (0x%04x) - %s", 
			conninfo(cp),
			localdisconnect ? "local" : "remote",
			reason, reason_b3, capi_info2str(reason));

}

static void incoming(capi_connection *cp,
			  unsigned contr,
			  unsigned cipvalue,
			  char *callednumber,
			  char *callingnumber)
{



int y=0;
int dienstkennung=0;

	switch (cipvalue) {
	case 1: /* Speech */
	dienstkennung=1;
	fprintf(stderr, "\nsprache\n"); break;
	case 4: /* 3.1 KHz audio */
	dienstkennung=2;
	fprintf(stderr, "\n3.1 khz audio\n"); break;
	case 5: /* 7 KHz audio */
	dienstkennung=3;
             fprintf(stderr, "\n7jhz audio\n"); break;
	case 16: /* Telephony */
	dienstkennung=4;
	 fprintf(stderr, "\ntelefony\n"); break;
	case 26: /* 7kHz telephony */
	dienstkennung=5;
	  fprintf(stderr, "\n7hz telephony!\n");
//		(void)capiconn_accept(cp, 1, 1, 0, 0, 0, 0, 0);
		break;
	case 2: /* unrestricted digital information */
	case 3: /* restricted digital infomation */
		/* HDLC: 0,1,0 X75: 0,0,0 X75+V42Bis: 0,8,0 */
		/* x25overx75: 0,0,2 */
		dienstkennung=6;
		fprintf(stderr, "\nDATA\n");
	//	(void)capiconn_accept(cp, 0, 1, 0, 0, 0, 0, 0);
		/*(void)capiconn_accept(cp, 0, 0, 2, 0, 0, 0, 0);*/
		break;
	case 17: /* Group 2/3 facsimile */
	//	(void)capiconn_accept(cp, 4, 4, 4, 0, 0, 0, 0);
	dienstkennung=7;
	fprintf(stderr,"\nFAX\n");
		break;
	default:
		(void)capiconn_ignore(cp);
		break;
	}






if (alles==2)
 {
     indb(callingnumber, callednumber, hostname, username, password, database, dienstkennung,tkanlage,export_joetxt,export_joetxt_file, use_smbclient, a_smbclient_hosts);
 }
 else
 {
while(a_rufnummer[y] != NULL)
 {
  if ( (strcmp(callednumber, a_rufnummer[y]))==0)
   {
     indb(callingnumber, callednumber, hostname, username, password, database,dienstkennung,tkanlage,export_joetxt,export_joetxt_file, use_smbclient, a_smbclient_hosts);
    break;
   }
y++;
 }


} //alles =="






}

static void connected(capi_connection *cp, _cstruct NCPI)
{
	infomsg("connected(%s) NCPIlen=%d", conninfo(cp), NCPI[0]);
}

static void received(capi_connection *cp,
			    unsigned char *data,
			    unsigned datalen)
{
	infomsg("received(%s): %p len=%u", conninfo(cp), data, datalen);
}

static void datasent(capi_connection *cp, unsigned char *buf)
{
	infomsg("sent hier(%s): %p (%p)", conninfo(cp), buf);
}

static void chargeinfo(capi_connection *cp,
		       unsigned long charge, int inunits)
{
	infomsg("chargeinfo(%s): %ld %s",
		conninfo(cp), charge, inunits ? "Units" : "Currency");
}

void put_message(unsigned appid, unsigned char *msg)
{
	unsigned err;
	debugmsg(">>> %s", capi_message2str(msg));
	err = capi20_put_message (appid, msg);
	if (err)
		errmsg("putmessage(appid=%u) = 0x%x", appid, err);
}

/* -------------------------------------------------------------------- */

capiconn_callbacks callbacks = {
	malloc: malloc,
	free: free,

	disconnected: disconnected,
	incoming: incoming,
	connected: connected,
	received: received, 
	datasent: datasent, 
	chargeinfo: chargeinfo,

	capi_put_message: put_message,

	debugmsg: debugmsg,
	infomsg: infomsg,
	errmsg: errmsg
};

static capiconn_context *ctx;


int main(int ac, char *av[])
{
	static capi_contrinfo cinfo = { 0 , 0, 0 };
	unsigned err;
	unsigned applid;
	int c;
int i=1, smbi=1;
int e=0,smbe=0;
char nbuffer[1024]="", smbnbuffer[1024]="";
char komma=',';

size_t laenge;
char buffer[1024]="";
char smbbuffer[1024]="";
	for (;;) {
	       int option_index = 0;
	       static struct option long_options[] = {
		       {"controller", 1, 0, 'c'},
		       {"debug", 0, 0, 'd'},
		       {"reject", 0, 0, 'r'},
		       {"ignore", 0, 0, 'i'},
		       {"alert", 0, 0, 'a'},
		       {0, 0, 0, 0}
	       };

	       c = getopt_long (ac, av, "c:C:dD:irN:",
			       long_options, &option_index);
	       if (c == -1)
		       break;

	       switch (c) {
		       case 0:
			       printf ("option %s",
				       long_options[option_index].name);
			       if (optarg)
				       printf (" with arg %s", optarg);
			       printf ("\n");
			       break;
		       case 'c':
			       opt_contr = atoi(optarg);
			       break;
		       case 'd':
			       opt_debug = 1;
			       break;
		       case 'D':
			       opt_ddi = optarg;
			       break;
		       case 'C':
			       opt_conf = optarg;
			       break;
		       case 'i':
			       opt_ignore = 1;
			       break;
		       case 'r':
			       opt_reject = 1;
			       break;
		       case 'a':
			      
 opt_alert = 1;			      
  break;
		       case '?':
			       usage();
			       return 1;
			    default :
			    break;			      
	       }
	}
opt_alert = 1;
	if (optind != ac) {
		errmsg("too many arguments");
	        usage();
		return 1;
	}

	if ((err = capi20_register (30, 8, 2048, &applid)) != 0) {
		errmsg("CAPI_REGISTER failed - 0x%04x");
		return 2;
        }
/*
================================================================================================

CONFI LESEN

*/


 memset(rufnummer, 0, sizeof(rufnummer));
  memset(hostname, 0, sizeof(hostname));
  memset(username, 0, sizeof(username));
 memset(password, 0, sizeof(password));
 memset(database, 0, sizeof(database));

 // Aus Config lesen:
 if (!config_open(&conf, opt_conf, C_READ))
  {
   fprintf(stderr, "\nError: ConfigFile /etc/capi2name.conf not found!!\n");
  // exit(-1);
  }

if (!config_read(&conf, "capi", "rufnummer", rufnummer, sizeof(rufnummer)))
 {
  fprintf(stderr, "\nError: Config-Option, hostname not found!!!\n");
 }



if (!config_read(&conf, "capi", "hostname", hostname, sizeof(hostname)))
 {
  fprintf(stderr, "\nError: Config-Option, hostname not found!!!\n");
 }
if (!config_read(&conf, "capi", "username", username, sizeof(username)))
 {
  fprintf(stderr, "\nError: Config-Option, username not found!!!\n");
 }
 if (!config_read(&conf, "capi", "password", password, sizeof(password)))
 {
  fprintf(stderr, "\nError: Config-Option, password not found!!!\n");
 }
if (!config_read(&conf, "capi", "database", database, sizeof(database)))
 {
  fprintf(stderr, "\nError: Config-Option, database not found!!!\n");
 }
if (!config_read(&conf, "capi", "tkanlage", tkanlage,sizeof(tkanlage)))
 {
  fprintf(stderr, "\nError: Config-Optopn, tkanlage not found!!!\n");
 }
if (!config_read(&conf, "capi", "export_joetxt", export_joetxt,sizeof(export_joetxt)))
  {
   fprintf(stderr, "\nError: Config-Option, export_joetxt not found!!!\n");
  }
if (!config_read(&conf, "capi", "export_joetxt_file", export_joetxt_file, sizeof(export_joetxt_file)))
 {
  fprintf(stderr, "\nError: Config-Option, export_joetxt_file not found!!!\n");
 }
if (!config_read(&conf, "capi", "use_smbclient", use_smbclient, sizeof(use_smbclient)))
   {
    fprintf(stderr, "\nError: Config-Option, use_smbclient not found!!!\n");
   }
if (!config_read(&conf, "capi", "smbclient_hosts", smbclient_hosts, sizeof(smbclient_hosts)))
  {
   fprintf(stderr, "\nError: Config-Option, smbclient_hosts not found!!!\n");
  }

//fprintf(stderr, "\nNach option lesen!\n");
// ENDE daten auslesen
  config_close(&conf);
  if ((strcmp("all", rufnummer))==0)
   {
    alles=2;
   }
 else
 {
 laenge= strlen(rufnummer);
do
 {
  buffer[0]='\0';
  nbuffer[0]='\0';
   if (rufnummer[i] == komma)
    {
  //   fprintf(stderr, "\nIn if ()\n");
     strncpy(buffer,rufnummer, i);
     strcpy(a_rufnummer[e], buffer);
     e++;
     strncpy(nbuffer,&rufnummer[i+1], laenge-i+1);
     sprintf(rufnummer, nbuffer);
     i=0;
     laenge=strlen(rufnummer);
    }
   i++;
  } while(i != laenge);

  *a_rufnummer[e]=NULL;
} // ende alles
  // ENDE COnfig lesen



    laenge= strlen(smbclient_hosts);
         do
          {
            smbbuffer[0]='\0';
             smbnbuffer[0]='\0';
             if (smbclient_hosts[smbi] == komma)
              {
              //   fprintf(stderr, "\nIn if ()\n");
                strncpy(smbbuffer,smbclient_hosts, smbi);
              strcpy(a_smbclient_hosts[smbe], smbbuffer);
             smbe++;
             strncpy(smbnbuffer,&smbclient_hosts[smbi+1], laenge-smbi+1);
            sprintf(smbclient_hosts, smbnbuffer);
             smbi=0;
            laenge=strlen(smbclient_hosts);
           }
          smbi++;
         } while(smbi != laenge);

        sprintf(a_smbclient_hosts[smbe], "NULL");
//} // ende alles
  // ENDE COnfig lesen






	ctx = capiconn_getcontext(applid, &callbacks);

	cinfo.ddi = opt_ddi;
	cinfo.ndigits = opt_ndigits;
	(void)capiconn_addcontr(ctx, opt_contr, &cinfo);
	(void)capiconn_listen(ctx, opt_contr, 0x1FFF03FF, 0);

	for (;;) {
		unsigned char *msg = 0;
		if (capi20_waitformessage(applid, 0) == 0) {
			if (capi20_get_message (applid, &msg) == 0) {
				if (opt_debug)
				    debugmsg("<<< %s", capi_message2str(msg));
				capiconn_inject(applid, msg);
			}
		}
		/*infomsg("loop");*/
	}
}
