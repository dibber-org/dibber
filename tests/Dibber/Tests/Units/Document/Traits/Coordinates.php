<?php
namespace Dibber\Tests\Units\Document\Traits\Asset;

require_once(__DIR__ . '/../Test.php');
require_once(__DIR__ . '/Asset/Coordinates.php');

use Dibber\Document;

class Coordinates extends \Dibber\Tests\Units\Document\Test
{
    /** @var Document\Traits\Asset\Coordinates */
    protected $coordinates;

    public function beforeTestMethod($method)
    {
        $this->coordinates = new \mock\Dibber\Document\Traits\Asset\Coordinates;
    }

    public function testSetCoordinates()
    {
        $this
            ->assert('coordinates is set and retreived')
                ->if($coordinates = new Document\Coordinates)
                ->and($this->coordinates->setCoordinates($coordinates))
                ->then
                    ->object($this->coordinates->getCoordinates())
                        ->isIdenticalTo($coordinates)
        ;
    }

    public function testSetDistance()
    {
        $this
            ->assert('distance is set and retreived')
                ->if($distance = (float) 42)
                ->and($this->coordinates->setDistance($distance))
                ->then
                    ->float($this->coordinates->getDistance())
                        ->isEqualTo($distance)
        ;
    }
}