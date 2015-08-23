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
 * Plugin Name: MEDes
 * Plugin URI: https://github.com/guoyunhe/medes
 * Description: Master of European Design
 * Version: 0.1.0
 * Author: Guo Yunhe
 * Author URI: http://guoyunhe.me/
 * License: GPLv3
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// require static functions
require_once 'include/user.php';
require_once 'include/school.php';
require_once 'include/country.php';
require_once 'include/year.php';
require_once 'include/security.php';
require_once 'include/ajax-utility.php';

// require hook functions
require_once 'hook/user-register.php';
require_once 'hook/user-admin.php';
require_once 'hook/school.php';
require_once 'hook/workshop.php';

// require api functions
require_once 'api/user.php';
require_once 'api/school.php';
require_once 'api/workshop.php';
require_once 'api/page.php';

// TODO Move this to theme
/**
 * Define AJAX URL for front end, not only admin side.
 */

add_action('wp_head', 'su_ajaxurl');

function su_ajaxurl() {
    ?>
    <script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
}