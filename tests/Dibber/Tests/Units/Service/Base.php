<?php
namespace Dibber\Tests\Units\Service;

require_once(__DIR__ . '/Test.php');

use Dibber\Service;

class Base extends Test
{
    /** @var Service\Base */
    protected $baseService;

    public function beforeTestMethod($method)
    {
//        parent::beforeTestMethod($method);
//
//        $this->baseService = new \mock\Dibber\Service\Base;
//        $this->baseService->setServiceManager($this->sm);
    }

    public function testSetServiceManager()
    {
//        $this->assert('serviceManager is set and retreived')
//             ->if($this->baseService->setServiceManager($this->sm));
//             ->then
//                ->object($this->baseService->getServiceManager())
//                    ->isInstanceOf('Zend\ServiceManager\ServiceManager')
//                    ->isEqualTo($this->sm);
    }
}
