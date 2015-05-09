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
        die();
    }
    $user_id = get_current_user_id();

    su_update_user_name($user_id);
    su_update_user_location($user_id);
    su_update_user_schools($user_id);

    $response = ['succeed' => true];
    echo json_encode($response);
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

function su_update_user_schools($user_id) {
    $schools = filter_input(INPUT_POST, 'schools');
    if ($schools !== false) {
        update_user_meta($user_id, 'schools', json_encode($schools));
    }
}
