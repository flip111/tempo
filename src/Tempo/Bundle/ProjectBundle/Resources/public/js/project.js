/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

window.addEvent('domready', function() {


    $$('#project_client, #project_type, #project_status').each(function(el){
       new mForm.Element.Select({
            original: el.getAttribute('id'),
            autoPosition: false
            // See section options for more info
        });
    });

    $$('#project_beginning').setDateText();
    $$('#project_ending').setDateText();

    var beginningDate = new MooDatePicker(document.getElements('input[id="project_beginning_date"]'), {
        onPick: function(date){
            this.element.set('value', date.format('%e/%m/%Y'));

            //var date_element = new Date.parse(this.element.getData('moodatepicker-value'));
            //var parent = this.element.getParent();
        }
    });

    var endingDate = new MooDatePicker(document.getElements('input[id="project_ending_date"]'), {
        onPick: function(date){
            this.element.set('value', date.format('%e/%m/%Y'));

            console.log(date);
            //var date_element = new Date.parse(this.element.getData('moodatepicker-value'));
            //var parent = this.element.getParent();
        }
    });

    $('project_avancement').getParent().grab( $('slider'));
    $('slider').addClass('project_avancement');


	var slider = $('slider');

	new Slider(slider, slider.getElement('.knob'), {
		range: [0, 100],
		initialStep: $('project_avancement').get('value') ,
		onChange: function(value){
            if (value){
                $('project_avancement').set('value', value);
                $('knob_value').innerHTML= value + '%';
            }
		}
	});

});