Tempo.View.Timesheet = Backbone.Marionette.ItemView.extend({

    triggers: {
        'keyup :input': 'logKey'
        ,'keypress :input': 'logKey'
    },
    logKey: function(e) {
        console.log(e.type, e.keyCode);
    },

    initialize: function() {

        //this.listenTo(this.collection, 'add', this.addOne);
        //this.listenTo(this.collection, 'all', this.render);
    },
    modelAdded: function(model) {
        console.log(model);
    },

    render: function() {

    }
});
