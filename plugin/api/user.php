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
 * Create new user account
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

/******************************************************************************
 **                                Login                                     **
 ******************************************************************************/

add_action('wp_ajax_login_user', 'su_login_user');
add_action('wp_ajax_nopriv_login_user', 'su_login_user');

function su_login_user() {

    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    $creds = [];
    $creds['user_login'] = $username;
    $creds['user_password'] = $password;
    $creds['remember'] = true;
    $user = wp_signon($creds, false);
    
    if(is_wp_error($user)) {
        $response = ['succeed' => false, 'error_message' => $user->get_error_message()];
    } else {
        $response = ['succeed' => true, 'first_name' => $user->first_name,
                'last_name' => $user->last_name, 'avatar_url' => $user->avatar_url,
            'is_admin' => user_can($user, 'manage_options')];
    }
    echo json_encode($response);
    die();
}

/**
 * API edit user basic information
 * 
 * [Request]
 * 
 * action: 'edit_user_basic'
 * first_name: string
 * last_name: string
 * country: string
 * city: string
 * role: string
 * schools: array
 * 
 * [Response]
 * 
 * succeed: boolean
 * error_message: string
 */

add_action( 'wp_ajax_edit_user_basic', 'su_edit_user_basic' );
add_action( 'wp_ajax_nopriv_edit_user_basic', 'su_edit_user_basic' );

function su_edit_user_basic() {
    su_check_login();
    su_can_edit_user();

    $user_id = get_current_user_id(); // @TODO detect user_id
    
    su_update_usermeta($user_id, 'first_name');
    su_update_usermeta($user_id, 'last_name');
    su_update_usermeta($user_id, 'user_email');
    
    su_update_usermeta($user_id, 'home_country');
    su_update_usermeta($user_id, 'home_city');
    su_update_usermeta($user_id, 'live_country');
    su_update_usermeta($user_id, 'live_city');
    
    su_update_usermeta($user_id, 'role');
    
    su_update_usermeta($user_id, 'school');
    
    su_update_usermeta($user_id, 'school_1');
    su_update_usermeta($user_id, 'year_1');
    su_update_usermeta($user_id, 'school_2');
    su_update_usermeta($user_id, 'year_2');
    su_update_usermeta($user_id, 'school_3');
    su_update_usermeta($user_id, 'year_3');
    
    $link_keys = su_get_link_types();
    
    foreach ($link_keys as $key) {
        if ($key === 'email') {
            su_update_usermeta($user_id, $key, FILTER_VALIDATE_EMAIL);
        } else {
            su_update_usermeta($user_id, $key, FILTER_VALIDATE_URL);
        }
        su_update_usermeta($user_id, $key . '_private', FILTER_VALIDATE_BOOLEAN);
    }
    
    su_update_usermeta($user_id, 'tagline');
    su_update_usermeta($user_id, 'description');
    
    $response = ['succeed' => true];

    echo json_encode($response);
    die();
}

/**
 * Return a JSON of user page data.
 * 
 * [Request]
 * 
 * action: 'get_user_page_data'
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
 * avatar_url: string
 * schools: array
 * links: array
 * pictures: array
 * experience: array
 */

add_action( 'wp_ajax_get_user_page_data', 'su_get_user_page_data' );
add_action( 'wp_ajax_nopriv_get_user_page_data', 'su_get_user_page_data' );

