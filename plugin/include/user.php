<?php

/* 
 * Copyright (C) 2015 Guo Yunhe <guoyunhebrave at gmail.com>
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
 * Get the featured people to display on front page
 * @param int $number The max number of featured people
 * @return array List of user object
 */

function su_get_featured_people( $number=6 ) {
    $args = array(
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'avatar_url',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'pictures',
                'compare' => 'EXISTS'
            )
        ),
        'number' => $number,
        'orderby' => 'login'
    );
    return get_users( $args );
}

function su_get_latest_project_of_user($user_id) {
    
}

/**
 * Login a user
 * @param string $username
 * @param string $password
 * @return WP_User|WP_Error
 */
function su_login($username, $password) {
    $creds = array();
    $creds['user_login'] = $username;
    $creds['user_password'] = $password;
    $creds['remember'] = true;
    $user = wp_signon($creds, false);
    return $user;
}