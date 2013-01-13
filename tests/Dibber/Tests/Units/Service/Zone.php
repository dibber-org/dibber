<?php
namespace Dibber\Tests\Units\Service;

require_once(__DIR__ . '/Test.php');

use Dibber\Service;

class Zone extends Test
{
    /** @var Service\Zone */
    protected $zoneService;

    public function beforeTestMethod($method)
    {
        $this->zoneService = new \mock\Dibber\Service\Zone;
        $this->zoneService->setServiceManager($this->sm);
    }

    public function testDefaultMapper()
    {
        $this->assert('default mapper is set and retreived')
             ->then
                ->object($this->zoneService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\Zone');
    }

    public function testSetMapper()
    {
        $this->assert('mapper is set and retreived')
             ->if($zoneMapper = new \Dibber\Mapper\Zone)
             ->and($this->zoneService->setMapper($zoneMapper))
             ->then
                ->object($this->zoneService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\Zone')
                    ->isEqualTo($zoneMapper);
    }
}