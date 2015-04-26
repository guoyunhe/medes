<?php

/**
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
 * Plugin Name: School Union
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A brief description of the plugin.
 * Version: The plugin's version number. Example: 1.0.0
 * Author: Name of the plugin author
 * Author URI: http://URI_Of_The_Plugin_Author
 * Text Domain: Optional. Plugin's text domain for localization. Example: mytextdomain
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include_once 'featured-people.php';
include_once 'user-ajax.php';

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
    ?>
    <p>
        <label for="first_name">First Name<br/>
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(wp_unslash($first_name)); ?>" size="25" />
        </label>
    </p>
    <p>
        <label for="last_name">Last Name<br/>
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr(wp_unslash($last_name)); ?>" size="25" />
        </label>
    </p>
    <p>
        <label for="country">Living Country<br/>
            <input type="text" name="country" id="country" class="input" size="25" />
        </label>
    </p>
    <p>
        <label for="city">Living City<br/>
            <input type="text" name="city" id="city" class="input" size="25" />
        </label>
    </p>
    <table>
        
        <tr>
            <td>
                <label for="first-year">1st Year<br/>
                    <input type="text" name="first-year" id="first-year" class="input" size="4" />
                </label>
            </td>
            <td style="padding-left: 5px;">
                <label for="first-school">1st School<br/>
                    <select name="first-school" id="first-school" class="input">
                        <option>School A</option>
                        <option>School B</option>
                        <option>School C</option>
                        <option>School D</option>
                        <option>School E</option>
                        <option>School F</option>
                    </select>
                </label>
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="second-year">2nd Year<br/>
                    <input type="text" name="second-year" id="second-year" class="input" size="4" />
                </label>
            </td>
            <td style="padding-left: 5px;">
                <label for="second-school">2nd School<br/>
                    <select name="second-school" id="second-school" class="input">
                        <option>School A</option>
                        <option>School B</option>
                        <option>School C</option>
                        <option>School D</option>
                        <option>School E</option>
                        <option>School F</option>
                    </select>
                </label>
            </td>
        </tr>
        
        <tr>
            <td>
                <label for="third-year">3rd Year<br/>
                    <input type="text" name="third-year" id="third-year" class="input" size="4" />
                </label>
            </td>
            <td style="padding-left: 5px;">
                <label for="third-school">3rd School<br/>
                    <select name="third-school" id="third-school" class="input">
                        <option>School A</option>
                        <option>School B</option>
                        <option>School C</option>
                        <option>School D</option>
                        <option>School E</option>
                        <option>School F</option>
                    </select>
                </label>
            </td>
        </tr>
    </table>
    <?php
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

/**
 * Edit User Screen Extra Fields
 */

// 1. Extend edit user page, add more fields

add_action('show_user_profile', 'su_show_extra_profile_fields');
add_action('edit_user_profile', 'su_show_extra_profile_fields');