function su_get_user_page_data() {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

    if ($user_id === false || $user_id === null) {
        $user_id = get_current_user_id(); // Request without any paramaters
    }

    $user = get_userdata($user_id);

    if ($user === false) {
        $response = ['succeed' => false, 'error_message' => 'User doesn\'t exist'];
        echo json_encode($response);
        die();
    }

    $response = [
        'succeed' => true,
        'ID' => $user_id,
        'username' => $user->user_login,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'live_country' => $user->live_country,
        'live_city' => $user->live_city,
        'home_country' => $user->home_country,
        'home_city' => $user->home_city,
        'role' => $user->role,
        'school' => $user->school,
        'school_name' => get_the_title($user->school),
        'school_short' => get_post_meta($user->school, 'short_name', true),
        'school_1' => $user->school_1,
        'school_1_short' => get_post_meta($user->school_1, 'short_name', true),
        'year_1' => $user->year_1,
        'school_2' => $user->school_2,
        'school_2_short' => get_post_meta($user->school_2, 'short_name', true),
        'year_2' => $user->year_2,
        'school_3' => $user->school_3,
        'school_3_short' => get_post_meta($user->school_3, 'short_name', true),
        'year_3' => $user->year_3,
        'avatar_url' => $user->avatar_url,
        'pictures' => json_decode($user->pictures, true),
        'experience' => json_decode($user->experience, true),
        'skills' => json_decode($user->skills, true),
        'tagline' => $user->tagline,
        'description' => $user->description,
    ];

    // Private data: links
    $link_keys = su_get_link_types();

    foreach ($link_keys as $key) {
        $link = $user->$key;
        $key_private = $key . '_private';
        $private = $user->$key_private;
        if (!empty($link) && (empty($private) || $user_id === get_current_user_id())) {
            $response[$key] = $link;
        }
        $response[$key . '_private'] = $private;
    }
    
    // Private data: user_email
    if($user_id === get_current_user_id()) {
        $response['user_email'] = $user->user_email;
    }

    echo json_encode($response);
    die();
}

/******************************************************************************
 **                                 Avatar                                   **
 ******************************************************************************/

/* API to upload avatar picture */

add_action('wp_ajax_update_user_avatar', 'su_update_user_avatar');
add_action('wp_ajax_nopriv_update_user_avatar', 'su_update_user_avatar');

function su_update_user_avatar() {
    su_check_login();
    su_check_picture('avatar');
    
    $user_id = get_current_user_id();
    
    $result = su_save_file('avatar');
    su_resize_picture($result['file'], 1024, 1024);

    $avatar_file = get_user_meta($user_id, 'avatar_file', true);
    su_remove_file($avatar_file);
    
    update_user_meta($user_id, 'avatar_url', $result['url']);
    update_user_meta($user_id, 'avatar_file', $result['file']);
    
    

    $response = ['avatar_url' => $result['url']];
    echo json_encode($response);
    die();
}

/******************************************************************************
 **                                Pictures                                  **
 ******************************************************************************/

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
    update_user_meta($user_id, 'pictures', json_encode($pictures, JSON_UNESCAPED_UNICODE));
    
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
    update_user_meta($user_id, 'pictures', json_encode($pictures, JSON_UNESCAPED_UNICODE));
    
    die();
}

function su_get_link_types () {
    return ['facebook', 'twitter', 'linkedin', 'google', 'instagram', 'flickr',
        'youtube', 'vimeo', 'tumblr', 'pinterest', 'pinterest', 'website', 'email'];
}

/******************************************************************************
 **                                 Skills                                   **
 ******************************************************************************/

// Add skill tag
add_action('wp_ajax_add_user_skill', 'su_add_user_skill');
add_action('wp_ajax_nopriv_add_user_skill', 'su_add_user_skill');

function su_add_user_skill() {
    su_check_login();
    su_can_edit_user();
    $user_id = su_get_target_user_id();

    $skills = json_decode(get_user_meta($user_id, 'skills', true), true);
    
    if (!is_array($skills)) {
        $skills = [];
    }
    
    $skill = filter_input(INPUT_POST, 'skill');
    
    if (empty($skill)) {
        $response = ['succeed' => false];
        echo json_encode($response);
        die();
    }
    
    if (in_array($skill, $skills)) {
        $response = ['succeed' => true, 'exist' => true];
        echo json_encode($response);
        die();
    }

    $skills[] = $skill;
    $skills_array = array_values($skills);
    update_user_meta($user_id, 'skills', json_encode($skills_array, JSON_UNESCAPED_UNICODE));
    $response = ['succeed' => true, 'skills' => $skills];
    echo json_encode($response);
    die();
}

// Remove skill tag
add_action('wp_ajax_remove_user_skill', 'su_remove_user_skill');
add_action('wp_ajax_nopriv_remove_user_skill', 'su_remove_user_skill');

