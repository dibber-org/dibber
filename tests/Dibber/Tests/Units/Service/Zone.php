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
        $this->zoneService = new \Dibber\Service\Zone;
        $this->zoneService->setServiceManager($this->sm);
    }

    public function testGetMapper()
    {
        $this
            ->assert('default mapper is set and retreived')
            ->then
                ->object($this->zoneService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\Zone')
        ;
    }
}
