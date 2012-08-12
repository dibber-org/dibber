<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document\Traits;

/** @ODM\Document(collection="fields") */
class Field extends Thing
{
    use Traits\Coordinates;
    use Traits\Surface;

    public $COLLECTION = 'fields';
    public $ACCEPTS = ['cultivations'];
}