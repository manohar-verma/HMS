#!/bin/sh

echo "Waiting for Laravel app to be ready..."
while ! nc -z app 9000; do
  sleep 1
done

echo "Laravel app is up — starting Nginx"
nginx -g "daemon off;"
