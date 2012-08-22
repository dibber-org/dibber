<?php
namespace Dibber\Tests\Units\Document\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Document\Mapper
 ,  mageekguy\atoum;

class Base extends Test
{
    /** @var Document\Mapper\Base */
    protected $baseMapper;

    public function beforeTestMethod($method)
    {
        # Will make it behave like a User mapper
        $this->baseMapper = new \mock\Dibber\Document\Mapper\Base('Dibber\Document\User', $this->dm);
    }

    public function testSetDocumentName()
    {
        $this->exception(function() {
                $this->baseMapper->setDocumentName('Non\Existing\FQDN');
            } )
                ->isInstanceOf('\Exception')
                ->hasMessage("'Non\Existing\FQDN' class doesn't exist. Can't create class.");

        $this->baseMapper->setDocumentName('Dibber\Document\User');
        $this->string($this->baseMapper->getDocumentName())
                ->isEqualTo('Dibber\Document\User');
    }

    public function testGetRepository()
    {
        $this->object($this->baseMapper->getRepository())
                ->isInstanceOf('\Doctrine\ODM\MongoDB\DocumentRepository')
             ->string($this->baseMapper->getRepository()->getDocumentName())
                ->isEqualTo('Dibber\Document\User')
             ->string($this->baseMapper->getRepository('Dibber\Document\Place')->getDocumentName())
                ->isEqualTo('Dibber\Document\Place');
    }

    public function testHydrate()
    {
        $place = new Document\Place;
        $dataPlace = [
            'name'    => 'Far away'
        ];
        $this->object($this->baseMapper->hydrate($dataPlace, $place))
                ->isInstanceOf('Dibber\Document\Place')
                ->isIdenticalTo($place);

        # Not sure next string test is really necessary
        $this->string($place->getName())
                ->isEqualTo($dataPlace['name']);

        $dataUser = [
            'login'    => 'jhuet',
            'password' => 'toto42',
            'email'    => 'jeremy.huet+dibber@gmail.com'
        ];
        $this->object($this->baseMapper->hydrate($dataUser))
                ->isInstanceOf('Dibber\Document\User');
    }

    public function testFlush()
    {
        return;

        // dm is not a mock :(
        $this->dm->getMockController()->flush = function() {};

        $this->baseMapper->flush();

        $this->mock($this->dm)
                ->call('flush')->once();
    }

    public function testCreateDocument()
    {
       $this->object($this->baseMapper->createDocument())
                ->isInstanceOf('Dibber\Document\User')
            ->exception(function() {
               $this->baseMapper->createDocument('Non\Existing\FQDN');
           } )
                ->isInstanceOf('\Exception')
                ->hasMessage("'Non\Existing\FQDN' class doesn't exist. Can't create class.");
    }

    public function testFind()
    {
        $user = new \mock\Dibber\Document\User;

        $repository = $this->mockGetRepository();
        $repository->getMockController()->find = function($id) use ($user) {
            return $user;
        };

        $this->object($this->baseMapper->find('4242'))
                ->isInstanceOf('Dibber\Document\User')
                ->isIdenticalTo($user)
             ->mock($repository)
                ->call('find')->withArguments('4242')->once();
    }

    public function testFindOneBy()
    {
        $user = new \mock\Dibber\Document\User;

        $repository = $this->mockGetRepository();
        $repository->getMockController()->findOneBy = function(array $criteria) use ($user) {
            return $user;
        };

        $this->object($this->baseMapper->findOneBy([]))
                ->isInstanceOf('Dibber\Document\User')
                ->isIdenticalTo($user)
             ->mock($repository)
                ->call('findOneBy')->withArguments([])->once();
    }

    public function testFindAll()
    {
        $user = new \mock\Dibber\Document\User;

        $repository = $this->mockGetRepository();
        $repository->getMockController()->findAll = function() use ($user) {
            return [$user, $user];
        };

        $this->phpArray($this->baseMapper->findAll())
                ->strictlyContainsValues([$user, $user])
             ->mock($repository)
                ->call('findAll')->once();
    }

    public function testFindBy()
    {
        $user = new \mock\Dibber\Document\User;

        $repository = $this->mockGetRepository();
        $repository->getMockController()->findBy = function(array $criteria) use ($user) {
            return [$user, $user];
        };

        $this->phpArray($this->baseMapper->findBy([]))
                ->strictlyContainsValues([$user, $user])
             ->mock($repository)
                ->call('findBy')->withArguments([])->once();
    }

    public function testSave()
    {

    }
}