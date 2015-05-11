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
 * Basic profile update API
 * 
 * data: {
 *     action: 'update_user_profile_basic'
 *     user_id: int
 *     first_name: string
 *     last_name: string,
 *     country: string,
 *     city: string,
 *     schools: array,
 * }
 * method: post
 * return: {succeed: true}, or {succeed:false}
 */
add_action('wp_ajax_update_user_profile_basic', 'su_update_user_profile_basic');
add_action('wp_ajax_nopriv_update_user_profile_basic', 'su_update_user_profile_basic');

function su_update_user_profile_basic() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        echo 'please login';
        die();
    }

    $user_id = get_current_user_id();

    su_update_user_name($user_id);
    su_update_user_location($user_id);
    su_update_user_role($user_id);
    su_update_user_schools($user_id);

    die();
}

function su_update_user_name($user_id) {
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    if ($first_name !== false) {
        update_user_meta($user_id, 'first_name', $first_name);
    }
    if ($last_name !== false) {
        update_user_meta($user_id, 'last_name', $last_name);
    }
}

function su_update_user_location($user_id) {
    $country = filter_input(INPUT_POST, 'country');
    $city = filter_input(INPUT_POST, 'city');
    if ($country !== false) {
        update_user_meta($user_id, 'country', $country);
    }
    if ($city !== false) {
        update_user_meta($user_id, 'city', $city);
    }
}

function su_update_user_role($user_id) {
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

function su_check_login() {
    if (!is_user_logged_in()) {
        $response = ['succeed'=>false, 'error_message' => 'Please login!'];
        echo json_encode($response);
        die();
    }
}

function su_check_picture($key_name) {
    if (!isset($_FILES[$key_name])) {
        $response = ['succeed' => false, 'error_message' => 'No upload file found!'];
        echo json_encode($response);
        die();
    }
}

function su_save_file($key_name) {

    $overrides = array('test_form' => false);
    $result = wp_handle_upload($_FILES[$key_name], $overrides);

    if (!isset($result['file'])) {
        $response = ['succeed' => false, 'error_message' => 'Saving file failed!'];
        echo json_encode($response);
        die();
    }

    return $result;
}

function su_resize_picture($file, $width, $height, $crop = false) {

    $image_editor = wp_get_image_editor($file);

    if (is_wp_error($image_editor)) {
        error_log('Cannot resize picture');
    }

    $image_editor->resize($width, $height, $crop);
    $image_editor->save($file);
}

function su_remove_file($file) {
    if (file_exists($file)) {
        unlink($file);
    }
}