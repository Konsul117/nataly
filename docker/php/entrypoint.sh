#!/bin/bash

# Stop on any error
set -e

echo "Init app"

echo "Start app"
/usr/bin/supervisord -n -c /etc/supervisord.conf
