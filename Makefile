# Makefile for capi2name
HTDOCS = $(CURDIR)/web/htdocs/
DAEMON = $(CURDIR)/daemon/
SOURCE = $(DAEMON)config_api.c $(DAEMON)find.c $(DAEMON)utils.c
SHLIB  = $(DAEMON)config_api.o
LIB    = -lmysqlclient -lcapi20  -L/usr/lib
CFLAGS = -Wall -static

capi2name:	shlib  $(DAEMON)client.o $(DAEMON)indb.o $(DAEMON)capiconn.o $(DAEMON)capi2name.o
		$(CC) $(LIB) $(DAEMON)config_api.o  $(DAEMON)client.o $(DAEMON)indb.o $(DAEMON)capiconn.o $(DAEMON)capi2name.o -o $(DAEMON)capi2name

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
		rm -f $(DAEMON)*.o

distclean:	clean
		rm -f $(DAEMON)capi2name

install:	capi2name
		install -d -m 755 $(DESTDIR)/usr/lib
		install -m 644 $(DAEMON)config_api.o $(DESTDIR)/usr/lib
		install -d -m 755 $(DESTDIR)/usr/sbin
		install -m 755 $(DAEMON)capi2name $(DESTDIR)/usr/sbin
		install -d -m 755 $(DESTDIR)/etc
		install -m 600 $(DAEMON)capi2name.conf $(DESTDIR)/etc
		install -d -m 755 $(DESTDIR)/usr/share/capi2name
		install -m 640 --owner=root --group=www-data $(HTDOCS)*.php $(DESTDIR)/usr/share/capi2name
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/admin
		install -m 640 --owner=root --group=www-data $(HTDOCS)admin/*.php $(DESTDIR)/usr/share/capi2name/admin
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/images
		install -m 640 --owner=root --group=www-data $(HTDOCS)images/* $(DESTDIR)/usr/share/capi2name/images
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/includes
		install -m 640 --owner=root --group=www-data $(HTDOCS)includes/* $(DESTDIR)/usr/share/capi2name/includes
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/language
		install -m 640 --owner=root --group=www-data $(HTDOCS)language/* $(DESTDIR)/usr/share/capi2name/language
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/up_inst
		install -m 640 --owner=root --group=www-data $(HTDOCS)up_inst/* $(DESTDIR)/usr/share/capi2name/up_inst
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/templates
		install -m 640 --owner=root --group=www-data $(HTDOCS)templates/index.html $(DESTDIR)/usr/share/capi2name/templates
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/templates/blueingrey
		install -m 640 --owner=root --group=www-data $(HTDOCS)templates/blueingrey/* $(DESTDIR)/usr/share/capi2name/templates/blueingrey
