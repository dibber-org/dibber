<?php
namespace Dibber\Tests\Units\Document;

require_once(__DIR__ . '/Test.php');

use Dibber\Document;

class Coordinates extends Test
{
    /** @var Document\Coordinates */
    protected $coordinates;

    public function beforeTestMethod($method)
    {
        $this->coordinates = new Document\Coordinates;
    }

    public function testConstruct()
    {
        $this
            ->assert('Sets latitude and longitude if given')
            ->if($latitude = (float) 42)
            ->and($longitude = (float) 24)
            ->and($this->coordinates = new Document\Coordinates($latitude, $longitude))
            ->then
                ->float($this->coordinates->getLatitude())
                    ->isEqualTo($latitude)
                ->float($this->coordinates->getLongitude())
                    ->isEqualTo($longitude)


            ->assert('Keep latitude and longitude to null if not given')
            ->if($this->coordinates = new Document\Coordinates)
            ->then
                ->variable($this->coordinates->getLatitude())
                    ->isNull()
                ->variable($this->coordinates->getLongitude())
                    ->isNull()
        ;
    }

    public function testSetLatitude()
    {
        $this
            ->assert('Latitude is set and retreived')
                ->if($latitude = (float) 24)
                ->and($this->coordinates->setLatitude($latitude))
                ->then
                    ->float($this->coordinates->getLatitude())
                        ->isEqualTo($latitude)
        ;
    }

    public function testSetLongitude()
    {
        $this
            ->assert('Longitude is set and retreived')
                ->if($longitude = (float) 42)
                ->and($this->coordinates->setLongitude($longitude))
                ->then
                    ->float($this->coordinates->getLongitude())
                        ->isEqualTo($longitude)
        ;
    }
}