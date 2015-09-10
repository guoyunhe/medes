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

/******************************************************************************
 *                        Create New Account Popup                            *
 ******************************************************************************/

// Open popup and initialize
function createUserPopup() {
    // Open user creation popup/wizard
    openPopup(jQuery('#user-create-popup'));
}

// User interaction and AJAX
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
            editUserPopup();
            jQuery('#user-menu .name').text(jQuery('#user-create-popup [name="username"]').val());
        } else {
            errorMessage(response['error_message']);
        }
    }

    function errorMessage(message) {
        jQuery('#user-create-popup .error-message').html(message);
    }
});

/******************************************************************************
 *                             User Login Popup                               *
 ******************************************************************************/
function loginUserPopup() {
    openPopup(jQuery('#user-login-popup'));
}

jQuery(function () {
    jQuery('#user-login-popup .next').click(function () {
        var request = {
            action: 'login_user',
            username: jQuery('#user-login-popup [name=username]').val(),
            password: jQuery('#user-login-popup [name=password]').val()
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function (response) {
            if (response.succeed) {
                user_id = response.ID;
                closePopup(jQuery('#user-login-popup'));
                jQuery('#user-menu .name').text(response.first_name + ' ' + response.last_name);
                jQuery('#user-menu .avatar').css('background-image', 'url("' + response.avatar_url + '")').show();
                is_admin = response.is_admin;
                if(is_admin) {
                    jQuery('#admin-menu').show();
                    jQuery('#admin-menu .click').show();
                } else {
                    jQuery('#admin-menu').hide();
                }
            } else {
                errorMessage(response.error_message);
            }
        });

    });
    function errorMessage(message) {
        jQuery('#user-create-popup .error-message').html(message);
    }
});

/******************************************************************************
 *                     Edit User Full Profile Popup                           *
 ******************************************************************************/

