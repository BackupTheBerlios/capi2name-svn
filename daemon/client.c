/* capi2name - ISDN capi monitor
   Copyright (C) 2005  Jonas Genannt <jonasge@gmx.net>

   capi2name comes with ABSOLUTELY NO WARRANTY; for details see COPYING.
   This is free software, and you are welcome to redistribute it
   under certain conditions; see COPYING for details. */

#include "capi.h"
#include <stdio.h>
#include <stdlib.h>
#include <netdb.h>
#include <arpa/inet.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <unistd.h>

void errormsg(char * msg)
 {
  printf("\nERROR: %s\n", msg);
 // exit(1);
 }

int client(char alles[1024])
{
struct sockaddr_in address;
struct in_addr inaddr;
struct hostent * host;
int sock;

printf("\nIn Client.o\n");
if (USE_CLIENT == 1 )
 {
  printf("\n%s\n", alles);
  inet_aton("127.0.0.1", &inaddr);
host = gethostbyaddr((char *) &inaddr, sizeof(inaddr), AF_INET);

if ((sock = socket(PF_INET, SOCK_STREAM, 0)) < 0 )
 errormsg("socket");

address.sin_family = AF_INET;
address.sin_port = htons(24000);

memcpy(&address.sin_addr, host->h_addr_list[0], sizeof(address.sin_addr));

if (connect(sock, (struct sockaddr *) &address, sizeof(address)))
 errormsg("connect");

 write (sock, alles, 1024);


  

 }
return 0;
}//funktion zu ENDE


