#!/usr/bin/perl
print <<"EOF";
HTTP/1.0 401 Unauthorized
WWW-Authenticate: Basic Realm="Basic Auth"
Content-Type: text/html
 
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<HTML><HEAD><TITLE>401 Authorizaed</TITLE></HEAD>
<BODY>
<H1>Unauthorized</H1>
</BODY>
</HTML>
EOF
