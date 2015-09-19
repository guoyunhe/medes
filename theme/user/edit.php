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

/**
 * Popup box to edit user profile
 */
?>
<div id="user-edit-popup" class="popup user edit">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div class="popup-body">
        <div class="container">
            
            <div class="edit-section">
                <div class="edit-section-title">Avatar</div>
                <div class="avatar">
                    <input type="file" name="avatar"/>
                    <button><i class="fa fa-camera"></i> Edit</button>
                </div>
            </div>
            
            <div id="user-edit-basic" class="edit-section">
                <div class="edit-section-title">Basic Information</div>
                <p>
                    <label>Username</label>
                    <input type="text" name="username" disabled="disabled"/>
                    <span>[can't be changed]</span>
                </p>
                <p>
                    <label>First name</label>
                    <input type="text" name="first_name"/>
                    <label>Last name</label>
                    <input type="text" name="last_name"/>
                </p>
                <p>
                    <label>Email</label>
                    <input type="email" name="user_email"/>
                </p>
            </div>
            
            <div id="user-edit-location" class="edit-section">
                <div class="edit-section-title">Location</div>
                <p>Where are you living?</p>
                <p>
                    <label>Country</label> 
                    <?php su_get_country_select(null,'live_country'); ?>
                    <label>City</label>
                    <input type="text" name="live_city"/>
                </p>
                <p>Your hometown</p>
                <p>
                    <label>Country</label>
                    <?php su_get_country_select(null, 'home_country'); ?>
                    <label>City</label>
                    <input type="text" name="home_city"/>
                </p>
            </div>
            
            <div id="user-edit-medes" class="edit-section">
                <div class="edit-section-title">MEDes Path</div>
                <p>
                    <label>Your role</label>
                    <select name="role">
                        <option value="student" selected>Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="tutor">Tutor</option>
                    </select>
                </p>
                <div class="schools">
                    <p>
                        <label>1<sup>st</sup> year</label>
                        <?php su_get_year_select(null, 'year_1'); ?>
                        <label>School</label>
                        <?php su_get_school_select(null, 'school_1'); ?>
                    </p>
                    <p>
                        <label>2<sup>nd</sup> year</label>
                        <?php su_get_year_select(null, 'year_2'); ?>
                        <label>School</label>
                        <?php su_get_school_select(null, 'school_2'); ?>
                    </p>
                    <p>
                        <label>3<sup>rd</sup> year</label>
                        <?php su_get_year_select(null, 'year_3'); ?>
                        <label>School</label>
                        <?php su_get_school_select(null, 'school_3'); ?>
                    </p>
                </div>
                <div class="school">
                    <p>
                        <label>School</label>
                        <?php su_get_school_select(null, 'school'); ?>
                    </p>
                </div>
            </div>
            
            <div id="user-edit-pictures" class="edit-section">
                <div class="edit-section-title">Pictures</div>
                <div class="pictures clearfix">
                    <div class="add-picture">
                        <i class="fa fa-camera"></i>
                        <input type="file" name="picture"/>
                    </div>
                </div>
            </div>
            
            <div id="user-edit-links" class="edit-section">
                <div class="edit-section-title">Links</div>
                <p>
                    <label>Facebook</label>
                    <input type="text" name="facebook">
                    <label><input type="checkbox" name="facebook_private"> private</label>
                </p>
                <p>
                    <label>Twitter</label>
                    <input type="text" name="twitter">
                    <label><input type="checkbox" name="twitter_private"> private</label>
                </p>
                <p>
                    <label>LinkedIn</label>
                    <input type="text" name="linkedin">
                    <label><input type="checkbox" name="linkedin_private"> private</label>
                </p>
                <p>
                    <label>Google+</label>
                    <input type="text" name="google">
                    <label><input type="checkbox" name="google_private"> private</label>
                </p>
                <p>
                    <label>Instagram</label>
                    <input type="text" name="instagram">
                    <label><input type="checkbox" name="instagram_private"> private</label>
                </p>
                <p>
                    <label>Flickr</label>
                    <input type="text" name="flickr">
                    <label><input type="checkbox" name="flickr_private"> private</label>
                </p>
                <p>
                    <label>YouTube</label>
                    <input type="text" name="youtube">
                    <label><input type="checkbox" name="youtube_private"> private</label>
                </p>
                <p>
                    <label>Vimeo</label>
                    <input type="text" name="vimeo">
                    <label><input type="checkbox" name="vimeo_private"> private</label>
                </p>
                <p>
                    <label>Tumblr</label>
                    <input type="text" name="tumblr">
                    <label><input type="checkbox" name="tumblr_private"> private</label>
                </p>
                <p>
                    <label>Pinterest</label>
                    <input type="text" name="pinterest">
                    <label><input type="checkbox" name="pinterest_private"> private</label>
                </p>
                <p>
                    <label>Website</label>
                    <input type="text" name="website">
                    <label><input type="checkbox" name="website_private"> private</label>
                </p>
                <p>
                    <label>Email</label>
                    <input type="text" name="email">
                    <label><input type="checkbox" name="email_private"> private</label>
                </p>
            </div>
            
            <div id="user-edit-experience" class="edit-section">
                <div class="edit-section-title">Work Experience</div>
                <div class="experience"></div>
                <p>
                    <label>From</label>
                    <?php su_get_year_select(null, 'xp_start', 'year', 'add-xp-start-input'); ?>
                    <select name="xp_start_month" id="add-xp-start-month-input">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <label>To</label>
                    <?php su_get_year_select(null, 'xp_end', 'year', 'add-xp-end-input'); ?>
                    <select name="xp_end_month" id="add-xp-end-month-input">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <textarea id="add-xp-desc-input" type="text" name="xp_desc"></textarea>
                    <button id="add-xp-button">Add Experience</button>
                </p>
            </div>
            
            <div id="user-edit-skills" class="edit-section">
                <div class="edit-section-title">Skills</div>
                <div class="skills"></div>
                <p>
                    <input id="add-skill-input" type="text" name="skill"/>
                    <button id="add-skill-button">Add Skill</button>
                </p>
            </div>
            
            <div id="user-edit-description" class="edit-section">
                <div class="edit-section-title">Description</div>
                <p>Description of your design philosophy</p>
                <p>
                    <textarea name="tagline" cols="50" rows="3"></textarea>
                </p>
            </div>
            
            <button class="finish large">View Result</button>
        </div>
    </div>
</div>