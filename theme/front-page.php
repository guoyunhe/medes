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

get_header(); ?>

<div id="front-page-header" class="">
    <div class="site-title-group">
        <!-- Site logo feature provided by Jetpack plugin -->
        <?php if (function_exists('jetpack_the_site_logo')) jetpack_the_site_logo(); ?>
        <div class="site-name"><?php bloginfo('name'); ?></div>
        <div class="site-description"><?php bloginfo('description'); ?></div>
    </div>
    <div class="site-intro">
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
            <a href="#" style="color:white;"><i class="fa fa-lg fa-plus-circle"></i></a>
        </p>
    </div>
</div>

<div id="front-page-map" class="section">
    <i class="fa fa-globe"></i>
</div>
<div id="map-popup" class="popup">
    <div class="popup-header">
        <div class="popup-close">
            <i class="fa fa-lg fa-close"></i> Close
        </div>
    </div>
    <div id="map-container"></div>
    <div class="popup-footer"></div>
</div>


Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec iaculis turpis molestie mi eleifend, convallis tristique tortor semper. Curabitur maximus lacus ut tincidunt laoreet. Suspendisse potenti. Donec egestas ante risus, accumsan mattis elit interdum convallis. Vestibulum venenatis ipsum ut tincidunt tempor. Curabitur pellentesque, lacus sed varius vulputate, odio sapien euismod lorem, sed rutrum magna urna vel velit. Ut at dui nec tortor bibendum volutpat.
<br><br>
Aliquam eget ligula lectus. Aenean posuere viverra odio, quis accumsan justo porta sit amet. Aliquam id erat sit amet risus malesuada maximus vel a nulla. Mauris porta non elit dapibus mattis. Sed condimentum non dolor vel rhoncus. Fusce vel auctor orci. Fusce lectus mi, tincidunt at risus eu, efficitur molestie felis. Cras ut suscipit lacus.
<br><br>
Nulla leo turpis, aliquet quis rutrum sodales, tincidunt vel dolor. Proin ultricies felis libero, id pretium augue fringilla eu. Aliquam dapibus eu nisi eu auctor. Nam sit amet mollis nisl, non ullamcorper ligula. Curabitur id nulla in ante mollis iaculis sed eget turpis. Ut sed est eu eros semper dapibus. Pellentesque bibendum iaculis nibh nec fringilla. Morbi ullamcorper nulla in ullamcorper imperdiet. Ut vel velit leo. Mauris maximus ex sed quam blandit sagittis. Maecenas eu porttitor mi. Praesent non massa ut magna consectetur dapibus. Phasellus ultricies turpis id dui molestie, non maximus velit aliquam. Nullam imperdiet volutpat turpis eget tristique.
<br><br>
Nullam mollis, felis ac sodales dapibus, dui sapien placerat ante, sed hendrerit nunc velit sed dui. Integer ligula ante, finibus ut elementum in, dignissim at risus. In ultricies finibus arcu, eget maximus odio finibus quis. Ut ut elementum felis. Integer nec mattis lorem. Phasellus a finibus dolor, non venenatis turpis. Phasellus nibh magna, accumsan a pharetra at, congue in quam. Phasellus lorem quam, maximus quis lacinia et, vulputate ut dui. Suspendisse non lectus scelerisque, facilisis eros pulvinar, ornare mi. Nunc venenatis libero sed imperdiet mattis.
<br><br>
Sed varius nisi id metus vehicula, ac efficitur leo dapibus. Praesent vitae ligula vitae lectus tincidunt mollis. Nulla eget ex nec metus hendrerit laoreet sit amet et mauris. Etiam tincidunt suscipit eros, nec rutrum orci convallis et. In imperdiet in dui et auctor. Vivamus aliquam tortor diam, quis consectetur velit tincidunt et. Maecenas lectus justo, placerat nec tortor nec, sollicitudin blandit justo. Nullam ipsum justo, consequat nec bibendum nec, feugiat vitae elit. Sed risus felis, fringilla a ipsum sit amet, semper porttitor dui. Nunc finibus suscipit nulla, imperdiet ornare elit cursus id. Cras libero leo, accumsan eget lorem nec, tempor aliquam mauris. Cras ut eros odio. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sit amet dolor eu ligula mattis euismod in et dui. Vestibulum sed consectetur neque. Quisque tristique fermentum sapien, vitae tristique leo pharetra at. 

<?php get_footer(); ?>