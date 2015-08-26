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
    // Open "Create School" popup
    jQuery('#create-school-click').click(function () {
        openPopup(jQuery('#school-create-popup'));
    });
    
    jQuery('#school-create-popup .next').click(function () {
        var request = {
            'action': 'create_school',
            'post_title': jQuery('#school-create-popup [name="post_title"]').val()
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function(response){
            if (response.succeed) {
                closePopup(jQuery('#school-create-popup'));
                openPopup(jQuery('#school-edit-popup'));
                
                // TODO fill data in school edit popup
                
            } else {
                errorMessage(response.error_message);
            }
        });
    });
    
    function errorMessage(message) {
        jQuery('#school-create-popup .error-message').html(message);
    }
});