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
    // Open "Create Workshop" popup
    jQuery('#create-workshop-click').click(function () {
        openPopup(jQuery('#workshop-create-popup'));
    });
    
    
    // Create workshop and open "Edit Workshop" popup
    jQuery('#workshop-create-popup .next').click(function () {
        var request = {
            'action': 'create_workshop',
            'post_title': jQuery('#workshop-create-popup [name="post_title"]').val()
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function(response){
            if (response.succeed) {
                closePopup(jQuery('#workshop-create-popup'));
                jQuery('#workshop-edit-popup [name="post_title"]').val(request.post_title);
                jQuery('#workshop-edit-popup').data('post-id', response.post_id);
                openPopup(jQuery('#workshop-edit-popup'));
                // TODO: add it to workshop list
            } else {
                errorMessage(response.error_message);
            }
        });

        function errorMessage(message) {
            jQuery('#workshop-create-popup .error-message').html(message);
        }
    });
    
    
    // Initialize "Edit Workshop" popup
    function initWorkshopEditPopup(postId) {
        jQuery('#workshop-edit-popup').data('postId', postId);
        
        // Fetch workshop information
        var request = {
            'action': 'view_workshop',
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
                jQuery('#workshop-edit-main-picture .main-picture').css('background-image',
                        'url(' + response.main_picture.url + ')');
                // Basic information
                // Post title
                jQuery('#workshop-edit-popup [name="post_title"]').val(response.post_title);
                jQuery('#workshop-edit-popup [name="year"]').val(response.year);
                jQuery('#workshop-edit-popup [name="school"]').val(response.school);
                jQuery('#workshop-edit-popup [name="website"]').val(response.website);
                // Description
                jQuery('#workshop-edit-popup [name="post_content"]').val(response.post_content);
                // Pictures
                jQuery('#workshop-edit-popup .pictures .picture').remove();
                var pictures = response['pictures'];
                for (var pictureKey in pictures) {
                    if (pictures.hasOwnProperty(pictureKey)) {
                        addWorkshopPicture(postId, pictureKey, pictures[pictureKey].url);
                    }
                }
            }
        });
    }
    
    
    // Edit interaction in "Edit Workshop" popup

    // Edit main picture
    jQuery('#workshop-edit-popup .main-picture button').click(function () {
        jQuery('#workshop-edit-popup .main-picture input').click();
    });

    jQuery('#workshop-edit-popup .main-picture input').change(function () {
        var file_data = jQuery(this).prop('files')[0];
        var request = new FormData();
        request.append('action', 'edit_workshop_main_picture');
        request.append('post_id', jQuery('#workshop-edit-popup').data('postId'));
        request.append('main_picture', file_data);
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            jQuery('#workshop-edit-popup .main-picture').css('background-image', 'url(' + response.url + ')');
        });
    });
    
    
    // Edit basic information, staff and description 
    jQuery('#workshop-edit-basic input, #workshop-edit-basic select, #workshop-edit-staff input, ' + 
            '#workshop-edit-description textarea').change(updatePostMeta);
    
    function updatePostMeta() {
        var name = jQuery(this).attr('name');
        var value;
        if (jQuery(this).attr('type') === 'checkbox') {
            value = jQuery(this).prop('checked');
        } else {
            value = jQuery(this).val();
        }
        var request = {
            action: 'edit_workshop',
            'post_id': jQuery('#workshop-edit-popup').data('postId')
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
    jQuery('#workshop-edit-popup .add-picture').click(function () {
        jQuery('#workshop-edit-popup .add-picture input')[0].click();
    });

    jQuery('#workshop-edit-popup .add-picture input').change(function () {
        var file_data = jQuery(this).prop('files')[0];
        var postId = jQuery('#workshop-edit-popup').data('postId');
        var request = new FormData();
        request.append('action', 'add_workshop_picture');
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
            addWorkshopPicture(postId, response.uuid, response.url);
        });
    });

    function addWorkshopPicture(postId, uuid, url) {
        var $picture = jQuery('<div class="picture"><span class="remove"><i class="fa fa-remove"></i></span></div>');
        $picture.css('background-image', 'url("' + url + '")');
        $picture.data('uuid', uuid);
        jQuery('#workshop-edit-popup .add-picture').after($picture);
        $picture.find('.remove').click(function () {
            var request = {
                'action': 'remove_workshop_picture',
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
    jQuery('#workshop-edit-popup .finish').click(function(){
        var postId = parseInt(jQuery('#workshop-edit-popup').data('postId'));
        closePopup(jQuery('#workshop-edit-popup'));
        openPopup(jQuery('#workshop-view-popup'));
        initWorkshopViewPopup(postId);
    });
    
    
    // View popup
    
    // Initialize view popup
    function initWorkshopViewPopup(postId) {
        jQuery('#workshop-view-popup').data('postId', postId);
        
        // Fetch workshop information
        var request = {
            'action': 'view_workshop',
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
                jQuery('#workshop-view-popup .main-picture').css('background-image',
                        'url(' + response.main_picture.url + ')');
                // Basic information
                // Post title
                jQuery('#workshop-view-popup .name').text(response.post_title);
                jQuery('#workshop-view-popup .subtitle').text(response.year + ', ' + response.school_name);
                jQuery('#workshop-view-popup .website a').text(response.website).attr('href', response.website);
                // Description
                jQuery('#workshop-view-popup .description').html(response.post_content_display);
                // Pictures
                jQuery('#workshop-view-popup .pictures .picture').remove();
                var pictures = response['pictures'];
                for (var pictureKey in pictures) {
                    if (pictures.hasOwnProperty(pictureKey)) {
                        var $picture = jQuery('<div class="picture"></div>');
                        $picture.css('background-image', 'url("' + pictures[pictureKey].url + '")');
                        jQuery('#workshop-view-popup .pictures').prepend($picture);
                    }
                }
            }
        });
        
        if(is_admin) {
            jQuery('#workshop-view-popup .edit').show();
        } else {
            jQuery('#workshop-view-popup .edit').hide();
        }
    }
    
    // Edit button
    jQuery('#workshop-view-popup .edit').click(function(){
        var postId = parseInt(jQuery('#workshop-view-popup').data('postId'));
        closePopup(jQuery('#workshop-view-popup'));
        openPopup(jQuery('#workshop-edit-popup'));
        initWorkshopEditPopup(postId);
    });
    
    // Workshop list
    jQuery('workshop').click(function(){
        var postId = parseInt(jQuery(this).data('postId'));
        openPopup(jQuery('#workshop-view-popup'));
        initWorkshopViewPopup(postId);
    });
});