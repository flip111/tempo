/*
 * This file is part of the Tempo-project package http://tempo.ikimea.com/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(function() {

    $('.cra_load').on('click', function(e) {
        e.preventDefault();

        var cra_id = $(this).attr('rel');
        var day_date = cra_id.replace('form-cra-load-', '');
        var init_date = new Date();

        var projectId = $(this).data('projectid');

    });

    $('.cra_load').on('keydown', function(event) {
        if (event.which == 9) {
            event.preventDefault();

            var cra_id = $(this).attr('rel');
            $(this).parent().find('.cra_desc').css('display', 'block');
        }
    });


    $('.cra_desc').on('keydown', function(event) {
        if (event.which == 13) {
            event.preventDefault();
            var form = $(this).parent('form');
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {
                    window.location.reload();
                }
            });

        }
    });

    $('a.show_cra').on('click', function(e) {
        e.preventDefault();
        $('.list').hide();
        $('#' + $(this).attr('rel')).show();
    });


    $('#time-list .boxclose').on('click', function(e) {
        $('#' + $(this).attr('rel')).hide();
    });

});
