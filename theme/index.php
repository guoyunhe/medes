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

get_header();

// Load popup modals of user, school and workshop page
if (su_check_secret_key()) {
    get_template_part('user/create');
}
get_template_part('user/login');
get_template_part('user/edit');
get_template_part('user/view');

get_template_part('school/create');
get_template_part('school/edit');
get_template_part('school/view');


get_template_part('workshop/create');
get_template_part('workshop/edit');
get_template_part('workshop/view');

get_template_part('page');

?>
<div id="dot-cloud">
    <canvas id="demo-canvas"></canvas>
    <div class="main-title">
        <div class="statistics medestrian">
            <span class="number">350</span>
            <span class="thin">Medestrians</span>
        </div>
        <div class="statistics school">
            <span class="number">7</span>
            <span class="thin">Schools</span>
        </div>
        <div class="statistics network">
            <span class="number">One</span>
            <span class="thin">Network</span>
        </div>
    </div>
</div>

<div id="front-page-intro" class="section">
    <div class="container">
        <!--
        This block should be replaced by a custom data filed that users can set
        their own text, images...
        -->
        <h1>
            The best design school is not one school.
        </h1>
        <p class="short">
            The MEDes is a unique network of seven leading European design schools. During the five year programme, students are integrated into three design...
        </p>
        <p class="long">
            The MEDes is a unique network of seven leading European design schools. During the five year programme, students are integrated into three design education systems and join a strong international community. These diverse experiences provide them with different approaches to design, multi-national perspectives and sensitivity to cultural differences. The MEDes course encourages and enables students to develop their creativity and imagination, their design research and investigative skills, and their professional executive practice.
        </p>
        <p>
            <a href="#" style="color:white; float: right;"><i class="fa fa-lg fa-plus-circle"></i></a>
        </p>
    </div><!-- .container -->
</div><!-- #front-page-intro.section -->

<?php get_template_part('featured-people'); ?>

<?php get_template_part('map-list'); ?>

<div id="search-popup" class="popup">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container">
            <p>
                <input type="search" name="keywords" placeholder="Search"/>
                <a class="click inline button">
                    <i class="fa fa-lg fa-search"></i>
                </a>
            </p>
            <div class="tabs clearfix">
                <span id="people-search-tab" class="click tab active" data-target="#people-search-pane">
                    People <span class="number"></span>
                </span>
                <span id="school-search-tab" class="click tab" data-target="#school-search-pane">
                    School <span class="number"></span>
                </span>
                <span id="workshop-search-tab" class="click tab" data-target="#workshop-search-pane">
                    Workshop <span class="number"></span>
                </span>
            </div>
            <div class="panes">
                <div id="people-search-pane" class="pane clearfix active">
                </div>
                <div id="school-search-pane" class="pane clearfix">
                </div>
                <div id="workshop-search-pane" class="pane clearfix">
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer();