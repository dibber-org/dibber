<?php
namespace Dibber\Tests\Units\Mapper;

require_once __DIR__ . '/../Test.php';

use mageekguy\atoum;

abstract class Test extends \Dibber\Tests\Units\Test
{
    /** @var \Doctrine\ODM\MongoDB\DocumentManager $dm */
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

    protected function mockFind($return = null, $mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        if (is_null($return)) {
            $return = $mockingOn->createDocument();
        }

        $mockingOn->getMockController()->find = function($id) use($return) {return $return;};
    }

    protected function mockFindOneBy($return = null, $mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        if (is_null($return)) {
            $return = $mockingOn->createDocument();
        }

        $mockingOn->getMockController()->findOneBy = function($criteria) use($return) {return $return;};
    }

    protected function mockHydrate($return = null, $mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        if (is_null($return)) {
            $return = $mockingOn->createDocument();
        }

        $mockingOn->getMockController()->hydrate = function($data, $document) use($return) {return $return;};
    }

    protected function mockFlush($mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        $mockingOn->getMockController()->flush = function() {};
    }

    protected function mockPersist($mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        $mockingOn->getMockController()->persist = function($document) {};
    }

    protected function mockRemove($mockingOn = null)
    {
        if (is_null($mockingOn)) {
            $mockingOn = $this->baseMapper;
        }

        $mockingOn->getMockController()->remove = function($document) {};
    }
}