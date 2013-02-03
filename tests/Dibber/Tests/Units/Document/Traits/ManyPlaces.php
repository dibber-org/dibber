<?php
namespace Dibber\Tests\Units\Document\Traits\Asset;

require_once(__DIR__ . '/../Test.php');
require_once(__DIR__ . '/Asset/ManyPlaces.php');

use Dibber\Document;

class ManyPlaces extends \Dibber\Tests\Units\Document\Test
{
    /** @var Document\Traits\Asset\ManyPlaces */
    protected $manyPlaces;

    public function beforeTestMethod($method)
    {
        $this->manyPlaces = new \Dibber\Document\Traits\Asset\ManyPlaces;
        $this->places = [
            $this->createPlace(['name' => 'place1']),
            $this->createPlace(['name' => 'place2']),
            $this->createPlace(['name' => 'place3']),
            $this->createPlace(['name' => 'place4'])
        ];
    }

    /**
     * @param array $data
     * @return Document\Place
     */
    protected function createPlace($data)
    {
        $place = new Document\Place;
        foreach ($data as $field => $value) {
            $setter = 'set' . ucfirst($field);
            $place->$setter($value);
        }
        return $place;
    }

    public function testSetPlaces()
    {
        $this
            ->assert('places are set and retreived')
                ->if($manyPlaces = [
                    $this->createPlace(['name' => 'place1']),
                    $this->createPlace(['name' => 'place2']),
                ] )
                ->and($this->manyPlaces->setPlaces($manyPlaces, false))
                ->then
                    ->array($this->manyPlaces->getPlaces()->toArray())
                        ->hasSize(2)
                        ->strictlyContainsValues($manyPlaces)


            ->assert('places are set without values that arent Document\Place')
                ->if($manyPlaces = [
                    $this->createPlace(['name' => 'place1']),
                    'notAPlace',
                ] )
                ->and($this->manyPlaces->setPlaces($manyPlaces, false))
                ->then
                    ->array($this->manyPlaces->getPlaces()->toArray())
                        ->hasSize(1)
                        ->strictlyContains($manyPlaces[0])
                        ->strictlyNotContains($manyPlaces[1])
        ;
    }

    public function testAddPlace()
    {
        $this
            ->assert('a place is added and not inversed')
                ->if($place = $this->createPlace(['name' => 'place1']))
                ->and($this->manyPlaces->addPlace($place, false))
                ->then
                    ->object($return = $this->manyPlaces->getPlaces()[0])
                        ->isIdenticalTo($place)
                    ->string($return->getName())
                        ->isEqualTo('place1')

            ->assert('a place is added and inversed')
                ->if($place = $this->createPlace(['name' => 'place1']))
                ->then
                    ->exception(function() use($place) {
                        $this->manyPlaces->addPlace($place);
                    } )
                    ->hasMessage('Added place is inversed.')
        ;
    }

    public function testRemovePlace()
    {
        $this
            ->assert('a place is removed and not inversed')
                ->if($place = $this->createPlace(['name' => 'place1']))
                ->and($this->manyPlaces->addPlace($place, false))
                ->and($this->manyPlaces->removePlace($place, false))
                ->then
                    ->array($return = $this->manyPlaces->getPlaces()->toArray())
                        ->hasSize(0)

            ->assert('a place is removed and inversed')
                ->if($place = $this->createPlace(['name' => 'place1']))
                ->and($this->manyPlaces->addPlace($place, false))
                ->then
                    ->exception(function() use($place) {
                        $this->manyPlaces->removePlace($place);
                    } )
                    ->hasMessage('Removed place is inversed.')
        ;
    }

    public function testHasPlace()
    {
        $this
            ->assert('returns true if has an already added place')
                ->if($place = $this->createPlace(['name' => 'place1']))
                ->and($this->manyPlaces->addPlace($place, false))
                ->then
                    ->boolean($this->manyPlaces->hasPlace($place))
                        ->isTrue()

            ->assert('returns false if has an already added place')
                ->if($place = $this->createPlace(['name' => 'place1']))
                ->and($this->manyPlaces->removePlaces(false))
                ->then
                    ->boolean($this->manyPlaces->hasPlace($place))
                        ->isFalse()
        ;
    }
}