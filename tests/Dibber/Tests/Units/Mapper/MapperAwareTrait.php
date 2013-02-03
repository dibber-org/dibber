<?php
namespace Dibber\Tests\Units\Mapper\Asset;

require_once(__DIR__ . '/Test.php');
require_once(__DIR__ . '/Asset/MapperAwareTrait.php');

use Dibber\Mapper;

class MapperAwareTrait extends \Dibber\Tests\Units\Mapper\Test
{
    /** @var Mapper\MapperAwareTrait */
    protected $mapperAwareTrait;

    public function beforeTestMethod($method)
    {
        $this->mapperAwareTrait = new \mock\Dibber\Mapper\Asset\MapperAwareTrait;
    }

    public function testSetMapper()
    {
        $this
            ->assert('mapper is set and retreived')
                ->if($mapper = new Mapper\User($this->dm))
                ->and($this->mapperAwareTrait->setMapper($mapper))
                ->then
                    ->object($this->mapperAwareTrait->getMapper())
                        ->isIdenticalTo($mapper)
        ;
    }
}
