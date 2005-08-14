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
#include "capi2name.h"
#define MAIN

char *command = "capi2name";

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
int dienstkennung=0;
char rufnr[41];
char msn_name[40];
char prefix_name[40];
int prefix_id;
char name[1024];

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


//service_number==dienstkennung
//nummer=callingnumber
//msn=callednumber
if (config.tksupport==1)
{
	sprintf(rufnr,"%s" ,callingnumber);
}
else
{
	sprintf(rufnr,"0%s",callingnumber);
}
if (!strcmp(rufnr, "") || !strcmp(rufnr, "0") )
{
	sprintf(rufnr, "unknown");
}
get_name_from_msn(callednumber,msn_name);
get_name_from_number(name, rufnr);
if (config.export_txt==1)
{	
	write_to_file(name,rufnr,msn_name);
}
prefix_id=get_prefix_from_number(rufnr, prefix_name);
write_data_to_db(rufnr,callednumber,prefix_id,dienstkennung);
if (config.dbox_support==1)
{	
msg_dbox (callednumber, rufnr, " ", name);
}

}//end incomming call

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
	
	openlog("Capi2Name",LOG_ODELAY,LOG_DAEMON);
	if (mk_daemon()!=0)
	{
		syslog(LOG_NOTICE,"Error on daemonize");
		exit(-1);
	}
	write_pid();
	syslog(LOG_NOTICE, "daemon started up");
	get_conf();




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
