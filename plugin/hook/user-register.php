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
 * Register Form Extend
 * 
 * Added:
 * 1. Real name
 * 2. Location
 * 3. Years and schools (MEDes path)
 */

//1. Add a new form element...
add_action('register_form', 'myplugin_register_form');

function myplugin_register_form() {

    $first_name = (!empty($_POST['first_name']) ) ? trim($_POST['first_name']) : '';
    $last_name = (!empty($_POST['last_name']) ) ? trim($_POST['last_name']) : '';
    include __DIR__ . '/../view/user-profile-admin.php';
}

//2. Add validation. In this case, we make sure first_name is required.
add_filter('registration_errors', 'myplugin_registration_errors', 10, 3);

function myplugin_registration_errors($errors, $sanitized_user_login, $user_email) {

    if (empty($_POST['first_name']) || !empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
        $errors->add('first_name_error', __('<strong>ERROR</strong>: You must include a first name.', 'mydomain'));
    }

    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action('user_register', 'myplugin_user_register');

function myplugin_user_register($user_id) {
    
    // Real Name
    
    if (!empty($_POST['first_name'])) {
        update_user_meta($user_id, 'first_name', trim($_POST['first_name']));
    }
    
    if (!empty($_POST['last_name'])) {
        update_user_meta($user_id, 'last_name', trim($_POST['last_name']));
    }
    
    // Location
    
    if (!empty($_POST['country'])) {
        update_user_meta($user_id, 'country', trim($_POST['country']));
    }
    
    if (!empty($_POST['city'])) {
        update_user_meta($user_id, 'city', trim($_POST['city']));
    }
    
    // MEDes Path
    
    // 1st
    
    if (!empty($_POST['first-year'])) {
        update_user_meta($user_id, 'first-year', trim($_POST['first-year']));
    }
    
    if (!empty($_POST['first-school'])) {
        update_user_meta($user_id, 'first-school', trim($_POST['first-school']));
    }
    
    // 2nd
    
    if (!empty($_POST['second-year'])) {
        update_user_meta($user_id, 'second-year', trim($_POST['second-year']));
    }
    
    if (!empty($_POST['second-school'])) {
        update_user_meta($user_id, 'second-school', trim($_POST['second-school']));
    }
    
    // 3rd
    
    if (!empty($_POST['third-year'])) {
        update_user_meta($user_id, 'third-year', trim($_POST['third-year']));
    }
    
    if (!empty($_POST['third-school'])) {
        update_user_meta($user_id, 'third-school', trim($_POST['third-school']));
    }
}