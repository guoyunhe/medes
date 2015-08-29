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
 * Create workshop API. Request sends name of workshop. Response returns the id of
 * new post or an error message.
 */

su_add_api('create_workshop');

function su_create_workshop() {
    su_ajax_check_admin(); // Check permission

    $post_title = filter_input(INPUT_POST, 'post_title');
    
    $post = [
        'post_title' => $post_title,
        'post_content' => ' ',
        'post_status' => 'publish',
        'post_type' => 'workshop'
    ];
    
    $post_id = wp_insert_post( $post );

    if ($post_id > 0) {
        $response = ['succeed' => true, 'post_id' => $post_id];
    } else {
        $response = ['succeed' => false, 'error_message' => 'Workshop creating failed'];
    }

    echo json_encode($response);
    die();
}

/**
 * Edit workshop API. Request sends post_id, post_title, short_name, post_content,
 * country, city. Response returns only boolean flag succeed.
 */

su_add_api('edit_workshop');

function su_edit_workshop() {
    su_ajax_check_admin(); // Check permission
    
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    
    su_update_post_meta($post_id, 'post_title');
    su_update_post_meta($post_id, 'post_content');
    su_update_post_meta($post_id, 'year');
    su_update_post_meta($post_id, 'school');
    su_update_post_meta($post_id, 'website');
    
    $response = [
        'succeed' => true,
    ];
    echo json_encode($response);
    die();
}

/**
 * View workshop API. Request sends post_id. Response returns post_title, short_name,
 * post_content, country, city and pictures.
 */

su_add_api('view_workshop');

function su_view_workshop() {
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        
    $response = [
        'succeed' => true,
        'ID' => $post_id,
        'post_title' => get_the_title($post_id),
        'post_content' => get_post_field('post_content', $post_id, 'raw'),
        'post_content_display' => get_post_field('post_content', $post_id, 'display'),
        'year' => get_post_meta($post_id, 'year', true),
        'school' => get_post_meta($post_id, 'school', true),
        'school_name' => get_the_title(get_post_meta($post_id, 'school', true)),
        'school_short_name' => get_post_meta(get_post_meta($post_id, 'school', true), 'short_name', true),
        'website' => get_post_meta($post_id, 'website', true),
    ];
    $response['main_picture'] = su_get_post_main_picture($post_id);
    $response['pictures'] = su_get_post_pictures($post_id);
    echo json_encode($response);
    die();
}


/**
 * Edit the main workshop picture API.
 * Request sends post_id, and a new picture file.
 * Response returns the url of the uploaded picture.
 */

su_add_api('edit_workshop_main_picture');

function su_edit_workshop_main_picture() {
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
 * Add workshop picture API. Request sends post_id and a picture file. Response returns a URL 
 * and a UUID of the uploaded picture.
 */

su_add_api('add_workshop_picture');

function su_add_workshop_picture() {
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
 * Remove(delete) workshop picture API. Request sends post_id and a UUID of picture.
 * Response returns succeed status. This picture will be deleted from server and
 * cannot be recovered.
 */

su_add_api('remove_workshop_picture');

function su_remove_workshop_picture() {
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
