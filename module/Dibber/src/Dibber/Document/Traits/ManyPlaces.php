<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document;

trait ManyPlaces
{
    /**
     * Override this property in the using class with according @ODM
     * annotations.
     *
     * Commented to pass strict standards.
     *
     * Do not forget to initialize $places property in the using class with :
     * $this->places = new \Doctrine\Common\Collections\ArrayCollection();
     *
     * @var array
     */
//    public $places;

    /**
     * @return array of Document\Place
     */
    public function getPlaces() {
        return $this->places;
    }

    /**
     * @param array $places of Document\Place
     * @return mixed
     */
    public function setPlaces($places)
    {
        $this->places = [];

        foreach ($places as $place) {
            if ($place instanceof Document\Place) {
                $this->addPlace($place);
            }
        }

        return $this;
    }

    /**
     * @param Document\Place $place
     * @return mixed
     */
    public function addPlace(Document\Place $place)
    {
        $this->places[] = $place;
        $place->belongsTo = $this;
        return $this;
    }
}
