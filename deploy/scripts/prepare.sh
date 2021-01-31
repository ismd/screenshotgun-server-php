#!/bin/sh

NGINX_CONF=/etc/nginx/conf.d/screenshotgun-server.conf

rm /etc/nginx/conf.d/default.conf
cp /app/deploy/conf/nginx.conf $NGINX_CONF

sed -i s/\<DOMAIN\>/$DOMAIN/g $NGINX_CONF
sed -i s#\<PATH_TO_PUBLIC_DIR\>#/app/public#g $NGINX_CONF
