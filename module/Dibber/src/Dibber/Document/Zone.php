<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM
 ,  Dibber\Document\Traits;

/** @ODM\Document(collection="zones", repositoryClass="Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository") */
class Zone extends Thing
{
    use Traits\Coordinates;
    use Traits\Surface;

    public $COLLECTION = 'zones';
    public $ACCEPTS = ['fields', 'zones'];
}