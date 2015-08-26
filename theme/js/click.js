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
});

jQuery(function () {
    jQuery('.tabs').each(function () {
        var tabGroup = jQuery(this);
        var tabs = tabGroup.children('.click.tab');
        tabs.click(function () {
            tabs.removeClass('active');
            jQuery(this).addClass('active');
            target = jQuery(jQuery(this).data('target'));
            console.log(target.siblings());
            target.siblings().removeClass('active');
            target.addClass('active');
        });
    });
});