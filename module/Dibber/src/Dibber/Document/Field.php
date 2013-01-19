<?php
namespace Dibber\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Dibber\Document\Traits;

/**@ODM\Document(collection="fields", repositoryClass="Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository") */
class Field extends Thing
{
    use Traits\Coordinates;
    use Traits\Surface;

    public $COLLECTION = 'fields';
    public $ACCEPTS = ['cultivations'];
}