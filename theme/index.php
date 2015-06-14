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
    get_template_part('user/edit-basic');
}

if (su_check_secret_key() || is_user_logged_in()) {
    get_template_part('user/edit');
}

get_template_part('user/view');

if (is_user_logged_in() && is_admin()) {
    // Only admin can create and edit school
    get_template_part('school/create');
    get_template_part('school/edit');
}

get_template_part('school/view');

if (is_user_logged_in() && is_admin()) {
    // Only admin can create and edit workshop
    get_template_part('workshop/create');
    get_template_part('workshop/edit');
}

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
        <div class="statistics country">
            <span class="number">6</span>
            <span class="thin">Countries</span>
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
        <p>
            The MEDes is a unique network of seven leading European design schools.
            During the five year programme, students are integrated into three design
            education systems and join a strong international community. These diverse
            experiences provide them with different approaches to design, multi-national
            perspectives and sensitivity to cultural differences. The MEDes course
            encourage and enables students to develop- their creativity and imagination,
            their design research and investigation skills, and their professional
            executive practice.
        </p>
        <p>
            <a href="#" style="color:white; float: right;"><i class="fa fa-lg fa-plus-circle"></i></a>
        </p>
    </div><!-- .container -->
</div><!-- #front-page-intro.section -->

<div id="featured-people" class="section clearfix">
    <h1 class="white-heading">Today's inspiration</h1>
    <div class="outer">
        <div class="inner">
            <?php get_template_part('featured-people'); ?>
        </div>
        <div class="scroll left"><i class="fa fa-arrow-left"></i></div>
        <div class="scroll right"><i class="fa fa-arrow-right"></i></div>
    </div>

    <div id="user-page" class="popup">
        <div class="popup-close"><i class="fa fa-close"></i></div>
        <div class="popup-body"></div>
    </div>
</div>

<div id="datamap-container" class="container">
    <div class="tabs">
        <span id="people-map-click" class="click active" data-target="#people-map">
            People
        </span>
        <span id="school-map-click" class="click" data-target="#school-map">
            School
        </span>
        <span id="workshop-map-click" class="click" data-target="#workshop-map">
            Workshop
        </span>
    </div>
    <div class="panes">
        <div id="people-map" class="pane active">
            <div class="map-grid tabs">
                <div class="click tab active" data-target="#datamap"><i class="fa fa-globe"></i></div>
                <div class="click tab" data-target="#grid"><i class="fa fa-th"></i></div>
            </div>
            <div class="panes">
                <div id="datamap" class="pane active"></div>
                <div id="grid" class="pane clearfix">
                    <div class="card city" style="background-color: aquamarine;">Finland</div>
                    <div class="card city" style="background-color: antiquewhite;">Germany</div>
                    <div class="card city" style="background-color: buttonface;">China</div>
                    <div class="card city" style="background-color: darkorange;">Itali</div>
                    <div class="card city" style="background-color: mistyrose;">Japan</div>
                </div>
            </div>
            
            <div id="city-list" class="popup hover">
                <h1>Cites in Country</h1>
                <div class="card city" style="background-color: aquamarine;">City Name 1</div>
                <div class="card city" style="background-color: antiquewhite;">City Name 2</div>
                <div class="card city" style="background-color: buttonface;">City Name 3</div>
                <div class="card city" style="background-color: darkorange;">City Name 4</div>
                <div class="card city" style="background-color: mistyrose;">City Name 5</div>
                <div class="popup-close"><i class="fa fa-close"></i></div>
            </div>
        </div>
    </div>
</div>

<?php get_footer();