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

add_action('wp_enqueue_scripts', 'schoolunion_scripts');

function schoolunion_scripts() {
    su_load_bower_components();
    $liburl = get_stylesheet_directory_uri() . '/lib';
    $jsurl = get_stylesheet_directory_uri() . '/js';

    // Third party libraries
    wp_enqueue_script('jquery');
    wp_enqueue_script('raf', $liburl . '/raf/rAF.js');

    // Theme JavaScript
    wp_enqueue_script('su-main-script', $jsurl . '/main.js');
    wp_enqueue_script('su-ajax-script', $jsurl . '/ajax.js');
    wp_enqueue_script('su-datamap-script', $jsurl . '/datamap.js');
    wp_enqueue_script('su-dotcloud-script', $jsurl . '/dotcloud.js');
    wp_enqueue_script('su-featured-people-script', $jsurl . '/featured-people.js');
    wp_enqueue_script('su-site-header-script', $jsurl . '/site-header.js');
    wp_enqueue_script('su-ui-module-script', $jsurl . '/ui-module.js');
    wp_enqueue_script('su-user-script', $jsurl . '/user.js');
    wp_enqueue_script('su-school-script', $jsurl . '/school.js');
    wp_enqueue_script('su-popup-script', $jsurl . '/popup.js');
    wp_enqueue_script('su-static-page-script', $jsurl . '/page.js');

    // Theme CSS
    wp_enqueue_style('theme-main-style', get_stylesheet_uri());
}

function su_load_bower_components() {
    $bower_dir = get_stylesheet_directory_uri() . '/bower_components';
    wp_enqueue_style('normalize', $bower_dir . '/normalize-css/normalize.css');
    wp_enqueue_style('font-awesome', $bower_dir . '/font-awesome/css/font-awesome.css');
    
    wp_enqueue_script('d3', $bower_dir . '/d3/d3.min.js');
    wp_enqueue_script('topojson', $bower_dir . '/topojson/topojson.js');
    wp_enqueue_script('datamaps', $bower_dir . '/datamaps/dist/datamaps.all.min.js');
    
    $gsap_dir = $bower_dir . '/gsap/src/minified';
    wp_enqueue_script('gsap-tweenlite', $gsap_dir . '/TweenLite.min.js');
    wp_enqueue_script('gsap-easepack', $gsap_dir . '/easing/EasePack.min.js');
}

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
