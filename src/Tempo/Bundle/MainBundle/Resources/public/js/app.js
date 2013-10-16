/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

var Tempo = Tempo || { 'settings': {}, 'notification' : {}, 'behavior' : {} };
/**
 *
 * @type {Object}
 * @todo : complete
 */
Tempo.behavior = {
    behaviors: {},
    statics: {},
    initialized: {},

    create: function(name, control_function)
    {
        this.behaviors[name] = control_function;
        this.statics[name] = {};
    },

    init: function (map) {
        var missing_behaviors = [];
        for (var name in map) {
            if (!(name in this.behaviors)) {
                missing_behaviors.push(name);
                continue;
            }

            var configs = map[name];
            if (!configs.length) {
                if (initialized.hasOwnProperty(name)) {
                    continue;
                }
                configs = [null];
            }
            for (var ii = 0; ii < configs.length; ii++) {
                this.behaviors[name](configs[ii], this.statics[name]);
            }
            this.initialized[name] = true;
        }

        if (missing_behaviors.length) {
            throw new Error(
                'Behavior.init(map): behavior(s) not registered: ' +
                    missing_behaviors.join(', ')
            );
        }
    }
};

$(function() {
    Tempo.log = function() {
        var msg = '[Tempo] ' + Array.prototype.join.call(arguments,', ');
        if (window.console && window.console.log) {
            window.console.log(msg);
        } else if (window.opera && window.opera.postError) {
            window.opera.postError(msg);
        }
    };

    $('body').removeClass('no-js').addClass('js');

    $('#user-barre li.notif').click(function(event){
        event.preventDefault();
        var parent = $(this).find('.notification');
        parent.attr('style', 'style:' + parent.is(':hidden') ? 'block' : 'none' );
    });

    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();

        var btn = $(this),
            url = btn.attr('href'),
            title = btn.data('title'),
            data_target = 'modal'+parseInt(Math.random()*1000),
            modal =  $('#myModal').clone();

        if (url.indexOf('#') == 0) {
            $(url).show().appendTo(modal.find('.modal-body'));
        } else {
            $.get(url, function(data) {
                modal.find('.modal-body').html(data);
            }).success(function() {
                $('input:text:visible:first').focus();
            });
        }

        modal.attr('id', data_target);
        modal.find('.modal-title').html(title);
        $('#dialog').append(modal);
        modal.modal();
    });
});
