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
 * Create school API. Request sends name of school. Response returns the id of
 * new post or an error message.
 */

su_add_api('create_school');

function su_create_school() {
    su_ajax_check_admin(); // Check permission

    $post_title = filter_input(INPUT_POST, 'post_title');
    
    $post = [
        'post_title' => $post_title,
        'post_content' => ' ',
        'post_status' => 'publish',
        'post_type' => 'school'
    ];
    
    $post_id = wp_insert_post( $post );

    if ($post_id > 0) {
        $response = ['succeed' => true, 'post_id' => $post_id];
    } else {
        $response = ['succeed' => false, 'error_message' => 'School creating failed'];
    }

    echo json_encode($response);
    die();
}

/**
 * Edit school API. Request sends post_id, post_title, short_name, post_content,
 * country, city. Response returns only boolean flag succeed.
 */

su_add_api('edit_school');

function su_edit_school() {
    su_ajax_check_admin(); // Check permission
    
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    
    su_update_post_meta($post_id, 'post_title');
    su_update_post_meta($post_id, 'short_name');
    su_update_post_meta($post_id, 'post_content');
    su_update_post_meta($post_id, 'country');
    su_update_post_meta($post_id, 'city');
    su_update_post_meta($post_id, 'coordinator_name');
    su_update_post_meta($post_id, 'coordinator_email');
    su_update_post_meta($post_id, 'tutor_name');
    su_update_post_meta($post_id, 'tutor_email');
    
    $response = [
        'succeed' => true,
    ];
    echo json_encode($response);
    die();
}

/**
 * View school API. Request sends post_id. Response returns post_title, short_name,
 * post_content, country, city and pictures.
 */

su_add_api('view_school');

function su_view_school() {
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        
    $response = [
        'succeed' => true,
        'ID' => $post_id,
        'post_title' => get_the_title($post_id),
        'short_name' => get_post_meta($post_id, 'short_name', true),
        'post_content' => get_post_meta($post_id, 'post_content', true),
        'country' => get_post_meta($post_id, 'country', true),
        'city' => get_post_meta($post_id, 'city', true),
        'coordinator_name' => get_post_meta($post_id, 'coordinator_name', true),
        'coordinator_email' => get_post_meta($post_id, 'coordinator_email', true),
        'tutor_name' => get_post_meta($post_id, 'tutor_name', true),
        'tutor_email' => get_post_meta($post_id, 'tutor_email', true),
    ];
    $response['main_picture'] = su_get_post_main_picture($post_id);
    $response['pictures'] = su_get_post_pictures($post_id);
    echo json_encode($response);
    die();
}


/**
 * Edit the main school picture API.
 * Request sends post_id, and a new picture file.
 * Response returns the url of the uploaded picture.
 */

su_add_api('edit_school_main_picture');

function su_edit_school_main_picture() {
    su_ajax_check_admin(); // Check permission
    
    su_check_picture('main_picture'); // Valid picture file
    $result = su_save_file('main_picture'); // Save picture file in WordPress
    su_resize_picture($result['file'], 1024, 1024); // Resize picture
    
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    
    $main_picture = su_get_post_main_picture($post_id);
    
    if(!empty($main_picture) && isset($main_picture['file'])) {
        su_remove_file($main_picture['file']);
    }
    
    $new_main_picture = [
        'url' => $result['url'],
        'file' => $result['file']
    ];
    su_set_post_main_picture($post_id, $new_main_picture);

    $response = ['succeed' => true, 'url' => $result['url']];
    echo json_encode($response);
    die();
}


// Picture management APIs

/**
 * Add school picture API. Request sends post_id and a picture file. Response returns a URL 
 * and a UUID of the uploaded picture.
 */

su_add_api('add_school_picture');

function su_add_school_picture() {
    su_ajax_check_admin(); // Check permission
    
    su_check_picture('picture'); // Valid picture file
    $result = su_save_file('picture'); // Save picture file in WordPress
    su_resize_picture($result['file'], 1024, 1024); // Resize picture
    
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    
    // UUID for removing picture later
    $uuid = uniqid();
    
    $pictures = su_get_post_pictures($post_id);
    $pictures[$uuid] = [
        'url' => $result['url'],
        'file' => $result['file']
    ];
    su_set_post_pictures($post_id, $pictures);

    $response = ['succeed' => true, 'url' => $result['url'], 'uuid' => $uuid];
    echo json_encode($response);
    die();
}

/**
 * Remove(delete) school picture API. Request sends post_id and a UUID of picture.
 * Response returns succeed status. This picture will be deleted from server and
 * cannot be recovered.
 */

su_add_api('remove_school_picture');

function su_remove_school_picture() {
    su_ajax_check_admin(); // Check permission
    
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    
    $uuid = filter_input(INPUT_POST, 'uuid');
    
    $pictures = su_get_post_pictures($post_id);

    if(!isset($pictures[$uuid])) {
        $response = ['succeed'=>false, 'error_message' => 'No such file with given UUID!'];
        echo json_encode($response);
        die();
    }
    
    su_remove_file($pictures[$uuid]['file']);
    unset($pictures[$uuid]);
    
    su_set_post_pictures($post_id, $pictures);
    
    die();
}

// Helper functions

function su_ajax_check_admin() {
    if(!current_user_can('manage_options')) {
        $response = [
            'succeed' => false,
            'error_message' => 'This action is only allowed by admins.'
        ];
        echo json_encode($response);
        die();
    }
}

function su_get_post_main_picture($post_id) {
    // The first true make get_post_meta() return single value, not array.
    // The second true make json_decode() return PHP array, not PHP object.
    $picture = json_decode(get_post_meta($post_id, 'main_picture', true), true);
    
    if (!is_array($picture)) {
        $picture = [];
    }
    
    return $picture;
}

function su_set_post_main_picture($post_id, $picture) {
    $json_string = json_encode($picture, JSON_UNESCAPED_UNICODE);
    update_post_meta($post_id, 'main_picture', $json_string);
}

/**
 * Get pictures JSON object from post meta.
 * @param int $post_id
 * @return array
 */
function su_get_post_pictures($post_id) {
    // The first true make get_post_meta() return single value, not array.
    // The second true make json_decode() return PHP array, not PHP object.
    $pictures = json_decode(get_post_meta($post_id, 'pictures', true), true);
    
    if (!is_array($pictures)) {
        $pictures = [];
    }
    
    return $pictures;
}

/**
 * Set pictures JSON object to post meta.
 * @param int $post_id
 * @param array $pictures
 */
function su_set_post_pictures($post_id, $pictures) {
    $json_string = json_encode($pictures, JSON_UNESCAPED_UNICODE);
    update_post_meta($post_id, 'pictures', $json_string);
}