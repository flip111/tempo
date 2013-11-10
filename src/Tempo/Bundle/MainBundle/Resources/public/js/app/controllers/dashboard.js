/**
 * Controller for viewing a scrum board
 *
 * Initializes the board view and board model
 */
Tempo.Controller.Dashboard = Tempo.baseObject.extend({

    room: null,
    connectedUsersView: null,
    messagesView: null,
    user:  null,

    load: function() {
        var container = $('#row-box');

        this.connectedUsersView = new Tempo.View.ConnectedUsers();
        this.messagesView = new Tempo.View.ChatBox({messages: this.room.get('chat_messages'), room: this.room});

        container.find('#chat-box').append(this.connectedUsersView.render().el);
        container.find('#chat-box').append(this.messagesView.render().el);

        //Open a socket
        Tempo.socket = io.connect(window.location.hostname + ':8000');
        Tempo.socket.on('connect', _.bind(this.onSocketConnect, this));
    },

    //Handler for socket connections and reconnections
    onSocketConnect: function() {
        //Join the room for this scrumboard
        Tempo.socket.emit('subscribe', this.room.id, this.user);

        //We now have a socket so bind on events from it
        this.connectedUsersView.bindSocketEvents();
        this.messagesView.bindSocketEvents();
    }

});

