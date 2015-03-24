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

function schoolunion_setup() {
    // Post thumbnail
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800, 300, true);
    add_image_size('square-thumbnail', 600, 600);
    // Site logo
    $args = array(
        'header-text' => array(
            'site-title',
            'site-description',
        ),
        'size' => 'large',
    );
    add_theme_support('site-logo', $args);
    

    // HTML5 search form
    add_theme_support('html5', array('search-form'));
    // Editor style
    add_editor_style(get_stylesheet_directory_uri() . '/editor.css');
}

add_action('after_setup_theme', 'schoolunion_setup');

/**
 * JavaScript & CSS
 */
function schoolunion_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '20150210.1');
    wp_enqueue_style('font-awesome-style', get_stylesheet_directory_uri() . '/font-awesome/css/font-awesome.min.css', array(), '4.3.0');
    wp_enqueue_style('openlayers-style', 'http://openlayers.org/en/v3.2.1/css/ol.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('openlayers', 'http://openlayers.org/en/v3.2.1/build/ol.js', array('jquery'));
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/script.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'schoolunion_scripts');


/**
 * Menu
 */
function schoolunion_menu_init() {
  register_nav_menu('primary-menu', 'Primary Menu');
}
add_action( 'init', 'schoolunion_menu_init' );


/**
 * Title
 */
function schoolunion_title($title) {
    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    return $title;
}

add_filter('wp_title', 'schoolunion_title', 10, 2);
