<?php
namespace Dibber\Tests\Units;

require __DIR__ . '/../../../../autoload_init.php';

use mageekguy\atoum;

abstract class Test extends atoum\test
{
    /** @var \Zend\Mvc\Application */
    var $application;

    public function __construct(atoum\factory $factory = null)
    {
        parent::__construct($factory);

        $autoloader = array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
        \Zend\Loader\AutoloaderFactory::factory($autoloader);

        $this->application = \Zend\Mvc\Application::init(include 'config/application.config.php');

        $this->setTestNamespace('\\Tests\\Units\\');
    }
}