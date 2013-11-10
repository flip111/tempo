/**
 * Model for Boards
 */
Tempo.Model.Room = Backbone.Model.extend({
    urlRoot: '/rooms',

    defaults: {
        stories: null,
        chat_messages: null
    },

    initialize: function(options) {

    },

    /**
     * When we get a response from the server, that contains tickets and stories
     * Put those into collections
     */
    parse: function(response) {
        response.chat_messages = new Tempo.Collection.ChatMessages(response.chat_messages);
        response.chat_messages.url = this.urlRoot + '/' + response.id + '/messages';
        response.chat_messages.fetch();
        return response;
    }
});

