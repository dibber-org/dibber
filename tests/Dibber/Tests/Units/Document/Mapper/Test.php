<?php
namespace Dibber\Tests\Units\Document\Mapper;

require_once __DIR__ . '/../../Test.php';

use mageekguy\atoum;

abstract class Test extends \Dibber\Tests\Units\Test
{
    /** @var $dm \Doctrine\ODM\MongoDB\DocumentManager */
    var $dm;

    public function __construct(atoum\factory $factory = null)
    {
        parent::__construct($factory);

        $this->dm = $this->application->getServiceManager()->get('doctrine.documentmanager.odm_default');
    }
}