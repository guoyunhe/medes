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

jQuery(function(){
    SiteHeaderFusion.init();
    DotCloud.init();
    FeaturedPeople.init();
});

/* Introduction */

jQuery(function () {
    jQuery('#front-page-intro a').click(function (e) {
        e.preventDefault();
        jQuery('#front-page-intro .short').hide();
        jQuery('#front-page-intro .long').show();
        jQuery('#front-page-intro a').hide();
    });
    
    jQuery('#school-menu-item').click(function () {
        jQuery('#school-map-click').click();
    });
    
    jQuery('#workshop-menu-item').click(function () {
        jQuery('#workshop-map-click').click();
    });
    
    jQuery('#people-menu-item').click(function () {
        jQuery('#people-map-click').click();
    });
});