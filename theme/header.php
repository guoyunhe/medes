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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            var is_admin = <?php echo current_user_can('manage_options')?'true':'false'; ?>;
            var user_id = <?php echo get_current_user_id(); ?>;
            var countries = <?php echo json_encode(su_get_user_country_city_list()); ?>;
        </script>
        <!-- Adobe Typekit fonts -->
<!--        <script type="text/javascript" src="//use.typekit.net/ycn2dal.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>-->
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <header id="site-header">
            <div class="site-title-group pull-left">
                <a class="site-logo" href="#"></a>
            </div>
            <div class="nav-wrap pull-right">
                <span id="site-search">
                    <input type="search" placeholder="Search..."/>
                    <i class="fa fa-search fa-lg"></i>
                </span>

                <span id="site-menu" class="click inline">
                    <i class="fa fa-bars fa-lg"></i>
                    <div class="dropdown">
                        <span class="click button">Schools</span>
                        <span class="click button">Workshops</span>
                        <span class="click button">People</span>
                        <a href="#page/2" class="click button">About</a>
                    </div>
                </span>

                <span id="user-menu" class="click inline button">
                    <?php
                    if (is_user_logged_in()):
                        $user_id = get_current_user_id();
                        $avatar_url = get_user_meta($user_id, 'avatar_url', true);
                        $user_name = get_user_meta($user_id, 'first_name', true)
                                . ' ' . get_user_meta($user_id, 'last_name', true);
                        ?>
                        <span class="avatar"
                              style="background-image: url('<?php echo $avatar_url ?>')"></span>
                        <span class="name"><?php echo $user_name ?></span>
                    <?php else: ?>
                        <span class="avatar" style="display:none;"></span>
                        <span class="name">Login</span>
                    <?php endif; ?>
                </span>

                <?php $isadmin = current_user_can('manage_options');
                        $islogin = is_user_logged_in();?>
                <span id="admin-menu" class="click inline"
                      <?php echo $islogin?'':'style="display:none"'; ?>>
                    <i class="fa fa-cog fa-lg"></i>
                    <div class="dropdown">
                        <span id="create-school-click" class="click button"
                              <?php echo $isadmin?'':'style="display:none"'; ?>>
                            <i class="fa fa-plus fa-fw"></i> Create school
                        </span>
                        <span id="create-workshop-click" class="click button"
                              <?php echo $isadmin?'':'style="display:none"'; ?>>
                            <i class="fa fa-plus fa-fw"></i> Create workshop
                        </span>
                        <a id="dashboard-click" class="click button"
                           href="<?php echo admin_url(); ?>"
                           <?php echo $isadmin?'':'style="display:none"'; ?>>
                            <i class="fa fa-tachometer fa-fw"></i> Dashboard
                        </a>
                        <a id="logout-click" class="click button"
                           href="<?php echo wp_logout_url( home_url() ); ?>">
                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>
                    </div>
                </span>
            </div>
        </header>
