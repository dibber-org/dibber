<?php
return [
    'zenddevelopertools' => [
         /**
          * General Profiler settings
          */
        'profiler' => [
            /**
             * Enables or disables the profiler.
             *
             * Expects: boolean
             * Default: false
             */
            'enabled' => false,

            /**
             * Enables or disables the strict mode. If the strict mode is
             * enabled, any error will throw an exception, otherwise all
             * errors will be added to the report (and shown in the toolbar).
             *
             * Expects: boolean
             * Default: true
             */
            'strict' => false,

            /**
             * If enabled, the profiler tries to flush the content before the it
             * starts collecting data. This option will be ignored if the Toolbar
             * is enabled.
             *
             * Note: The flush listener listens to the MvcEvent::EVENT_FINISH event
             *       with a priority of -9400. You have to disbale this function if
             *       you wish to modify the output with a lower priority.
             *
             * Expects: boolean
             * Default: false
             */
            'flush_early' => false,

            /**
             * The cache directory is used in the version check and for every storage
             * type that writes to the disk.
             *
             * Note: The default value assumes that the current working directory is the
             *       application root.
             *
             * Expects: string
             * Default: 'data/cache'
             */
            'cache_dir' => 'data/cache',

            /**
             * If a matches is defined, the profiler will be disabled if the
             * request does not match the pattern.
             *
             * Example: 'matcher' => ['ip' => '127.0.0.1')
             *          OR
             *          'matcher' => ['url' => ['path' => '/admin')
             *
             * Note: The matcher is not implemented yet!
             */
            'matcher' => [],

            /**
             * Contains a list with all collector the profiler should run.
             * Zend Developer Tools ships with 'db' (Zend\Db), 'time', 'event', 'memory',
             * 'exception', 'request' and 'mail' (Zend\Mail). If you wish to disable a default
             * collector, simply set the value to null or false.
             *
             * Example: 'collectors' => ['db' => null]
             *
             * Expects: array
             */
            'collectors' => [],
        ],
         /**
          * General Toolbar settings
          */
        'toolbar' => [
            /**
             * Enables or disables the Toolbar.
             *
             * Expects: boolean
             * Default: false
             */
            'enabled' => false,

            /**
             * If enabled, every empty collector will be hidden.
             *
             * Expects: boolean
             * Default: false
             */
            'auto_hide' => false,

            /**
             * The Toolbar position.
             *
             * Expects: string ('bottom' or 'top')
             * Default: bottom
             */
            'position' => 'bottom',

            /**
             * If enabled, the Toolbar will check if your current Zend Framework version
             * is up-to-date.
             *
             * Note: The check will only occur once every hour.
             *
             * Expects: boolean
             * Default: false
             */
            'version_check' => true,

            /**
             * Contains a list with all collector toolbar templates. The name
             * of the array key must be same as the name of the collector.
             *             *
             * Example: 'profiler' => [
             *              'collectors' => [
             *                  // My_Collector_Example::getName() -> mycollector
             *                  'MyCollector' => 'My_Collector_Example',
             *              )
             *          ),
             *          'toolbar' => [
             *              'entries' => [
             *                  'mycollector' => 'example/toolbar/my-collector',
             *              )
             *          ),
             *
             * Expects: array
             */
            'entries' => [],
        ],
    ],
];