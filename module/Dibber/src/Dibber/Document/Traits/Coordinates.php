<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document;

trait Coordinates
{
    /** @ODM\EmbedOne(targetDocument="Coordinates") */
    private $coordinates;

    /** @ODM\Distance */
    private $distance;

    /**
     * @return Coordinates the $coordinates
     */
    public function getCoordinates() {
        return $this->coordinates;
    }

    /**
     * @return float the $distance
     */
    public function getDistance() {
        return $this->distance;
    }

    /**
     * @param Coordinates $coordinates
     * @return Place
     */
    public function setCoordinates(Document\Coordinates $coordinates) {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * @param float $distance
     * @return Place
     */
    public function setDistance($distance) {
        $this->distance = (float) $distance;
        return $this;
    }
}
