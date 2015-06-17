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
                    <span>[Cannot change]</span>
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
                    <label>Email</label>
                    <input type="text" name="openemail">
                    <label><input type="checkbox" name="openemail_private"> private</label>
                </p>
            </div>
            
            <div id="user-edit-experience" class="edit-section">
                <div class="edit-section-title">Experience</div>
                
            </div>
            
            <div id="user-edit-skills" class="edit-section">
                <div class="edit-section-title">Skills</div>
                
            </div>
            
            <div id="user-edit-description" class="edit-section">
                <div class="edit-section-title">Description</div>
                <p>
                    <label>Tagline</label>
                    <input type="text" name="tagline"/>
                </p>
                <p>
                    <label>Description</label>
                    <textarea name="description"></textarea>
                </p>
            </div>
            
            <button class="finish large">View Result</button>
        </div>
    </div>
</div>