// Place module
define([
    // Application.
    'app',
    'moment'
],

// Map dependencies from above array.
function(app, moment) {

    // Create a new module.
    var Place = app.module();

    // Default Model.
    Place.Model = Backbone.Model.extend({
        defaults: {
            code: '',
            coordinates: {
                latitude: 0.0,
                longitude: 0.0
            },
            createdAt: moment().format(),
            level: 1,
            name: '',
            path: '',
            surfaceSize: 0,
            surfaceUnit: '',
            updatedAt: moment().format()
        }
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
