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

// Create new account popup

function createUserPopup() {
    // Open user creation popup/wizard
    openPopup(jQuery('#user-create-popup'));
}

jQuery(function () {
    jQuery('#user-create-popup .next').click(function () {
        if (checkPassword()) {
            createUser();
        }
    });

    function checkPassword() {
        var username = jQuery('#user-create-popup [name="username"]').val();
        var pwd1 = jQuery('#user-create-popup [name="password"]').val();
        var pwd2 = jQuery('#user-create-popup [name="password_repeat"]').val();
        if (username === null || username === '') {
            errorMessage('Username cannot be empty!');
            return false;
        }
        if (pwd1 === null || pwd1 === '') {
            errorMessage('Password cannot be empty!');
            return false;
        }
        if (pwd1 !== pwd2) {
            errorMessage('Password doesn\'t match!');
            return false;
        }
        return true;
    }

    function createUser() {
        var sendData = {
            'action': 'create_user',
            'secret_key': jQuery('#user-create-popup [name="secret_key"]').val(),
            'username': jQuery('#user-create-popup [name="username"]').val(),
            'password': jQuery('#user-create-popup [name="password"]').val(),
            'email': jQuery('#user-create-popup [name="email"]').val()
        };
        jQuery.post(ajaxurl, sendData, ajaxCallback, 'json');
    }


    function ajaxCallback(response) {
        if (response.succeed) {
            closePopup(jQuery('#user-create-popup'));
            openPopup(jQuery('#user-edit-basic-popup'));
        } else {
            errorMessage(response['error_message']);
        }
    }

    function errorMessage(message) {
        jQuery('#user-create-popup .error-message').html(message);
    }
});

// Edit user basic profile popup

function editUserBasicPopup() {
    openPopup(jQuery('#user-edit-basic-popup'));
}

jQuery(function () {
    jQuery('#user-edit-basic-popup .next').click(function(){
        var request = {
            'action': 'edit_user_basic',
            'first_name': jQuery('#user-edit-basic-popup input[name="first_name"]').val(),
            'last_name': jQuery('#user-edit-basic-popup input[name="last_name"]').val(),
            'country': jQuery('#user-edit-basic-popup select[name="country"]').val(),
            'city': jQuery('#user-edit-basic-popup input[name="city"]').val(),
            'role': jQuery('#user-edit-basic-popup select[name="role"]').val(),
            'schools': [
                {
                    'year': jQuery('#user-edit-basic-popup select[name="year_1"]').val(),
                    'school': jQuery('#user-edit-basic-popup select[name="school_1"]').val()
                },
                {
                    'year': jQuery('#user-edit-basic-popup select[name="year_2"]').val(),
                    'school': jQuery('#user-edit-basic-popup select[name="school_2"]').val()
                },
                {
                    'year': jQuery('#user-edit-basic-popup select[name="year_3"]').val(),
                    'school': jQuery('#user-edit-basic-popup select[name="school_3"]').val()
                }
            ]
        };
        
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function (response) {
            if (response.succeed) {
                closePopup(jQuery('#user-edit-basic-popup'));
                editUserPopup();
            }
        });
    });
});


// Edit user full profile popup

function editUserPopup(userId) {
    // Open user creation popup/wizard
    openPopup(jQuery('#user-edit-popup'));
    
    var request = {'action': 'get_user_page_data'};

    if (typeof userId !== 'undefined') {
        request['user_id'] = userId;
    }

    jQuery.ajax({
        url: ajaxurl,
        data: request,
        method: 'POST',
        dataType: 'json'
    }).done(function (response) {
        if (!response['succeed']) {
            return;
        }
        // Avatar
        jQuery('#user-edit-popup .avatar').css('background-image',
                'url("' + response['avatar_url'] + '")');
        // Display name (first name + last name)
        jQuery('#user-edit-popup .name span').text(response['first_name'] + ' ' + response['last_name']);
        
        // Schools
        jQuery('#user-edit-popup .schools span').text('School A/Aalto University/SchoolB');
        // Links
        
        // Pictures
        jQuery('#user-edit-popup .pictures .picture').remove();
        var pictures = response['pictures'];
        for (var key in pictures) {
            if (pictures.hasOwnProperty(key)) {
                var $picture = jQuery('<div class="picture"><span class="remove"><i class="fa fa-remove"></i></span></div>');
                $picture.css('background-image', 'url("' + pictures[key].url + '")');
                $picture.data('uuid', key);
                jQuery('#user-edit-popup .add-picture').after($picture);
                $picture.find('.remove').click(function () {
                    var sendData = {
                        'action': 'remove_user_picture',
                        'uuid': key
                    };
                    jQuery.ajax({
                        url: ajaxurl,
                        data: sendData,
                        method: 'POST',
                        dataType: 'json'
                    });
                    $picture.remove();
                });
            }
        }
    });
}

