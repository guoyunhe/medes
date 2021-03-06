/* 
 * Copyright (C) 2015 Guo Yunhe <guoyunhebrave at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


jQuery(function () {
    jQuery('#datamap').height(jQuery('#datamap').width() * 0.45);
    
    var fills = {defaultFill: "#eeeeee"};
    var data = {};
    var threeToTwo = {};
    
    for (var key in countries) {
        var threeLetter = countries[key]['three_letter'];
        var color = countries[key]['color'];
        fills[threeLetter] = color;
        data[threeLetter] = {fillKey: threeLetter, twoLetter: key};
        threeToTwo[threeLetter] = key;
    }
    
    var datamap = new Datamap({
        element: document.getElementById("datamap"),
        fills: fills,
        geographyConfig: {
            borderWidth: 0.2,
            borderColor: '#000000',
            popupTemplate: function (geography, data) { //this function should just return a string
                return '<div class="hoverinfo"><strong>' + geography.properties.name + '</strong></div>';
            },
            popupOnHover: true, //disable the popup while hovering
            highlightOnHover: true,
            highlightFillColor: '#FC8D59',
            highlightBorderColor: 'rgba(250, 15, 160, 0.2)',
            highlightBorderWidth: 2
        },
        data: data,
        done: function (datamap) {
            datamap.svg.selectAll('.datamaps-subunit').on('click', function (geography) {
                var country = threeToTwo[geography.id];
                if (typeof country === 'undefined') {
                    return;
                }
                openPopup(jQuery('#city-list'));
                jQuery('#city-list city').remove();
                var cities = countries[country]['cities'];
                var colors = d3.scale.category10();
                for (var i = 0; i < cities.length; i++) {
                    var city = cities[i];
                    var cityElement = jQuery('<city></city>');
                    cityElement.addClass('card');
                    cityElement.css('background-color', colors(Math.random() * 10));
                    cityElement.text(city);
                    cityElement.click(function () {
                        closePopup(jQuery('#city-list'));
                        openPopup(jQuery('#people-list'));
                        jQuery('#people-list person').remove();
                        var request = {
                            'action': 'filter_user',
                            'live_country': country,
                            'live_city': city
                        };
                        jQuery.ajax({
                            url: ajaxurl,
                            data: request,
                            method: 'POST',
                            dataType: 'json'
                        }).done(function (response) {
                            var colors2 = d3.scale.category10();
                            for(var j = 0; j < response.length; j++) {
                                var person = response[j];
                                var personElement = jQuery('<person></person>');
                                personElement.addClass('card');
                                personElement.css('background-image', 'url("'+person.avatar+'")');
                                personElement.css('background-color', colors2(Math.random() * 10));
                                personElement.data('userId', person.ID);
                                personElement.text(person.first_name + ' ' + person.last_name);
                                personElement.click(function(){
                                    viewUserPopup(person.ID);
                                });
                                jQuery('#people-list .popup-body').append(personElement);
                            }
                        });
                    });
                    jQuery('#city-list .popup-body').append(cityElement);
                }
            });
        }
    });
    
    // People list view
    // bind click event and open popup
    jQuery('#list-view person').click(function () {
        viewUserPopup(jQuery(this).data('user-id'));
    });
});