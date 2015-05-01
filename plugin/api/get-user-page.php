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


add_action('wp_head', 'su_ajaxurl');

/**
 * Fefine AJAX URL for front end, not only admin side.
 */

function su_ajaxurl() {
    ?>
    <script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
}

add_action( 'wp_ajax_get_user_page', 'su_get_user_page' );
add_action( 'wp_ajax_nopriv_get_user_page', 'su_get_user_page' );

function su_get_user_page() {
    $user_id = $_POST['user_id'];
    $user = new WP_User($user_id);
    
    include 'view/user-page.php';
    
    die();
}