/**
 * Open popup and initialize user data through AJAX
 * @param {Number} userId
 * @returns {undefined}
 */
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
        // Username
        jQuery('#user-edit-popup [name=username]').val(response.username);
        // First name
        jQuery('#user-edit-popup [name=first_name]').val(response.first_name);
        // First name
        jQuery('#user-edit-popup [name=last_name]').val(response.last_name);
        // Email
        jQuery('#user-edit-popup [name=user_email]').val(response.user_email);
        // Living country
        jQuery('#user-edit-popup [name=live_country]').val(response.live_country);
        // Living city
        jQuery('#user-edit-popup [name=live_city]').val(response.live_city);
        // Home country
        jQuery('#user-edit-popup [name=home_country]').val(response.home_country);
        // Home city
        jQuery('#user-edit-popup [name=home_city]').val(response.home_city);
        // Role
        jQuery('#user-edit-popup [name=role]').val(response.role);
        // Schools
        jQuery('#user-edit-popup [name=school]').val(response.school);
        jQuery('#user-edit-popup [name=school_1]').val(response.school_1);
        jQuery('#user-edit-popup [name=year_1]').val(response.year_1);
        jQuery('#user-edit-popup [name=school_2]').val(response.school_2);
        jQuery('#user-edit-popup [name=year_2]').val(response.year_2);
        jQuery('#user-edit-popup [name=school_3]').val(response.school_3);
        jQuery('#user-edit-popup [name=year_3]').val(response.year_3);
        
        if (response.role === 'tutor' || response.role === 'teacher') {
            jQuery('#user-edit-popup div.schools').hide();
            jQuery('#user-edit-popup div.school').show();
        } else {
            jQuery('#user-edit-popup div.school').hide();
            jQuery('#user-edit-popup div.schools').show();
        }

        // Pictures
        jQuery('#user-edit-popup .pictures .picture').remove();
        var pictures = response['pictures'];

        for (var pictureKey in pictures) {
            if (pictures.hasOwnProperty(pictureKey)) {
                addUserPicture(pictureKey, pictures[pictureKey].url);
            }
        }

        // Skills
        jQuery('#user-edit-skills .skill').remove();
        var skills = response.skills;
        if (skills) {
            for (var i = 0; i < skills.length; i++) {
                var skill = skills[i];
                addUserSkill(skill);
            }
        }

        // Experience
        jQuery('#user-edit-experience .experience-item').remove();
        var experience = response.experience;

        for (var xpKey in experience) {
            if (experience.hasOwnProperty(xpKey)) {
                var xp = experience[xpKey];
                addUserExperience(xpKey, xp.start, xp.end, xp.desc);
            }
        }

        // Links
        var linkKeys = suGetLinkTypes();
        for (var i = 0; i < linkKeys.length; i++) {
            var linkKey = linkKeys[i];
            var link = response[linkKey];
            var private = response[linkKey + '_private'];
            jQuery('#user-edit-popup input[name=' + linkKey + ']').val(link);
            jQuery('#user-edit-popup input[name=' + linkKey + '_private]').prop('checked', private);
        }

        // Tagline
        jQuery('#user-edit-popup [name=tagline]').val(response.tagline);
    });
}
// User interaction
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
        jQuery.ajax({
            url: ajaxurl,
            data: form_data,
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            jQuery('#user-edit-popup .avatar').css('background-image', 'url("' + response.avatar_url + '")');
            jQuery('#user-menu .avatar').css('background-image', 'url("' + response.avatar_url + '")');
        });
    });

    function updateSimpleUserMeta() {
        var name = jQuery(this).attr('name');
        var value;
        if (jQuery(this).attr('type') === 'checkbox') {
            value = jQuery(this).prop('checked');
        } else {
            value = jQuery(this).val();
        }
        var request = {action: 'edit_user_basic'};
        request[name] = value;
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        });
    }

    // First name, last name, email
    jQuery('#user-edit-basic input').change(updateSimpleUserMeta);

    jQuery('#user-edit-basic input').change(function () {
        jQuery('#user-menu .name').text(jQuery('#user-edit-basic [name="first_name"]').val()
                + ' ' + jQuery('#user-edit-basic [name="last_name"]').val());
    });

    // Living country, city; home country city
    jQuery('#user-edit-location input').change(updateSimpleUserMeta);
    jQuery('#user-edit-location select').change(updateSimpleUserMeta);

    // User role
    jQuery('#user-edit-medes select').change(updateSimpleUserMeta);
    jQuery('#user-edit-medes input').change(updateSimpleUserMeta);
    jQuery('#user-edit-medes select[name="role"]').change(function () {
        if (jQuery(this).val() === 'tutor' || jQuery(this).val() === 'teacher') {
            jQuery('#user-edit-popup div.schools').hide();
            jQuery('#user-edit-popup div.school').show();
        } else {
            jQuery('#user-edit-popup div.school').hide();
            jQuery('#user-edit-popup div.schools').show();
        }
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
        }).done(function (response) {
            addUserPicture(response.uuid, response.url);
        });
    });

    // Links
    jQuery('#user-edit-links input').change(updateSimpleUserMeta);

    // Skills
    jQuery('#add-skill-button').click(function () {
        var skill = jQuery('#add-skill-input').val();
        var request = {
            'action': 'add_user_skill',
            'skill': skill
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        });
        addUserSkill(skill);
    });

    // Experience
    jQuery('#add-xp-button').click(function () {
        var start = jQuery('#add-xp-start-input').val();
        var end = jQuery('#add-xp-end-input').val();
        var desc = jQuery('#add-xp-desc-input').val();
        var request = {
            'action': 'add_user_experience',
            'start': start,
            'end': end,
            'desc': desc
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        }).done(function (response) {
            addUserExperience(response.uuid, start, end, desc);
        });
    });



    // Description
    jQuery('#user-edit-description textarea').change(updateSimpleUserMeta);

    // Finish button
    jQuery('#user-edit-popup .finish').click(function () {
        closePopup(jQuery('#user-edit-popup'));
        viewUserPopup();
    });
});