function su_show_extra_profile_fields($user) {
    ?>
    
    <h3>Photo</h3>
    
    <table class="form-table">
        <tr>
            <th><label for="su-avatar">Avatar</label></th>

            <td>
                <?php if (get_the_author_meta('su_avatar', $user->ID)) : ?>
                <img src="<?php echo esc_attr(get_the_author_meta('su_avatar', $user->ID)); ?>"/><br/>
                <?php endif; ?>
                Add new avatar:
                <input type="file" name="su-avatar" id="su-avatar" />
            </td>
        </tr>
        
        <tr>
            <th><label for="su-photo">Photo</label></th>

            <td>
                <?php if (get_the_author_meta('su_photo', $user->ID)) : ?>
                <img src="<?php echo esc_attr(get_the_author_meta('su_photo', $user->ID)); ?>"/><br/>
                <?php endif; ?>
                Add new photo:
                <input type="file" name="su-photo" id="su-photo" />
            </td>
        </tr>
    </table>
    
    <h3>Location</h3>
    
    <table class="form-table">
        <tr>
            <th><label for="city">City</label></th>

            <td>
                <input type="text" name="city" id="city"
                       value="<?php echo esc_attr(get_the_author_meta('city', $user->ID)); ?>"
                       class="regular-text" placeholder="city you are living"/>
            </td>
        </tr>
        
        <tr>
            <th><label for="country">Country</label></th>

            <td>
                <input type="text" name="country" id="country"
                       value="<?php echo esc_attr(get_the_author_meta('country', $user->ID)); ?>"
                       class="regular-text" placeholder="country you are living"/>
            </td>
        </tr>
    </table>

    <h3>MEDes Path</h3>

    <table class="form-table">
        
        <?php // first year ?>

        <tr>
            <th><label for="first-year">1st Year</label></th>

            <td>
                <input type="text" name="first-year" id="first-year"
                       value="<?php echo esc_attr(get_the_author_meta('first_year', $user->ID)); ?>"
                       class="regular-text" placeholder="year"/>
            </td>
        </tr>
        
        <tr>
            <th><label for="first-school">1st School</label></th>

            <td>
                <input type="text" name="first-school" id="first-school"
                       value="<?php echo esc_attr(get_the_author_meta('first_school', $user->ID)); ?>"
                       class="regular-text" placeholder="school name"/>
            </td>
        </tr>
        
        <?php // second year ?>

        <tr>
            <th><label for="second-year">2nd Year</label></th>

            <td>
                <input type="text" name="second-year" id="second-year"
                       value="<?php echo esc_attr(get_the_author_meta('second_year', $user->ID)); ?>"
                       class="regular-text" placeholder="year"/>
            </td>
        </tr>
        
        <tr>
            <th><label for="second-school">2nd School</label></th>

            <td>
                <input type="text" name="second-school" id="second-school"
                       value="<?php echo esc_attr(get_the_author_meta('second_school', $user->ID)); ?>"
                       class="regular-text" placeholder="school name"/>
            </td>
        </tr>
        
        <?php // first year ?>

        <tr>
            <th><label for="third-year">3rd Year</label></th>

            <td>
                <input type="text" name="third-year" id="third-year"
                       value="<?php echo esc_attr(get_the_author_meta('third_year', $user->ID)); ?>"
                       class="regular-text" placeholder="year"/>
            </td>
        </tr>
        
        <tr>
            <th><label for="third-school">3rd School</label></th>

            <td>
                <input type="text" name="third-school" id="third-school"
                       value="<?php echo esc_attr(get_the_author_meta('third_school', $user->ID)); ?>"
                       class="regular-text" placeholder="school name"/>
            </td>
        </tr>

    </table>
    
    <script>
        jQuery('form').attr('enctype', 'multipart/form-data');
    </script>
<?php
}

// 2. Save extra fields to database

add_action('personal_options_update', 'su_save_extra_profile_fields');
add_action('edit_user_profile_update', 'su_save_extra_profile_fields');

function su_save_extra_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id))
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_user_meta($user_id, 'city', $_POST['city']);
    update_user_meta($user_id, 'country', $_POST['country']);
    update_user_meta($user_id, 'first_year', $_POST['first-year']);
    update_user_meta($user_id, 'first_school', $_POST['first-school']);
    update_user_meta($user_id, 'second_year', $_POST['second-year']);
    update_user_meta($user_id, 'second_school', $_POST['second-school']);
    update_user_meta($user_id, 'third_year', $_POST['third-year']);
    update_user_meta($user_id, 'third_school', $_POST['third-school']);
    
    error_log( print_r( $_FILES, true ) );
    
    if (!function_exists('wp_handle_upload')) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    
    if (isset($_FILES['su-avatar'])) {
        $uploadedfile = $_FILES['su-avatar'];
        $upload_overrides = array('test_form' => false);
        $upload_result = wp_handle_upload($uploadedfile, $upload_overrides);
        if (isset($upload_result['file'])) {
            unlink(get_user_meta( $user_id, 'su_avatar_file', true ));
            update_user_meta($user_id, 'su_avatar', $upload_result['url']);
            update_user_meta($user_id, 'su_avatar_file', $upload_result['file']);
            $image = wp_get_image_editor($upload_result['file']); // Return an 
            //implementation that extends <tt>WP_Image_Editor</tt>
            if ( ! is_wp_error( $image ) ) {
                $image->resize( 300, 300, true );
                $image->save( $upload_result['file'] );
                error_log( 'avatar resized!' );
            }
        }
    }
    
    if (isset($_FILES['su-photo'])) {
        $uploadedfile = $_FILES['su-photo'];
        $upload_overrides = array('test_form' => false);
        $upload_result = wp_handle_upload($uploadedfile, $upload_overrides);
        if (isset($upload_result['file'])) {
            unlink(get_user_meta( $user_id, 'su_photo_file', true ));
            update_user_meta($user_id, 'su_photo', $upload_result['url']);
            update_user_meta($user_id, 'su_photo_file', $upload_result['file']);
            $image = wp_get_image_editor($upload_result['file']); // Return an 
            //implementation that extends <tt>WP_Image_Editor</tt>
            if ( ! is_wp_error( $image ) ) {
                $image->resize( 900, 500, true );
                $image->save( $upload_result['file'] );
                error_log( 'photo resized!' );
            }
        }
    }
}

