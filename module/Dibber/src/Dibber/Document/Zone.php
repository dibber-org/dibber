<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document\Traits;

/** @ODM\Document(collection="zones") */
class Zone extends Thing
{
    use Traits\Coordinates;
    use Traits\Surface;

    public $COLLECTION = 'zones';
    public $ACCEPTS = ['fields'];
}