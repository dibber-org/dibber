<?php
namespace Dibber\Tests\Units\Service;

require_once(__DIR__ . '/Test.php');

use Dibber\Service;

class Place extends Test
{
    /** @var Service\Place */
    protected $placeService;

    public function beforeTestMethod($method)
    {
        $this->placeService = new \Dibber\Service\Place;
        $this->placeService->setServiceManager($this->sm);
    }

    public function testGetMapper()
    {
        $this
            ->assert('default mapper is set and retreived')
            ->then
                ->object($this->placeService->getMapper())
                    ->isInstanceOf('Dibber\Mapper\Place');
    }
}
