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

UpdateProfileBasic = {
    init: function () {
        
    },
    updateProfileBasic: function () {
        
    },
    ajaxCallback: function () {

    }
};

jQuery(function () {
    // Open user creation popup/wizard
    openPopup(jQuery('#create-user'));

    // Page 1: register

    jQuery('#page-1 .next').click(function () {
        if (checkPassword()) {
            createUser();
        }
    });

    function checkPassword() {
        var pwd1 = jQuery('#page-1 input[name="password"]').val();
        var pwd2 = jQuery('#page-1 input[name="password_repeat"]').val();
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
            'secret_key': jQuery('#page-1 input[name="secret_key"]').val(),
            'username': jQuery('#page-1 input[name="username"]').val(),
            'password': jQuery('#page-1 input[name="password"]').val(),
            'email': jQuery('#page-1 input[name="email"]').val()
        };
        jQuery.post(ajaxurl, sendData, ajaxCallback, 'json');
    }


    function ajaxCallback(response) {
        if (response.succeed) {
            jQuery('#page-1').hide();
            jQuery('#page-2').fadeIn();
        } else {
            errorMessage(response['error_message']);
        }
    }

    function errorMessage(message) {
        jQuery('#page-1 .error-message').html(message);
    }


    // Page 2: basic information
    jQuery('#page-2 .next').click(function () {
        var schools = [];
        
        var y = jQuery('#page-2 select[name="year_1"]').val();
        var s = jQuery('#page-2 input[name="school_1"]').val();
        if(y.length > 0 && s.length > 0) {
            schools.push({'year':y, 'school': s});
        }
        y = jQuery('#page-2 select[name="year_2"]').val();
        s = jQuery('#page-2 input[name="school_2"]').val();
        if(y.length > 0 && s.length > 0) {
            schools.push({'year':y, 'school': s});
        }
        y = jQuery('#page-2 select[name="year_3"]').val();
        s = jQuery('#page-2 input[name="school_3"]').val();
        if(y.length > 0 && s.length > 0) {
            schools.push({'year':y, 'school': s});
        }
        
        var sendData = {
            'action': 'update_user_profile_basic',
            'first_name': jQuery('#page-2 input[name="first_name"]').val(),
            'last_name': jQuery('#page-2 input[name="last_name"]').val(),
            'country': jQuery('#page-2 select[name="country"]').val(),
            'city': jQuery('#page-2 input[name="city"]').val(),
            'role': jQuery('#page-2 select[name="role"]').val(),
            'schools': schools
        };
        
        jQuery.post(ajaxurl, sendData);
    });

});