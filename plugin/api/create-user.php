<?php

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

/**
 * Call this API through AJAX to create a new user with most basic information.
 * If succeed, return true and user id; else, return false and error message.
 * To add complete profile data, use "update-user-profile" API.
 * 
 * AJAX:
 * url: from ajaxurl variable
 * data: {
 *     action: 'create_user',
 *     username: string
 *     password: string
 *     password_repeat: string
 *     email: string
 * }
 * method: 'post'
 * return: {succeed: true, userid: int} or {succeed: false, error message: string}
 */

add_action('wp_ajax_create_user', 'su_create_user');
add_action('wp_ajax_nopriv_create_user', 'su_create_user');

function su_create_user() {
    // Check secret key to stop unwanted registeration!
    if (!su_check_secret_key_on_submit()) {
        $response = ['succeed' => false, 'error_message' => 'Wrong secret key!'];
        echo json_encode($response);
        die();
    }

    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');

    $result = wp_create_user($username, $password, $email);

    if (is_int($result)) {
        $response = ['succeed' => true, 'user_id' => $result];
    } else {
        $response = ['succeed' => false, 'error_message' => $result->get_error_message()];
    }
    echo json_encode($response);
    die();
}
