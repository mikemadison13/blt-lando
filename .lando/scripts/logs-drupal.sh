#!/usr/bin/env bash

# This file is configured in .lando.yml. Run: lando logs-drupal.
# It will enable the syslog module using config_split module,
# start the rsyslog service and tail the log file. This is really
# only necessary because Drush 10 removed the ability to tail `drush wd-show`.

NORMAL="\033[0m"
RED="\033[31m"
YELLOW="\033[32m"
ORANGE="\033[33m"
PINK="\033[35m"
BLUE="\033[34m"

service rsyslog restart

sleep 1

echo
echo -e "${YELLOW}Tailing logs...${NORMAL}"
echo
tail -f /var/log/syslog | grep drupal
