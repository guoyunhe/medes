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


FeaturedPeopleScroll = {
    init: function () {
        var $scrollOuter = jQuery('#featured-people .outer');
        var $scrollInner = jQuery('#featured-people .inner');
        
        jQuery('#featured-people .right').click(function(){
            var offset = $scrollInner.offset();
            offset.left -= $scrollOuter.width() * 0.8;
            
            if(offset.left + $scrollInner.width() < $scrollOuter.width()) {
                offset.left = $scrollOuter.width() - $scrollInner.width();
                jQuery(this).fadeOut();
            }
            $scrollInner.offset(offset);
            jQuery('#featured-people .left').show();
        });
        jQuery('#featured-people .left').click(function(){
            var offset = $scrollInner.offset();
            offset.left += $scrollOuter.width() * 0.8;
            
            if(offset.left > 0) {
                offset.left = 0;
                jQuery(this).fadeOut();
            }
            $scrollInner.offset(offset);
            jQuery('#featured-people .right').show();
        });
    }
};