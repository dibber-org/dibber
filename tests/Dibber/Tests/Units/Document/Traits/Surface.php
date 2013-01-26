<?php
namespace Dibber\Tests\Units\Document\Traits\Asset;

require_once(__DIR__ . '/../Test.php');
require_once(__DIR__ . '/Asset/Surface.php');

use Dibber\Document;

class Surface extends \Dibber\Tests\Units\Document\Test
{
    /** @var Document\Traits\Asset\Surface */
    protected $surface;

    public function beforeTestMethod($method)
    {
        $this->surface = new \mock\Dibber\Document\Traits\Asset\Surface;
    }

    public function testSetSurfaceSize()
    {
        $this
            ->assert('surfaceSize is set and retreived')
                ->if($surfaceSize = (float) 42)
                ->and($this->surface->setSurfaceSize($surfaceSize))
                ->then
                    ->float($this->surface->getSurfaceSize())
                        ->isEqualTo($surfaceSize)
        ;
    }

    public function testSetSurfaceUnit()
    {
        $this
            ->assert('surfaceUnit is set and retreived')
                ->if($surfaceUnit = 'ha')
                ->and($this->surface->setSurfaceUnit($surfaceUnit))
                ->then
                    ->string($this->surface->getSurfaceUnit())
                        ->isEqualTo($surfaceUnit)
        ;
    }

    public function testSetShape()
    {
        $this
            ->assert('shape is set and retreived')
                ->if($shape = 'woaah')
                ->and($this->surface->setShape($shape))
                ->then
                    ->string($this->surface->getShape())
                        ->isEqualTo($shape)
        ;
    }
}