/* capi2name - ISDN capi monitor
   Copyright (C) 2002-2005  Michael Foerster <michael.foerster@muellingen.de>

   capi2name comes with ABSOLUTELY NO WARRANTY; for details see COPYING.
   This is free software, and you are welcome to redistribute it
   under certain conditions; see COPYING for details. */
#include "capi2name.h"
#include <netinet/in.h>
#include <netdb.h>
#include <string.h>
#include <iconv.h>

char bin2hex (char ch)
{                              /* return ascii char for hex value of ightmost 4 bits of input */
    ch = ch & 0x0f;            /* mask off right nibble  - & bitwise AND*/
    ch += '0';                  /* make ascii '0' - '9'  */
    if (ch > '9')
        ch += 7;                /* account for 7 chars between '9' and 'A' */
    return (ch);
}

int AlphaNumeric (char ch)
{
    return ((ch >='a') && (ch <= 'z') ||   /* logical AND &&, OR || */
            (ch >='A') && (ch <= 'Z') ||
            (ch >='0') && (ch <= '9') );
}

int URLencode (const char * plain, char * encode, int maxlen)
{
    char ch;            /* each char, use $t2 */
    char * limit;       /* point to last available location in encode */
    char * start;       /* save start of encode for length calculation */

    limit = encode + maxlen - 4;       /* need to store 3 chars and a zero */
    ch = *plain ++;                    /* get first character */
    while (ch != 0)
    {                                  /* end of string, asciiz */
        if (ch == ' ')
            * encode ++ = '+';
        else if (AlphaNumeric (ch))
            * encode ++ = ch;
        else {
            * encode ++ = '%';
            * encode ++ = bin2hex (ch >> 4);   /*shift right for left nibble*/
            * encode ++ = bin2hex (ch);                /* right nibble */
        }
        ch = *plain ++;                                /* ready for next character */
        if (encode > limit)
       {
            *encode = 0;        /* still room to terminate string */
            return (-1);        /* get out with error indication */
        }
    }
    * encode = 0;               /* store zero byte to terminate string */
    return (encode - start);    /* done, return count of characters */
} 

void msg_dbox (char *called, char *caller, char *areacode, char *fullname)
{
    /*Puffer fuer die Serverantwort*/
    char puffer[10000];
    /*Puffer fuer die Clientanfrage*/
    char anfrage[10000];
    /*Handle fuer die Verbindung*/
    int sock;
    /*fuer DNS ( gethostbyname() )*/
    struct hostent *ht;
    /*fuer Verbindungsaufbau (Host Adressierung)*/
    struct sockaddr_in host;
    time_t t_now;
    char pdate[15];
    struct tm *zgr;
    char line1[255], result1[510];
    char line2[255], result2[510];
    char line3[255], result3[510];
    char urltext[1024];
    time(&t_now);
    zgr=localtime(&t_now);
    strftime(pdate,15, "%Y-%m-%d",zgr);
    /* einen Socket erzeugen, der die Kommunikation verwaltet.
       family : AF_INET
       type   : SOCK_STREAM
    */
    sock=socket(AF_INET, SOCK_STREAM, 0);
    ht = gethostbyname(config.dbox_host);

    /*konnte ueber DNS aufgeoest werden ?*/
    if (ht==NULL)
    {
       syslog(LOG_NOTICE,"DBOX: Could not found Hostname");
       // exit(0);
    }

    /*family : AF_INET*/
    host.sin_family=AF_INET;

    /*port   : 80 */
    host.sin_port=htons(80);

    /*IP-Adresse*/
    /* host.sin_addr.s_addr=(long)*ht->h_addr; */
    /* host.sin_addr.s_addr=inet_addr("192.168.100.254"); */
    memcpy(&host.sin_addr, ht->h_addr, sizeof(host.sin_addr));

    /*Verbindung aufbauen*/
    if (connect(sock, (struct sockaddr*)&host, sizeof(host))<0)
    {
       syslog(LOG_NOTICE,"DBOX: Could not create connection to dbox");
    }

    sprintf(line1,"Neuer Anruf: %s", pdate);
    if(strcmp(fullname,"unknown"))
    {
       sprintf(line2,"Anrufer: %s (%s)", fullname, areacode);
    } else
    {
       sprintf(line2,"Anrufer: %s (%s)", caller, areacode);
    }
    sprintf(line3,"MSN: %s", called);

    URLencode (line1, result1, 510);
    URLencode (line2, result2, 510);
    URLencode (line3, result3, 510);

    sprintf(urltext,"%s%%0a%s%%0a%s",result1,result2,result3);
    sprintf(anfrage,"GET /control/message?popup=%s HEAD/1.0\r\n",urltext);
    write (sock,anfrage, strlen(anfrage));
    bzero(puffer, sizeof(puffer));

    close(sock);
}


