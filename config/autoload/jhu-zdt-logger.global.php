<?php
/**
 * JhuZdtLoggerModule Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
    /**
     * The logger that will be used by the module. It will only add a writer to
     * it so if you already have a logger in your application, you can set it
     * here to avoid instantiating a new one.
     *
     * The logger you'll set here has to be available thru the service manager.
     */
    'logger' => 'dibber_logger'
);

/**
 * You do not need to edit below this line
 */
return array(
    'jhu' => array(
        'zdt_logger' => $settings
    )
);
