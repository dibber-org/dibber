<?php
namespace Dibber\Tests\Units\Service;

require_once __DIR__ . '/../Test.php';

use mageekguy\atoum;

abstract class Test extends \Dibber\Tests\Units\Test
{
    /** @var $sm \Zend\ServiceManager\ServiceManager */
    var $sm;

    /** @var $dm \Doctrine\ODM\MongoDB\DocumentManager */
    var $dm;

    public function __construct(atoum\factory $factory = null)
    {
        parent::__construct($factory);

        $this->sm = $this->application->getServiceManager();
        $this->dm = $this->sm->get('doctrine.documentmanager.odm_default');
    }
}
