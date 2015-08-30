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
                        // TODO AJAX
                    });
                    jQuery('#city-list .popup-body').append(cityElement);
                }
            });
        }
    });
});