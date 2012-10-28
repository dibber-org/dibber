<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

// Composer autoloading
require 'vendor/autoload.php';

# Hack as this package is not yet available in composer. PR waiting for it :
# https://github.com/ZF-Commons/ZfcUserDoctrineMongoODM/pull/5
// @todo remove once package available
//require 'vendor/zf-commons/zfc-user-doctrine-mongo-odm/autoload_register.php';

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install`.');
}
