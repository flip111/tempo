Tempo.Model.Timesheet = Backbone.Model.extend({

    url : '/api/latest/timesheet/periods',
    defaults: {
    },

    initialize: function(options) {

    },
    save: function(key, val, options) {
        var attributes  = this.attributes;
        this.url = this.url + '/' + attributes.project;
        return Backbone.Model.prototype.save.call(this,attributes, options);
    }
});
