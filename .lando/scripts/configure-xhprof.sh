#!/usr/bin/env bash

# You must use the XHPROF module of Drupal to profile and view results.)

if [ ! -f /usr/local/etc/php/conf.d/tideways_xhprof.ini ]
then
  cd /tmp && git clone https://github.com/tideways/php-profiler-extension.git
  cd /tmp/php-profiler-extension && phpize && ./configure && make && make install
  echo 'extension=tideways_xhprof.so' > /usr/local/etc/php/conf.d/tideways_xhprof.ini
fi
