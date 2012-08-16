<?php
namespace Dibber\Tests\Units;

require __DIR__ . '/../../../../vendor/autoload.php';
require __DIR__ . '/../../../../autoload_register.php';

use mageekguy\atoum;

abstract class Test extends atoum\test
{
    public function __construct(atoum\factory $factory = null)
    {
        $this->setTestNamespace('\\Tests\\Units\\');
        parent::__construct($factory);
    }
}