/**
 * Custom Post Types
 * 
 * School
 * 
 * Workshop (name, featured image/logo)
 *     |-- Project (name, authors, school, featured image, content)
 * 
 */

add_action('init', 'su_create_post_type');

function su_create_post_type() {
    $school_post_type_args = [
        'labels' => ['name' => 'Schools', 'singular_name' => 'School'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions',
            'custom-fields', 'comments'],
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
    ];

    register_post_type('school', $school_post_type_args);
    
    $workshop_post_type_args = [
        'labels' => ['name' => 'Workshops', 'singular_name' => 'Workshop'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions',
            'custom-fields', 'comments'],
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
    ];

    register_post_type('workshop', $workshop_post_type_args);
    
    $project_post_type_args = [
        'labels' => ['name' => 'Projects', 'singular_name' => 'Project'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions',
            'custom-fields', 'comments'],
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
    ];

    register_post_type('project', $project_post_type_args);
}

/**
 * Get a list of posts
 */

function su_get_post_list ($post_type) {
    $myquery = new WP_Query( "post_type=$post_type" );
    while ( $myquery->have_posts() ) {
        $myquery->the_post();
        $list[get_the_ID()] = get_the_title();
    }
    return $list;
}

function su_get_school_list () {
    su_get_post_list('school');
}

function su_get_workshop_list () {
    su_get_post_list('workshop');
}

function su_get_post_select ($post_type, $selected) {
    $list = su_get_post_list($post_type);
    foreach($list as $key => $value) {
        echo '<option value="' . $key . '"';
        if ($key == $selected) {
            echo ' selected="selected"';
        }
        echo '>' . $value . '</option>';
    }
}

function su_get_school_select ($selected) {
    su_get_post_select ('school', $selected);
}

function su_get_workshop_select ($selected) {
    su_get_post_select ('workshop', $selected);
}

/**
 * Add custom fields to admin edit screen of project meta. Accept custom fields
 * when saving the post.
 */

add_action( 'add_meta_boxes_project', 'su_add_project_meta_box' );

function su_add_project_meta_box() {
    // http://codex.wordpress.org/Function_Reference/add_meta_box
    add_meta_box('project_info', 'Project Information', 'project_info_content', 'project', 'side', 'high');
}

function project_info_content ($post) {
    ?>
    <p>
        <label for="workshop">Workshop</label>
        <select name="workshop" id="workshop">
            <?php su_get_workshop_select(get_post_meta($post->ID, 'workshop', true)); ?>
        </select>
    </p>

    <p>
        <label for="school">School</label>
        <select name="school" id="school">
            <?php su_get_school_select(get_post_meta($post->ID, 'school', true)); ?>
        </select>
    </p>
    
    <p>
        <label for="members">Members</label>
        <input type="text" name="members" id="members" />
    </p>
    <?php
}

/**
 * Write custom fields of project posts to database.
 */

add_action( 'save_post', 'su_project_meta_box_save' );

function su_project_meta_box_save ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    // Record meta data
    if (isset($_POST['post_type']) && ( $post_type_object = get_post_type_object($_POST['post_type']) ) && $post_type_object->public) {
        if (current_user_can('edit_post', $post_id)) {
            if (isset($_POST['workshop'])) {
                // TODO check workshop id, see if it exists
                update_post_meta($post_id, 'workshop', $_POST['workshop']);
            }
            if (isset($_POST['school'])) {
                // TODO check school id, see if it exists
                update_post_meta($post_id, 'school', $_POST['school']);
            }
            // TODO members
        }
    }

    return $post_id;
}