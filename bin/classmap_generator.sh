#!/bin/sh

/usr/local/bin/php54 vendor/zendframework/zendframework/bin/classmap_generator.php -l module/Dibber/
/usr/local/bin/php54 vendor/zendframework/zendframework/bin/classmap_generator.php -l tests/Dibber/