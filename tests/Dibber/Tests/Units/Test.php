<?php
namespace Dibber\Tests\Units;

require __DIR__ . '/../../../../init_autoloader.php';

use mageekguy\atoum;

abstract class Test extends atoum\test
{
    /** @var \Zend\Mvc\Application */
    var $application;

    public function __construct(atoum\factory $factory = null)
    {
        parent::__construct($factory);

        $this->application = \Zend\Mvc\Application::init(include 'config/application.config.php');

        $this->setTestNamespace('\\Tests\\Units\\');
    }
}