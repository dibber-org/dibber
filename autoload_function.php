<?php
return function ($class) {
    static $map;
    if (!$map) {
        $map = array_merge(
            include __DIR__ . '/module/Dibber/autoload_classmap.php'
        );
    }

    if (!isset($map[$class])) {
        return false;
    }
    return include $map[$class];
};