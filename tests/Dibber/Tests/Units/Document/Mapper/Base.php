<?php
namespace Dibber\Tests\Units\Document\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Document\Mapper;

class Base extends Test
{
    /** @var Document\Mapper\Base */
    protected $baseMapper;

    public function beforeTestMethod($method)
    {
        # Make it behave like a User mapper
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
              ->isInstanceOf('\Doctrine\ODM\MongoDB\DocumentRepository');

         $this->string($this->baseMapper->getRepository()->getDocumentName())
              ->isEqualTo('Dibber\Document\User');

         $this->string($this->baseMapper->getRepository('Dibber\Document\Place')->getDocumentName())
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

         # Not sure next one is really are necessary
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

     public function testCreateDocument()
     {
        $this->object($this->baseMapper->createDocument())
             ->isInstanceOf('Dibber\Document\User');

        $this->exception(function() {
                $this->baseMapper->createDocument('Non\Existing\FQDN');
            } )
             ->isInstanceOf('\Exception')
             ->hasMessage("'Non\Existing\FQDN' class doesn't exist. Can't create class.");
     }
}