/******************************************************************************
 *                     Open User Profile View Popup                           *
 ******************************************************************************/

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
        jQuery('#user-page-popup .first-name').text(response.first_name);
        jQuery('#user-page-popup .last-name').text(response.last_name);
        
        // Colors
        jQuery('#user-page-popup .header').css('background-color', response.color);
        jQuery('#user-page-popup .avatar').css('background-color', response.color);
        jQuery('#user-page-popup .links a').css('color', response.color);

        // Schools
        if (response.role === 'tutor' || response.role === 'teacher') {
            subtitle = response.school_name;
        } else {
            var subtitle = '';
            if (response.school_1_short) {
                subtitle += response.school_1_short;
            }
            if (response.school_2_short) {
                subtitle += '/' + response.school_2_short;
            }
            if (response.school_3_short) {
                subtitle += '/' + response.school_3_short;
            }
        }
        jQuery('#user-page-popup .subtitle').text(subtitle);

        // Links
        var linkKeys = suGetLinkTypes();
        for (var i = 0; i < linkKeys.length; i++) {
            var linkKey = linkKeys[i];
            var link = response[linkKey];
            if (link) {
                jQuery('#link-' + linkKey).attr('href', link).show();
            } else {
                jQuery('#link-' + linkKey).hide();
            }
        }

        // Pictures
        jQuery('#user-page-popup .pictures .picture').remove();
        var pictures = response['pictures'];
        for (var pictureKey in pictures) {
            if (pictures.hasOwnProperty(pictureKey)) {
                var $picture = jQuery('<div class="picture"></div>');
                $picture.css('background-image', 'url("' + pictures[pictureKey].url + '")');
                jQuery('#user-page-popup .pictures').prepend($picture);
            }
        }

        // Skills
        jQuery('#user-page-popup .skills .skill').remove();
        var skills = response.skills;
        if (skills) {
            for (var i = 0; i < skills.length; i++) {
                jQuery('#user-page-popup .skills').append('<div class="skill">' + skills[i] + '</div>');
            }
        }

        // Experience
        jQuery('#user-page-popup .experience .experience-item').remove();
        var experience = response.experience;
        for (var xpKey in experience) {
            if (experience.hasOwnProperty(xpKey)) {
                var xp = experience[xpKey];
                var $xp = jQuery('<div class="experience-item">' + xp.start + '-'
                        + xp.end + ' ' + xp.desc + '</div>');
                jQuery('#user-page-popup .experience').append($xp);
            }
        }

        jQuery('#user-page-popup .tagline').text(response.tagline);
    });
    
    if (userId === user_id || typeof userId === 'undefined') {
        jQuery('#user-page-popup .edit').show();
    } else {
        jQuery('#user-page-popup .edit').hide();
    }
}
// User interaction
jQuery(function () {
    jQuery('#user-page-popup button.edit').click(function () {
        closePopup(jQuery('#user-page-popup'));
        editUserPopup();
    });
});


// Add picture
function addUserPicture(uuid, url) {
    var $picture = jQuery('<div class="picture"><span class="remove"><i class="fa fa-remove"></i></span></div>');
    $picture.css('background-image', 'url("' + url + '")');
    $picture.data('uuid', uuid);
    jQuery('#user-edit-popup .add-picture').after($picture);
    $picture.find('.remove').click(function () {
        var request = {
            'action': 'remove_user_picture',
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

// Add skill
function addUserSkill(skill) {
    var $skill = jQuery('<span class="skill">' + skill + ' <i class="fa fa-remove"></i></span>');
    $skill.find('i').click(function () {
        $skill.remove();
        var request = {
            'action': 'remove_user_skill',
            'skill': skill
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        });
    });
    jQuery('#user-edit-skills .skills').append($skill);
}

// Add experience
function addUserExperience(uuid, start, end, desc) {
    var $xp;
    if (end) {
        $xp = jQuery('<div class="experience-item">' + start + '-' + end + ' '
                + desc + '<span class="remove"><i class="fa fa-remove"></i></span></div>');
    } else {
        $xp = jQuery('<div class="experience-item">' + start + ' ' + desc +
                '<span class="remove"><i class="fa fa-remove"></i></span></div>');
    }
    $xp.find('.remove').click(function () {
        $xp.remove();
        var request = {
            'action': 'remove_user_experience',
            'uuid': uuid
        };
        jQuery.ajax({
            url: ajaxurl,
            data: request,
            method: 'POST',
            dataType: 'json'
        });
    });
    jQuery('#user-edit-experience .experience').append($xp);
}


// Header user menu

jQuery(function () {
    jQuery('#user-menu').click(function () {
        if (jQuery('#user-menu .name').text() === 'Login') {
            loginUserPopup();
        } else {
            viewUserPopup();
        }
    });
});

// Link types
function suGetLinkTypes() {
    return ['facebook', 'twitter', 'linkedin', 'google', 'instagram', 'flickr',
        'youtube', 'vimeo', 'tumblr', 'pinterest', 'pinterest', 'website', 'email'];
}