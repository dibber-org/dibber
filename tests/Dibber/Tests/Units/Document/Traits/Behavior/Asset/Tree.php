<?php
namespace Dibber\Document\Traits\Behavior\Asset;
require_once 'module/Dibber/src/Dibber/Document/Traits/Behavior/Tree.php';

use Dibber\Document;

class Tree
{
    use Document\Traits\Behavior\Tree;

    private $parent;

    public function __construct()
    {
        $this->code = 'code';
        $this->level = 42;
        $this->path = 'path';
        $this->lockTime = new \DateTime(date('Y-m-d'));
    }
}
