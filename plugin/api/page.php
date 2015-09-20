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
 * APIs of static page
 */

/**
 * Fetch page data for display
 * 
 * Anyone can access this API, without login session.
 * 
 * [Request]
 * 
 * action: 'get_page_data'
 * page_id: int
 * 
 * [Response]
 * 
 * succeed: boolean
 * page_title: string
 * page_content: string
 * error_message: string
 */

add_action('wp_ajax_get_page_data', 'su_get_page_data');
add_action('wp_ajax_nopriv_get_page_data', 'su_get_page_data');

function su_get_page_data() {
    $slug = filter_input(INPUT_POST, 'page_slug');
    $pages = get_posts(
            array(
                'name' => $slug,
                'post_type' => 'page'
            )
    );

    if ($pages) {
        $page = $pages[0];
        $page_id = $page->ID;
    } else {
        $response = ['succeed' => false, 'error_message' => 'Page doesn\'t exist!'];
        die();
    }
    $response = ['succeed' => true, 'page_title' => $page->post_title,
        'page_content' => get_post_field('post_content', $page_id, 'display')];

    echo json_encode($response);
    die();
}
