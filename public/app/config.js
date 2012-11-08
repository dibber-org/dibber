// Set the require.js configuration for your application.
require.config({
    urlArgs: "bust=" + (new Date()).getTime(), // @todo change bust with revision number or App version ?

  // Initialize the application with the main application file.
  deps: ["main"],

  paths: {
    // JavaScript folders.
    libs: "../assets/js/libs",
    plugins: "../assets/js/plugins",
    vendor: "../assets/vendor",

    // Libraries.
    zepto: "../assets/js/libs/zepto",
    lodash: "../assets/js/libs/lodash",
    backbone: "../assets/js/libs/backbone"
  },

  shim: {
    // Backbone library depends on lodash and Zepto (jQuery replacement).
    backbone: {
      deps: ["lodash", "zepto"],
      exports: "Backbone"
    },

    // Backbone.LayoutManager depends on Backbone.
    "plugins/backbone.layoutmanager": ["backbone"]
  }

});
