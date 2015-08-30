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
<!-- Map and list view of people, schools, workshops -->
<div id="map-list">
    <div class="tabs clearfix">
        <span id="people-map-click" class="click tab active" data-target="#people-pane">
            People
        </span>
        <span id="school-map-click" class="click tab" data-target="#school-pane">
            School
        </span>
        <span id="workshop-map-click" class="click tab" data-target="#workshop-pane">
            Workshop
        </span>
    </div>
    <div class="panes">
        <div id="people-pane" class="pane active">
            <div class="map-view">
                <div id="datamap"></div>
                <div id="city-list" class="popup hover">
                    <div class="popup-close"><i class="fa fa-close"></i></div>
                    <div class="popup-body">
                        
                    </div>
                </div>
                <div id="people-list" class="popup hover">
                    <div class="popup-close"><i class="fa fa-close"></i></div>
                    <div class="popup-body">
                        
                    </div>
                </div>
            </div>
            <div class="list-view">
                
            </div>
            <div class="swap">
                
            </div>
        </div>
        <div id="school-pane" class="pane clearfix">
            <?php
            $schools = su_get_school_list();
            foreach ($schools as $school):
                $main_picture = json_decode(get_post_meta($school->ID, 'main_picture', true), true);
                ?>
                <school class="card" data-post-id="<?php echo $school->ID;?>"
                        style="background-color:<?php echo su_text_to_color($school->post_title) ?>;
                        background-image:url('<?php echo $main_picture['url']; ?>')">
                    <?php echo $school->post_title;?>
                </school>
            <?php endforeach; ?>
        </div>
        <div id="workshop-pane" class="pane clearfix">
            <?php
            $workshops = su_get_workshop_list();
            foreach ($workshops as $workshop):
                $main_picture = json_decode(get_post_meta($workshop->ID, 'main_picture', true), true);
                ?>
                <workshop class="card" data-post-id="<?php echo $workshop->ID;?>"
                        style="background-color:<?php echo su_text_to_color($workshop->post_title) ?>;
                        background-image:url('<?php echo $main_picture['url']; ?>')">
                    <?php echo $workshop->post_title;?>
                </workshop>
            <?php endforeach; ?>
        </div>
    </div>
</div>