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
    
    
    // Create school and open "Edit School" popup
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
                jQuery('#school-edit-popup [name="post_title"]').val(request.post_title);
                jQuery('#school-edit-popup').data('post-id', response.post_id);
                openPopup(jQuery('#school-edit-popup'));
                // TODO: add it to school list
            } else {
                errorMessage(response.error_message);
            }
        });

        function errorMessage(message) {
            jQuery('#school-create-popup .error-message').html(message);
        }
    });
    
    
    // Initialize "Edit School" popup
    function initSchoolEditPopup(postId) {
        jQuery('#school-edit-popup').data('postId', postId);
        
        // Fetch school information
        var request = {
            'action': 'view_school',
            'post_id': postId
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function(response){
            if (response.succeed) {
                // Main picture
                jQuery('#school-edit-main-picture .main-picture').css('background-image',
                        'url(' + response.main_picture.url + ')');
                // Basic information
                // Post title
                jQuery('#school-edit-popup [name="post_title"]').val(response.post_title);
                jQuery('#school-edit-popup [name="short_name"]').val(response.short_name);
                jQuery('#school-edit-popup [name="color"]').val(response.color);
                jQuery('#school-edit-popup [name="country"]').val(response.country);
                jQuery('#school-edit-popup [name="city"]').val(response.city);
                jQuery('#school-edit-popup [name="website"]').val(response.website);
                // Staff
                jQuery('#school-edit-popup [name="coordinator_name"]').val(response.coordinator_name);
                jQuery('#school-edit-popup [name="coordinator_email"]').val(response.coordinator_email);
                jQuery('#school-edit-popup [name="tutor_name"]').val(response.tutor_name);
                jQuery('#school-edit-popup [name="tutor_email"]').val(response.tutor_email);
                // Description
                jQuery('#school-edit-popup [name="post_content"]').val(response.post_content);
                // Pictures
                jQuery('#school-edit-popup .pictures .picture').remove();
                var pictures = response['pictures'];
                for (var pictureKey in pictures) {
                    if (pictures.hasOwnProperty(pictureKey)) {
                        addSchoolPicture(postId, pictureKey, pictures[pictureKey].url);
                    }
                }
            }
        });
    }
    
    
    // Edit interaction in "Edit School" popup

    // Edit main picture
    jQuery('#school-edit-popup .main-picture button').click(function () {
        jQuery('#school-edit-popup .main-picture input').click();
    });

    jQuery('#school-edit-popup .main-picture input').change(function () {
        var file_data = jQuery(this).prop('files')[0];
        var request = new FormData();
        request.append('action', 'edit_school_main_picture');
        request.append('post_id', jQuery('#school-edit-popup').data('postId'));
        request.append('main_picture', file_data);
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            jQuery('#school-edit-popup .main-picture').css('background-image', 'url(' + response.url + ')');
        });
    });
    
    
    // Edit basic information, staff and description 
    jQuery('#school-edit-basic input, #school-edit-basic select, #school-edit-staff input, ' + 
            '#school-edit-description textarea').change(updatePostMeta);
    
    function updatePostMeta() {
        var name = jQuery(this).attr('name');
        var value;
        if (jQuery(this).attr('type') === 'checkbox') {
            value = jQuery(this).prop('checked');
        } else {
            value = jQuery(this).val();
        }
        var request = {
            action: 'edit_school',
            'post_id': jQuery('#school-edit-popup').data('postId')
        };
        request[name] = value;
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        });
    }
    
    
    // Edit pictures
    jQuery('#school-edit-popup .add-picture').click(function () {
        jQuery('#school-edit-popup .add-picture input')[0].click();
    });

    jQuery('#school-edit-popup .add-picture input').change(function () {
        var file_data = jQuery(this).prop('files')[0];
        var postId = jQuery('#school-edit-popup').data('postId');
        var request = new FormData();
        request.append('action', 'add_school_picture');
        request.append('post_id', postId);
        request.append('picture', file_data);
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            addSchoolPicture(postId, response.uuid, response.url);
        });
    });

    function addSchoolPicture(postId, uuid, url) {
        var $picture = jQuery('<div class="picture"><span class="remove"><i class="fa fa-remove"></i></span></div>');
        $picture.css('background-image', 'url("' + url + '")');
        $picture.data('uuid', uuid);
        jQuery('#school-edit-popup .add-picture').after($picture);
        $picture.find('.remove').click(function () {
            var request = {
                'action': 'remove_school_picture',
                'post_id': postId,
                'uuid': uuid
            };
            jQuery.ajax({
                url: ajaxurl,
                data: request,
                method: 'POST',
                dataType: 'json'
            });
            $picture.remove();
        });
    }
    
    // "View Result" button
    jQuery('#school-edit-popup .finish').click(function(){
        var postId = parseInt(jQuery('#school-edit-popup').data('postId'));
        closePopup(jQuery('#school-edit-popup'));
        openPopup(jQuery('#school-view-popup'));
        initSchoolViewPopup(postId);
    });
    
    
    // View popup
    
    // Initialize view popup
    function initSchoolViewPopup(postId) {
        jQuery('#school-view-popup').data('postId', postId);
        
        // Fetch school information
        var request = {
            'action': 'view_school',
            'post_id': postId
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function(response){
            if (response.succeed) {
                // Main picture
                jQuery('#school-view-popup .main-picture').css('background-image',
                        'url(' + response.main_picture.url + ')');
                // Basic information
                // Post title
                jQuery('#school-view-popup .name').text(response.post_title);
                jQuery('#school-view-popup .location').text(response.city + ', ' + response.country_name);
                jQuery('#school-view-popup .website a').text(response.website).attr('href', response.website);
                // Staff
                jQuery('#school-view-popup .coordinator-name').text(response.coordinator_name);
                jQuery('#school-view-popup .coordinator-email').text(response.coordinator_email);
                jQuery('#school-view-popup .tutor-name').text(response.tutor_name);
                jQuery('#school-view-popup .tutor-email').text(response.tutor_email);
                // Color
                jQuery('#school-view-popup .header').css('background-color', response.color);
                jQuery('#school-view-popup .main-picture').css('background-color', response.color);
                jQuery('#school-view-popup .website').css('color', response.color);
                jQuery('#school-view-popup .staff').css('color', response.color);
                // Description
                jQuery('#school-view-popup .description').text(response.post_content);
                // Pictures
                jQuery('#school-view-popup .pictures .picture').remove();
                var pictures = response['pictures'];
                for (var pictureKey in pictures) {
                    if (pictures.hasOwnProperty(pictureKey)) {
                        var $picture = jQuery('<div class="picture"></div>');
                        $picture.css('background-image', 'url("' + pictures[pictureKey].url + '")');
                        jQuery('#school-view-popup .pictures').prepend($picture);
                    }
                }
            }
        });
        
        if(is_admin) {
            jQuery('#school-view-popup .edit').show();
        } else {
            jQuery('#school-view-popup .edit').hide();
        }
    }
    
    // Edit button
    jQuery('#school-view-popup .edit').click(function(){
        var postId = parseInt(jQuery('#school-view-popup').data('postId'));
        closePopup(jQuery('#school-view-popup'));
        openPopup(jQuery('#school-edit-popup'));
        initSchoolEditPopup(postId);
    });
    
    // School list
    jQuery('school').click(function(){
        var postId = parseInt(jQuery(this).data('postId'));
        openPopup(jQuery('#school-view-popup'));
        initSchoolViewPopup(postId);
    });
});