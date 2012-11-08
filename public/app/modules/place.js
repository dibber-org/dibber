// Place module
define([
    // Application.
    'app'
],

// Map dependencies from above array.
function(app) {

    // Create a new module.
    var Place = app.module();

    // Default Model.
    Place.Model = Backbone.Model.extend({

    });

    // Default Collection.
    Place.Collection = Backbone.Collection.extend({
        model: Place.Model
    });

    // Default View.
    Place.Views.Layout = Backbone.Layout.extend({
        template: 'place'
    });

    // Return the module for AMD compliance.
    return Place;

});
