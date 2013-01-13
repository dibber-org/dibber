<?php
namespace Dibber\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager;

class Zone extends Base
{
    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    public function __construct(DocumentManager $dm = null)
    {
        parent::__construct('Dibber\Document\Zone', $dm);
    }
}