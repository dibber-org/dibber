// Set the require.js configuration for your application.
require.config({
    urlArgs: 'bust=' + (new Date()).getTime(), // @todo change bust with revision number or App version ?

    // Initialize the application with the main application file.
    deps: ['main'],

    paths: {
        // JavaScript folders.
        libs:       '../assets/js/libs',
        plugins:    '../assets/js/plugins',
        vendor:     '../assets/vendor',

        // Libraries.
        jquery:     '../assets/js/libs/jquery',
        moment:     '../assets/js/libs/moment',
        lodash:     '../assets/js/libs/lodash',
        backbone:   '../assets/js/libs/backbone'
    },

    shim: {
        // Backbone library depends on lodash and jQuery.
        backbone: {
            deps: ['lodash', 'jquery'],
            exports: 'Backbone'
        },

        // Backbone.LayoutManager depends on Backbone.
        'plugins/backbone.layoutmanager': ['backbone']
    }

});
