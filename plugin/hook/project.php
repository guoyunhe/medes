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
 * Custom Post Types
 * 
 * School
 * 
 * Workshop (name, featured image/logo)
 *     |-- Project (name, authors, school, featured image, content)
 * 
 */

add_action('init', 'su_create_project');

function su_create_project() {
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