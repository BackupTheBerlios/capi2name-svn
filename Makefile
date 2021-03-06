# Makefile for capi2name
HTDOCS = $(CURDIR)/web/htdocs/
DAEMON = $(CURDIR)/daemon/
LIB    = -lmysqlclient -lcapi20
CFLAGS = -Wall 

capi2name:	$(DAEMON)dbox.o $(DAEMON)c2n.o $(DAEMON)capiconn.o $(DAEMON)capi2name.o 
		$(CC) $(CFLAGS) $(LIB) $(DAEMON)c2n.o $(DAEMON)dbox.o  $(DAEMON)capiconn.o $(DAEMON)capi2name.o -o $(DAEMON)capi2name

dbox.o:		dbox.c
		$(CC) $(CFLAGS) -c dbox.c

c2n.o:		c2n.c
		$(CC) $(CFLAGS) -c c2n.c

capiconn.o:	capiconn.c
		$(CC) $(CFLAGS)  -c capiconn.c

capi2name.o:	capi2name.c
		$(CC) $(CFLAGS) -c capi2name.c

clean:
		rm -f $(DAEMON)*.o

distclean:	clean
		rm -f $(DAEMON)capi2name

install:	capi2name
		install -d -m 755 $(DESTDIR)/usr/sbin
		install -m 755 $(DAEMON)capi2name $(DESTDIR)/usr/sbin
		install -d -m 755 $(DESTDIR)/etc/capi2name/
		install -m 600 $(DAEMON)capi2name.conf $(DESTDIR)/etc/capi2name/
		install -m 640 $(HTDOCS)includes/conf.inc.php $(DESTDIR)/etc/capi2name/
		install -d -m 755 $(DESTDIR)/usr/share/capi2name
		install -m 640 $(HTDOCS)*.php $(DESTDIR)/usr/share/capi2name
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/admin
		install -m 640 $(HTDOCS)admin/*.php $(DESTDIR)/usr/share/capi2name/admin
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/images
		install -m 640 $(HTDOCS)images/* $(DESTDIR)/usr/share/capi2name/images
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/includes
		install -m 640 $(HTDOCS)includes/functions.php $(DESTDIR)/usr/share/capi2name/includes
		install -m 640 $(HTDOCS)includes/index.html $(DESTDIR)/usr/share/capi2name/includes
		install -m 640 $(HTDOCS)includes/template.php $(DESTDIR)/usr/share/capi2name/includes
		ln -s $(DESTDIR)/etc/capi2name/conf.inc.php $(DESTDIR)/usr/share/capi2name/includes/conf.inc.php
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/language
		install -m 640 $(HTDOCS)language/* $(DESTDIR)/usr/share/capi2name/language
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/up_inst
		install -m 640 $(HTDOCS)up_inst/* $(DESTDIR)/usr/share/capi2name/up_inst
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/templates
		install -m 640 $(HTDOCS)templates/index.html $(DESTDIR)/usr/share/capi2name/templates
		install -d -m 755 $(DESTDIR)/usr/share/capi2name/templates/blueingrey
		install -m 640 $(HTDOCS)templates/blueingrey/* $(DESTDIR)/usr/share/capi2name/templates/blueingrey