jQuery(function () {

    // Avatar
    jQuery('#user-edit-popup .avatar button').click(function () {
        jQuery('#user-edit-popup .avatar input')[0].click();
    });

    jQuery('#user-edit-popup .avatar input').change(function () {
        var file_data = jQuery(this).prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'update_user_avatar');
        form_data.append('avatar', file_data);
        console.log(ajaxurl);
        jQuery.ajax({
            url: ajaxurl,
            data: form_data,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(updateAvatar);
    });
    
    function updateAvatar(data) {
        jQuery('#user-edit-popup .avatar').css('background-image', 'url("' + data.avatar_url + '")');
    }
    
    // Name
    jQuery('#user-edit-popup .name > button').click(function () {
        jQuery('#user-edit-popup .name .edit-box').show();
    });
    
    jQuery('#user-edit-popup .name .edit-box button').click(function () {
        jQuery('#user-edit-popup .name .edit-box').hide();
    });
    
    // Photos
    jQuery('#user-edit-popup .add-picture').click(function () {
        jQuery('#user-edit-popup .add-picture input')[0].click();
    });
    
    jQuery('#user-edit-popup .add-picture input').change(function () {
        var file_data = jQuery(this).prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'upload_user_picture');
        form_data.append('picture', file_data);
        jQuery.ajax({
            url: ajaxurl,
            data: form_data,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(addPicture);
    });
    
    function addPicture(data) {
        var $picture = jQuery('<div class="picture"><span class="remove"><i class="fa fa-remove"></i></span></div>');
        $picture.data('uuid', data.uuid);
        $picture.css('background-image', 'url("' + data.url + '")');
        jQuery('#user-edit-popup .add-picture').after($picture);
        $picture.find('.remove').click(function(){
            var sendData ={
                'action': 'remove_user_picture',
                'uuid': data.uuid
            };
            jQuery.ajax({
                url: ajaxurl,
                data: sendData,
                method: 'POST',
                dataType: 'json'
            });
            $picture.remove();
        });
    }
    
    // Links
    jQuery('#user-edit-popup .links > button').click(function () {
        jQuery('#user-edit-popup .links .edit-box').show();
    });
    
    jQuery('#user-edit-popup .links .edit-box button').click(function () {
        jQuery('#user-edit-popup .links .edit-box').hide();
    });
    // Experience
    
    // Description text?
    
    // Finish button
    jQuery('#user-edit-popup .finish').click(function () {
        closePopup(jQuery('#user-edit-popup'));
        viewUserPopup();
    });
});



/**
 * Open user page popup, query and display user data
 * @param {Number} userId User ID, can be ignored
 */

function viewUserPopup(userId) {
    openPopup(jQuery('#user-page-popup'));

    var request = {'action': 'get_user_page_data'};

    if (typeof userId !== 'undefined') {
        request['user_id'] = userId;
    }

    jQuery.ajax({
        url: ajaxurl,
        data: request,
        method: 'POST',
        dataType: 'json'
    }).done(function (response) {
        if (!response['succeed']) {
            return;
        }
        // Avatar
        jQuery('#user-page-popup .avatar').css('background-image',
                'url("' + response['avatar_url'] + '")');
        // Display name (first name + last name)
        jQuery('#user-page-popup .name').text(response['first_name'] + ' ' + response['last_name']);
        
        // Schools
        jQuery('#user-edit-popup .schools span').text('School A/Aalto University/SchoolB');
        
        // Links
        
        // Pictures
        jQuery('#user-page-popup .pictures .picture').remove();
        var pictures = response['pictures'];
        for (var key in pictures) {
            if (pictures.hasOwnProperty(key)) {
                var $picture = jQuery('<div class="picture"></div>');
                $picture.css('background-image', 'url("' + pictures[key].url + '")');
                jQuery('#user-page-popup .pictures').append($picture);
            }
        }
    });
}

jQuery(function () {
    jQuery('#user-page-popup button.edit').click(function () {
        closePopup(jQuery('#user-page-popup'));
        editUserPopup();
    });
});

// Header user menu

jQuery(function () {
    jQuery('#site-header .user').click(function () {
        viewUserPopup();
    });
});