#!/bin/sh

# don't have the rights some time to regenerate them as they can be created by www-data with only 644 rights
rm -rf module/Dibber/src/Dibber/Document/Hydrator/*.php
rm -rf module/Dibber/src/Dibber/Document/Proxy/*.php

if [ -z $1 ]; then
  dir='tests/Dibber/'
else
  dir=$1
fi

# execute tests
/usr/local/bin/php54 vendor/mageekguy/atoum/scripts/runner.php -p /usr/local/bin/php54 -d $dir