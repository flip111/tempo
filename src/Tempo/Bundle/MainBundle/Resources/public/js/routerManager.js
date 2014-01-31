var RouterManager = Backbone.Router.extend({
    routes: {
        "": "home",
        "*timesheet": "timesheet",
        "*path": "root"
    },
    root: function() {
    },
    home: function() {

    },
    timesheet: function() {
        new Tempo.Controller.Timesheet();
    }
});