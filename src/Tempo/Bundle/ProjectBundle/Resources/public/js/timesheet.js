/*
 * This file is part of the Tempo-project package http://tempo.ikimea.com/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

(function($) {

    $('.cra_load').click(function(e) {
        e.preventDefault();

        var cra_id = this.getProperty('rel');
        var day_date = cra_id.replace('form-cra-load-', '');
        var init_date = new Date();

        var projectId = this.data('projectid');

    });

    $('.cra_load').keydown(function(event) {
        var cra_id = this.getProperty('rel');

        if (event.key == 'tab'){
            this.getParent().getElement('.cra_desc').setStyle('display', 'block');
            event.stop();
        }

    });

    $('.cra_desc').keydown(function(event) {
        var cra_id = this.getProperty('rel');
        if(event.key == 'enter') {

            var form  = this.getParent();
            var formRequest = new Form.Request(form, $('craDesc'), {
                onSuccess: function(result) {
                    window.location.reload()
                }
            }).send();

        }
    });

    $('a.show_cra').click(function(e) {
        e.preventDefault();
        $('.list').hide();
        $('#' + this.getProperty('rel')).show();
    });


    $$('#craTable .boxclose').click(function(e) {
        $(this.getAttribute('rel')).hide();
    });

})(jQuery);
