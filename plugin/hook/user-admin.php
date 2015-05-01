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