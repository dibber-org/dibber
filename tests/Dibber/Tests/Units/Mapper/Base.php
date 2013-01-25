<?php
namespace Dibber\Tests\Units\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;
use Dibber\Mapper;
use mageekguy\atoum;
use Doctrine\ODM\MongoDB\Events as DoctrineEvents;
use Zend\EventManager\Event as ZendEvent;

class Base extends Test
{
    /** @var Mapper\Base */
    protected $baseMapper;

    public function beforeTestMethod($method)
    {
        # Will make it behave like a User mapper
        $this->baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm);
//        $this->baseMapper->setSerializer($this->application->getServiceManager()->get('doctrine.serializer.odm_default'));
    }

    public function testSetDocumentName()
    {
        $this
            ->assert('Setting non-existing DocumentName raises an exception')
                ->exception(function() {
                    $this->baseMapper->setDocumentName('Non\Existing\FQDN');
                } )
                    ->isInstanceOf('\Exception')
                    ->hasMessage("'Non\Existing\FQDN' class doesn't exist. Can't create class.")

            ->assert('DocumentName is set and retreived')
                ->if($this->baseMapper->setDocumentName('Dibber\Document\User'))
                ->then
                    ->string($this->baseMapper->getDocumentName())
                        ->isEqualTo('Dibber\Document\User')
        ;
    }

    public function testGetRepository()
    {
        $this
            ->assert('Getting repository')
                ->object($this->baseMapper->getRepository())
                    ->isInstanceOf('\Doctrine\ODM\MongoDB\DocumentRepository')
            ->assert('Getting default DocumentName from Repository')
                ->string($this->baseMapper->getRepository()->getDocumentName())
                    ->isEqualTo('Dibber\Document\User')
            ->assert('Getting another DocumentName from Repository')
                ->string($this->baseMapper->getRepository('Dibber\Document\Place')->getDocumentName())
                    ->isEqualTo('Dibber\Document\Place')
        ;
    }

    /**
     * @todo really test what methods are called but would require to mock
     * DocumentManager wich can only be instantiate via a static factory :(
     */
    public function testHydrate()
    {
        $this
            ->assert('Hydrating an already existing Place')
                ->if($place = new Document\Place)
                ->and($dataPlace = [
                    'name'    => 'Far away'
                ] )
                ->then
                    ->object($return = $this->baseMapper->hydrate($dataPlace, $place))
                        ->isInstanceOf('Dibber\Document\Place')
                        ->isIdenticalTo($place)
                    ->string($return->getName())
                        ->isEqualTo($dataPlace['name'])

            ->assert('Hydrating a new User')
                ->if($dataUser = [
                    'login'    => 'jhuet',
                    'password' => 'toto42',
                    'email'    => 'contact@dibber.org'
                ] )
                ->then
                    ->object($return = $this->baseMapper->hydrate($dataUser))
                        ->isInstanceOf('Dibber\Document\User')
                    ->string($return->getLogin())
                        ->isEqualTo($dataUser['login'])
                    ->string($return->getPassword())
                        ->isEqualTo($dataUser['password'])
                    ->string($return->getEmail())
                        ->isEqualTo($dataUser['email'])
        ;
    }

    public function testFlush()
    {
        $this
            ->assert('Flush is being executed by Doctrine')
                ->if($evm = $this->dm->getEventManager())
                ->and(new Asset\Doctrine\EventListenerFlush($evm, DoctrineEvents::preFlush))
                ->then
                    ->exception(function() {
                        $this->baseMapper->flush();
                    } )
                        ->hasMessage('preFlush event caught.')
        ;
    }

    public function testCreateDocument()
    {
        $this
            ->assert('Creating default document')
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

            ->assert('Creating default document with no default FQDN raises an exception')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base)
                ->then
                    ->exception(function() use ($baseMapper) {
                        $baseMapper->createDocument();
                    } )
                        ->isInstanceOf('\Exception')
                        ->hasMessage("documentName not set. Can't create class.")
        ;
    }

    public function testFind()
    {
        $this
            ->assert('Correctly returns the result and calls the right find')
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
                        ->call('find')->withArguments('4242')->once()
        ;
    }

    public function testFindOneBy()
    {
        $this
            ->assert('Correctly returns the result and calls the right findOneBy')
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
                        ->call('findOneBy')->withArguments([])->once()
        ;
    }

    public function testFindAll()
    {
        $this
            ->assert('Correctly returns the result and calls the right findBy with the right arguments')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($repository = $this->mockGetRepository())
                ->and($repository->getMockController()->findBy = function(array $criteria, array $orderBy = null) use ($user) {
                    return [$user, $user];
                } )
                ->then
                    ->phpArray($this->baseMapper->findAll(['name']))
                        ->strictlyContainsValues([$user, $user])

                    ->mock($repository)
                        ->call('findBy')->withArguments([], ['name'])->once()
        ;
    }

    public function testFindBy()
    {
        $this
            ->assert('Correctly returns the result and calls the right findBy')
                ->if($user = new \mock\Dibber\Document\User)
                ->and($repository = $this->mockGetRepository())
                ->and($repository->getMockController()->findBy = function(array $criteria) use ($user) {
                    return [$user, $user];
                } )
                ->then
                    ->phpArray($this->baseMapper->findBy([]))
                        ->strictlyContainsValues([$user, $user])

                    ->mock($repository)
                        ->call('findBy')->withArguments([])->once()
        ;
    }

    public function testSave()
    {
        $this
            ->assert('Triggers save.pre event with correct params')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($test = $this)
                ->and($document = [])
                ->and($baseMapper->getEventManager()->attach(
                    'save.pre',
                    function(ZendEvent $e) use($test, $document) {
                        $test
                            ->phpArray($e->getParam('document'))
                                ->strictlyContainsValues($document)
                            ->boolean($e->getParam('flush'))
                                ->isFalse()
                        ;
                        throw new \Exception('save.pre event caught.');
                    }
                ) )
                ->then
                    ->exception(function() use ($document, $baseMapper) {
                        $baseMapper->save($document);
                    } )
                        ->hasMessage('save.pre event caught.')


            ->assert('Finds the document and returns it if "_id" key is given')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($document = ['_id' => '42'])
                ->and($return = new Document\User)
                ->and($this->mockFind($return, $baseMapper))
                ->and($this->mockPersist($baseMapper))
                ->then
                    ->object($baseMapper->save($document))
                        ->isIdenticalTo($return)


            ->assert('Hydrates to a document and returns it if an array is given')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($document = ['toto' => 'titi'])
                ->and($return = new Document\User)
                ->and($this->mockHydrate($return, $baseMapper))
                ->and($this->mockPersist($baseMapper))
                ->then
                    ->object($baseMapper->save($document))
                        ->isIdenticalTo($return)


            ->assert('Flushes if asked to')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($this->mockFlush($baseMapper))
                ->and($this->mockPersist($baseMapper))
                ->and($baseMapper->save([], true)) // true = flush
                ->then
                    ->mock($baseMapper)
                        ->call('flush')->once()


            ->assert('Triggers save.post event with correct params')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($test = $this)
                ->and($document = new Document\User)
                ->and($this->mockPersist($baseMapper))
                ->and($baseMapper->getEventManager()->attach(
                    'save.post',
                    function(ZendEvent $e) use($test, $document) {
                        $test
                            ->object($e->getParam('document'))
                                ->isIdenticalTo($document)
                            ->boolean($e->getParam('flush'))
                                ->isFalse()
                            ->object($e->getParam('saved'))
                                ->isIdenticalTo($document)
                        ;
                        throw new \Exception('save.post event caught.');
                    }
                ) )
                ->then
                    ->exception(function() use ($document, $baseMapper) {
                        $baseMapper->save($document);
                    } )
                        ->hasMessage('save.post event caught.')
        ;
    }

    public function testDelete()
    {
        $this
            ->assert('Triggers delete.pre event with correct params')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($test = $this)
                ->and($document = new Document\User)
                ->and($baseMapper->getEventManager()->attach(
                    'delete.pre',
                    function(ZendEvent $e) use($test, $document) {
                        $test
                            ->object($e->getParam('document'))
                                ->isIdenticalTo($document)
                            ->boolean($e->getParam('flush'))
                                ->isFalse()
                        ;
                        throw new \Exception('delete.pre event caught.');
                    }
                ) )
                ->then
                    ->exception(function() use ($document, $baseMapper) {
                        $baseMapper->delete($document);
                    } )
                        ->hasMessage('delete.pre event caught.')


            ->assert('Finds the document and returns it if an id is given')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($id = '42')
                ->and($return = new Document\User)
                ->and($this->mockFind($return, $baseMapper))
                ->and($this->mockRemove($baseMapper))
                ->then
                    ->object($baseMapper->delete($id))
                        ->isIdenticalTo($return)


            ->assert('Finds the document and returns it if an array is given')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($criteria = [])
                ->and($return = new Document\User)
                ->and($this->mockFindOneBy($return, $baseMapper))
                ->and($this->mockRemove($baseMapper))
                ->then
                    ->object($baseMapper->delete($criteria))
                        ->isIdenticalTo($return)


            ->assert('Flushes if asked to')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($document = new Document\User)
                ->and($this->mockFlush($baseMapper))
                ->and($this->mockRemove($baseMapper))
                ->and($baseMapper->delete($document, true))
                ->then
                    ->mock($baseMapper)
                        ->call('flush')->once()


            ->assert('Triggers delete.post event with correct params')
                ->if($baseMapper = new \mock\Dibber\Mapper\Base('Dibber\Document\User', $this->dm))
                ->and($test = $this)
                ->and($document = new Document\User)
                ->and($this->mockRemove($baseMapper))
                ->and($baseMapper->getEventManager()->attach(
                    'delete.post',
                    function(ZendEvent $e) use($test, $document) {
                        $test
                            ->object($e->getParam('document'))
                                ->isIdenticalTo($document)
                            ->boolean($e->getParam('flush'))
                                ->isFalse()
                            ->object($e->getParam('deleted'))
                                ->isIdenticalTo($document)
                        ;
                        throw new \Exception('delete.post event caught.');
                    }
                ) )
                ->then
                    ->exception(function() use ($document, $baseMapper) {
                        $baseMapper->delete($document);
                    } )
                        ->hasMessage('delete.post event caught.')
        ;
    }
}
