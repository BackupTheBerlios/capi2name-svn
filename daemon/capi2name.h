/* capi2name - ISDN capi monitor
   Copyright (C) 2002-2005  Jonas Genannt <jonas.genannt@capi2name.de>

   capi2name comes with ABSOLUTELY NO WARRANTY; for details see COPYING.
   This is free software, and you are welcome to redistribute it
   under certain conditions; see COPYING for details. */
#ifndef CAPI2NAME_H
#define CAPI2NAME_H
#include <stdio.h>
#include <stdlib.h>
#include <fcntl.h>
#include <string.h>
#include <syslog.h>
#include <stdarg.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <sys/fcntl.h>
#include <unistd.h>
#include <mysql/mysql.h>
#include <time.h>


typedef struct {
	char hostname[20];
	char username[10];
	char password[10];
	char database[15];
	int  tksupport;
	int  export_txt;
	char export_txt_file[50];
	int dbox_support;
	char dbox_host[20];
	char ip_addr[20];
	char ip_port[20];
}confFile;
confFile config;

void write_to_file(char *full_name, char *tele_number, char *msn);
void get_name_from_msn(char *msn, char *msn_name);
int get_prefix_from_number(char *tele_number, char *prefix_name);
void get_name_from_number(char *full_name, char *tele_number);
void get_conf();
void write_data_to_db(char *number, char *msn, int prefix, int servicenr);
int mk_daemon();
void write_pid();
void msg_dbox (char *called, char *caller, char *areacode, char *fullname);

#endif
