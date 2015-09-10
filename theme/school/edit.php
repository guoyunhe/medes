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
<!-- Popup for editing school page -->
<div id="school-edit-popup" class="popup school edit">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container">
            
            <div id="school-edit-main-picture" class="edit-section">
                <div class="edit-section-title">Main Picture</div>
                <div class="main-picture avatar">
                    <input type="file" name="picture"/>
                    <button><i class="fa fa-camera"></i> Edit</button>
                </div>
            </div>
            
            <div id="school-edit-basic" class="edit-section">
                <div class="edit-section-title">Basic Information</div>
                <p>
                    <label>Name</label>
                    <input type="text" name="post_title"/>
                </p>
                <p>
                    <label>Short name</label>
                    <input type="text" name="short_name"/>
                </p>
                <p>
                    <label>Color</label>
                    <input type="text" name="color"/>
                    Format: #ffec57
                </p>
                <p>
                    <label>Country</label> 
                    <?php su_get_country_select(null,'country'); ?>
                    <label>City</label>
                    <input type="text" name="city"/>
                </p>
                <p>
                    <label>Website</label>
                    <input type="text" name="website"/>
                </p>
            </div>
            
            <div id="school-edit-staff" class="edit-section">
                <div class="edit-section-title">Staff</div>
                <p>
                    <label>Coordinator</label>
                    <input type="text" name="coordinator_name"/>
                    <label>Email</label>
                    <input type="text" name="coordinator_email"/>
                </p>
                <p>
                    <label>Tutor</label>
                    <input type="text" name="tutor_name"/>
                    <label>Email</label>
                    <input type="text" name="tutor_email"/>
                </p>
            </div>
            
            <div id="school-edit-pictures" class="edit-section">
                <div class="edit-section-title">Pictures</div>
                <div class="pictures clearfix">
                    <div class="add-picture">
                        <i class="fa fa-camera"></i>
                        <input type="file" name="picture"/>
                    </div>
                </div>
            </div>
            
            <div id="school-edit-description" class="edit-section">
                <div class="edit-section-title">Description</div>
                <p>
                    <textarea name="post_content"></textarea>
                </p>
            </div>
            
            <button class="finish large">View Result</button>
        </div>
    </div>
</div>