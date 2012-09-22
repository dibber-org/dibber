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
        $this->assert('Setting non-existing DocumentName raises an exception')
             ->exception(function() {
                $this->baseMapper->setDocumentName('Non\Existing\FQDN');
            } )
                ->isInstanceOf('\Exception')
                ->hasMessage("'Non\Existing\FQDN' class doesn't exist. Can't create class.")

             ->assert('DocumentName is set and retreived')
             ->if($this->baseMapper->setDocumentName('Dibber\Document\User'))
             ->then
                ->string($this->baseMapper->getDocumentName())
                    ->isEqualTo('Dibber\Document\User');
    }

    public function testGetRepository()
    {
        $this->assert('Getting repository')
                ->object($this->baseMapper->getRepository())
                    ->isInstanceOf('\Doctrine\ODM\MongoDB\DocumentRepository')
             ->assert('Getting default DocumentName from Repository')
                ->string($this->baseMapper->getRepository()->getDocumentName())
                    ->isEqualTo('Dibber\Document\User')
             ->assert('Getting another DocumentName from Repository')
                ->string($this->baseMapper->getRepository('Dibber\Document\Place')->getDocumentName())
                    ->isEqualTo('Dibber\Document\Place');
    }

    /**
     * @todo really test what methods are called but would require to mock
     * DocumentManager wich can only be instantiate via a static factory :(
     */
    public function testHydrate()
    {
        $this->assert('Hydrating an already existing Place')
             ->if($place = new Document\Place)
             ->and($dataPlace = [
                'name'    => 'Far away'
             ] )
             ->then
                ->object($this->baseMapper->hydrate($dataPlace, $place))
                    ->isInstanceOf('Dibber\Document\Place')
                    ->isIdenticalTo($place)

             ->assert('Hydrating a new User')
             ->if($dataUser = [
                'login'    => 'jhuet',
                'password' => 'toto42',
                'email'    => 'contact@dibber.org'
             ] )
             ->then
                ->object($this->baseMapper->hydrate($dataUser))
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
        $this->assert('Creating default document')
                ->object($this->baseMapper->createDocument())
                    ->isInstanceOf('Dibber\Document\User')

             ->assert('Creating Place document')
                ->object($this->baseMapper->createDocument('Dibber\Document\Place'))
                    ->isInstanceOf('Dibber\Document\Place')

             ->assert('Creating non-existing Document raises an exception')
                ->exception(function() {
                    $this->baseMapper->createDocument('Non\Existing\FQDN');
                } )
                    ->isInstanceOf('\Exception')
                    ->hasMessage("'Non\Existing\FQDN' class doesn't exist. Can't create class.")

             ->assert('Creating default document with no default raises an exception')
             ->if($baseMapper = new \mock\Dibber\Document\Mapper\Base)
                ->exception(function() use ($baseMapper) {
                    $baseMapper->createDocument();
                } )
                    ->isInstanceOf('\Exception')
                    ->hasMessage("documentName not set. Can't create class.");
    }

    public function testFind()
    {
        $this->assert('Correctly returns the result and calls the right find')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($repository = $this->mockGetRepository())
             ->and($repository->getMockController()->find = function($id) use ($user) {
                return $user;
             } )
             ->then
                ->object($this->baseMapper->find('4242'))
                    ->isInstanceOf('Dibber\Document\User')
                    ->isIdenticalTo($user)

                ->mock($repository)
                    ->call('find')->withArguments('4242')->once();
    }

    public function testFindOneBy()
    {
        $this->assert('Correctly returns the result and calls the right findOneBy')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($repository = $this->mockGetRepository())
             ->and($repository->getMockController()->findOneBy = function(array $criteria) use ($user) {
                return $user;
             } )
             ->then
                ->object($this->baseMapper->findOneBy([]))
                    ->isInstanceOf('Dibber\Document\User')
                    ->isIdenticalTo($user)

                ->mock($repository)
                    ->call('findOneBy')->withArguments([])->once();
    }

    public function testFindAll()
    {
        $this->assert('Correctly returns the result and calls the right findBy')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($repository = $this->mockGetRepository())
             ->and($repository->getMockController()->findBy = function() use ($user) {
                return [$user, $user];
             } )
             ->then
                ->phpArray($this->baseMapper->findAll())
                    ->strictlyContainsValues([$user, $user])

                ->mock($repository)
                    ->call('findBy')->once();
    }

    public function testFindBy()
    {
        $this->assert('Correctly returns the result and calls the right findBy')
             ->if($user = new \mock\Dibber\Document\User)
             ->and($repository = $this->mockGetRepository())
             ->and($repository->getMockController()->findBy = function(array $criteria) use ($user) {
                return [$user, $user];
             } )
             ->then
                ->phpArray($this->baseMapper->findBy([]))
                    ->strictlyContainsValues([$user, $user])

                ->mock($repository)
                    ->call('findBy')->withArguments([])->once();
    }

    public function testSave()
    {

    }
}