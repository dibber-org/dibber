<?php
namespace Dibber\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Dibber\Document;

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
//    private $places;

    /**
     * @return array of Document\Place
     */
    public function getPlaces() {
        return $this->places;
    }

    /**
     * @param array $places of Document\Place
     * @param bool $inverse
     * @return mixed
     */
    public function setPlaces($places, $inverse = true)
    {
        $this->removePlaces($inverse);

        foreach ($places as $place) {
            if ($place instanceof Document\Place) {
                $this->addPlace($place, $inverse);
            }
        }

        return $this;
    }

    /**
     * @param bool $inverse
     * @return mixed
     */
    public function removePlaces($inverse = true)
    {
        foreach ($this->places as $place) {
            $this->removePlace($place, $inverse);
        }
        return $this;
    }

    /**
     * @param Document\Place $place
     * @param bool $inverse
     * @return mixed
     */
    public function addPlace(Document\Place $place, $inverse = true)
    {
        $this->places[] = $place;
        if ($inverse == true && method_exists($this, 'inverseAddPlace')) {
            $this->inverseAddPlace($place);
        }
        return $this;
    }

    /**
     * @param Document\Place $place
     * @param bool $inverse
     * @return mixed
     */
    public function removePlace(Document\Place $place, $inverse = true)
    {
        foreach ($this->places as $key => $currentPlace) {
            if ($currentPlace == $place) {
                unset($this->places[$key]);
                if ($inverse == true && method_exists($this, 'inverseRemovePlace')) {
                    $this->inverseRemovePlace($place);
                }
            }
        }

        return $this;
    }

    /**
     * @param Document\Place $place
     * @return boolean
     */
    public function hasPlace(Document\Place $place)
    {
        foreach ($this->places as $currentPlace) {
            if ($currentPlace == $place) {
                return true;
            }
        }

        return false;
    }
}
