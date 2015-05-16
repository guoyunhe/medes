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
 * API: create new user account
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
        su_login($username, $password);
    } else {
        $response = ['succeed' => false, 'error_message' => $result->get_error_message()];
    }
    echo json_encode($response);
    die();
}

/**
 * API: Return a JSON of user page data.
 * 
 * [Request]
 * 
 * user_id: int
 * 
 * [Response]
 * 
 * succeed: boolean
 * error_message: string
 * first_name: string
 * last_name: string
 * country: string
 * city: string
 * role: string
 * schools: array
 * links: array
 * avatar: array
 * pictures: array
 * experience: array
 */

add_action( 'wp_ajax_get_user_page', 'su_get_user_page' );
add_action( 'wp_ajax_nopriv_get_user_page', 'su_get_user_page' );

function su_get_user_page() {
    $user_id = filter_input(INPUT_POST, 'user_id');
    
    if($user_id === false) {
        $user_id = get_current_user_id(); // Request without any paramaters
    }
    
    $user = get_userdata( $user_id );

    if ($user === false) {
        $response = ['succeed' => false, 'error_message' => 'User doesn\'t exist'];
    } else {
        $response = [
            'succeed' => true,
            'username' => $user->user_login,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'country' => $user->country,
            'city' => $user->city,
            'role' => $user->role,
            'avatar' => json_decode($user->avatar, true),
            'schools' => json_decode($user->schools, true),
            'links' => json_decode($user->links, true),
            'pictures' => json_decode($user->pictures, true),
            'experience' => json_decode($user->experience, true),
        ];
    }

    echo json_encode($response);
    die();
}


/**
 * API: Update first name and last name
 * 
 * [Request]
 * 
 * first_name: string
 * last_name: string
 * 
 * [Response]
 * 
 * succeed: boolean
 */

add_action('wp_ajax_update_real_name', 'su_update_real_name');
add_action('wp_ajax_nopriv_update_real_name', 'su_update_real_name');

function su_update_real_name() {
    su_check_login();
    $user_id = get_current_user_id();

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');

    if ($first_name !== false && $last_name !== false) {
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'last_name', $last_name);
        $response = ['succeed' => true];
    } else {
        $response = ['succeed' => false];
    }

    echo json_encode($response);
    die();
}

/**
 * API: Update country and city
 * 
 * [Request]
 * 
 * country: string
 * city: string
 * 
 * [Response]
 * 
 * succeed: boolean
 */

add_action('wp_ajax_update_user_location', 'su_update_user_location');
add_action('wp_ajax_nopriv_update_user_location', 'su_update_user_location');

function su_update_user_location() {
    su_check_login();
    $user_id = get_current_user_id();

    $country = filter_input(INPUT_POST, 'country');
    $city = filter_input(INPUT_POST, 'city');

    if ($country !== false && $city !== false) {
        update_user_meta($user_id, 'country', $country);
        update_user_meta($user_id, 'city', $city);
        $response = ['succeed' => true];
    } else {
        $response = ['succeed' => false];
    }

    echo json_encode($response);
    die();
}

/**
 * API: Update country and city
 * 
 * [Request]
 * 
 * role: string
 * 
 * [Response]
 * 
 * succeed: boolean
 */

add_action('wp_ajax_update_user_role', 'su_update_user_role');
add_action('wp_ajax_nopriv_update_user_role', 'su_update_user_role');

function su_update_user_role() {
    $role = filter_input(INPUT_POST, 'role');
    if ($role !== false) {
        update_user_meta($user_id, 'role', $role);
    }
}

function su_update_user_schools($user_id) {
    $schools = filter_input(INPUT_POST, 'schools', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($schools !== false) {
        update_user_meta($user_id, 'schools', json_encode($schools));
    }
}


/* API to upload avatar picture */

add_action('wp_ajax_update_user_avatar', 'su_update_user_avatar');
add_action('wp_ajax_nopriv_update_user_avatar', 'su_update_user_avatar');

function su_update_user_avatar() {
    su_check_login();
    su_check_picture('avatar');
    if (!isset($_FILES['avatar'])) {
        echo 'no upload file';
        die();
    }
    
    $user_id = get_current_user_id();
    
    $uploadedfile = $_FILES['avatar'];
    $upload_overrides = array('test_form' => false);
    $upload_result = wp_handle_upload($uploadedfile, $upload_overrides);
    
    if (!isset($upload_result['file'])) {
        echo 'file save failed';
        die();
    }
    
    $avatar_file = get_user_meta($user_id, 'avatar_file', true);
    if ($avatar_file !== '' && file_exists($avatar_file)) {
        unlink(get_user_meta($user_id, 'avatar_file', true));
    }
    update_user_meta($user_id, 'avatar_url', $upload_result['url']);
    update_user_meta($user_id, 'avatar_file', $upload_result['file']);
    $image = wp_get_image_editor($upload_result['file']);
    if (is_wp_error($image)) {
        echo 'cannot crop picture';
        die();
    }
    
    $image->resize(300, 300, true);
    $image->save($upload_result['file']);

    $response = ['avatar_url' => $upload_result['url']];
    echo json_encode($response);
    die();
}

/* API to upload user pictures */

add_action('wp_ajax_upload_user_picture', 'su_upload_user_picture');
add_action('wp_ajax_nopriv_upload_user_picture', 'su_upload_user_picture');

function su_upload_user_picture() {
    su_check_login();
    su_check_picture('picture');
    
    $user_id = get_current_user_id();
    
    $result = su_save_file('picture');
    // UUID for change or delete picture
    $uuid = uniqid();
    
    $pictures = json_decode(get_user_meta($user_id, 'pictures', true), true);
    
    if (!is_array($pictures)) {
        $pictures = [];
    }
    
    $pictures[$uuid] = ['url' => $result['url'], 'file' => $result['file']];
    update_user_meta($user_id, 'pictures', json_encode($pictures));
    
    su_resize_picture($result['file'], 1024, 1024);

    $response = ['succeed' => true, 'url' => $result['url'], 'uuid' => $uuid];
    echo json_encode($response);
    die();
}

/* API to remove user pictures */

add_action('wp_ajax_remove_user_picture', 'su_remove_user_picture');
add_action('wp_ajax_nopriv_remove_user_picture', 'su_remove_user_picture');

function su_remove_user_picture() {
    su_check_login();

    $user_id = get_current_user_id();
    $uuid = filter_input(INPUT_POST, 'uuid');
    $pictures = json_decode(get_user_meta($user_id, 'pictures', true), true);
    
    // DEBUG
    print_r($uuid);
    print_r($pictures);

    if(!isset($pictures[$uuid])) {
        $response = ['succeed'=>false, 'error_message' => 'No such file with given UUID!'];
        echo json_encode($response);
        die();
    }
    
    su_remove_file($pictures[$uuid]['file']);
    unset($pictures[$uuid]);
    update_user_meta($user_id, 'pictures', json_encode($pictures));
    
    die();
}