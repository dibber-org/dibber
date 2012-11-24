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
        $this->fieldService = new \mock\Dibber\Service\Field;
        $this->fieldService->setServiceManager($this->sm);
    }

    public function testDefaultMapper()
    {
        $this->assert('default mapper is set and retreived')
             ->then
                ->object($this->fieldService->getMapper())
                    ->isInstanceOf('Dibber\Document\Mapper\Field');
    }

    public function testSetMapper()
    {
        $this->assert('mapper is set and retreived')
             ->if($fieldMapper = new \Dibber\Document\Mapper\Field)
             ->and($this->fieldService->setMapper($fieldMapper))
             ->then
                ->object($this->fieldService->getMapper())
                    ->isInstanceOf('Dibber\Document\Mapper\Field')
                    ->isEqualTo($fieldMapper);
    }
}