function su_remove_user_skill() {
    su_check_login();
    su_can_edit_user();
    $user_id = su_get_target_user_id();

    $skills = json_decode(get_user_meta($user_id, 'skills', true), true);
    
    if (!is_array($skills)) {
        $skills = [];
    }
    
    $skill = filter_input(INPUT_POST, 'skill');
    
    if (empty($skill)) {
        $response = ['succeed' => false];
        echo json_encode($response);
        die();
    }
    
    if (!in_array($skill, $skills)) {
        $response = ['succeed' => true, 'exist' => false];
        echo json_encode($response);
        die();
    }
    
    $key = array_search($skill, $skills);
    unset($skills[$key]);
    $skills_array = array_values($skills);
    update_user_meta($user_id, 'skills', json_encode($skills_array, JSON_UNESCAPED_UNICODE));
    $response = ['succeed' => true];
    echo json_encode($response);
    die();
}


/******************************************************************************
 **                               Experience                                 **
 ******************************************************************************/

// Add experience
add_action('wp_ajax_add_user_experience', 'su_add_user_experience');
add_action('wp_ajax_nopriv_add_user_experience', 'su_add_user_experience');

function su_add_user_experience() {
    su_check_login();
    su_can_edit_user();
    $user_id = su_get_target_user_id();

    $uuid = uniqid();
    
    $experience = json_decode(get_user_meta($user_id, 'experience', true), true);
    
    if (!is_array($experience)) {
        $experience = [];
    }
    
    $start = filter_input(INPUT_POST, 'start', FILTER_VALIDATE_INT);
    $end = filter_input(INPUT_POST, 'end', FILTER_VALIDATE_INT);
    $desc = filter_input(INPUT_POST, 'desc');
    
    if (empty($start) || empty($desc)) {
        $response = ['succeed' => false];
        echo json_encode($response);
        die();
    }
    
    $experience[$uuid] = ['start' => $start, 'end' => $end, 'desc' => $desc];
    update_user_meta($user_id, 'experience', json_encode($experience, JSON_UNESCAPED_UNICODE));
    
    $response = ['succeed' => true];
    echo json_encode($response);
    die();
}

// Remove experience
add_action('wp_ajax_remove_user_experience', 'su_remove_user_experience');
add_action('wp_ajax_nopriv_remove_user_experience', 'su_remove_user_experience');

function su_remove_user_experience() {
    su_check_login();
    su_can_edit_user();
    $user_id = su_get_target_user_id();
    
    $experience = json_decode(get_user_meta($user_id, 'experience', true), true);
    
    if (!is_array($experience)) {
        $experience = [];
    }
    
    $uuid = filter_input(INPUT_POST, 'uuid');
    
    if (empty($uuid)) {
        $response = ['succeed' => false];
        echo json_encode($response);
        die();
    }
    
    unset($experience[$uuid]);
    update_user_meta($user_id, 'experience', json_encode($experience, JSON_UNESCAPED_UNICODE));
    
    $response = ['succeed' => true];
    echo json_encode($response);
    die();
}


/**
 * Get user countries and citys API.
 */

su_add_api('list_user_country_city');

function su_list_user_country_city() {

    $countries = su_get_user_country_city_list();

    echo json_encode($countries);
    die();
}

/**
 * Get user countries and citys API.
 */

su_add_api('filter_user');

function su_filter_user() {
    $live_country = filter_input(INPUT_POST, 'live_country');
    $live_city = filter_input(INPUT_POST, 'live_city');
    $search = filter_input(INPUT_POST, 'search');
    
    $args = [];
    
    if (!empty($search)) {
        $args['search'] = $search;
    }
    
    $meta_query = ['relation' => 'AND'];
    
    if (!empty($live_country)) {
        $meta_query[] = [
            'key' => 'live_country',
            'value' => $live_country,
            'compare' => '=',
        ];
        if (!empty($live_city)) {
            $meta_query[] = [
                'key' => 'live_city',
                'value' => $live_city,
                'compare' => 'LIKE',
            ];
        }
        $args['meta_query'] = $meta_query;
    }
    
    $users = get_users( $args );
    
    $response = [];
    
    foreach ($users as $user) {
        $array = [
            'ID' => $user->ID,
            'avatar' => get_user_meta($user->ID, 'avatar_url', true),
            'first_name' => get_user_meta($user->ID, 'first_name', true),
            'last_name' => get_user_meta($user->ID, 'last_name', true),
        ];
        $response[] = $array;
    }

    echo json_encode($response);
    die();
}