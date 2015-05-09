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
    var datamapObj;
    jQuery('#datamap').height(jQuery('#datamap').width() * 0.5);
    datamapObj = new Datamap({
        element: document.getElementById("datamap"),
        scope: 'world',
        fills: {
            defaultFill: "#eeeeee",
            activeFill: "#99ddee",
            CHN: '#ff0000'
        },
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
        data: {
            CHN: {fillKey: 'activeFill'},
            FIN: {fillKey: 'activeFill'},
            JPN: {fillKey: 'activeFill'},
            DEU: {fillKey: 'activeFill'},
            FRA: {fillKey: 'activeFill'},
            ITA: {fillKey: 'activeFill'},
            USA: {fillKey: 'activeFill'}
        }
    });

    // Click on map
    jQuery('.datamaps-subunit').click(function () {
        // TODO Query city, people or school in this country, and determin if
        // open popup
        openPopup(jQuery('#city-list'));
    });
});