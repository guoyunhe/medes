/* 
 * Copyright (C) 2015 Guo Yunhe <guoyunhebrave@gmail.com>
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

    /* Basic UI Elements
     * 
     * Click, dropdown, popup...
     */

    // Click element events
    jQuery('.click').click(function (event) {
        event.stopPropagation();
        if (jQuery(this).hasClass('button')) {
            jQuery('.click:not(.tab)').removeClass('active');
            return;
        }
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
            return;
        } else {
            jQuery('.click:not(.tab)').removeClass('active');
            jQuery(this).addClass('active');
            return;
        }
    });
    jQuery(document).click(function () {
        jQuery('.click:not(.tab)').removeClass('active');
    });

    // Dropdown use the active status of click by default, so no event

    // Popup
    jQuery('.popup').each(function () {
        var popup = jQuery(this);
        popup.find('.popup-close').click(function () {
            popup.hide();
        });

    });


    /* Page Layout and Responsive Design
     * 
     * Top bar...
     */

    // Top bar fusion effect
    topbarFusion();
    jQuery(window).scroll(topbarFusion);
    jQuery(window).resize(topbarFusion);
    
    // Search
    jQuery('#top-search-click .dropdown').click(function (event) {
        event.stopPropagation();
    });

    /* Front Page
     * 
     * Popup, maps, slides
     */

    // OpenLayers Map

    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.transform([37.41, 8.82], 'EPSG:4326', 'EPSG:3857'),
            zoom: 4
        })
    });

    // Update map size
    // http://gis.stackexchange.com/questions/31409/openlayers-redrawing-map-after-container-resize
    // http://dev.openlayers.org/docs/files/OpenLayers/Map-js.html#OpenLayers.Map.updateSize

    jQuery(window).resize(function () {
        map.updateSize();
    });

    // Popup map

    jQuery('#front-page-map i').click(function () {
        jQuery('#map-popup').show();
    });

});

/* Top Bar Fusion Effect
 *
 * Detect scroll length of page
 */
function topbarFusion() {
    if (jQuery(document).scrollTop() < jQuery('#site-header').height()) {
        jQuery('#site-header').addClass('fusion');
    } else {
        jQuery('#site-header').removeClass('fusion');
    }
}