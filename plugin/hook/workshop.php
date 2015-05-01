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

add_action('init', 'su_create_workshop');

function su_create_workshop() {
    $workshop_post_type_args = [
        'labels' => ['name' => 'Workshops', 'singular_name' => 'Workshop'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions',
            'custom-fields', 'comments'],
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
    ];

    register_post_type('workshop', $workshop_post_type_args);
}