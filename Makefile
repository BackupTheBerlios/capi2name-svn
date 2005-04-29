# Makefile for capi2name
HTDOCS = $(CURDIR)/web/htdocs/
DAEMON = $(CURDIR)/daemon/
SOURCE = $(DAEMON)config_api.c $(DAEMON)find.c $(DAEMON)utils.c
SHLIB  = $(DAEMON)config_api.o
LIB    = -lmysqlclient -lcapi20  -L/usr/lib
CFLAGS = -Wall 

capi2name:	shlib $(DAEMON)client.o $(DAEMON)indb.o $(DAEMON)capiconn.o $(DAEMON)capi2name.o
		$(CC) -shared $(LIB) $(DAEMON)config_api.o  $(DAEMON)client.o $(DAEMON)indb.o $(DAEMON)capiconn.o $(DAEMON)capi2name.o -o $(DAEMON)capi2name

shlib:		$(SOURCE)
		$(CC) -shared -fPIC -lpthread -o $(SHLIB) $(SOURCE)
#		libtool $(CC) -g -o $(DAEMON)libconfig_api.la -rpath $(CURDIR)/usr/lib/ -lpthread
		

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
		rm -f $(DAEMON)*.so
		rm -f $(DAEMON)*.la
		rm -rf $(DAEMON).libs

distclean:	clean
		rm -f $(DAEMON)capi2name

install:	capi2name
		install -d -m 755 $(DESTDIR)/usr/lib
		install -m 755 $(DAEMON).libs/libconfig_api.so.0.0.0 $(DESTDIR)/usr/lib
		install -m 755 $(DAEMON)libconfig_api.la $(DESTDIR)/usr/lib
		ln -s libconfig_api.so.0.0.0 $(DESTDIR)/usr/lib/libconfig_api.so
		ln -s libconfig_api.so.0.0.0 $(DESTDIR)/usr/lib/libconfig_api.so.0
		install -d -m 755 $(DESTDIR)/usr/sbin
		install -m 755 $(DAEMON)capi2name $(DESTDIR)/usr/sbin
		install -d -m 755 $(DESTDIR)/etc
		install -m 600 $(DAEMON)capi2name.conf $(DESTDIR)/etc
		install -d -m 755 $(DESTDIR)/usr/share/capi2name
		install -m 640 $(HTDOCS)*.php $(DESTDIR)/usr/share/capi2name
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/admin
		install -m 640 $(HTDOCS)admin/*.php $(DESTDIR)/usr/share/capi2name/admin
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/images
		install -m 640 $(HTDOCS)images/* $(DESTDIR)/usr/share/capi2name/images
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/includes
		install -m 640 $(HTDOCS)includes/* $(DESTDIR)/usr/share/capi2name/includes
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/language
		install -m 640 $(HTDOCS)language/* $(DESTDIR)/usr/share/capi2name/language
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/up_inst
		install -m 640 $(HTDOCS)up_inst/* $(DESTDIR)/usr/share/capi2name/up_inst
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/templates
		install -m 640 $(HTDOCS)templates/index.html $(DESTDIR)/usr/share/capi2name/templates
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/templates/blueingrey
		install -m 640 $(HTDOCS)templates/blueingrey/* $(DESTDIR)/usr/share/capi2name/templates/blueingrey
