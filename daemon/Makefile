# Makefile for capi2name

SOURCE = config_api.c find.c utils.c
SHLIB  = config_api.o
LIB    = -lmysqlclient -lcapi20  -L/usr/lib
CFLAGS = -Wall -static

capi2name:	shlib  client.o indb.o capiconn.o capi2name.o
		$(CC) $(LIB) config_api.o  client.o indb.o capiconn.o capi2name.o -o capi2name

shlib:		$(SOURCE)
		$(CC) -shared -fPIC -lpthread  -o $(SHLIB) $(SOURCE)

client.o:	client.c
		$(CC) $(CFLAGS) -c client.c

indb.o:		indb.c
		$(CC) $(CFLAGS) -c indb.c

capiconn.o:	capiconn.c
		$(CC) $(CFLAGS)  -c capiconn.c

capi2name.o:	capi2name.c
		$(CC) $(CFLAGS) -c capi2name.c

clean:
		rm -f *.o

distclean:	clean
		rm -f capi2name

install:	capi2name
		install -d -m 755 $(DESTDIR)/usr/lib
		install -m 644 config_api.o $(DESTDIR)/usr/lib
		install -d -m 755 $(DESTDIR)/usr/sbin
		install -m 755 capi2name $(DESTDIR)/usr/sbin
		install -d -m 755 $(DESTDIR)/etc
		install -m 600 capi2name.conf $(DESTDIR)/etc
