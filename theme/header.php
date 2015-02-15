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
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <header id="site-header">
            <div class="site-title-group">
                <!-- Site logo feature provided by Jetpack plugin -->
                <?php if (function_exists('jetpack_the_site_logo')) jetpack_the_site_logo(); ?>
                <div class="site-name"><?php bloginfo('name'); ?></div>
                <div class="site-description"><?php bloginfo('description'); ?></div>
            </div>
            <div class="click-wrap">
                <span id="top-search-click" class="click inline round">
                    <i class="fa fa-lg fa-search"></i>
                </span>
                <span id="top-menu-click" class="click inline round">
                    <i class="fa fa-lg fa-bars"></i>
                    <div class="dropdown">
                        <div class="click">Maps</div>
                        <div class="click">Schools</div>
                        <div class="click">Workshops</div>
                        <div class="click">People</div>
                        <div class="click">About</div>
                    </div>
                </span>
            </div>
        </header>
