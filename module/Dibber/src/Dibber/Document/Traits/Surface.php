<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document;

trait Surface
{
    /** @ODM\Float  */
    private $surfaceSize;

    /** @ODM\String  */
    private $surfaceUnit;

    /** @ODM\String */
    private $shape;

    /**
     * @return float the $surfaceSize
     */
    public function getSurfaceSize() {
        return $this->surfaceSize;
    }

    /**
     * @param float $surfaceSize
     * @return Field
     */
    public function setSurfaceSize($surfaceSize) {
        $this->surfaceSize = (float) $surfaceSize;
        return $this;
    }

    /**
     * @return string the $surfaceUnit
     */
    public function getSurfaceUnit() {
        return $this->surfaceUnit;
    }

    /**
     * @param string $surfaceUnit
     * @return Field
     */
    public function setSurfaceUnit($surfaceUnit) {
        $this->surfaceUnit = (string) $surfaceUnit;
        return $this;
    }

    /**
     * @return string the $shape
     */
    public function getShape() {
        return $this->shape;
    }

    /**
     * @param string $shape
     * @return Thing
     */
    public function setShape($shape) {
        $this->shape = $shape;
        return $this;
    }
}
