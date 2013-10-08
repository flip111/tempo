/*
---
name: Element.Data
description: Stores data in HTML5 data properties
provides: [Element.Data]
requires: [Core/Element, Core/JSON]
script: Element.Data.js

...
*/
(function(){
    
    Element.implement({
        setDateText: function(element){

            var value2 = $$(this).get("html");

            /*
            var date_day = $(this.getAttribute('id') + '_day');
            var date_month = $(this.getAttribute('id') + '_month');
            var date_year = $(this.getAttribute('id') + '_year');

            date_day.setStyles({'display' : 'none'});
            date_month.setStyles({'display' : 'none'});
            date_year.setStyles({'display' : 'none'});

            $(this.getAttribute('id')).grab(
                new Element('input', {
                    type: 'text',
                    'class': 'select_replace'
                }).set('value',
                    date_day.getSelected().get("value") + '/' +
                    date_month.getSelected().get("value") + '/' +
                    date_year.getSelected().get("value")
                )
            );
            */
        },
        setDateValue: function(){
            
        },
        
        getIndex: function(element){
            var optionsIndex = new Array(); 
            this.getElements('option').each(function(el){
                // regular array (add an optional integer
                optionsIndex[el.get('value')]= el.index;
            });
            
            return optionsIndex[element];
        }
    });
})();