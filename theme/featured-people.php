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
    <div class="main-gallery js-flickity"
         data-flickity-options='{ "cellAlign": "center", "contain": true, "wrapAround": true, "autoPlay": true }'>
        <?php
        $featured_people = su_get_featured_people();
        foreach ($featured_people as $featured_person) {
            $id = $featured_person->ID;
            $name = $featured_person->first_name . ' ' . $featured_person->last_name;
            $color = su_text_to_color($name);
            $avatar = $featured_person->avatar_url;
            $pictures = array_values(json_decode(get_user_meta($id, 'pictures', true), true));
            $picture = $pictures[0]['url'];
            $tagline = get_user_meta($id, 'tagline', true);
            $skills = json_decode(get_user_meta($id, 'skills', true), true);
            ?>
            <div class="featured-person"
                 data-user-id="<?php echo $featured_person->ID ?>">
                <div class="name" style="background-color:<?php echo $color; ?>">
                    <?php
                    echo $featured_person->first_name
                    . ' ' . $featured_person->last_name;
                    ?>
                </div>
                <div class="avatar" style="background-image:url('<?php echo $avatar; ?>');
                     background-color:<?php echo $color; ?>;"></div>
                <div class="picture" style="background-image:url('<?php echo $picture; ?>')"></div>
                <div class="tagline" style="background-color:<?php echo $color; ?>">
                    <?php echo $tagline; ?>
                </div>
                <div class="tags">
                    <?php
                    if (!empty($skills)) {
                        foreach ($skills as $skill) {
                            ?>
                            <span class="tag">#<?php echo $skill; ?></span>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>