/**
 * View object for the chat box
 */
Tempo.View.ChatBox = Backbone.View.extend({
    tagName: 'div',
    template: '<div id="chat-handle" class="live-box-heading"></div>' +
        '<div id="chat-window"><div id="chat-messages"></div>' +
        '<form name="chat-input"><div id="message-input-area clearfix"><input name="chat[content]" required="required" id="message-input" class="form-control" value=""/><input id="message-submit" type="submit" value="&gt;" class="btn btn-sm btn-primary"/></form></div></div>',
    id: 'chatbox',

    events: {
        'submit form': 'newMessage'
    },

    room: null,
    messages: null,

    /**
     * Initialize params and bind on collection events
     */
    initialize: function(options) {
        this.room = options.room;
        this.messages = options.messages;
        this.messages.bind('add', this.renderNewMessage, this);
    },

    /**
     * Render the chat box, and render any messages using the sub view
     **/
    render: function() {
        this.$el.html(_.template(this.template));

        var messageList = $('#chat-messages', this.$el);
        messageList.html('');
        var fragment = document.createDocumentFragment();
        if (typeof this.messages !== 'undefined') {
            this.messages.forEach(function(message) {
                var template = new Tempo.View.ChatMessage({model: message});
                fragment.appendChild(template.render().el);
            });
        }
        messageList.append(fragment);
        return this;
    },

    /**
     * Bind to events coming in from the socket connection
     */
    bindSocketEvents: function() {
        var socket = Tempo.socket;
        if (typeof socket !== 'undefined') {
            socket.on('chatMessage:create', _.bind(this.remoteCreate, this));
        }
    },

    /**
     * When the user submits a new chat message, save it and add it to the collection
     */
    newMessage: function(event) {
        event.preventDefault();
        event.stopPropagation();
        var textbox = $('#message-input', this.$el);
        if (textbox.val() != '') {
            var messages = this.room.get('chat_messages');
            var message = messages.create(
                {
                    content: textbox.val()
                },
                {
                    wait: true,
                    success:  _.bind(this.onCreateSuccess, this)
                }
            );
            textbox.val('');
        }
    },

   /**
    * Send a socket message when a new ticket is created
    */
    onCreateSuccess: function(message) {
        if (typeof Tempo.socket !== 'undefined') {
            Tempo.socket.emit('RoomEvent', Tempo.roomId, 'chatMessage:create', {message: message});
        }
    },

    /**
     * Handler for a message created by a different user
     */
    remoteCreate: function(params) {
        var newMessage = new Tempo.Model.ChatMessage(params.message);
        this.messages.add(newMessage);
        $('#chat-handle', this.$el).addClass('new-message');
    },

    /**
     * When a message is added to the collection, render the new message
     * so we don't need to rerender the whole chat box
     */
    renderNewMessage: function(message) {
        var view = new Tempo.View.ChatMessage({model: message});
        var messageBox = $('#chat-messages', this.$el);
        messageBox.append(view.render().el);
        messageBox.prop('scrollTop', messageBox.prop('scrollHeight'));
    }
});


