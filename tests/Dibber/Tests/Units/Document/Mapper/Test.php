<?php
namespace Dibber\Tests\Units\Document\Mapper;

require_once __DIR__ . '/../../Test.php';

use mageekguy\atoum;

abstract class Test extends \Dibber\Tests\Units\Test
{
    /** @var $dm \Doctrine\ODM\MongoDB\DocumentManager */
    var $dm;

    public function __construct(atoum\factory $factory = null)
    {
        parent::__construct($factory);

        $this->dm = $this->application->getServiceManager()->get('doctrine.documentmanager.odm_default');
    }

    /**
     * @return Doctrine\ODM\MongoDB\DocumentRepository
     */
    protected function mockGetRepository($mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        $this->mockGenerator->orphanize('__construct');
        $repository = new \mock\Doctrine\ODM\MongoDB\DocumentRepository();

        $mockingOn->getMockController()->getRepository = function() use ($repository) {return $repository;};
        return $repository;
    }
}