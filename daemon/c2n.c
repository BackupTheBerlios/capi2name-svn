/* capi2name - ISDN capi monitor
   Copyright (C) 2002-2005  Jonas Genannt <jonas.genannt@capi2name.de>

   capi2name comes with ABSOLUTELY NO WARRANTY; for details see COPYING.
   This is free software, and you are welcome to redistribute it
   under certain conditions; see COPYING for details. */
   #include "capi2name.h"
   
   
   
   void write_to_file(char *full_name, char *tele_number, char *msn)
{
	FILE *fd;
	char buffer[1024];
	struct tm *zgr;
	char ptime[15];
	char pdate[15];
	time_t t_now;

	time(&t_now);
	zgr=localtime(&t_now);
	strftime(ptime,15, "%H:%M:%S",zgr);
	strftime(pdate,15, "%Y-%m-%d",zgr);
	if (!(fd=fopen(config.export_txt_file,"a")))
	{
		sprintf(buffer, "Could not open file %s to write down information", config.export_txt_file);
		syslog(LOG_NOTICE,buffer);
	}
	else
	{
		fprintf(fd, "%s\t%s\t%s\t%s\t%s\n",pdate,ptime,tele_number,full_name,msn);
		fclose(fd);
	}
}

void get_name_from_msn(char *msn, char *msn_name)
{
	MYSQL sql;
	MYSQL_RES *res;
	MYSQL_ROW data;
	char buffer[1024];
	res = NULL;


	mysql_init(&sql);
	if (!mysql_real_connect(&sql,config.hostname,config.username,config.password,config.database,0,NULL,0))
	{
		sprintf(buffer,"Error on Connect. (get_name_from_msn) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		buffer[0]='\0';
	}
	sprintf(buffer, "SELECT msn,name FROM msnzuname WHERE msn='%s'",msn);
	if ((mysql_real_query(&sql,buffer,0))!=0)
	{
		buffer[0]='\0';
		sprintf(buffer,"Error on real_query. (get_name_from_msn) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		buffer[0]='\0';
	}
	buffer[0]='\0';
	res = mysql_store_result(&sql);
	if (res)
	{
		data=mysql_fetch_row(res);
		if (data)
		{
			sprintf(msn_name, "%s",data[1]);
		}
		else
		{
			sprintf(msn_name,"%s",msn);
		}
	}
	else
	{
		sprintf(msn_name,"%s",msn);		
	}
	mysql_free_result(res);
	res = NULL;
	mysql_close(&sql);
	
}

int get_prefix_from_number(char *tele_number, char *prefix_name)
{
	MYSQL sql;
	MYSQL_RES *res;
	MYSQL_ROW data;
	char buffer[1024];
	char sub_tele[30];
	int foundid=0;
	int vor_laenge;
	int cell_phone=0;
	int i;
	int result;
	res= NULL;
	sub_tele[0]='\0';

	strncpy(buffer,(char *)tele_number+1,3);
	for (i=150;i<=179;i++)
	{
		if (atoi(buffer)==i)
		{
			cell_phone=1;
			foundid=1;
			sprintf(prefix_name, "cell phone");
			result=2;
			break;
		}
	}
	
	if (cell_phone==0)
	{
	mysql_init(&sql);
	if (!mysql_real_connect(&sql,config.hostname,config.username,config.password,config.database,0,NULL,0))
	{
		sprintf(buffer, "Error on Connect. (get_prefix_from_number) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		buffer[0]='\0';
	}
	sprintf(buffer,"SELECT id,vorwahlnr,name FROM vorwahl");
	if ((mysql_real_query(&sql,buffer,0))!=0)
	{
		sprintf(buffer,"Error on real_query. (get_prefix_from_number) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		buffer[0]='\0';
	}
	res = mysql_store_result(&sql);
	buffer[0]='\0';
	if (res)
	{
		while((data=mysql_fetch_row(res)))
		{
			if (data)
			{
				vor_laenge=strlen(data[1]);
				strncat(sub_tele,tele_number,vor_laenge);
				if (! strcmp(sub_tele,data[1]))
				{
					foundid=1;
					sprintf(prefix_name, "%s",data[2]);
					result=atoi(data[0]);
					break;
				}
				sub_tele[0]='\0';
			}
			else
			{
				sprintf(prefix_name, "unknown");
				result=-1;
			}
		}
	}
	else
	{
		sprintf(prefix_name, "unknown");
		result=-1;
	}
	mysql_free_result(res);
	res = NULL;
	mysql_close(&sql);
	}//Cell phone 
	if (foundid!=1)
	{
		sprintf(prefix_name, "unknown");
		result=-1;
	}
	return result;
}

void get_name_from_number(char *full_name, char *tele_number)
{
	MYSQL sql;
	MYSQL_RES *res, *res1;
	MYSQL_ROW data,data1;
	res = NULL;
	res1 = NULL;
	int unknow=0;
	char buffer[1024];
	buffer[0]='\0';

	mysql_init(&sql);
	if (!mysql_real_connect(&sql, config.hostname,config.username,config.password,config.database,0,NULL,0))
	{
		sprintf(buffer, "Error on Connect. (get_name_from_number) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer );
		buffer[0]='\0';
	}
	sprintf(buffer,"SELECT addr_id,areacode,typ FROM phonenumbers WHERE number='%s' LIMIT 1", tele_number);	
	if ((mysql_real_query(&sql,buffer,0))!=0)
	{
		sprintf(buffer, "Error on real_query. (get_name_from_number) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		buffer[0]='\0';
	}
	res = mysql_store_result(&sql);
	buffer[0]='\0';
	//CODE
	if (res)
	{
		data=mysql_fetch_row(res);
		if (data)
		{
			unknow=0;
			sprintf(buffer,"SELECT name_first,name_last,id FROM addressbook WHERE id='%s' LIMIT 1", data[0]);
			mysql_real_query(&sql,buffer,0);
			buffer[0]='\0';
			res1 = mysql_store_result(&sql);
			data1=mysql_fetch_row(res1);
			sprintf(full_name,"%s %s", data1[0], data1[1]);
			//memory fee
			mysql_free_result(res1);
			res1=NULL;
		}
		else
		{
			sprintf(full_name, "unknown");
			unknow=1;
		}
	}
	else
	{
		sprintf(full_name, "unknown");
		unknow=1;
	}
	//Memory free:
	mysql_free_result(res);
	res = NULL;
	mysql_close(&sql);
}

void get_conf()
{
	FILE *fd;
	char *c;
	char line[100];
	char buffer[20];
	int laenge;
	int i=0;
	//printf("Parsing config-FIle\n");
	fd = fopen("/etc/capi2name.conf","r");
	if (fd==NULL)
	{
		syslog(LOG_NOTICE,"Could not open ConfigFile: EXIT NOW");
		exit(-1);
	}
		do
		{
			c=fgets(line,100,fd);
			if (c!=NULL)
			{
				//printf("%s",line);
				laenge= strlen(line);
				if (line[0]!='#' && line[0]!='\n' && line[0]!='\t')
				{
				do
				{
					if (line[i]=='=' || i==laenge)
					{
						strncpy(buffer,line,i);
						buffer[i]='\0';
						strncpy(line,&line[i+1],laenge-1+1);
						laenge=strlen(line);
						line[laenge-1]='\0';
						 if (!strcmp(buffer, "hostname")) sprintf(config.hostname, "%s",line);
						 if (!strcmp(buffer, "username")) sprintf(config.username, "%s",line);
						 if (!strcmp(buffer, "password")) sprintf(config.password, "%s",line);
						 if (!strcmp(buffer, "database")) sprintf(config.database, "%s",line);
						 if (!strcmp(buffer, "export_txt_file")) sprintf(config.export_txt_file, "%s",line);
						 if (!strcmp(buffer, "ip_addr"))  sprintf(config.ip_addr, "%s",line);
						 if (!strcmp(buffer, "ip_port"))  sprintf(config.ip_port, "%s",line);
						 if (!strcmp(buffer, "dbox_host")) sprintf(config.dbox_host, "%s",line);
						 if (!strcmp(buffer, "tksupport")) config.tksupport=atoi(line);
						 if (!strcmp(buffer, "export_txt")) config.export_txt=atoi(line);
						 if (!strcmp(buffer, "dbox_support")) config.dbox_support=atoi(line);
						//printf("Buffer:%s---%s-%d\n",buffer, line, laenge);
						i=0;
						laenge=0;
					}
					++i;
				}while(i!=(laenge+1));
				} // ungleich #
			}
				
		}while(c!=NULL);
	
	fclose(fd);
	syslog(LOG_NOTICE, "reading configFile complete");
}

void write_data_to_db(char *number, char *msn, int prefix, int servicenr)
{
	MYSQL sql;
	MYSQL_RES *res;
	char buffer[1024];
	res = NULL;
	buffer[0]='\0';

	mysql_init(&sql);
	if (!mysql_real_connect(&sql, config.hostname,config.username,config.password,config.database,0,NULL,0))
	{
		sprintf(buffer,"Error on Connect. (write_data_to_db) Mysql: %s", mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		buffer[0]='\0';
	}
	sprintf(buffer, "INSERT INTO angerufene VALUES(NULL,'%s',NOW(),NOW(),'1','unknown','%s','%d','%d')",number,msn,prefix,servicenr);
	if ((mysql_real_query(&sql,buffer,0))!=0)
	{
		buffer[0]='\0';
		sprintf(buffer,"Error on real_query. (write_data_to_db) Mysql: %s",mysql_error(&sql));
		syslog(LOG_NOTICE,buffer);
		
	}
	buffer[0]='\0';
	mysql_close(&sql);
}

int mk_daemon()
{
	pid_t pid;

	if ((pid=fork()) <0)
	{
		return -1;
	}
	else if(pid !=0)
	{
		exit(0);
	}
	setsid();
	chdir("/");
	umask(0);
	close(STDIN_FILENO);
	close(STDOUT_FILENO);
	close(STDERR_FILENO);
	return (0);	
}
