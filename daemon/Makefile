# Makefile for capi2name
SOURCE = config_api.c find.c utils.c
SHLIB = config_api.o
CC = gcc
CP = cp -f
CFLAGS = -Wall -static
LIB = -lmysqlclient -lcapi20  -L/usr/lib
capi2name : shlib  client.o indb.o capiconn.o capi2name.o
	$(CC) $(LIB) config_api.o  client.o indb.o capiconn.o capi2name.o -o capi2name

shlib:	$(SOURCE)
	$(CC) -shared -fPIC -lpthread  -o $(SHLIB) $(SOURCE)

client.o: client.c
	$(CC) $(CFLAGS) -c client.c

indb.o : indb.c
	$(CC) $(CFLAGS) -c indb.c

capiconn.o : capiconn.c
	$(CC) $(CFLAGS)  -c capiconn.c

capi2name.o : capi2name.c
	$(CC) $(CFLAGS) -c capi2name.c 
clean :
	rm -f *.o
	rm capi2name


install:
	$(CP) config_api.o /usr/lib/
	$(CP) capi2name /usr/sbin
	$(CP) capi2name.conf /etc/
	chmod 600 /etc/capi2name.conf
