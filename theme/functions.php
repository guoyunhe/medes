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
    add_image_size('square-thumbnail', 300, 300, true);
    add_image_size('square-thumbnail-1.5x', 450, 450, true);
    add_image_size('square-thumbnail-2x', 600, 600, true);
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
    $liburl = get_stylesheet_directory_uri() . '/lib';
    $jsurl = get_stylesheet_directory_uri() . '/js';
    $cssurl = get_stylesheet_directory_uri() . '/css';

    // Third party libraries
    wp_enqueue_style('normalize', $liburl . '/normalize/normalize.css');
    wp_enqueue_style('font-awesome', $liburl . '/font-awesome/css/font-awesome.min.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('tweenlite', $liburl . '/gsap/TweenLite.min.js');
    wp_enqueue_script('easepack', $liburl . '/gsap/EasePack.min.js');
    wp_enqueue_script('raf', $liburl . '/raf/rAF.js');
    wp_enqueue_script('d3', $liburl . '/d3/d3.min.js');
    wp_enqueue_script('topojson', $liburl . '/topojson/topojson.min.js');
    wp_enqueue_script('datamaps', $liburl . '/datamaps/datamaps.world.min.js');

    // Theme JavaScript
    wp_enqueue_script('theme-main-script', $jsurl . '/main.js');
    wp_enqueue_script('theme-ajax-script', $jsurl . '/ajax.js');
    wp_enqueue_script('theme-datamap-script', $jsurl . '/datamap.js');
    wp_enqueue_script('theme-dotcloud-script', $jsurl . '/dotcloud.js');
    wp_enqueue_script('theme-featured-people-script', $jsurl . '/featured-people.js');
    wp_enqueue_script('theme-site-header-script', $jsurl . '/site-header.js');
    wp_enqueue_script('theme-ui-module-script', $jsurl . '/ui-module.js');

    // Theme CSS
    wp_enqueue_style('theme-main-style', get_stylesheet_uri());
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
