<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument  */
class Coordinates
{
    /** @ODM\Float */
    private $latitude;

    /** @ODM\Float */
    private $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude = null, $longitude = null)
    {
        if (! is_null($latitude)) {
            $this->setLatitude($latitude);
        }
        if (! is_null($longitude)) {
            $this->setLongitude($longitude);
        }
    }

    /**
     * @return float the $latitude
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return float the $longitude
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @param float $latitude
     * @return Coordinates
     */
    public function setLatitude($latitude) {
        $this->latitude = (float) $latitude;
        return $this;
    }

    /**
     * @param float $longitude
     * @return Coordinates
     */
    public function setLongitude($longitude) {
        $this->longitude = (float) $longitude;
        return $this;
    }
}