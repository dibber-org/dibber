define([
    // Application.
    'app',
    'modules/place'
],

function(app, Place) {

    // Defining the application router, you can attach sub routers here.
    var Router = Backbone.Router.extend({
        routes: {
            '': 'index'
        },

        index: function() {
            var place = new Place.Model();
            console.log(place);
        }
    });

    return Router;

});
