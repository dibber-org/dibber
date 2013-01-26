<?php
namespace Dibber\Tests\Units\Service;

require_once(__DIR__ . '/Test.php');

use Dibber\Service;

class Field extends Test
{
    /** @var Service\Field */
    protected $fieldService;

    public function beforeTestMethod($method)
    {
        $this->fieldService = new \Dibber\Service\Field;
        $this->fieldService->setServiceManager($this->sm);
    }

    public function testGetMapper()
    {
        $this
            ->assert('default mapper is set and retreived')
            ->then
                ->object($this->fieldService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\Field')
        ;
    }
}
