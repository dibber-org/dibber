<?php
/**
 * Needed for ZendDeveloperTools to correctly show execution time.
 */
define('REQUEST_MICROTIME', microtime(true));

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
include 'autoload_init.php';

// Run the application!
Zend\Mvc\Application::init(include 'config/application.config.php')->run();
