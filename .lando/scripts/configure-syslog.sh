#!/usr/bin/env bash

# We want to remove drupal.log so it doesn't get too big,
# but we want to allow rsyslog to create it so it has correct permissions.
rm -f /var/logs/drupal.log

if [ ! -f /etc/rsyslog.d/50-default.conf ]
then
  apt-get update -y
  apt-get install rsyslog -y
  cat /app/.lando/config/rsyslog.conf > /etc/rsyslog.d/50-default.conf
fi
