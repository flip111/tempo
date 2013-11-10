/**
 * Simple view to render chat messages in the chatBox
 */
Tempo.View.ChatMessage = Backbone.View.extend({
    tagName: 'div',
    template: '<div class="message-head" title="<%= created %>"><%= user.username %> </div><p class="message-content"><%= content %></p>',
    className: 'chat-message',

    initialize: function(options) {
    },

    /**
     * Render a singe chat message
     */
    render: function() {
        var data = this.model.toJSON();
        //data.content = Tempo.View.TextConverter.convert(data.content);
        this.$el.html(_.template(this.template, data));
        return this;
    }
});

