#include "capi.h"

int indb(	char rufnummer[80],
		char msn[80],
		char hostname[100],
		char username[100],
		char password[100],
		char database[100],
		int dienstkennung,
		char tkanlage[80],
		char export_joetxt[80],
		char export_joetxt_file[100],
		char use_smbclient[5],
		char a_smbclient_hosts[20][80])
{
   struct tm *zgr;
   char ptime[80],pdate[80], buffer[1000]="", rufnr[80]="", name_anz[800]="";
   char vorwahl[200]="";
   char msnn[80]="";
   char smbclient_buffer[300]="";
   char sub_vorwahl[100];
   int smby=0;
   int laenge=0;
   FILE *datei;
   time_t jetzt;
   MYSQL mysql;
   MYSQL_RES *result;
   MYSQL_ROW data;
   result=NULL;
 

   fprintf(stderr, "\nin DB nach auslesen\n");

   if (!strcmp("no",tkanlage)) //tkanlage CHeck
     {
      sprintf(rufnr, "0%s", rufnummer); 
     }
   else
     {
      sprintf(rufnr,rufnummer);
     }

   if (!strcmp("0", rufnr))
     {
      sprintf(rufnr, "unbekannt");
     }

  #ifdef MYSQL_4
    mysql_init(&mysql);
    if (!(mysql_real_connect(&mysql,hostname,username,password,database,0,NULL,0)))
      {
       fprintf(stderr, "\nError (Connecting - 51): %s\n",mysql_error(&mysql));
       return 1;
      }
  #else
    if (!(mysql_connect(&mysql,hostname,username,password)))
      {
       fprintf(stderr, "\nError (Connecting - 57): %s\n",mysql_error(&mysql));
       return 1;
      }
  #endif
    if (mysql_select_db(&mysql,database))
      {
       fprintf(stderr, "\nError (Select DB - 63): %s\n",mysql_error(&mysql));
      }
    if (mysql_query(&mysql, "SELECT * FROM vorwahl"))
      {
       fprintf(stderr, "\nError (Query - 67): %s\n", mysql_error(&mysql));
      }
    result=mysql_store_result(&mysql);
    if (!result)
      {
       fprintf(stderr, "\nError (Store Result - 69): No rows\n %s\n", mysql_error(&mysql));
      }
    while(data = mysql_fetch_row(result))
      {
       laenge=strlen(data[1]);
       strcpy(sub_vorwahl,"");    
       strncat(sub_vorwahl,rufnr,laenge);
       if (!strcmp(sub_vorwahl,data[1]))
         {
          fprintf(stderr,"\nGleich: %s", data[2]);
	  sprintf(vorwahl, "%s", data[2]);
	  break;
         }
      }
    mysql_free_result(result);
    result=NULL;
    time(&jetzt);
    zgr=localtime(&jetzt);
    strftime(ptime,80, "%H:%M:%S",zgr);
    strftime(pdate,80, "%Y-%m-%d",zgr);
    sprintf(buffer, "INSERT INTO angerufene (id, rufnummer, datum, uhrzeit, aktive,name, msn, vorwahl, dienst) VALUES(\"\",\"%s\", \"%s\", \"%s\", \"1\", \"unbekannt\", \"%s\", \"%s\",\"%d\")",rufnr,pdate,ptime, msn, vorwahl, dienstkennung);
  

    fprintf(stderr, "\nRufnummer: %s\nDate: %s\nTime: %s", rufnr,pdate,ptime);
    if (mysql_query(&mysql, buffer))
      {
       fprintf(stderr, "\nError (Query -98): %s",mysql_error(&mysql));
      }
     
    //name nachschauen:
    if (strcmp("unbekannt",rufnr))
      {
       sprintf(buffer, "SELECT * FROM adressbuch WHERE tele1='%s' OR tele2='%s' OR tele3='%s' OR handy='%s'",rufnr,rufnr,rufnr,rufnr );
      if (mysql_query(&mysql, buffer))
      {
       fprintf(stderr, "\nError (SELECT - 104): %s\n", mysql_error(&mysql));
      }
     
    result=mysql_store_result(&mysql);
    if (!result)
      {
       fprintf(stderr, "\nError: No rows\n %s\n", mysql_error(&mysql));
      }
    data = mysql_fetch_row(result);
    if (data)
      {
       sprintf(name_anz, "%s %s", data[1], data[2]);     
      }
    else
      {
       sprintf(name_anz, "unbekannt");
      }
    mysql_free_result(result);
    result=NULL;
    
  //ende while
 }
else
  {
   sprintf(name_anz, "unbekannt");
  }
  //MSN2Name
  sprintf(buffer, "SELECT * FROM msnzuname WHERE msn=%s", msn);
    if (mysql_query(&mysql, buffer))
    {
     fprintf(stderr, "\nError (Query - 136): %s\n", mysql_error(&mysql));
    }
    result=mysql_store_result(&mysql);
   if (!result)
    {
      fprintf(stderr, "\nError (Store Result - 142): No rows\n %s\n", mysql_error(&mysql));
    }
    data = mysql_fetch_row(result);
    if (data)
    {
     sprintf(msnn, "%s", data[2]);
    }
    else
    {
     sprintf(msnn, "%s", msn);
    }
      
  //MSN2Name Ende
 mysql_free_result(result);
 result=NULL;
 mysql_close(&mysql);   
//Buffer zusammenstellen:
sprintf(buffer, "%s\t%s\t%s\t%s\t%s\t%s",pdate,ptime,rufnr,name_anz,vorwahl,msn);
printf("\n: %s", name_anz);
  
  //nach smbclient schicken:
  if (strcmp("no", use_smbclient)) //Wenn =yes dann senden per smbclient
    {
      //fprintf(stderr, "\nNach smbclient senden, %s", smbclient_hosts);
      do
        {
          sprintf(smbclient_buffer, "echo \"Anruf von %s (Rufnummer: %s) fuer %s\" | smbclient -M %s",name_anz,rufnr,msnn, a_smbclient_hosts[smby]);
	  fprintf(stderr,"\n:%s", smbclient_buffer);
          system(smbclient_buffer );
	  smbclient_buffer[0]='\0';
          smby++;		    
        }
      while(strcmp(a_smbclient_hosts[smby], "NULL" ));
    }

//Wirklich in die datei schreiben: 
if (strcmp("no", export_joetxt)) //Wenn =yes dann schreibe in TXT file!!
 {
  fprintf(stderr,"\n In Export TXT FIle");   
  datei=fopen(export_joetxt_file,"a");
   if (datei!=NULL)
     {
      //fseek(datei,0,SEEK_END);
      int test = fprintf(datei, "%s\n",buffer);
      fprintf(stderr, "\nZahl: %d\n", test);
      fclose(datei);
     }
   else
     {
      fprintf(stderr, "\nError:Fehler beim oeffnen der Datei: %s", export_joetxt_file);
     }
  }
 //ENDE schreibe in TXT file
 
 return 0;
}

