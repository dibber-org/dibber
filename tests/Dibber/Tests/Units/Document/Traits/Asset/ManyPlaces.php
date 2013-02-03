<?php
namespace Dibber\Document\Traits\Asset;
require_once 'module/Dibber/src/Dibber/Document/Traits/ManyPlaces.php';

use Dibber\Document;

class ManyPlaces
{
    use Document\Traits\ManyPlaces;

    public $places;

    public function __construct()
    {
        $this->places = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Called after a ManyPlaces::addPlace to inverse the relation
     *
     * @param Document\Place $place
     */
    public function inverseAddPlace(Document\Place $place)
    {
        throw new \Exception('Added place is inversed.');
    }

    /**
     * Called after a ManyPlaces::removePlace to inverse the removal of the
     * relation.
     *
     * @param Document\Place $place
     */
    public function inverseRemovePlace(Document\Place $place)
    {
        throw new \Exception('Removed place is inversed.');
    }
}
