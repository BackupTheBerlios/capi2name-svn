/* capi2name - ISDN capi monitor
   Copyright (C) 2002-2005  Jonas Genannt <jonasge@gmx.net>

   capi2name comes with ABSOLUTELY NO WARRANTY; for details see COPYING.
   This is free software, and you are welcome to redistribute it
   under certain conditions; see COPYING for details. */
#ifndef CAPI_H
#define CAPI_H
#include <stdio.h>
#include <stdlib.h>
#include <mysql/mysql.h>
#include <time.h>

//Mysql Version 4.0
#define MYSQL_4





// BITTE NIX AENDERN:
#define USE_CLIENT  0 //DEVELOPMENT NOT CHANGE

int indb(char rufnummer[80], char msn[80], char hostname[100], char username[100], char passwd[100], char database[100], int dienstkennung, char tkanlage[80], char export_joetxt[80], char export_joetxt_file[100], char use_smbclient[5], char a_smbclient_hosts[20][80]);
int insert_db(char rufnummer[80], char name[80], char msn[80]);
int name_ruf(char rufnummer[80], char msn[80]);
int display_last();
int client(char alles[1024]);
#endif
