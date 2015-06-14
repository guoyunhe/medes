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
?>
<div id="featured-people" class="section clearfix">
    <h1 class="white-heading">Today's inspiration</h1>
    <div class="outer">
        <div class="inner">        
            <?php
            $featured_people = su_get_featured_people();
            foreach ($featured_people as $featured_person) {
                ?>
                <div class="featured-person"
                     data-user-id="<?php echo $featured_person->ID ?>">
                    <div class="name">
                        <?php
                        echo $featured_person->first_name
                        . ' ' . $featured_person->last_name;
                        ?>
                    </div>
                    <img class="avatar" src="<?php echo $featured_person->su_avatar; ?>"/>
                    <img class="project-photo" src="example.jpg"/>
                    <div class="tagline">The future belongs to those who make it.</div>
                    <div class="tags">#Illustration #FastPrototyping #HumanCentredDesign</div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="scroll left"><i class="fa fa-arrow-left"></i></div>
        <div class="scroll right"><i class="fa fa-arrow-right"></i></div>
    </div>
</div>