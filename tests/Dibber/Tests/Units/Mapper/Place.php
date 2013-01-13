<?php
namespace Dibber\Tests\Units\Mapper;

require_once(__DIR__ . '/Test.php');

use Dibber\Document
 ,  Dibber\Mapper
 ,  mageekguy\atoum;

class Place extends Test
{
    /** @var Mapper\Place */
    protected $placeMapper;

    public function beforeTestMethod($method)
    {
        $this->placeMapper = new \mock\Dibber\Mapper\Place($this->dm);
    }

    public function testFindByLogin()
    {
        $this->assert('FindByCode is called as it\'s an alias of it')
             ->if($place = new \mock\Dibber\Document\Place)
             ->and($this->placeMapper->getMockController()->findByCode = function($code) use ($place) {
                 return $place;
             } )
             ->and($login = 'pot-a-je')
             ->then
                ->object($this->placeMapper->findByLogin($login))
                    ->isInstanceOf('Dibber\Document\Place')
                ->mock($this->placeMapper)
                    ->call('findByCode')->withArguments($login)->once();
    }

    public function testFindByCode()
    {
        $this->assert('FindByOne is called on parent')
             ->if($place = new \mock\Dibber\Document\Place)
             ->and($this->placeMapper->getMockController()->findOneBy = function(array $criteria) use ($place) {
                 return $place;
             } )
             ->and($code = 'pot-a-je')
             ->then
                ->object($this->placeMapper->findByLogin($code))
                    ->isInstanceOf('Dibber\Document\Place')
                ->mock($this->placeMapper)
                    ->call('findOneBy')->withArguments(['code' => $code])->once();
    }
}