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


CreateUser = {
    init: function () {
        jQuery('#page-1 .next').click(function(){
            if(CreateUser.checkPassword()){
                CreateUser.createUser();
            }
        });
    },
    checkPassword: function () {
        var pwd1 = jQuery('#page-1 input[name="password"]').val();
        var pwd2 = jQuery('#page-1 input[name="password_repeat"]').val();
        if(pwd1 === null || pwd1 === '') {
            this.errorMessage('Password cannot be empty!');
            return false;
        }
        if(pwd1 !== pwd2) {
            this.errorMessage('Password doesn\'t match!');
            return false;
        }
        return true;
    },
    createUser: function () {
        var sendData = {
            'action': 'create_user',
            'username': jQuery('#page-1 input[name="username"]').val(),
            'password': jQuery('#page-1 input[name="password"]').val(),
            'email': jQuery('#page-1 input[name="email"]').val()
        };
        jQuery.post(ajaxurl, sendData, this.ajaxCallback, 'json');
    },
    errorMessage: function (message) {
        jQuery('#page-1 .error-message').html(message);
    },
    ajaxCallback: function (response) {
        if(response.succeed) {
            jQuery('#page-1').hide();
            jQuery('#page-2').fadeIn();
        } else {
            CreateUser.errorMessage(response['error_message']);
        }
    }
};