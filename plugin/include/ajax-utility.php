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
 * Check if the user logged in. If not, send error message and end progress
 */
function su_check_login() {
    if (!is_user_logged_in()) {
        $response = ['succeed'=>false, 'error_message' => 'Please login!'];
        echo json_encode($response);
        die();
    }
}

/**
 * Check if current user can edit target user.
 * Only users themselves and admins can edit users.
 * @return boolean
 */
function su_can_edit_user() {
    su_check_login();
    
    // If user is admin
    if (is_admin() ) {
        return true;
    }
    
    $self = get_current_user()->id;
    $target = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    
    if (empty($target)) {
        return true; // No user_id specified, users edit themselves
    }
    
    if ($self === $target) {
        return true;
    }
    
    $response = ['succeed'=>false, 'error_message' => 'You don\'t have permission'];
    echo json_encode($response);
    die();
}

function su_update_usermeta($user_id, $key, $filter=FILTER_DEFAULT) {
    $value = filter_input(INPUT_POST, $key, $filter);
    if ($value === null) {
        return;
    }
    if ($value === false) {
        update_user_meta($user_id, $key, '');
    } else {
        update_user_meta($user_id, $key, $value);
    }
}

/**
 * Check if a file is uploaded, and if it is a picture.
 * @param string $key_name
 */
function su_check_picture($key_name) {
    if (!isset($_FILES[$key_name])) {
        $response = ['succeed' => false, 'error_message' => 'No upload file found!'];
        echo json_encode($response);
        die();
    }
}

/**
 * Save a file that send through AJAX or page submit
 * @param string $key_name $_FILES[] key name
 * @return File|Error_Message Uploaded file object or error message if failed
 */
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

/**
 * Remove a file safely by checking if it exists.
 * @param string $file Local file path
 */
function su_remove_file($file) {
    if (file_exists($file)) {
        unlink($file);
    }
}

/**
 * Resize picture
 * @param string $file Local file path
 * @param int $width Maximum width
 * @param int $height Maximum height
 * @param boolean $crop If crop image
 */
function su_resize_picture($file, $width, $height, $crop = false) {

    $image_editor = wp_get_image_editor($file);

    if (is_wp_error($image_editor)) {
        error_log('Cannot resize picture');
    }

    $image_editor->resize($width, $height, $crop);
    $image_editor->save($file);
}